<?php

class LDAP{
    /**
     * Public Vars
     */
    public $Domain; # Contains the User Domain. Set in __contruct.
    public $Username; # Contains the username given by user. Set in __construct.
    
    /**
     * Private Vars
     */
    private $Link; # Contains the active LDAP Link. Set in CreateLink.
    private $User; # Contains the Username given by user. Set in __construct.
    private $Password; # Contains the Password given by user. Set in __construct.
    private $Bind; # Contains the bound Link and User info. Set in CreateLink.
    private $SearchResults; # Contains return of ldap_search. Set in Search.
    private $Results; # Contains the final search results. Set in Search.
    private $UserData; # Contains the Domain\\Username string. Set in __construct.
    private $Host = ""; # The LDAP Host name. Set here.
    private $Port = 389; # The LDAP Port(int). Set here.
    private $DN = "DC=,DC=,DC="; # Active Directory DN. Set here.
    private $UserDOM = "@xyz.com"; # LDAP Domain. Set here.
    private $Filter = "(&(sAMAccountName=[+++]))"; # LDAP Search Filter. Set here.
    private $OnlyReturnThese = array("ou", "sn", "givenname", "mail");

    /**
     * Create the main construct / default call
     */
    function __construct($username, $password, $domain, $action = "Search"){
        # Set domain as given by user, else throw exception.
        if(!empty($domain)){ $this->Domain = strtoupper($domain);
        } else { throw new Exception("User Domain must be set."); }
        
        # Set username as given by user, else throw exception.
        if(!empty($username)){ $this->Username = $username; 
        } else { throw new Exception("Username must be set."); }
        
        # Set password as given by user, else throw exception.
        if(!empty($password)){ $this->Password = $password;
        } else { throw new Exception("Password must be set."); }
        
        # Concat and replace filter data and user domain data
        $this->User = $this->Username . $this->UserDOM;
        $this->UserData = $this->Domain . "\\" . $this->Username;
        $this->Filter = str_replace("[+++]", $this->Username, $this->Filter);
        
        # Create a link & bind user to LDAP
        # greenLight is only used in local scope to check if Link was created.
        $greenLight = $this->CreateLink();
       
        # Check link is active (TRUE). If not TRUE, throw Exception.
        if($greenLight == TRUE){
            switch(strtolower($action)){
                case "search" : $this->Search();
                    break;
            }
        } else {
            throw new Exception('Failed to create Link (E4554)');
        }
    }
    
    /**
     * Public functions
     */
    public function Search(){
        # Check that user is bound to LDAP
        if ($this->Bind){
            # Perform ldap_search with link, DN and Filter data.
            $this->SearchResults = ldap_search($this->Link, $this->DN, $this->Filter);
            if($this->SearchResults == FALSE){
                throw new Exception('Search failed in search (Check DN/Filter) (E3823)');
            } else {
                # If ldap_search is good, attempt to get entries related to search
                $this->Results = ldap_get_entries($this->Link, $this->SearchResults);
                if($this->Results == FALSE){
                    throw new Exception('Failed to fetch entries (Check DN/Filter) (E5367)');
                } else {
                    if(!$this->Results) throw new Exception('Could not establish search (Check DN/Filter or Link) (E6880)');
                    # Everything went great, return the object and search results
                    else return $this->Results;
                }
            }
        } else {
            throw new Exception('Bind could not be established in Search (E1586)');
            return FALSE;
        }
    }
    
    /**
     * Private functions
     */ 
    private function CreateLink(){
        # Attempt to create a new LDAP link
        $this->Link = ldap_connect($this->Host);
        ldap_set_option($this->Link, LDAP_OPT_SIZELIMIT, 10);
        ldap_set_option($this->Link, LDAP_OPT_REFERRALS, 0);
        ldap_set_option($this->Link, LDAP_OPT_PROTOCOL_VERSION, 3);
        
        if($this->Link) {
            # Bind user to active link
            $this->Bind = ldap_bind($this->Link, $this->UserData, $this->Password);
            if($this->Bind == FALSE){
                throw new Exception('Bind failed while attempting to create link (Perhaps user credentials are incorrect or do not exist) (E9982)');
                return FALSE;
            } else return TRUE;
        } else {
            throw new Exception('Link could not be established while attempting to create new link (E7895)');
        }

        return FALSE;
    }

    # TODO: Comment; Do not use this->Result;
    private function ExplodeDN($with_attributes = 0){
        $this->Result = ldap_explode_dn($this->DN, $with_attributes);
        foreach($this->Result as $key => $value) 
            $this->Result[$key] = preg_replace("/\\\([0-9A-Fa-f]{2})/e", "''.chr(hexdec('\\1')).''", $value);
        return TRUE;
    }
}
