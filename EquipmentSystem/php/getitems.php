<?php

$link = mysqli_connect("localhost", "hometogo0625", "sessy5295!!","hometogo0625");
mysqli_set_charset($link,"utf8");
if (mysqli_connect_errno()) {
    echo "2";
} else {
    $items = $_POST['items'];
    $arr = array();
    foreach ($items as $item) {
        $sql = "SELECT `name` as `eqname`, `pic_ref` FROM `equip` WHERE `equip_id` = '$item'";
        $result = mysqli_query($link, $sql);
        if ($result) {
            $ret = mysqli_fetch_array($result);
            array_push($arr, $ret);
        }
    }
    echo json_encode($arr);
    mysqli_close($link);
}
?>