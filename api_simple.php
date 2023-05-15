<?php
session_start();
// Read JSON data from client
$jsonData = json_decode(file_get_contents("php://input"), true);
$ACCESS_TOKEN = $_SESSION['access_token'];

$key = file_get_contents('./key.pem');
$publicKey = openssl_pkey_get_public($key);
if (!$publicKey) {
    echo "Error getting public key: " . openssl_error_string();
    exit;
}

// 근로자고용정보현황조회
$END_POINT = 'https://development.codef.io/v1/kr/public/cw/kcomwel-employment/detail';
// echo "<p id='api_json'>";
// Extract twoWayInfo data
$twoWayInfo = $jsonData['data'];

// Additional data
$simpleAuth = "1";
$is2Way = true;

// Combine data into a single array
$requestData = array(
    'organization' => "0001",
    'userType' => "0",
    'identity' => "9403281233817",
    'manageNo' => "22518014710",
    'insuranceType' => "0",
    'userIdentity' => "9403281233817",
    'userName' => "김수호",
    'loginType' => "5",
    'loginTypeLevel' => "1",
    'loginUserName' => "김수호",
    'phoneNo' => "01049986709"
);

// JSON으로 인코딩
$json_data = json_encode($requestData);
// cURL 초기화
$ch = curl_init();
// 요청 URL 설정
curl_setopt($ch, CURLOPT_URL, $END_POINT);
// POST 요청 설정
curl_setopt($ch, CURLOPT_POST, true);
// 요청 바디 설정
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
// 요청 헤더 설정
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($json_data),
    "Authorization: Bearer ".$ACCESS_TOKEN
));
// 응답 받기
$response = urldecode(curl_exec($ch));

// URL 디코딩
$response = rawurldecode($response);

// url decode
// $response = urldecode($response);

// cURL 종료
curl_close($ch);

$response_data = json_decode($response, true);

echo json_encode($response_data);




?>

