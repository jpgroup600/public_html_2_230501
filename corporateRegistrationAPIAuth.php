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
$END_POINT = 'https://development.codef.io/v1/kr/public/nt/proof-issue/corporate-registration';
echo "<p id='api_json'>";
// Extract twoWayInfo data
$twoWayInfo = $jsonData['data'];

// Additional data
$simpleAuth = "1";
$is2Way = true;

// Combine data into a single array
$requestData = array(
    'organization' => "0001",
    'userType' => "0",
    'insuranceType' => "0",
    'userIdentity' => "9403281233817",
    'userName' => "김수호",
    'loginType' => "6",
    'loginTypeLevel' => "1",
    'loginUserName' => "김수호",
    'phoneNo' => "01049986709",
    'usePurposes' => "99",
    'submitTargets' => "99",
    'isIdentityViewYN' => "1",
    'loginIdentity' => "9403281233817"

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

// url decode
$response = urldecode($response);
// cURL 종료
curl_close($ch);

$response_data = json_decode($response, true);

if (isset($response_data['data'])) {
    $data_array = $response_data['data'];
    echo "'hello";
    // $data_array 변수에는 "data" 필드에 있는 array가 저장됩니다.
}
echo "</p>";

echo "<p id= 'api_json_data'></p>";

?>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>



    // 근로자고용정보현황조회
    let body = document.getElementById("api_json");
    let decodedValue = decodeURIComponent(body.innerHTML);
    //body.innerHTML = decodedValue;
    let jsonData = decodedValue;

    $('#api_json').html(decodedValue);


    // const xhr = new XMLHttpRequest();
    // xhr.open("POST", "employmentStatusAPI.php");
    // xhr.setRequestHeader("Content-type", "application/json");
    // xhr.onload = function () {
    //     if (xhr.status === 200) {
    //         console.log("근로자고용정보현황조회 저장 완료");
    //     }
    // };
    // xhr.send(jsonData);

        const xhr = new XMLHttpRequest();
    xhr.open("POST", "corporateRegistrationAPI.php");
    xhr.setRequestHeader("Content-type", "application/json");
    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log("근로자고용정보현황조회 저장 완료");
        }
    };
    xhr.send(jsonData);

    $(document).ready(function() {
        $("#send_data").click(function() {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "corporateRegistrationAPI.php");
            xhr.setRequestHeader("Content-type", "application/json");
            xhr.onload = function () {
        if (xhr.status === 200) {
            console.log("근로자고용정보현황조회 저장 완료");
            console.log(xhr.responseText);
        }
    };
    xhr.send(jsonData);
  });
});


    $('#api_json_data').html("<button id='send_data'>send data</button>");


</script>
