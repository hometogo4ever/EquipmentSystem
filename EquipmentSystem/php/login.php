<?php

$link = mysqli_connect("localhost", "hometogo0625", "sessy5295!!", "hometogo0625");
mysqli_set_charset($link,"utf8");

$id = $_POST['id'];
$pw = $_POST['pw'];

$sql = "SELECT * FROM `user` WHERE `user_id` = '$id' AND `password` = '$pw'";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) {
    echo '1';
    setcookie('user_id', $id, time() + 3600, '/');
} else {
    echo '0';
}
?>