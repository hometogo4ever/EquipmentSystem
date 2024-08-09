<?php
$arr = array();
$namelist = array();
include 'property.php';
$link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DATABASE);
mysqli_set_charset($link,"utf8");
if (!mysqli_connect_errno()) {
    $items = $_POST['items'];
    $userid = $_POST['user_id'];
    foreach ($items as $item) {
        // To check if the item is already borrowed by someone
        $sqlcheck = "SELECT `name` FROM `equip` WHERE `equip_id` = ? AND `equip_status` = '1'";
        $stmt = mysqli_prepare($link, $sqlcheck);
        mysqli_stmt_bind_param($stmt, "s", $item);
        mysqli_stmt_execute($stmt);
        $resultcheck = mysqli_stmt_get_result($stmt);
        if (!$resultcheck) {
            // If that item is already borrowed, return 0
            array_push($arr, $item);
        } else {
            $resultcheck2 = mysqli_fetch_assoc($resultcheck);
            if (!$resultcheck2) {    
                array_push($arr, $item);
            } else {
                // Borrow-able
                $quantitysql = "SELECT `quantity` FROM `equip` WHERE `equip_id` = ?";
                $stmt = mysqli_prepare($link, $quantitysql);
                mysqli_stmt_bind_param($stmt, "s", $item);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $q = mysqli_fetch_array($result);
                if ($q[0] == 1) {
                    $sql = "UPDATE `equip` SET `equip_status` = '2', `quantity` = 0 WHERE `equip_id` = ?";
                    $stmt = mysqli_prepare($link, $sql);
                    mysqli_stmt_bind_param($stmt, "s", $item);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                } else {
                    $sql = "UPDATE `equip` SET `quantity` = `quantity` - 1 WHERE `equip_id` = ?";
                    $stmt = mysqli_prepare($link, $sql);
                    mysqli_stmt_bind_param($stmt, "s", $item);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                }
                if ($result) {
                    $current = new DateTime();
                    $current = $current->format("Y-m-d H:i:s");

                    $future = new DateTime();
                    $future->modify('+2 day');
                    $future = $future->format('Y-m-d H:i:s');

                    $sql2 = "INSERT INTO `rent` (`equip_id`, `user_id`, `due_date`, `start_date`, `status`) VALUES (?, ?, ?, ?, '1')";
                    $stmt = mysqli_prepare($link, $sql2);
                    mysqli_stmt_bind_param($stmt, "ssss", $item, $userid, $future, $current);
                    mysqli_stmt_execute($stmt);
                    $result2 = mysqli_stmt_get_result($stmt);
                    if (!$result2) {
                        array_push($arr, $item);
                    } else {
                        array_push($namelist, $resultcheck2['name']);
                    }
                } else {
                    array_push($arr, $item);
                }
            }
        } 
    }
    $num = count($arr);
    echo $num;
    if ($num > 0) {
        $string = implode(",", $arr);
        setcookie("buylist", $string, time() + 3600,"/");
        setcookie("shoppinglist", $string, time() + 3600, "/");
    } else {
        setcookie("buylist", "", time() - 3600, "/");
        setcookie("shoppinglist", "", time() - 3600, "/");
        $rett = implode(',', $namelist);
        setcookie("afterbuy", $rett, time() + 3600, "/");
    }
    mysqli_close($link);
} else {
    echo -1;
}

?>
