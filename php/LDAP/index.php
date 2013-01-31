<?php
error_reporting(0);

require_once("LDAP.php");

/* Initialize a new LDAP class */
if($_POST){
    try {
        # Only supporting action[search] for now sadly
        $LDAP_Object = new LDAP($_POST['username'],$_POST['password'],$_POST['domain'],"Search");
        
        echo "<pre>";
        var_dump($LDAP_Object);
        echo "</pre>";
    } catch(Exception $e) {
        die("Exception: " . $e->getMessage());
    }
}
?>

<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <link type="text/plain" rel="author" href="http://www1.touro.edu/
        <link type="text/plain" rel="author" href="humans.txt" />
        <title>Touro LDAP Self Search Test</title>
        <style>
            html{ margin:0 auto; -webkit-font-smoothing: antialiased; }
            body{
                color:#333;
                font-family:"lucida grande",tahoma,verdana,arial,sans-serif;
                line-height:1.28;
                direction:ltr;
                font-size:11px;
                text-align:left;
            }
            
            /* hand cursor on clickable input elements */
            label, input[type=button], input[type=submit], button { 
                cursor: pointer;
                display:block;
                margin-top:15px;
            }
        </style>
    </head>

    <body>
        <form action="" method="post">
            <label for="username">Username:</label>
            <input name="username" id="username" placeholder="Username" required />
            
            <label for="password">Password:</label>
            <input name="password" id="password" type="password" placeholder="Password" required />
            
            <label for="domain">Domain:</label>
            <select name="domain" id="domain" required>
                <option>ADMIN</option>
                <option>STUDENT</option>
            </select>
            
            <input type="submit" value="Submit">
        </form>
        
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    </body>
</html>