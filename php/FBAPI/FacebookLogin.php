<?
@session_start();
require("facebook_php_sdk/facebook.php"); # We require the library
require("NJOP.Class.php");

$facebook = new Facebook(array( # Creating the facebook object
    'appId'  => '123456789012345',
    'secret' => 'abcdefghijklmnopqrstuvwxyzabcdef',
    'cookie' => true
));

# Let's see if we have an active session
$fbSession = $facebook->getUser(); #Used to be getSession()

if(!empty($fbSession)) {
    # Active session, let's try getting the user id (getUser()) and user info (api->('/me'))
    try{
        $uid = $facebook->getUser();
        $user = $facebook->api('/me');
    } catch (Exception $e){}

    if(!empty($user)){
        mysql_connect($NJOP->DBHostname, $NJOP->DBUsername, $NJOP->DBPassword);
        mysql_select_db($NJOP->DBDatabase);
        
        # We have an active session, let's check if we have already registered the user
        $query = mysql_query("SELECT * FROM fb_auth WHERE oauth_provider = 'facebook' AND oauth_uid = ". $user['id']);
        $result = mysql_fetch_array($query);
        
        # If not, let's add it to the database
        if(empty($result)){
            $query = mysql_query("INSERT INTO fb_auth (oauth_provider, oauth_uid, username) VALUES ('facebook', {$user['id']}, '{$user['name']}')");
            $query = mysql_query("SELECT * FROM fb_auth WHERE id = " . mysql_insert_id());
            $result = mysql_fetch_array($query);
        }
        // this sets variables in the session 
        $_SESSION['id'] = $result['id'];
        $_SESSION['oauth_uid'] = $result['oauth_uid'];
        $_SESSION['oauth_provider'] = $result['oauth_provider'];
        $_SESSION['username'] = $result['username'];
        
        header("Location: " . $NJOP->SiteURL);
    } else {
        # For testing purposes, if there was an error, let's kill the script
        die("There was an error.");
    }
} else {
    $fbLoginURL = $facebook->getLoginUrl(array(
        'req_perms' => 'status_update'
    ));
    
    # There's no active session, let's generate one
    header("Location: " . $fbLoginURL);
}
?>
