<?php
session_start();
include 'property.php';
include 'remoteLogin.php';

function loadUser($link, $id){
    $sql = "SELECT * FROM `user` WHERE `user_id` = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_array($result);

    return $user;
}
function createUser($link, $userInfo){
    $sql = "INSERT INTO `user` (`user_id`, `name`, `password`, `user_status`, `user_info`, `email`) VALUES (?, ?, ?, '0', ?, ?)";
    $stmt = mysqli_prepare($link, $sql);

    $passwordDefault = "remoteLogin";
    $user_info = $userInfo->col_no." ".$userInfo->major;

    mysqli_stmt_bind_param($stmt, "sssss", $userInfo->id, $userInfo->username, $passwordDefault, $user_info, $userInfo->email);
    return mysqli_stmt_execute($stmt);
}
function updateUser($link, $userInfo){
    $sql = "UPDATE `user` SET `name` = ?, `user_info` = ?, `email` = ? WHERE `user_id` = ?";
    $stmt = mysqli_prepare($link, $sql);

    $user_info = $userInfo->col_no." ".$userInfo->major;

    mysqli_stmt_bind_param($stmt, "ssss", $userInfo->username, $user_info, $userInfo->email, $userInfo->id);
    return mysqli_stmt_execute($stmt);
}

$id = $_POST['id'];
$pw = $_POST['pw'];

$remoteLoginResult = remoteLogin($id, $pw, $REMOTE_HOST);
if($remoteLoginResult->success != 1){
    echo '0';
    exit;
}

$link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DATABASE);
mysqli_set_charset($link,"utf8");

$user = loadUser($link, $id);

if(!$user){
    if(!createUser($link, $remoteLoginResult->userInfo)){
        echo "0";
        exit;
    }
}
else{
    if(!updateUser($link, $remoteLoginResult->userInfo)){
        echo "0";
        exit;
    }
}


$_SESSION['userId'] = $id;
//$_SESSION['token'] = $remoteLoginResult->token;
setcookie('token', $remoteLoginResult->token, time() + 3600, '/EquipmentSystem');

echo "1";

?>
