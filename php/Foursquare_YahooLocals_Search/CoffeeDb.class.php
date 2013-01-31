<?php

class CoffeeDb extends CoffeeKeys{
    public function __construct() { parent::__construct(); } 
    
    public function DBStartConnection(){
        $this->DBConnection = mysql_connect($this->DBHostname, 
                                            $this->DBUsername, 
                                            $this->DBPassword)
                              or die(mysql_error());
        mysql_select_db($this->DBDatabase) or die(mysql_error());
    }
    
    public function DBEndConnect(){
        if($this->DBConnection)
            mysql_close($this->DBConnection);
    }
    
    private function DBCleanQuery($string){
        return mysql_real_escape_string($string);
    }
    
    /*
     * mixed DBRunSelect ( [string $column [, string $from [, string $where [, 
     *                     string $groupBy [, string $having [, string $orderBy 
     *                     [, bool $array = true [, bool $json = false ]]]]]]]])
     * Builds a MySQL query and runs it, returns array, json object or resource
     *
     * Requires $column and $from
     * Returns associative array by default
     * 
     * Sample usage: DBRunSelect("shoeSizes", "shoeStore", "size=9", "color", 
     *                           "SUM(price)", "size", TRUE, FALSE);
     *
    */
    public function DBRunSelect($column, $from, $where = "", $groupBy = "", 
                                $having = "", $orderBy = "", $array = TRUE, 
                                $json = FALSE){
        $this->DBStartConnection();

        $query = "SELECT ";
        if($column)  $query .= $this->DBCleanQuery($column);
        if($from)    $query .= " FROM "     . $this->DBCleanQuery($from);
        if($where)   $query .= " WHERE "    . $this->DBCleanQuery($where);
        if($groupBy) $query .= " GROUP BY " . $this->DBCleanQuery($groupBy);
        if($having)  $query .= " HAVING "   . $this->DBCleanQuery($having);
        if($orderBy) $query .= " ORDER BY " . $this->DBCleanQuery($orderBy);

        $result = mysql_query($query);

        if($array === TRUE){
            $i = 0;
            while($row = mysql_fetch_assoc($result)){
                $output[$i] = $row;
                $i++;
            }
            if($json === TRUE)
                $result = json_decode(json_encode($output));
            else 
                $result = $output;
        }
        
        $this->DBEndConnect();
        return $result;
    }
}

?>
