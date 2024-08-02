<?php

$link = mysqli_connect("localhost", "hometogo0625", "sessy5295!!","hometogo0625");
if (mysqli_connect_errno()) {
    echo "2";
} else {
    $eqid = $_POST['eqid'];
    $userid = $_POST['user_id'];
    $data = "SELECT * FROM `rent` WHERE `equip_id` = '$eqid' AND `user_id` = ?";
    $datastmt = mysqli_prepare($link, $data);
    $datastmt->bind_param("s", $userid);
    $datastmt->execute();
    $dataresult = $datastmt->get_result();
    if (mysqli_num_rows($dataresult) > 0) {
        $sql = "DELETE FROM `rent` WHERE `equip_id` = '$eqid' AND `user_id` = ?";
        $stmt = mysqli_prepare($link, $sql);
        $stmt->bind_param("s", $userid);
        $result = $stmt->execute();
        if ($result) {
            // Update the status of the equipment
            $quantitysql = "SELECT `quantity` FROM `equip` WHERE `equip_id` = ?";
            $quantitystmt = mysqli_prepare($link, $quantitysql);
            $quantitystmt->bind_param("s", $eqid);
            $quantitystmt->execute();
            $quantityresult = $quantitystmt->get_result();
            $quantityrow = mysqli_fetch_array($quantityresult);
            if ($quantityrow[0] == 0) {
                $sql2 = "UPDATE `equip` SET `equip_status` = '1', `quantity` = 1 WHERE `equip_id` = ?";
            } else {
                $sql2 = "UPDATE `equip` SET `quantity` = `quantity` + 1 WHERE `equip_id` = ?";
            }
            $result2 = mysqli_query($link, $sql2);
            if ($result2) {
                $data2 = mysqli_fetch_assoc($dataresult);
                $due = $data2['due_date'];
                $start = $data2['start_date'];
                $dueover = ($due < date('Y-m-d H:i:s')) ? 0 : $data2['status'];
                $current = new DateTime();
                $current = $current->format("Y-m-d H:i:s");
                $sql3 = "INSERT INTO `history` (`user_id`,`equip_id`, `start_date`, `status`, `end_date`) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($link, $sql3);
                $stmt->bind_param("sssss", $userid, $eqid, $start, $dueover, $current);
                $result3 = $stmt->execute();
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

