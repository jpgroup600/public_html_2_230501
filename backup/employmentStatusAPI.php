<?php
session_start();
include_once dirname(__FILE__) . "/conDB.php";

$ACCESS_TOKEN = $_SESSION['access_token'];

$key = file_get_contents('./key.pem');
$publicKey = openssl_pkey_get_public($key);
if (!$publicKey) {
    echo "Error getting public key: " . openssl_error_string();
    exit;
}

// return json
$json_data = file_get_contents('php://input');

//json decode
$jsonObject = json_decode($json_data);

$resultCode = $jsonObject->result->code;
$extraMessage = $jsonObject->result->extraMessage;
$message = $jsonObject->result->message;
$transactionId = $jsonObject->result->transactionId;
$jobIndex = $jsonObject->data->jobIndex;
$threadIndex = $jsonObject->data->threadIndex;
$jti = $jsonObject->data->jti;
$twoWayTimestamp = $jsonObject->data->twoWayTimestamp;
$continue2Way = $jsonObject->data->continue2Way;
$commSimpleAuth = $jsonObject->data->extraInfo->commSimpleAuth;
$method = $jsonObject->data->method;


// 근로자고용정보현황조회
$END_POINT = 'https://development.codef.io/v1/kr/public/cw/kcomwel-employment/detail';
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
    'identity' => "9403281233817",
    'manageNo' => "22518014710",
    'insuranceType' => "0",
    'userIdentity' => "9403281233817",
    'userName' => "김수호",
    'loginType' => "5",
    'loginTypeLevel' => "1",
    'loginUserName' => "김수호",
    'phoneNo' => "01049986709",
    'simpleAuth' => "1",
    'is2Way' => true,
    'twoWayInfo' => array(
        'jobIndex' => 0,
        'threadIndex' => 0,
        'jti' => $jti,
        'twoWayTimestamp' => $twoWayTimestamp
    )
    
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


echo "</p>";


$sql_sel = "SELECT * from employment where user_key=$user_key";
$result = mysqli_query($conn, $sql_sel);

if (mysqli_num_rows($result) > 0) {
    // user_data table settings
    $sql = "UPDATE employment SET json_data='$json_data' WHERE user_key=$user_key";
} else {
    // user_data table settings
    $sql = "INSERT INTO employment(user_key, json_data) VALUES($user_key, '$json_data')";
}

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    // echo "Error: " . $sql . "<br>" . $conn->error;
    echo "<br>";
}

// db snowflake
$conn->close();
?>

<?php
if($_POST) {
    ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

        // 근로자고용정보현황조회
        var body = document.getElementById("api_json");
        let decodedValue = decodeURIComponent(body.innerHTML);
        body.innerHTML = decodedValue ;
        // body.innerHTML = "<h1>hello</h1>";
        let jsonData = decodedValue;

    

<?php 
}


?>
