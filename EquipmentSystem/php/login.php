<?php

include 'property.php';
include 'remoteLogin.php';
include "user.php";

$id = $_POST['id'];
$pw = $_POST['pw'];

$remoteLoginResult = remoteLogin($id, $pw, $REMOTE_HOST);
if($remoteLoginResult->success != 1){
    echo '0';
    exit;
}

setcookie('token', $remoteLoginResult->token, time() + 3600, '/');

echo "1";

?>
