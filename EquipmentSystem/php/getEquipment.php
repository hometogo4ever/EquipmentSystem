<?php

include 'property.php';
$link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DATABASE);
if (mysqli_connect_errno()) {
    echo "2";
} else {
    $sql = "SELECT `equip`.`name` as `eqname`, `maker`, `type`, `loc`.`name` as `locname`, `equip_status`, `pic_ref`, `nickname`, `feature`
             FROM `equip`, `loc`
             WHERE `equip`.`loc_id` = `loc`.`loc_id`";
    $result = mysqli_query($link, $sql);
    $arr = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push($arr, $row);
    }
    echo json_encode($arr);
    mysqli_close($link);
}
?>