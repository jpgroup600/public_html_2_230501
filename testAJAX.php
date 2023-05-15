<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>API testing</title>
</head>
<body>
<?php
session_start();
include_once dirname(__FILE__)."/conDB.php";

if(isset($_SESSION['access_token'])) {
    $ACCESS_TOKEN = $_SESSION['access_token'];
} else {
    ?>

    <script>
        alert('세션 발급 이후 진행해주시기 바랍니다.');
        window.location.replace("https://phpstack-761997-3303412.cloudwaysapps.com/");
    </script>

    <?php
}


if($_POST) {
    $token = $ACCESS_TOKEN;
    $certFile = $_POST['certFile'];
    $certPassword = $_POST['certPassword'];
    $userName = $_POST['userName'];
    $identity = $_POST['identity'];

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

// JSON 요청 데이터
    $data = array(
        'organization' => '0001',
        'certFile' => $certFile,
        'certPassword' => $encrypted,
        'certType' => 'pfx',
        'userName' => $userName,
        'identity' => $identity
    );
// AJAX로 대체
//// JSON으로 인코딩
//    $json_data = json_encode($data);
//// cURL 초기화
//    $ch = curl_init();
//// 요청 URL 설정
//    curl_setopt($ch, CURLOPT_URL, 'https://development.codef.io/v1/kr/public/ef/driver-license/detail');
//// POST 요청 설정
//    curl_setopt($ch, CURLOPT_POST, true);
//// 요청 바디 설정
//    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
//// 요청 헤더 설정
//    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//        'Content-Type: application/json',
//        'Content-Length: ' . strlen($json_data),
//        "Authorization: Bearer ".$token
//    ));
//// 응답 받기
//    $response = urldecode(curl_exec($ch));
//// url decode
//    $response = urldecode($response);
//// cURL 종료
//    curl_close($ch);
    ?>
    <script>
        const token = "<?php echo $ACCESS_TOKEN; ?>";
        const certFile = "<?php echo $_POST['certFile'];?>";
        const certPassword = "<?php echo $encrypted;?>";
        const userName = "<?php echo $_POST['userName'];?>";
        const identity = "<?php echo $_POST['identity'];?>";

        const data = {
            organization: '0001',
            certFile: certFile,
            certPassword: certPassword,
            certType: 'pfx',
            userName: userName,
            identity: identity
        };

        const xhr = new XMLHttpRequest();
        const url = 'https://development.codef.io/v1/kr/public/ef/driver-license/detail';

        xhr.open('POST', url);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('Authorization', 'Bearer ' + token);

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = xhr.responseText;
                const decodedResponse = decodeURIComponent(response);
                console.log(decodedResponse);
            }
        };

        const jsonData = JSON.stringify(data);
        xhr.send(jsonData);
        console.log(jsonData);

    </script>

        <?php

} else {

    $sql = "SELECT * FROM yourtablename WHERE user_key = ".$_SESSION['user_key'];
    $result = mysqli_query($conn, $sql);
    // 결과에서 데이터 행 가져오기
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // json_decode 함수를 사용하여 JSON 데이터를 배열 형태로 변환
            $json_data = json_decode($row["json_data"], true);

            // JSON 데이터를 사용하여 필요한 작업 수행
            echo "json데이터에 저장된 이름: ".$json_data['data']['resUserNm'];
        }
    } else {
        echo "No results found.";
    }
    ?>

    <form action="" method="post">
        <h1>API 요청 테스트 (운전면허 상세)</h1>
        <input type="text" name="certFile" placeholder="인증서 der파일" required>
        <input type="text" name="certPassword" placeholder="인증서 비밀번호" required>
        <input type="text" name="userName" placeholder="성명" required>
        <input type="text" name="identity" placeholder="사용자 주민번호" required>
        <a href="https://cert.codef.io/#/api">링크를 통해 인증서 필요 정보 확인</a>
        <div>
            <button>제출</button>
        </div>
    </form>

    <?php
}
?>
</body>
<?php
if($_POST) {
    ?>
    <script>
        const body = document.getElementsByTagName("body")[0];
        // Decode the contents of the body
        const decoded = decodeURI(body.innerHTML);
        const decodedBody = decodeURI(decoded);
        const decodedValue = decodeURIComponent(decodedBody);
        // const jsonObject = JSON.parse(decodedValue);
        console.log(decodedValue);

        // Replace the contents of the body with the decoded contents
        body.innerHTML = decodedValue;
    </script>

    <?php
}
?>
</html>
