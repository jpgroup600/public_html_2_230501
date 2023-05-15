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
include("./conDB.php");

if($_POST) {
    $ORGANIZATION = '0001';
    $END_POINT = 'https://development.codef.io/v1/kr/public/cw/kcomwel-total-remuneration-report/list';
    $token = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzZXJ2aWNlX3R5cGUiOiIxIiwic2NvcGUiOlsicmVhZCJdLCJzZXJ2aWNlX25vIjoiMDAwMDAyMTkwMDAyIiwiZXhwIjoxNjc5ODM4MzQ1LCJhdXRob3JpdGllcyI6WyJJTlNVUkFOQ0UiLCJQVUJMSUMiLCJCQU5LIiwiRVRDIiwiU1RPQ0siLCJDQVJEIl0sImp0aSI6IjU1MjZhM2ZjLTllYTYtNGE1Zi04NmJmLTczNTY1ZmRjM2QxMSIsImNsaWVudF9pZCI6IjljMjdlZWIxLWQ0MTEtNDE5YS1iODIyLTYyMzA1NmZjMTU4OSJ9.H_TgkEmebnnyK8kCNYASrxfJerBeWiM5t_2UD4VBHF2OM7oc_VBeeFsPrt-Z46nyAX1kLobpNj_I-rpxCc1h1_4WfuBIbR2q4aAN-WX-IyVBkmLsgtsyhjj6kXIJxS5KWibDP1GkdijDTekaOB_VZwaefC_k-ArGv9JS821fqDp9hRQKdGAIaSM48ADPHXYDo3gPUfzDghNV1Ew510MvuBWKEnA-eaKv_aCvv6xBkQV-Uo7QSGFOUD0Q3TAq7ycdEjfDtexfo5W_t2TaYWnpxiqROF1jSX3khuawmQ4jWAXu6JzYJfbDBASm6mos5flJBuPEfJOsPtEZ7O-mO0IMig';
    $certFile = $_POST['certFile'];
    $certPassword = $_POST['certPassword'];
    $userType = $_POST['userType'];
    $identity = $_POST['identity'];
    $manageNo = $_POST['manageNo'];
    $year = $_POST['year'];

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
        'year' => $year
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
        <h1>고용산재보험 - 근로자고용정보현황조회, 보수총액신고서</h1>
        <legend>인증서 der파일</legend>
        <textarea name="certFile" required>
        </textarea><br>
        <?php
        // user_account 테이블에서 username 컬럼 값 가져오기
        $sql = "SELECT username FROM user_account where username='".$_SESSION['kakao_user_info']['kakao_account']['profile']['nickname']."'";
        $result = mysqli_query($conn, $sql);

        // 가져온 결과 출력
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <input type="password" name="certPassword" placeholder="인증서 비밀번호" required>
                <input type="text" name="userName" value="<? echo $row['username']; ?>" placeholder="성명" required>
                <input type="text" name="userType" value="<? echo $row['userType']; ?>" placeholder="사용자구분(0: '대표자 개인명의', 1: '대리인 개인명의', 2: '사업자명의 인증서')" style="width: 425px;" required>
                <?php
                if($row['userType'] == 0 || $row['userType'] == 1) {
                    ?>
                    <input type="text" name="identity" value="<? echo $row['user_birth']; ?>" placeholder="사용자구분: 0 or 1 => 주민등록번호, 사용자구분: 2 => 사업자번호" style="width: 375px;" required>
                    <?php
                } else {
                    ?>
                    <input type="text" name="identity" value="<? echo $row['user_bisnum']; ?>" placeholder="사용자구분: 0 or 1 => 주민등록번호, 사용자구분: 2 => 사업자번호" style="width: 375px;" required>
                    <?php
                }
                ?>
                <input type="text" name="manageNo" placeholder="관리번호" required>
                <input type="text" name="insuranceType" placeholder="보험년도(YYYY)" required>
        <?php
            }
        }
        ?>

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
