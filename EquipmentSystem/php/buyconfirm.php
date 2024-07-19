<?php
$arr = array();
$namelist = array();
$link = mysqli_connect("localhost", "hometogo0625", "sessy5295!!","hometogo0625");
mysqli_set_charset($link,"utf8");
if (!mysqli_connect_errno()) {
    $items = $_POST['items'];
    $userid = $_POST['user_id'];
    foreach ($items as $item) {
        // To check if the item is already borrowed by someone
        $sqlcheck = "SELECT `name` FROM `equip` WHERE `equip_id` = '$item' AND `equip_status` = '1'";
        $resultcheck = mysqli_query($link, $sqlcheck);
        if (!$resultcheck) {
            // If that item is already borrowed, return 0
            array_push($arr, $item);
        } else {
            $resultcheck2 = mysqli_fetch_assoc($resultcheck);
            if (!$resultcheck2) {    
                array_push($arr, $item);
            } else {
                // Borrow-able
                $sql = "UPDATE `equip` SET `equip_status` = '2' WHERE `equip_id` = '$item'";
                $result = mysqli_query($link, $sql);
                if ($result) {
                    $current = new DateTime();
                    $current = $current->format("Y-m-d H:i:s");

                    $future = new DateTime();
                    $future->modify('+2 day');
                    $future = $future->format('Y-m-d H:i:s');

                    $sql2 = "INSERT INTO `rent` (`equip_id`, `user_id`, `due_date`, `start_date`, `status`) VALUES ('$item', '$userid', '$future','$current', '1')";
                    $result2 = mysqli_query($link, $sql2);
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