<?php
$userid = $_POST['user_id'];

include 'property.php';
$link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DATABASE);
mysqli_set_charset($link,"utf8");
$arr = array();
if (mysqli_connect_errno()) {
    echo json_encode($arr);
} else {
    $sql = "SELECT `equip`.`name` as `eqname`, `start_date`, `due_date`, `rent`.`status`, `pic_ref`, `equip`.`equip_id` as `eqid`   
            FROM `rent`, `equip`
            WHERE `rent`.`equip_id` = `equip`.`equip_id` AND `rent`.`user_id` = ?";
    $stmt = mysqli_prepare($link, $sql);
    $userid = $_POST['user_id'];
    $stmt->bind_param("s", $userid);
    $stmt->execute();
    $result = $stmt->get_result();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            array_push($arr, $row);
        }
        echo json_encode($arr);
    } else {
        echo json_encode($arr);
    }
}
?>