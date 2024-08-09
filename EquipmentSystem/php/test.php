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

$num_dept = $num . " " . $dept;
$pw = password_hash($pw, PASSWORD_DEFAULT);

$sql = "insert into `user` values(?, ?, ?, '0', ?, ?)";
$stmt = mysqli_prepare($link, $sql);
$stmt->bind_param("sssss", $id, $pw, $name, $num_dept, $email);
$stmt->execute();
$result = $stmt->get_result();
echo "$sql<br>";

mysqli_close($link);

?>