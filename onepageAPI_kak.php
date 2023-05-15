<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>API form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<?php

session_start();
include 'send_kako_data.php';
include_once dirname(__FILE__)."/conDB.php";

if(isset($_SESSION['access_token'])) {
    $ACCESS_TOKEN = $_SESSION['access_token'];
} else {
    ?>
    <script>
        alert('세션 발급 이후 진행해주시기 바랍니다.');
        window.location.replace("https://taxget.co.kr");
    </script>
    <?php
}

function return_first_word($userIdentity) {  //19년생 20년생 따라 나뉘는 앞단위 연산 
    $check_user = substr($userIdentity, 0, 2);
    $check_user = (int)$check_user;
    
    if($check_user > 20 )
    {
        $userIdentity_long = "19".$userIdentity;
        return $userIdentity_long;
    }
    
    else {

        $userIdentity_long = "20".$userIdentity;
        return $userIdentity_long;
    }

  }


  function send_api($url,$Ar_data) //API 전송 함수 
  {
    global $token;
    $END_POINT = $url;
    // JSON 요청 데이터
        // userType값 default 는 2 (사업자명의 인증서)
        // identitiy 값은 default로 (사업자 번호)
        $data = $Ar_data;
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

        $response_data = json_decode($response, true);

  }


if($_POST) {
    echo "<div>";
    $token = $ACCESS_TOKEN;
    global $token;
    $certFile = $_POST['certFile'];
    $certPassword = $_POST['certPassword'];
    $userName = $_POST['userName'];
    $userIdentity = $_POST['userIdentity']; // 주민번호
    $userIdentity2 = $_POST['userIdentity2']; // 주민번호
    echo "useridentity: ".$userIdentity;
    $userType = $_POST['userType'];
    $identity = $_POST['identity']; // 사업자번호
    // echo "identity: ".$identity;
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
    $userIdentity_r = $userIdentity.$userIdentity2;
    $id = $userName.$userIdentity_r;

    $userIdentity_long = return_first_word($userIdentity);

    // Assign variables to the session
$_SESSION['token'] = $ACCESS_TOKEN;
$_SESSION['certFile'] = $certFile;
$_SESSION['certPassword'] = $certPassword;
$_SESSION['userName'] = $userName;
$_SESSION['userIdentity'] = $userIdentity;
$_SESSION['userIdentity2'] = $userIdentity2;
$_SESSION['userType'] = $userType;
$_SESSION['identity'] = $identity;
$_SESSION['manageNo'] = $manageNo;
$_SESSION['insuranceType'] = $insuranceType;
$_SESSION['startDate'] = $startDate;
$_SESSION['endDate'] = $endDate;
$_SESSION['inquiryType'] = $inquiryType;
$_SESSION['year'] = "2022";
$_SESSION['infoViewYn'] = $infoViewYn;
$_SESSION['usePurposes'] = "99";
$_SESSION['submitTargets'] = "99";
$_SESSION['phoneNo'] = $phoneNo;
$_SESSION['email'] = $email;
$_SESSION['userIdentity_r'] = $userIdentity.$userIdentity2;
$_SESSION['id'] = $userName.$userIdentity_r;
    

    // echo "아이디 : $id";

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


    //API 시작 
    // 근로자고용정보현황조회

    // 보수총액신고서
    $END_POINT2 = 'https://development.codef.io/v1/kr/public/cw/kcomwel-total-remuneration-report/list';

       // JSON 요청 데이터
           // userType값 default 는 2 (사업자명의 인증서)
           // identitiy 값은 default로 (사업자 번호)
           $data2 = array(
               'organization' => "0001",
               'userType' => "0",
               'manageNo' => $manageNo,
               'identity' => $userIdentity_r,
               'year' => $year,
               'userName' => $userName,
               'loginType' => "5",
               'loginTypeLevel' => "1",
               'loginUserName' => $userName,
               'phoneNo' => $phoneNo,
   
   );

   $END_POINT3 = 'https://development.codef.io/v1/kr/public/nt/report/corporate-tax-base';

   // JSON 요청 데이터
       // userType값 default 는 2 (사업자명의 인증서)
       // identitiy 값은 default로 (사업자 번호)
       $data3 = array(
           'organization' => "0005",
           'startDate' => $startDate,
           'endDate' => $endDate,
           'identity' => $identity,
           'loginType' => "5",
           'loginTypeLevel' => "1",
           'userName' => $userName,
           'loginIdentity' => $userIdentity_long,
           'phoneNo' => $phoneNo,
      
       );

        // 종합소득세,농어촌특별세,주민세 과세표준확정신고 및 납부계산서
    $END_POINT4 = 'https://development.codef.io/v1/kr/public/nt/report/final-return-tax-base';
    // JSON 요청 데이터
        // userType값 default 는 2 (사업자명의 인증서)
        // identitiy 값은 default로 (사업자 번호)
        $data4 = array(
            'organization' => '0005',
            'startDate' => $startDate,
            'endDate' => $endDate,
            'identity' => $identity,
            'loginType' => "5",
            'loginTypeLevel' => "1",
            'userName' => $userName,
            'loginIdentity' => $userIdentity_long,
            'phoneNo' => $phoneNo,

        );

    // 신고서 세액공제명세서
    $END_POINT8 = 'https://development.codef.io/v1/kr/public/nt/report/tax-deduction-statement';

    // JSON 요청 데이터
        // userType값 default 는 2 (사업자명의 인증서)
        // identitiy 값은 default로 (사업자 번호)
        $data8 = array(
            'organization' => '0005',
            'startDate' => $startDate,
            'endDate' => $endDate,
            'identity' => $identity,
            'inquiryType' => $inquiryType,
            'loginType' => "5",
            'loginTypeLevel' => "1",
            'userName' => $userName,
            'loginIdentity' => $userIdentity_long,
            'phoneNo' => $phoneNo,
        );

    // 신고서 사업소득명세서
    $END_POINT9 = 'https://development.codef.io/v1/kr/public/nt/report/business-income-statement';
    // JSON 요청 데이터
        // userType값 default 는 2 (사업자명의 인증서)
        // identitiy 값은 default로 (사업자 번호)
        $data9 = array(
            'organization' => '0005',
            'startDate' => $startDate,
            'endDate' => $endDate,
            'identity' => $identity,
            'inquiryType' => $inquiryType,
            'loginType' => "5",
            'loginTypeLevel' => "1",
            'userName' => $userName,
            'loginIdentity' => $userIdentity_long,
            'phoneNo' => $phoneNo,
        );

    // 신고서 공제감면세액 및 추가납부세액합계표(갑)
    $END_POINT10 = 'https://development.codef.io/v1/kr/public/nt/report/deductible-tax-exemption-amount-additional-tax-to-be-paid';
    // JSON 요청 데이터
        // userType값 default 는 2 (사업자명의 인증서)
        // identitiy 값은 default로 (사업자 번호)
        $data10 = array(
            'organization' => '0005',
            'startDate' => $startDate,
            'endDate' => $endDate,
            'identity' => $userIdentity_r,
            'inquiryType' => $inquiryType,
            'loginType' => "5",
            'loginTypeLevel' => "1",
            'userName' => $userName,
            'loginIdentity' => $userIdentity_long,
            'phoneNo' => $phoneNo,
        );

         // 증명발급 사업자등록 증명
    $END_POINT11 = 'https://development.codef.io/v1/kr/public/nt/proof-issue/corporate-registration';
    // JSON 요청 데이터
        // userType값 default 는 2 (사업자명의 인증서)
        // identitiy 값은 default로 (사업자 번호)
        $data11 = array(
            'organization' => '0001',
            'loginType' => '5',
            'loginIdentity' => $userIdentity_long,
            'userName' => $userName,
            'manageNo' => $identity,
            'usePurposes' => $usePurposes,
            'submitTargets' => $submitTargets,
            'isIdentityViewYN' => $infoViewYn,
            'identity' => $identity,
            'phoneNo' => $phoneNo,
            'loginTypeLevel' => "1",

        );



    
    echo "<p id='api_json'>";
    send_api($END_POINT1,$data1); // 근로자고용정보현황조회
    echo "</p>";

    $ajax_request = $_POST['ajax_request'];

    echo "<button id='send-auth'>2차 인증 제출하기</button>"; //send 2nd auth 

    if ($ajax_request == '1') { //start if 

        echo "hello";

    echo "<p id='api_json2'>";
    send_api($END_POINT2,$data2); // 근로자고용정보현황조회
    echo "</p>";

    sleep(2);

    // 신고서 법인세 과세표준 및 세액신고서
    echo "<p id='api_json3'>";
    send_api($END_POINT3,$data3);
    echo "</p>";

    sleep(2);

      
    echo "<p id='api_json4'>";
    send_api($END_POINT4,$data4);
    echo "</p>";

    sleep(2);


    
    echo "<p id='api_json8'>";
    send_api($END_POINT8,$data8);
    echo "</p>";

    sleep(2);



    
    echo "<p id='api_json9'>";
    send_api($END_POINT9,$data9);
    echo "</p>";

    sleep(2);



    
    echo "<p id='api_json10'>";
    send_api($END_POINT10,$data10);
    echo "</p>";

    sleep(2);



   
    echo "<p id='api_json11'>";
    send_api($END_POINT11,$data11);
    echo "</p>";

    sleep(2);

    echo "<div id=result></div>";
    
}

 


   





    // 신고서 세액공제조정명세서
    // echo "<p id='api_json12'>";
    // $END_POINT = 'https://development.codef.io/v1/kr/public/nt/report/tax-credit-reconciliation';

    // // JSON 요청 데이터
    //     // userType값 default 는 2 (사업자명의 인증서)
    //     // identitiy 값은 default로 (사업자 번호)
    //     $data = array(
    //         'organization' => '0005',
    //         'startDate' => $startDate,
    //         'endDate' => $endDate,
    //         'identity' => $userIdentity_r,
    //         'inquiryType' => $inquiryType,
    //         'loginType' => "5",
    //         'loginTypeLevel' => "1",
    //         'userName' => $userName,
    //         'loginIdentity' => $userIdentity_long,
    //         'phoneNo' => $phoneNo,
    //         'manageNo' => $manageNo,
    //         'id' => $id,
    //     );

    // // JSON으로 인코딩
    //     $json_data = json_encode($data);
    // // cURL 초기화
    //     $ch = curl_init();
    // // 요청 URL 설정
    //     curl_setopt($ch, CURLOPT_URL, $END_POINT);
    // // POST 요청 설정
    //     curl_setopt($ch, CURLOPT_POST, true);
    // // 요청 바디 설정
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    // // 요청 헤더 설정
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    //         'Content-Type: application/json',
    //         'Content-Length: ' . strlen($json_data),
    //         "Authorization: Bearer ".$token
    //     ));
    // // 응답 받기
    //     $response = urldecode(curl_exec($ch));
    // // url decode
    //     $response = urldecode($response);
    // // cURL 종료
    //     curl_close($ch);
    // echo "</p>";
    // echo "</div>";

} else {
    ?>

<style>

.form_style {
    margin: auto;
display: flex;
flex-direction: column;
align-items: center;
justify-content: center;
gap: 10px;
}
</style>

<form action= "" method="post" class="form_style">
        <h1>원페이지 폼</h1>
        <!-- <input type="text" name="certFile" placeholder="인증서 der파일" required>
        <input type="text" name="certPassword" placeholder="인증서 비밀번호" required> -->
        <div><input type="text" name="userName" placeholder="성명" value="<?= $_SESSION['username'] ?>" required></div>
        <div><input type="text" name="userIdentity" placeholder="사용자 주민번호 앞자리" value="<?= $_SESSION['user_birth'] ?>" required></div>
        <div><input type="text" name="userIdentity2" placeholder="사용자 주민번호 뒷자리" value="<?= $_SESSION['user_birth2'] ?>" required></div>
        <div> 사용자 구분
       <select name="userType">
            <option value="0" selected>개인</option>
            <option value="1">법인</option>
        </select>
</div>
        <div><input type="text" name="identity" placeholder="사업자 번호" value="<?= $_SESSION['user_bisnum'] ?>"></div>
        <div><input type="text" name="manageNo" placeholder="관리 번호" value="<?= $_SESSION['manageNo'] ?>"></div>
      <div>  보험구분
        <select name="insuranceType">
            <option value="0" selected>전체</option>
            <option value="1" disabled>산재보험</option>
            <option value="2" disabled>고용보험</option>
        </select></div>
<!--        TODO 보험년도-->
       <div> 조회시작
        <input type="date" name="startDate"
               value="<?= date('Y-m-d', strtotime('-5 years')); ?>"></div>
        <div>조회종료
        <input type="date" name="endDate"
               value="<?= date('Y-m-d', strtotime('-5 years')); ?>"></div>
        <div>조회구분
        <select name="inquiryType">
            <option value="0" disabled>고용일</option>
            <option value="1" selected>고용종료일</option>
            <option value="2" disabled>휴직시작일</option>
            <option value="3" disabled>휴직종료일</option>
            <option value="4" disabled>전보일</option>
            <option value="5" disabled>조회기간</option>
        </select></div>
        <div>주민번호 뒷자리 공개여부
        <select name="infoViewYn">
            <option value="0">비공개</option>
            <option value="1" selected>공개</option>
        </select></div>
        <!--   사용용도(usePurposes) - 기타:99 로 고정, 제출처(submitTargets) - 기타:99 로 고정    -->
        <div><input type="text" name="phoneNo" placeholder="전화번호" value="<?= $_SESSION['phoneNo'] ?>"></div>
        <div><input type="text" name="email" placeholder="이메일" value="<?= $_SESSION['email'] ?>"></div>
        <a href="https://cert.codef.io/#/api">링크를 통해 인증서 필요 정보 확인</a>
        <div>
            <button id="click-button">제출</button>
        </div>
        <div class="extra_button" id="extra-button"></div>

        
    </form>
    <li><a href="<?php echo $kakaologin->redirect_uri; 
            ?>?logout=true">로그아웃</a></li>

    <?php

}
?>
</body>
<?php
if($_POST) {
    ?>


    <script>

        // 근로자고용정보현황조회
        var body = document.getElementById("api_json");
        let decodedValue = decodeURIComponent(body.innerHTML);
        body.innerHTML = decodedValue ;
        // body.innerHTML = "<h1>hello</h1>";
        let jsonData = decodedValue;


        

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "employmentStatusAuthAPI.php");
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


        // // 신고서 표준대차대조표
        // body = document.getElementById("api_json5");
        // decodedValue = decodeURIComponent(body.innerHTML);
        // body.innerHTML = decodedValue;
        // jsonData = decodedValue;

        // const xhr5 = new XMLHttpRequest();
        // xhr5.open("POST", "BalanceSheetAPI.php");
        // xhr5.setRequestHeader("Content-type", "application/json");
        // xhr5.onload = function() {
        //     if (xhr5.status === 200) {
        //         console.log("신고서 표준대차대조표 저장 완료");
        //     }
        // };
        // xhr5.send(jsonData);


        // // 신고서 표준손익계산서
        // body = document.getElementById("api_json6");
        // decodedValue = decodeURIComponent(body.innerHTML);
        // body.innerHTML = decodedValue;
        // jsonData = decodedValue;

        // const xhr6 = new XMLHttpRequest();
        // xhr6.open("POST", "incomeStatementAPI.php");
        // xhr6.setRequestHeader("Content-type", "application/json");
        // xhr6.onload = function() {
        //     if (xhr6.status === 200) {
        //         console.log("신고서 표준손익계산서 저장 완료");
        //     }
        // };
        // xhr6.send(jsonData);


        // 신고서 법인세 과세표준 및 세액조정신고서
        // body = document.getElementById("api_json7");
        // decodedValue = decodeURIComponent(body.innerHTML);
        // body.innerHTML = decodedValue;
        // jsonData = decodedValue;

        // const xhr7 = new XMLHttpRequest();
        // xhr7.open("POST", "taxAdjustmentAPI.php");
        // xhr7.setRequestHeader("Content-type", "application/json");
        // xhr7.onload = function() {
        //     if (xhr7.status === 200) {
        //         console.log("신고서 법인세 과세표준 및 세액조정신고서 저장 완료");
        //     }
        // };
        // xhr7.send(jsonData);


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
        // body = document.getElementById("api_json12");
        // decodedValue = decodeURIComponent(body.innerHTML);
        // // body.innerHTML = decodedValue + "<button class='btn-click' onclick='click_button()'>버튼</button>";
        // body.innerHTML = decodedValue;
        // jsonData = decodedValue;

        // const xhr12 = new XMLHttpRequest();
        // xhr12.open("POST", "taxCreditReconciliationAPI.php");
        // xhr12.setRequestHeader("Content-type", "application/json");
        // xhr12.onload = function() {
        //     if (xhr12.status === 200) {
        //         console.log("신고서 세액공제조정명세서 저장 완료");
        //     }
        // };
        // xhr12.send(jsonData);

       
        
        // window.location.href = 'https://phpstack-761997-3303412.cloudwaysapps.com/';

        const div = document.getElementById("extra-button");
        div.innerHTML = "<h1>Hello, world!</h1>";


              
    </script>

    <?php
}
?>


<script>
 $(document).ready(function() {
            $("#send-auth").click(function() {
                $.ajax({
                    url: 'onepageAPI_kak.php',
                    type: 'POST',
                    data: { ajax_request: 1 },
                    success: function(response) {
                        $("#result").html(response);
                    }
                });
            });
        });


</script>
</html>
