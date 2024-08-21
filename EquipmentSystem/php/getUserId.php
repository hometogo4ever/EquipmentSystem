<?php
include 'property.php';
include 'remoteLogin.php';
include "user.php";

if(!isset($_COOKIE['token'])){
    echo "0";
    exit;
}
$token = $_COOKIE['token'];
$userInfo = getRemoteUserInfo($token, $REMOTE_HOST);
if(!$userInfo){
    echo "0";
    exit;
}

$id = $userInfo->id;


$link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DATABASE);
mysqli_set_charset($link,"utf8");

$user = loadUser($link, $id);

if(!$user){
    if(!createUser($link, $userInfo)){
        echo "0";
        exit;
    }
}
else{
    if(!updateUser($link, $userInfo)){
        echo "0";
        exit;
    }
}

session_start();
$_SESSION['userId'] = $id;
echo $id;

?>