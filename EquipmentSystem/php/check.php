<?php

$link = mysqli_connect("localhost", "hometogo0625", "sessy5295!!", "hometogo0625");
mysqli_set_charset($link,"utf8");

$id = $_POST['id'];

$sql = "SELECT * FROM `user` WHERE `user_id` = ?";
$stmt = mysqli_prepare($link, $sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();

if (mysqli_num_rows($result) > 0) {
    echo "1";
} else{
    echo "0";
}

mysqli_query($link, $sql);
mysqli_close($link);

?>
