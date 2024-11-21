<?php

include 'property.php';
$link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DATABASE);
if (mysqli_connect_errno()) {
    echo "2";
} else {
    $sql = "SELECT `history`.`id` as `hisid`, `user`.`name` as `username`, `equip`.`name` as `eqname`, `history`.`start_date` as `date`, `history`.`end_date` as `date2`
             FROM `history`, `user`, `equip`
             WHERE `history`.`user_id` = `user`.`user_id` AND `history`.`equip_id` = `equip`.`equip_id`";
             
    $result = mysqli_query($link, $sql);
    $arr = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push($arr, $row);
    }
    echo json_encode($arr);
    mysqli_close($link);
}

?>