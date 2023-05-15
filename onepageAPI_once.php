<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>API form</title>
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
    echo "<div>";
    $token = $ACCESS_TOKEN;
    $certFile = $_POST['certFile'];
    $certPassword = $_POST['certPassword'];
    $userName = $_POST['userName'];
    $userIdentity = $_POST['userIdentity']; // 주민번호
    echo "useridentity: ".$userIdentity;
    $userType = $_POST['userType'];
    $identity = $_POST['identity']; // 사업자번호
    echo "identity: ".$identity;
    $manageNo = $_POST['manageNo'];
    $insuranceType = $_POST['insuranceType'];
    $start = $_POST['startDate'];
    $timestart = strtotime($start); // Unix timestamp로 변환
    $startDate = date('Ymd', $timestart); // YYYYMMDD 형식으로 변환
    $end = $_POST['endDate'];
    $timeend = strtotime($end); // Unix timestamp로 변환
    $endDate = date('Ymd', $timeend); // YYYYMMDD 형식으로 변환
    $inquiryType = $_POST['inquiryType'];
    $year = "2022";   // 보험년도
    $infoViewYn = $_POST['infoViewYn'];
    $usePurposes = "99";
    $submitTargets = "99";
    $phoneNo = $_POST['phoneNo'];
    $email = $_POST['email'];
    $der_file = $_SESSION['der_file']; 
    $key_file = $_SESSION['key_file']; 

    // user_account에 insert
    $sql = "UPDATE user_account SET username='$userName', user_birth='$userIdentity', user_bisnum='$identity', userType='$userType', manageNo='$manageNo', insuranceType='$insuranceType', phoneNo='$phoneNo', email='$email' WHERE user_key=".$_SESSION['user_key'];

// 쿼리 실행
    if (mysqli_query($conn, $sql)) {
        echo "회원 정보가 업데이트 되었습니다.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }


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

    // 근로자고용정보현황조회
    $END_POINT = ' ';
    echo "<p id='api_json'>";
    // JSON 요청 데이터
        // userType값 default 는 2 (사업자명의 인증서)
        // identitiy 값은 default로 (사업자 번호)
        $data = array(
            'organization' => "0001",
            'certFile' => $der_file,
            'keyFile' => $key_file,
            'certPassword' => $encrypted,
            'certType' => '1',
            'userType' => "2",
            'identity' => $identity,
            'manageNo' => $manageNo,
            'insuranceType' => $insuranceType,
            'userIdentity' => $userIdentity,
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
    echo "</p>";


    // 보수총액신고서
    echo "<p id='api_json2'>";
    $END_POINT = 'https://development.codef.io/v1/kr/public/cw/kcomwel-total-remuneration-report/list';

    // JSON 요청 데이터
        // userType값 default 는 2 (사업자명의 인증서)
        // identitiy 값은 default로 (사업자 번호)
        $data = array(
            'organization' => "0001",
            'certFile' => $der_file,
            'keyFile' => $key_file,
            'certPassword' => $encrypted,
            'certType' => '1',
            'userType' => "2",
            'identity' => $identity,
            'manageNo' => $manageNo,
            'year' => $year,
            
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
        echo "</p>";



    // 신고서 법인세 과세표준 및 세액신고서
    echo "<p id='api_json3'>";
    $END_POINT = 'https://development.codef.io/v1/kr/public/nt/report/corporate-tax-base';

    // JSON 요청 데이터
        // userType값 default 는 2 (사업자명의 인증서)
        // identitiy 값은 default로 (사업자 번호)
        $data = array(
            'organization' => "0005",
            'certFile' => $der_file,
            'keyFile' => $key_file,
            'certPassword' => $encrypted,
            'certType' => '1',
            'startDate' => $startDate,
            'endDate' => $endDate,
            'identity' => $identity
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
    echo "</p>";



    // 종합소득세,농어촌특별세,주민세 과세표준확정신고 및 납부계산서
    echo "<p id='api_json4'>";
    $END_POINT = 'https://development.codef.io/v1/kr/public/nt/report/final-return-tax-base';
    // JSON 요청 데이터
        // userType값 default 는 2 (사업자명의 인증서)
        // identitiy 값은 default로 (사업자 번호)
        $data = array(
            'organization' => '0005',
            'certFile' => $der_file,
            'keyFile' => $key_file,
            'certPassword' => $encrypted,
            'certType' => '1',
            'startDate' => $startDate,
            'endDate' => $endDate,
            'identity' => $identity
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
    echo "</p>";



    // 신고서 표준대차대조표
    echo "<p id='api_json5'>";
    $END_POINT = 'https://development.codef.io/v1/kr/public/nt/report/balance-sheet';
    // JSON 요청 데이터
        // userType값 default 는 2 (사업자명의 인증서)
        // identitiy 값은 default로 (사업자 번호)
        $data = array(
            'organization' => '0005',
            'certFile' => $der_file,
            'keyFile' => $key_file,
            'certPassword' => $encrypted,
            'certType' => '1',
            'startDate' => $startDate,
            'endDate' => $endDate,
            'identity' => $identity
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
    echo "</p>";



    // 신고서 표준손익계산서
    echo "<p id='api_json6'>";
    $END_POINT = 'https://development.codef.io/v1/kr/public/nt/report/income-statement';
    // JSON 요청 데이터
        // userType값 default 는 2 (사업자명의 인증서)
        // identitiy 값은 default로 (사업자 번호)
        $data = array(
            'organization' => '0005',
            'certFile' => $der_file,
            'keyFile' => $key_file,
            'certPassword' => $encrypted,
            'certType' => '1',
            'startDate' => $startDate,
            'endDate' => $endDate,
            'identity' => $identity
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
    echo "</p>";



    // 신고서 법인세 과세표준 및 세액조정신고서
    echo "<p id='api_json7'>";
    $END_POINT = 'https://development.codef.io/v1/kr/public/nt/report/corporate-tax-adjustment';
    // JSON 요청 데이터
        // userType값 default 는 2 (사업자명의 인증서)
        // identitiy 값은 default로 (사업자 번호)
        $data = array(
            'organization' => '0005',
            'certFile' => $der_file,
            'keyFile' => $key_file,
            'certPassword' => $encrypted,
            'certType' => '1',
            'startDate' => $startDate,
            'endDate' => $endDate,
            'identity' => $identity
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
    echo "</p>";



    // 신고서 세액공제명세서
    echo "<p id='api_json8'>";
    $END_POINT = 'https://development.codef.io/v1/kr/public/nt/report/tax-deduction-statement';

    // JSON 요청 데이터
        // userType값 default 는 2 (사업자명의 인증서)
        // identitiy 값은 default로 (사업자 번호)
        $data = array(
            'organization' => '0005',
            'certFile' => $der_file,
            'keyFile' => $key_file,
            'certPassword' => $encrypted,
            'certType' => '1',
            'startDate' => $startDate,
            'endDate' => $endDate,
            'identity' => $identity,
            'inquiryType' => $inquiryType
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
    echo "</p>";



    // 신고서 사업소득명세서
    echo "<p id='api_json9'>";
    $END_POINT = 'https://development.codef.io/v1/kr/public/nt/report/business-income-statement';
    // JSON 요청 데이터
        // userType값 default 는 2 (사업자명의 인증서)
        // identitiy 값은 default로 (사업자 번호)
        $data = array(
            'organization' => '0005',
            'certFile' => $der_file,
            'keyFile' => $key_file,
            'certPassword' => $encrypted,
            'certType' => '1',
            'startDate' => $startDate,
            'endDate' => $endDate,
            'identity' => $identity,
            'inquiryType' => $inquiryType
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
    echo "</p>";



    // 신고서 공제감면세액 및 추가납부세액합계표(갑)
    echo "<p id='api_json10'>";
    $END_POINT = 'https://development.codef.io/v1/kr/public/nt/report/deductible-tax-exemption-amount-additional-tax-to-be-paid';
    // JSON 요청 데이터
        // userType값 default 는 2 (사업자명의 인증서)
        // identitiy 값은 default로 (사업자 번호)
        $data = array(
            'organization' => '0005',
            'certFile' => $der_file,
            'keyFile' => $key_file,
            'certPassword' => $encrypted,
            'certType' => '1',
            'startDate' => $startDate,
            'endDate' => $endDate,
            'identity' => $identity,
            'inquiryType' => $inquiryType
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
    echo "</p>";



    // 증명발급 사업자등록 증명
    echo "<p id='api_json11'>";
    $END_POINT = 'https://development.codef.io/v1/kr/public/nt/proof-issue/corporate-registration';
    // JSON 요청 데이터
        // userType값 default 는 2 (사업자명의 인증서)
        // identitiy 값은 default로 (사업자 번호)
        $data = array(
            'organization' => '0001',
            'loginType' => '0',
            'certType' => '1',
            'certFile' => $der_file,
            'keyFile' => $key_file,
            'certPassword' => $encrypted,
            'loginIdentity' => $userIdentity,
            'userName' => $userName,
            'manageNo' => $identity,
            'usePurposes' => $usePurposes,
            'submitTargets' => $submitTargets,
            'isIdentityViewYN' => $infoViewYn,
            'identity' => $identity,
            'phoneNo' => $phoneNo
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
    echo "</p>";



    // 신고서 세액공제조정명세서
    echo "<p id='api_json12'>";
    $END_POINT = 'https://development.codef.io/v1/kr/public/nt/report/tax-credit-reconciliation';

    // JSON 요청 데이터
        // userType값 default 는 2 (사업자명의 인증서)
        // identitiy 값은 default로 (사업자 번호)
        $data = array(
            'organization' => '0005',
            'certFile' => $der_file,
            'keyFile' => $key_file,
            'certPassword' => $encrypted,
            'certType' => '1',
            'startDate' => $startDate,
            'endDate' => $endDate,
            'identity' => $identity,
            'inquiryType' => $inquiryType
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
    echo "</p>";
    echo "</div>";

} else {
    ?>

    <?php
    include 'gongdong2.php';
    //공동인증서 값 가져오기 
    echo "값출력".$_SESSION['der_file']; 
    echo "값출력".$_SESSION['key_file']; 
    
    ?>

<a href="/pro_files/certBridge.exe" download>인증서 프로그램 다운로드</a>

    <form action="" method="post">
        <h1>원페이지 폼</h1>
        <!-- <input type="text" name="certFile" placeholder="인증서 der파일" required> -->
        <input type="text" name="certPassword" placeholder="인증서 비밀번호" required>
        <input type="text" name="userName" placeholder="성명" value="<?= $_SESSION['username'] ?>" required>
        <input type="text" name="userIdentity" placeholder="사용자 주민번호" value="<?= $_SESSION['user_birth'] ?>" required>
        사용자 구분
        <select name="userType">
            <option value="0" selected>개인</option>
            <option value="1">법인</option>
        </select>
        <input type="text" name="identity" placeholder="사업자 번호" value="<?= $_SESSION['user_bisnum'] ?>">
        <input type="text" name="manageNo" placeholder="관리 번호" value="<?= $_SESSION['manageNo'] ?>">
        보험구분
        <select name="insuranceType">
            <option value="0" selected>전체</option>
            <option value="1" disabled>산재보험</option>
            <option value="2" disabled>고용보험</option>
        </select>
<!--        TODO 보험년도-->
        조회시작
        <input type="date" name="startDate"
               value="<?= date('Y-m-d', strtotime('-5 years')); ?>">
        조회종료
        <input type="date" name="endDate"
               value="<?= date('Y-m-d', strtotime('-5 years')); ?>">
        조회구분
        <select name="inquiryType">
            <option value="0" disabled>고용일</option>
            <option value="1" selected>고용종료일</option>
            <option value="2" disabled>휴직시작일</option>
            <option value="3" disabled>휴직종료일</option>
            <option value="4" disabled>전보일</option>
            <option value="5" disabled>조회기간</option>
        </select>
        주민번호 뒷자리 공개여부
        <select name="infoViewYn">
            <option value="0">비공개</option>
            <option value="1" selected>공개</option>
        </select>
        <!--   사용용도(usePurposes) - 기타:99 로 고정, 제출처(submitTargets) - 기타:99 로 고정    -->
        <input type="text" name="phoneNo" placeholder="전화번호" value="<?= $_SESSION['phoneNo'] ?>">
        <input type="text" name="email" placeholder="이메일" value="<?= $_SESSION['email'] ?>">
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

        // 근로자고용정보현황조회
        let body = document.getElementById("api_json");
        let decodedValue = decodeURIComponent(body.innerHTML);
        body.innerHTML = decodedValue;
        let jsonData = decodedValue;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "employmentStatusAPI.php");
        xhr.setRequestHeader("Content-type", "application/json");
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log("근로자고용정보현황조회 저장 완료");
            }
        };
        xhr.send(jsonData);


        // 고용산재보험 보수총액신고서
        body = document.getElementById("api_json2");
        decodedValue = decodeURIComponent(body.innerHTML);
        body.innerHTML = decodedValue;
        jsonData = decodedValue;

        const xhr2 = new XMLHttpRequest();
        xhr2.open("POST", "totalRemunerationAPI.php");
        xhr2.setRequestHeader("Content-type", "application/json");
        xhr2.onload = function() {
            if (xhr2.status === 200) {
                console.log("고용산재보험 보수총액신고서 저장 완료");
            }
        };
        xhr2.send(jsonData);


        // 신고서 법인세 과세표준 및 세액신고서
        body = document.getElementById("api_json3");
        decodedValue = decodeURIComponent(body.innerHTML);
        body.innerHTML = decodedValue;
        jsonData = decodedValue;

        const xhr3 = new XMLHttpRequest();
        xhr3.open("POST", "taxReportAPI.php");
        xhr3.setRequestHeader("Content-type", "application/json");
        xhr3.onload = function() {
            if (xhr3.status === 200) {
                console.log("신고서 법인세 과세표준 및 세액신고서 저장 완료");
            }
        };
        xhr3.send(jsonData);


        // 종합소득세,농어촌특별세,주민세 과세표준확정신고 및 납부계산서
        body = document.getElementById("api_json4");
        decodedValue = decodeURIComponent(body.innerHTML);
        body.innerHTML = decodedValue;
        jsonData = decodedValue;

        const xhr4 = new XMLHttpRequest();
        xhr4.open("POST", "taxPaymentStatusAPI.php");
        xhr4.setRequestHeader("Content-type", "application/json");
        xhr4.onload = function() {
            if (xhr4.status === 200) {
                console.log("종합소득세,농어촌특별세,주민세 과세표준확정신고 및 납부계산서 저장 완료");
            }
        };
        xhr4.send(jsonData);


        // 신고서 표준대차대조표
        body = document.getElementById("api_json5");
        decodedValue = decodeURIComponent(body.innerHTML);
        body.innerHTML = decodedValue;
        jsonData = decodedValue;

        const xhr5 = new XMLHttpRequest();
        xhr5.open("POST", "BalanceSheetAPI.php");
        xhr5.setRequestHeader("Content-type", "application/json");
        xhr5.onload = function() {
            if (xhr5.status === 200) {
                console.log("신고서 표준대차대조표 저장 완료");
            }
        };
        xhr5.send(jsonData);


        // 신고서 표준손익계산서
        body = document.getElementById("api_json6");
        decodedValue = decodeURIComponent(body.innerHTML);
        body.innerHTML = decodedValue;
        jsonData = decodedValue;

        const xhr6 = new XMLHttpRequest();
        xhr6.open("POST", "incomeStatementAPI.php");
        xhr6.setRequestHeader("Content-type", "application/json");
        xhr6.onload = function() {
            if (xhr6.status === 200) {
                console.log("신고서 표준손익계산서 저장 완료");
            }
        };
        xhr6.send(jsonData);


        // 신고서 법인세 과세표준 및 세액조정신고서
        body = document.getElementById("api_json7");
        decodedValue = decodeURIComponent(body.innerHTML);
        body.innerHTML = decodedValue;
        jsonData = decodedValue;

        const xhr7 = new XMLHttpRequest();
        xhr7.open("POST", "taxAdjustmentAPI.php");
        xhr7.setRequestHeader("Content-type", "application/json");
        xhr7.onload = function() {
            if (xhr7.status === 200) {
                console.log("신고서 법인세 과세표준 및 세액조정신고서 저장 완료");
            }
        };
        xhr7.send(jsonData);


        // 신고서 세액공제명세서
        body = document.getElementById("api_json8");
        decodedValue = decodeURIComponent(body.innerHTML);
        body.innerHTML = decodedValue;
        jsonData = decodedValue;

        const xhr8 = new XMLHttpRequest();
        xhr8.open("POST", "taxDeductionStatementAPI.php");
        xhr8.setRequestHeader("Content-type", "application/json");
        xhr8.onload = function() {
            if (xhr8.status === 200) {
                console.log("신고서 세액공제명세서 저장 완료");
            }
        };
        xhr8.send(jsonData);


        // 신고서 사업소득명세서
        body = document.getElementById("api_json9");
        decodedValue = decodeURIComponent(body.innerHTML);
        body.innerHTML = decodedValue;
        jsonData = decodedValue;

        const xhr9 = new XMLHttpRequest();
        xhr9.open("POST", "businessIncomeStatement.php");
        xhr9.setRequestHeader("Content-type", "application/json");
        xhr9.onload = function() {
            if (xhr9.status === 200) {
                console.log("신고서 사업소득명세서 저장 완료");
            }
        };
        xhr9.send(jsonData);


        // 신고서 공제감면세액 및 추가납부세액합계표(갑)
        body = document.getElementById("api_json10");
        decodedValue = decodeURIComponent(body.innerHTML);
        body.innerHTML = decodedValue;
        jsonData = decodedValue;

        const xhr10 = new XMLHttpRequest();
        xhr10.open("POST", "deductibleTaxExemptionAPI.php");
        xhr10.setRequestHeader("Content-type", "application/json");
        xhr10.onload = function() {
            if (xhr10.status === 200) {
                console.log("신고서 공제감면세액 및 추가납부세액합계표(갑) 저장 완료");
            }
        };
        xhr10.send(jsonData);


        // 증명발급 사업자등록 증명
        body = document.getElementById("api_json11");
        decodedValue = decodeURIComponent(body.innerHTML);
        body.innerHTML = decodedValue;
        jsonData = decodedValue;

        const xhr11 = new XMLHttpRequest();
        xhr11.open("POST", "corporateRegistrationAPI.php");
        xhr11.setRequestHeader("Content-type", "application/json");
        xhr11.onload = function() {
            if (xhr11.status === 200) {
                console.log("증명발급 사업자등록 증명 저장 완료");
            }
        };
        xhr11.send(jsonData);


        // 신고서 세액공제조정명세서
        body = document.getElementById("api_json12");
        decodedValue = decodeURIComponent(body.innerHTML);
        body.innerHTML = decodedValue;
        jsonData = decodedValue;

        const xhr12 = new XMLHttpRequest();
        xhr12.open("POST", "taxCreditReconciliationAPI.php");
        xhr12.setRequestHeader("Content-type", "application/json");
        xhr12.onload = function() {
            if (xhr12.status === 200) {
                console.log("신고서 세액공제조정명세서 저장 완료");
            }
        };
        xhr12.send(jsonData);


        // window.location.href = 'https://phpstack-761997-3303412.cloudwaysapps.com/';
    </script>

    <?php
}
?>
</html>
