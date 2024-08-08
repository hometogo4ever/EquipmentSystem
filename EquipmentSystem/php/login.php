<?php

include 'property.php';
$link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DATABASE);
mysqli_set_charset($link,"utf8");

$id = $_POST['id'];
$pw = $_POST['pw'];

$sql = "SELECT * FROM `user` WHERE `user_id` = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "s", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_array($result);

if ($user) {
    $password = $user['password'];

    if (password_verify($pw, $password) || $pw === $password) {
        echo '1';
        setcookie('user_id', $id, time() + 3600, '/');
    } else {
        echo '0';
    }
} else {
    echo '0';
}
?>
