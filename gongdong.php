
<?php
session_start();
$data = $_POST['data']; // 전송된 데이터를 받아옵니다.

$_SESSION['send_data'] = $data;
// 데이터 처리 코드를 작성합니다.



// foreach ($data["data"] as $item) {
//     echo "<a href=gongdong2.php?count=$count>". $item["infoData"]["ownerName"] . "</a> <br>";
//      $count++;
//       }








?>