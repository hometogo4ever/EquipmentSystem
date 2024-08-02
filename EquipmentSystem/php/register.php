<?php
$link = mysqli_connect("localhost", "hometogo0625", "sessy5295!!", "hometogo0625");
mysqli_set_charset($link,"utf8");

$name = $_POST['name'];
$model = isset($_POST['model']) ? $_POST['model'] : '';
$category = $_POST['category'];
$location = $_POST['location'];
$status = $_POST['status'];

$nickname = isset($_POST['nickname']) ? $_POST['nickname'] : '';
$feature = isset($_POST['feature']) ? $_POST['feature'] : '';

$target_dir = './img/equipment/';

$SIZE_LIMIT = 1024 * 1024 * 10; // 10MB

if ($_FILES['picture']['size'] === 0 || $_FILES['picture']['size'] > $SIZE_LIMIT) {
    echo "4";
    exit();
}

if (preg_match('/^[a-zA-Z0-9_\-.]+\.(jpg|jpeg|heic|webp)$/', $_FILES['picture']['name']) === 0) {
    echo "4";
    exit();
}

$sql1 = "SELECT `loc_id` FROM `loc` WHERE `name` = ?";
$stmt1 = mysqli_prepare($link, $sql1);
$stmt1->bind_param("s", $location);
$stmt1->execute();
$result1 = $stmt1->get_result();
if (!$result1) {
    echo "3";
} else {
    $loc = mysqli_fetch_assoc($result1);
    if ($loc != null) {
        $locId = $loc['loc_id'];
        $basename = $_FILES['picture']['name'];
        $sql = "INSERT INTO `equip`(`name`, `loc_id`,`equip_status`, `pic_ref`, `type`, `maker`, `nickname`, `feature`) 
                VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $sql);
        $stmt->bind_param("ssssssss", $name, $locId, $status, $basename, $category, $model, $nickname, $feature);
        $result2 = $stmt->execute()
        if ($result2) {
            // SQL 쿼리가 성공한 후 파일 업로드 로직 실행
            if ($_FILES['picture']['size'] > 0) {
                $target_file = $target_dir . $_FILES['picture']['name'];
                if (move_uploaded_file($_FILES['picture']['tmp_name'], $target_file)) {
                    echo "1";
                } else {
                    echo "2";
                
                }
            } else {
                echo "1";
            }
        } else {
            echo "3";
        }
    } else {
        echo "0";
    }
}

// Error code 
// 0: location not found
// 1: success
// 2: file upload failed
// 3: SQL query failed
// 4: invalid file