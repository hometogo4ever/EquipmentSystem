<?php
function loadUser($link, $id){
    $sql = "SELECT * FROM `user` WHERE `user_id` = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_array($result);

    return $user;
}
function user_info($userInfo){
    return $userInfo->col_no." ".$userInfo->major;
    /*return json_encode(
        (object) array(
            "col_no" => $userInfo->col_no,
            "major" => $userInfo->major
        )
    );*/
}
function createUser($link, $userInfo){
    $sql = "INSERT INTO `user` (`user_id`, `name`, `password`, `user_status`, `user_info`, `email`) VALUES (?, ?, ?, '0', ?, ?)";
    $stmt = mysqli_prepare($link, $sql);

    $passwordDefault = "remoteLogin";
    $user_info = user_info($userInfo);

    mysqli_stmt_bind_param($stmt, "sssss", $userInfo->id, $userInfo->username, $passwordDefault, $user_info, $userInfo->email);
    return mysqli_stmt_execute($stmt);
}
function updateUser($link, $userInfo){
    $sql = "UPDATE `user` SET `name` = ?, `user_info` = ?, `email` = ? WHERE `user_id` = ?";
    $stmt = mysqli_prepare($link, $sql);

    $user_info = user_info($userInfo);

    mysqli_stmt_bind_param($stmt, "ssss", $userInfo->username, $user_info, $userInfo->email, $userInfo->id);
    return mysqli_stmt_execute($stmt);
}
?>