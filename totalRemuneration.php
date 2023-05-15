<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>API</title>
</head>
<body>
<?php
session_start();

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
    $ORGANIZATION = '0001';
    $END_POINT = 'https://development.codef.io/v1/kr/public/cw/kcomwel-employment/detail';
    $token = $ACCESS_TOKEN;
    $certFile = $_POST['certFile'];
    $certPassword = $_POST['certPassword'];
    $userName = $_POST['userName'];
    $userType = $_POST['userType'];
    $identity = $_POST['identity'];
    $manageNo = $_POST['manageNo'];
    $insuranceType = $_POST['insuranceType'];

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
    // userType값 default 는 2 (사업자명의 인증서)
    // identitiy 값은 default로 (사업자 번호)
    $data = array(
        'organization' => $ORGANIZATION,
        'certFile' => $certFile,
        'certPassword' => $encrypted,
        'certType' => 'pfx',
        'userType' => $userType,
        'identity' => $identity,
        'manageNo' => $manageNo,
        'insuranceType' => $insuranceType,
        'userName' => $userName,
    );

// JSON으로 인코딩
    $json_data = json_encode($data);
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
        "Authorization: Bearer ".$token
    ));
// 응답 받기
    $response = urldecode(curl_exec($ch));
// url decode
    $response = urldecode($response);
// cURL 종료
    curl_close($ch);
} else {
    ?>

    <form action="" method="post">
        <h1>고용산재보험 근로자고용정보현황</h1>
        <legend>인증서 der파일</legend>
        <textarea name="certFile" required>
        </textarea><br>
        <input type="text" name="certPassword" placeholder="인증서 비밀번호" required>
        <input type="text" name="userName" placeholder="성명" required>
        <input type="text" name="userType" placeholder="사용자구분(0: '대표자 개인명의', 1: '대리인 개인명의', 2: '사업자명의 인증서')" style="width: 455px;" required>
        <input type="text" name="identity" placeholder="사업자번호" required>
        <input type="text" name="manageNo" placeholder="관리번호" required>
        <input type="text" name="insuranceType" placeholder="보험구분(0: '전체', 1: '산재보험', 2: '고용보험')" style="width: 275px;" required>

        <a href="https://developer.codef.io/products/public/each/pp/employment-detail">링크를 통해 인증서 필요 정보 확인</a>
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
