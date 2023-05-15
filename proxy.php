<?php
// Get the JSON data from the POST request
session_start();
include_once dirname(__FILE__)."/conDB.php";

if(isset($_SESSION['access_token'])) {
    $ACCESS_TOKEN = $_SESSION['access_token'];
    $token = $ACCESS_TOKEN;
} else {
    ?>
    <script>
        alert('세션 발급 이후 진행해주시기 바랍니다.');
        window.location.replace("https://www.taxget.co.kr");
    </script>
    <?php
}


$json_data = file_get_contents('php://input');

$data_object = json_decode($json_data);

$url = $data_object->url;

// Set your API URL
$api_url = $url;

$key = file_get_contents('./key.pem');
$publicKey = openssl_pkey_get_public($key);
if (!$publicKey) {
    echo "Error getting public key: " . openssl_error_string();
    exit;
}

if (!openssl_public_encrypt($certPassword, $ciphertext, $publicKey)) {
    echo "Error encrypting password: " . openssl_error_string();
    exit;
}
$encrypted = base64_encode($ciphertext);


// Initialize cURL session
$json_data = json_encode($json_data);
// cURL 초기화
    $ch = curl_init();
// 요청 URL 설정
    curl_setopt($ch, CURLOPT_URL, $api_url);
// POST 요청 설정
    curl_setopt($ch, CURLOPT_POST, true);
// 요청 바디 설정
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
// 요청 헤더 설정
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($json_data),
        "Authorization: Bearer ".$token
    ));
// 응답 받기
    $response = urldecode(curl_exec($ch));
    
// url decode
    $response = urldecode($response);
// cURL 종료
    curl_close($ch);

    $response_data = json_decode($response, true);
?>
