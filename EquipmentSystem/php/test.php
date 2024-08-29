<?php

include 'property.php';
$link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DATABASE);
mysqli_set_charset($link,"utf8");

$id = $_POST['id'];
$pw = $_POST['pw'];
$name = $_POST['name'];
$num = $_POST['num'];
$dept = $_POST['dept'];
$email = $_POST['email'];

$num_dept = $num . $dept;
$pw = password_hash($pw, PASSWORD_DEFAULT);

$sql = "INSERT INTO `user` (`user_id`, `name`, `password`, `user_status`, `user_info`, `email`) VALUES (?, ?, ?, '7', ?, ?)";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "sssss", $id, $name, $pw, $num_dept, $email);
if (mysqli_stmt_execute($stmt)) {
    echo "1";
} else {
    echo "2";
}
mysqli_stmt_close($stmt);
mysqli_close($link);

?>