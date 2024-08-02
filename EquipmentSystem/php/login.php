<?php

$link = mysqli_connect("localhost", "hometogo0625", "sessy5295!!", "hometogo0625");
mysqli_set_charset($link,"utf8");

$id = $_POST['id'];
$pw = $_POST['pw'];

$sql = "SELECT * FROM `user` WHERE `user_id` = '$id'";
$stmt = mysqli_prepare($link, $sql);
$stmt->bind_param("s", $pw);
$stmt->execute();
$result = $stmt->get_result();
$user = mysqli_fetch_array($result);

$password = $user['password'];

if (password_verify($pw, $password) || $pw === $password) {
    echo '1';
    setcookie('user_id', $id, time() + 3600, '/');
} else {
    echo '0';
}
?>