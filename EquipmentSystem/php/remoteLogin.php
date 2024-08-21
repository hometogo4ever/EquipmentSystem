<?php
    include 'property.php';

    function getUserInfo($token, $REMOTE_HOST){
        $url = $REMOTE_HOST."/api/userinfo/";
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer '.$token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $response_body = substr($result, $header_size);
        $body_decode = json_decode($response_body);

        if($body_decode->success){
            return $body_decode->userInfo;
        }

        return null;
    }

    function remoteLogin($id, $password, $REMOTE_HOST){
        $ch = curl_init();
        $url = $REMOTE_HOST."/api/auth/login/";
        $body_data = (object) array(
            "id" => $id,
            "password" => $password
        );
        $body = json_encode($body_data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $response_body = substr($result, $header_size);
        $body_decode = json_decode($response_body);

        if($body_decode->sucess){
            $userInfo = getUserInfo($body_decode->token, $REMOTE_HOST);
            return (object) array('success' => true, 'userInfo' => $userInfo, 'token' => $body_decode->token);
        }
        else{
            return (object) array("success" => false, "message" => $body_decode->message);
        }

        return $body_decode;
    }
?>