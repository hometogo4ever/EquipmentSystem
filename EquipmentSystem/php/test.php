<?php

$link = mysqli_connect("localhost", "hometogo0625", "sessy5295!!", "hometogo0625");
mysqli_set_charset($link,"utf8");

$id = $_POST['id'];
$pw = $_POST['pw'];
$name = $_POST['name'];
$num = $_POST['num'];
$dept = $_POST['dept'];
$email = $_POST['email'];

$sql = "insert into `user` values('$id', '$name','$pw', '0', '$num $dept', '$email')";
echo "$sql<br>";

mysqli_query($link, $sql);
mysqli_close($link);

?>