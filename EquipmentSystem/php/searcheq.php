<?php
$link = mysqli_connect("localhost", "hometogo0625", "sessy5295!!", "hometogo0625");
mysqli_set_charset($link,"utf8");
if (mysqli_connect_errno()) {
    echo "2";
} else {
    $name = $_POST['name'];
    $model = $_POST['model'];
    $category = $_POST['category'];
    $location = $_POST['location'];
    $status = $_POST['status'];
    $page = (int)$_POST['page'];

    $results_per_page = 10; // 한 페이지에 표시할 결과 수
    $offset = ($page - 1) * $results_per_page;

    $sql = "SELECT `equip`.`name` as `eqname`, `maker`, `type`, `loc`.`name` as `locname`, `equip_status`, `pic_ref`, `nickname`, `feature`, `equip_id` as `eqid`
             FROM `equip`
             JOIN `loc` ON `equip`.`loc_id` = `loc`.`loc_id`
             WHERE 1=1";

    $name = mysqli_real_escape_string($link, $name);
    $model = mysqli_real_escape_string($link, $model);
    $category = mysqli_real_escape_string($link, $category);
    $location = mysqli_real_escape_string($link, $location);
    $status = mysqli_real_escape_string($link, $status);
    if ($name) {
        $sql .= " AND (`equip`.`name` LIKE '%$name%' OR `equip`.`nickname` LIKE '%$name%')";
    } if ($model) {
        $sql .= " AND `equip`.`maker` LIKE '%$model%'";
    } if ($category) {
        $sql .= " AND `equip`.`type` = '$category'";
    } if ($location) {
        $sql .= " AND `loc`.`name` LIKE '%$location%'";
    } if ($status) {
        $sql .= " AND `equip`.`equip_status` = '$status'";
    }

    $sql .= " LIMIT $results_per_page OFFSET $offset";

    
    $result = mysqli_query($link, $sql);
    $arr = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push($arr, $row);
    }
    echo json_encode($arr);
    mysqli_close($link);
}


?>