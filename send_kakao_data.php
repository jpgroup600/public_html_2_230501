 <?php
 session_start();

 // Assign the session to a variable
 $sessionData = $_SESSION;

 $ACCESS_TOKEN = $_SESSION['token'];
$certFile = $_SESSION['certFile'];
$certPassword = $_SESSION['certPassword'];
$userName = $_SESSION['userName'];
$userIdentity = $_SESSION['userIdentity'];
$userIdentity2 = $_SESSION['userIdentity2'];
$userType = $_SESSION['userType'];
$identity = $_SESSION['identity'];
$manageNo = $_SESSION['manageNo'];
$insuranceType = $_SESSION['insuranceType'];
$startDate = $_SESSION['startDate'];
$endDate = $_SESSION['endDate'];
$inquiryType = $_SESSION['inquiryType'];
$infoViewYn = $_SESSION['infoViewYn'];
$phoneNo = $_SESSION['phoneNo'];
$email = $_SESSION['email'];
$userIdentity_r = $_SESSION['userIdentity_r'];
$id = $_SESSION['id'];
 //API 시작 
    // 근로자고용정보현황조회
    $END_POINT1 = 'https://development.codef.io/v1/kr/public/cw/kcomwel-employment/detail';
    // JSON 요청 데이터
        // userType값 default 는 2 (사업자명의 인증서)
        // identitiy 값은 default로 (사업자 번호)
        $data1 = array(
            'organization' => "0001",
            'userType' => "0",
            'identity' => $userIdentity_r,
            'manageNo' => $manageNo,
            'insuranceType' => $insuranceType,
            'userIdentity' => $userIdentity_r,
            'userName' => $userName,
            'loginType' => "5",
            'loginTypeLevel' => "1",
            'loginUserName' => $userName,
            'phoneNo' => $phoneNo,
        );

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


        ?>