<?php
# We require the library
require("facebook_php_sdk/facebook.php");
require("NJOP.Class.php"); # $NJOP Object already set

mysql_connect($NJOP->DBHostname, $NJOP->DBUsername, $NJOP->DBPassword);
mysql_select_db($NJOP->DBDatabase);
        
# Creating the facebook object
$facebook = new Facebook(array(
    'appId'  => '123456789012345',
    'secret' => 'abcdefghijklmnopqrstuvwxyzabcdef',
    'cookie' => true
));


mysql_query("DELETE FROM fb_auth WHERE oauth_provider = 'facebook' AND oauth_uid = ". $_SESSION['oauth_uid']);
unset($_SESSION['oauth_uid']);
unset($_SESSION['oauth_provider']);
unset($_SESSION['username']);

header("Location: ".$facebook->getLogoutUrl());
?>
