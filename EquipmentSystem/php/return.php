<?php

$link = mysqli_connect("localhost", "hometogo0625", "sessy5295!!","hometogo0625");
if (mysqli_connect_errno()) {
    echo "2";
} else {
    $eqid = $_POST['eqid'];
    $userid = $_POST['user_id'];
    $data = "SELECT * FROM `rent` WHERE `equip_id` = '$eqid' AND `user_id` = '$userid'";
    $dataresult = mysqli_query($link, $data);
    if (mysqli_num_rows($dataresult) > 0) {
        $sql = "DELETE FROM `rent` WHERE `equip_id` = '$eqid' AND `user_id` = '$userid'";
        $result = mysqli_query($link, $sql);
        if ($result) {
            $sql2 = "UPDATE `equip` SET `equip_status` = '1' WHERE `equip_id` = '$eqid'";
            $result2 = mysqli_query($link, $sql2);
            if ($result2) {
                $data2 = mysqli_fetch_assoc($dataresult);
                $due = $data2['due_date'];
                $start = $data2['start_date'];
                $dueover = ($due < date('Y-m-d H:i:s')) ? 0 : $data2['status'];
                $sql3 = "INSERT INTO `history` (`user_id`,`equip_id`, `start_date`, `status`) VALUES ('$userid', '$eqid', '$start','$dueover')";
                $result3 = mysqli_query($link, $sql3);
                if ($result3) {
                    echo "1";
                } else {
                    echo "30";
                }
            } else {
                echo "20";
            }
        } else {
            echo "10";
        }
    } else {
        echo "3";
    }
    mysqli_close($link);
}

// 0 : SQL Fail
// 1 : Success
// 2 : Connection Fail
// 3 : No data
?>

