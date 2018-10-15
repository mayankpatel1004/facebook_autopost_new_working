<?php
include 'httpcurl.php';
include 'fbform.php';

$fbhomepage = 'http://m.facebook.com';
$username = "mayank.patel@msn.com";   // Insert your login email
$password = "mayankpatel104";   // Insert your password
//$status = "New and Updated! Check it out at http://php8legs.com/en/facebook/45-new-and-updated-facebook-remote-status-update-with-php-curl-bot!";
$status = "Developerddddd Post updated...........";

$pages = new FBform();
$pages->get($fbhomepage);  
$pages->fblogin($username, $password);
$pages->get($fbhomepage);
if($pages->fbstatusupdate($status)){
    echo "Success";
}else{
    echo "Fail";
}

?>