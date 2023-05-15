<?php
session_start();
include_once dirname(__FILE__) . "/conDB.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$ACCESS_TOKEN = $_SESSION['access_token'];

$key = file_get_contents('./key.pem');
$publicKey = openssl_pkey_get_public($key);
if (!$publicKey) {
    echo "Error getting public key: " . openssl_error_string();
    exit;
}

// return json
$json_data = file_get_contents('php://input');


$id = $_SESSION['id'];
$date = $_SESSION['date'];
$ac_token = $_SESSION['access_token'];


echo "</p>";

// session에서 user_key 값 가져오기
// $user_key = $_SESSION['user_key'];

// json 데이터 받기
// $json_data = file_get_contents('php://input');

$sql_sel = "SELECT * from corporate where id='$id'";
$result = mysqli_query($conn, $sql_sel);

// if (mysqli_num_rows($result) > 0) {
//     // user_data table에 데이터 저장
//     $sql = "UPDATE corporate SET user_key=$user_key, json_data='$json_data' where id=$id";
// } else {
//     // user_data table에 데이터 저장
$sql = "INSERT INTO corporate (id, json_data,date) VALUES ('$id', '$json_data','$date')";

//}

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// db 연결 종료
$conn->close();
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

    // var body = document.getElementById("api_json");
    // let decodedValue = decodeURIComponent(body.innerHTML);
    // body.innerHTML = decodedValue ;
    // let jsonData = decodedValue;


    // const xhr8 = new XMLHttpRequest();
    //     xhr8.open("POST", "corporateRegistrationAPIsend.php");
    //     xhr8.setRequestHeader("Content-type", "application/json");
    //     xhr8.onload = function() {
    //         if (xhr8.status === 200) {
    //             console.log("신고서 세액공제명세서 저장 완료");
    //         }
    //     };
    //     xhr8.send(jsonData);





</script>



