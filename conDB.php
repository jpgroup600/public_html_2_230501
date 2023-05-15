<?php
// MySQL 서버 정보 설정
$servername = "141.164.63.149";  // MySQL 서버 주소 (localhost 또는 IP 주소)
$username = "yaemkvbzpa";         // MySQL 사용자 이름
$password = "aJX2g7DxUb";     // MySQL 사용자 비밀번호
$dbname = "yaemkvbzpa";     // 접속할 데이터베이스 이름

// MySQL 서버에 접속
$conn = mysqli_connect($servername, $username, $password, $dbname);

// 접속 확인
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$conn->set_charset("utf8");

?>





