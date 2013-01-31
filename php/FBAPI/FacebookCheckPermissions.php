<?php
@session_start();
# We require the library
require("facebook_php_sdk/facebook.php");
require("NJOP.Class.php");

# Creating the facebook object
$facebook = new Facebook(array(
    'appId'  => '123456789012345',
    'secret' => 'abcdefghijklmnopqrstuvwxyzabcdef',
    'cookie' => true
));

# Let's see if we have an active session
$session = $facebook->getUser();

if(!empty($session)) {
    # Active session, let's try getting the user id (getUser()) and user info (api->('/me'))
    try{
        $uid = $facebook->getUser();
        
        # users.hasAppPermission
        $api_call = array(
            'method' => 'users.hasAppPermission',
            'uid' => $uid,
            'ext_perm' => 'publish_stream'
        );
        $users_hasapppermission = $facebook->api($api_call);
        print_r($users_hasapppermission);
    } catch (Exception $e){}
} else {
    # There's no active session, let's generate one
    $login_url = $facebook->getLoginUrl();
    header("Location: ".$login_url);
}
