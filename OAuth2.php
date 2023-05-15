<?php
    session_start();
    include_once dirname(__FILE__)."/conDB.php";
    $clientId = '9c27eeb1-d411-419a-b822-623056fc1589';
    $clientSecret = 'b2fd41d7-9dae-4df6-a631-750b5ebe93ff';
    $url = 'https://oauth.codef.io/oauth/token';
    $params = "grant_type=client_credentials&scope=read";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/x-www-form-urlencoded",
        "Authorization: Basic " . base64_encode("$clientId:$clientSecret")
    ));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        return null;
    }

    $tokenMap = json_decode(urldecode($response), true);
    $_SESSION['access_token'] = $tokenMap['access_token'];

    // access_token 값을 넣을 사용자의 user_key
    $user_key = $_SESSION['user_key'];

    // access_token 값
    $access_token = $_SESSION['access_token'];
    $expiration_date = date('Y-m-d H:i:s', strtotime('+7 days'));

    // access_token 값을 업데이트하는 SQL 쿼리문
    $sql = "UPDATE user_account SET access_token='$access_token', token_expiration='$expiration_date' WHERE user_key=$user_key";
    //echo $sql;

    // SQL 쿼리문 실행
    // if (mysqli_query($conn, $sql)) {
    //     echo "Record updated successfully";
    // } else {
    //     echo "Error updating record: " . mysqli_error($conn);
    // }

    // MySQL 연결 종료
    mysqli_close($conn);
    // header('Location: https://phpstack-761997-3303412.cloudwaysapps.com');
