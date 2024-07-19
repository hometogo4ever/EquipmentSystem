<?php
$link = mysqli_connect("localhost", "hometogo0625", "sessy5295!!", "hometogo0625");
if (mysqli_connect_errno()) {
    echo "2";
} else {
    $sql = "SELECT * FROM `loc`";
    $result = mysqli_query($link, $sql);
    $arr = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push($arr, $row['name']);
    }
    echo json_encode($arr);
    mysqli_close($link);
}

?>