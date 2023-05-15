<?php
session_start();
include_once dirname(__FILE__) . "/conDB.php";

// session에서 user_key 값 가져오기
$user_key = $_SESSION['user_key'];

// json 데이터 받기
$json_data = file_get_contents('php://input');


$id = $_SESSION['id'];
$date = $_SESSION['date'];
$ac_token = $_SESSION['access_token'];
$sql_sel = "SELECT * from corporate where id='$id'";
$result = mysqli_query($conn, $sql_sel);

// if (mysqli_num_rows($result) > 0) {
//     // user_data table에 데이터 저장
//     $sql = "UPDATE corporate SET user_key=$user_key, json_data='$json_data' where id=$id";
// } else {
//     // user_data table에 데이터 저장
$sql = "INSERT INTO corporate (id, json_data,date) VALUES ('$id', '$json_data','$date')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// db 연결 종료
$conn->close();
?>