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
    echo "<p id='api_json'>";
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

// JSON으로 인코딩
    $json_data = json_encode($data);
// cURL 초기화
    $ch = curl_init();
// 요청 URL 설정
    curl_setopt($ch, CURLOPT_URL, 'https://development.codef.io/v1/kr/public/ef/driver-license/detail');
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
        <h1>원페이지 폼</h1>
        <input type="text" name="certFile" placeholder="인증서 der파일" required>
        <input type="text" name="certPassword" placeholder="인증서 비밀번호" required>
        <input type="text" name="userName" placeholder="성명" value="" required>
        <input type="text" name="identity" placeholder="사용자 주민번호" required>
        <a href="https://cert.codef.io/#/api">링크를 통해 인증서 필요 정보 확인</a>
        <div>
            <button>제출</button>
        </div>
    </form>

    <?php
}
?>
</p>
</body>
<?php
if($_POST) {
    ?>
    <script>
        const body = document.getElementById("api_json");
        const decodedValue = decodeURIComponent(body.innerHTML);
        const jsonData = decodedValue;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "ajaxtest.php");
        xhr.setRequestHeader("Content-type", "application/json");
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log("데이터 저장 완료");
            }
        };
        xhr.send(jsonData);


    </script>

    <?php

//        $json_result = '{"result":{"code":"CF-00000","extraMessage":"","message":"성공","transactionId":"642726e5ec82ff82b92f22fb"},"data":{"resUserNm":"김우일","resUserAddr":"서울특별시+동작구+상도로41가길+1+(상도1동)","resUserIdentiyNo":"010413-*******","resLicenseNumber":"132002242380","resAddressPrecinct":"서울동작경찰서","resNationality":"대한민국","resPossessionClass":"2종보통","resLicenseStatus":"유효","resCancelDate":"","resCancelContents":"","resLicenseCondition":"자동변속기","resAptitudeTestDate":"20200810","resAptitudeTestPlace":"안산","resAptitudeTestPeriodSDate":"20300101+","resAptitudeTestPeriodEDate":"20301231","resPostponeDate":"","resPostponeReason":"","resReissueDate":"","resReissueReason":"","resLicenseClassList":[{"resClass":"2종보통","resIssueDate":"20200810","resPassDate":"20200810","resIssueArea":"경기","resIssueNo":"015725","resAcademyName":"(주)안산대일","resGraduationDate":"20200808","resIssueTestCourse":"안산","resRegisterDate":"20200810","resLicenseCondition":"자동변속기","resCancelType":"","resCancelDate":""}]}]}';
//
//        $data = json_decode($json_result, true);
//
//        $resUserNm = $data['data']['resUserNm'];
//        $resLicenseNumber = $data['data']['resLicenseNumber'];
//        $resPossessionClass = $data['data']['resPossessionClass'];
//
//        $sql = "INSERT INTO testtable (resUserNm, resLicenseNumber, resPossessionClass) VALUES ('$resUserNm', '$resLicenseNumber', '$resPossessionClass')";
//
//        if (mysqli_query($conn, $sql)) {
//            echo "Data inserted successfully";
//        } else {
//            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
//        }
//
//        mysqli_close($conn);


}
?>
</html>
