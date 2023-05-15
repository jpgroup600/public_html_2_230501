<!-- |Great! How can I assist you with your PHP coding needs?
| -->


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
include_once dirname(__FILE__)."/conDB.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_SESSION['access_token'])) {
    $ACCESS_TOKEN = $_SESSION['access_token'];
} else {
    ?>
    <script>
        alert('세션 발급 이후 진행해주시기 바랍니다.');
        //window.location.replace("https://taxget.co.kr");
    </script>
    <?php
}


  function decode_json($json_string) {
    // Decode the JSON string
    $decoded_json = json_decode($json_string, true);
  
    // Return the decoded JSON array
    return $decoded_json;
  }

  function send_api($url,$Ar_data,$id_f,$date_f,$API_END) //API 전송 함수 
  {

    global $token;
    global $conn;

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
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);  //url decode 부분
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

        print_r($response);

        $response_data = json_decode($response, true);

        $string_data = json_encode($response_data, JSON_UNESCAPED_UNICODE);

        $sql = "INSERT INTO $API_END (id, json_data,date,user_key) VALUES ('$id_f', '$string_data','$date_f','$token')";

        if ($conn->query($sql) === TRUE) {
          echo "New record created successfully";
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
      }


        return $string_data;

        
        

  }

    echo "<div>";
    $token = $ACCESS_TOKEN;
    global $token;

// Access session variables
$token = $_SESSION['token'];

$userName = $_SESSION['userName'];

$userType = $_SESSION['userType'];
$identity = $_SESSION['identity'];
$manageNo = $_SESSION['manageNo'];
$insuranceType = $_SESSION['insuranceType'];
$startDate = $_SESSION['startDate'];
$endDate = $_SESSION['endDate'];
$inquiryType = $_SESSION['inquiryType'];
$year = $_SESSION['year'];
$submitTargets = $_SESSION['submitTargets'];
$phoneNo = $_SESSION['phoneNo'];
$email = $_SESSION['email'];
$userIdentity_r = $_SESSION['userIdentity_r'];
$id = $_SESSION['id'];
$date = $_SESSION['date'];
$userIdentity_long = $_SESSION['identity_long'];






global $conn;



$sql_sel = "SELECT * from user_account where id='$id'";
$result = mysqli_query($conn, $sql_sel);

if (mysqli_num_rows($result) < 0) {  //if data exsists
    // user_data table에 데이터 저장
    //$sql = "UPDATE user_account SET username='$userName', user_birth='$userIdentity', user_bisnum='$identity', userType='$userType', manageNo='$manageNo', insuranceType='$insuranceType', phoneNo='$phoneNo', email='$email' WHERE user_key=".$_SESSION['user_key'];
    $sql = "INSERT INTO user_account (username, user_birth, user_bisnum, userType, manageNo, insuranceType,phoneNo,email,id) VALUES ('$userName', '$userIdentity','$identity','$userType','$manageNo','$insuranceType','$phoneNo','$email','$id')";
    mysqli_query($conn, $sql);
}
   // user_account에 insert



   // 쿼리 실행
//     if (mysqli_query($conn, $sql)) {
//            echo "회원 정보가 업데이트 되었습니다.";
//    } else {           echo "Error: " . $sql . "<br>" . mysqli_error($conn);
//        }

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
            "id" => $id,
            "simpleAuth" => "1", 
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
               "id" => $id,
              "simpleAuth" => "1", 
   
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
           "id" => $id,
            "simpleAuth" => "1", 
      
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
            "id" => $id,
            "simpleAuth" => "1", 

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
            "id" => $id,
            "simpleAuth" => "1", 
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
            "id" => $id,
            "simpleAuth" => "1", 
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
            "id" => $id,
            "simpleAuth" => "1", 
        );


        //start MAIN

        echo "Token: " . $_SESSION['token'] . "<br>";
echo "Cert File: " . $_SESSION['certFile'] . "<br>";
echo "Cert Password: " . $_SESSION['certPassword'] . "<br>";
echo "User Name: " . $_SESSION['userName'] . "<br>";
echo "User Identity: " . $_SESSION['userIdentity'] . $_SESSION['userIdentity2'] . "<br>";
echo "User Type: " . $_SESSION['userType'] . "<br>";
echo "Identity: " . $_SESSION['identity'] . "<br>";
echo "Manage No: " . $_SESSION['manageNo'] . "<br>";
echo "Insurance Type: " . $_SESSION['insuranceType'] . "<br>";
echo "Start Date: " . $_SESSION['startDate'] . "<br>";
echo "End Date: " . $_SESSION['endDate'] . "<br>";
echo "Inquiry Type: " . $_SESSION['inquiryType'] . "<br>";
echo "Year: " . $_SESSION['year'] . "<br>";
echo "Info View Yn: " . $_SESSION['infoViewYn'] . "<br>";
echo "Use Purposes: " . $_SESSION['usePurposes'] . "<br>";
echo "Submit Targets: " . $_SESSION['submitTargets'] . "<br>";
echo "Phone No: " . $_SESSION['phoneNo'] . "<br>";
echo "Email: " . $_SESSION['email'] . "<br>";
echo "User Identity R: " . $_SESSION['userIdentity_r'] . "<br>";
echo "ID: " . $_SESSION['id'] . "<br>";
echo "Date: " . $_SESSION['date'] . "<br>";
echo "dadasd".$userIdentity_long."asda".$identity;


      // $get_data1 = send_api($END_POINT1,$data1,$id,$date,"employment"); // 근로자고용정보현황조회
      // $get_data2 = send_api($END_POINT2,$data2,$id,$date,"remunerationlist"); // 근로자고용정보현황조회
      //$get_data3 = send_api($END_POINT3,$data3,$id,$date,"taxreport");
      $get_data4 = send_api($END_POINT4,$data4,$id,$date,"taxpayment");
      // $get_data8 = send_api($END_POINT8,$data8,$id,$date,"taxdeducation");
      // $get_data9 =  send_api($END_POINT9,$data9,$id,$date,"income");
      // $get_data10 = send_api($END_POINT10,$data10,$id,$date,"taxexemption");



  
    echo "<pre>"; print_r($string_get_data1_auth); echo "</pre>";
    
    // db 연결 종료
    $conn->close();

        


        

        echo "<div><button id='sendData'>2차인증 완료</button></div>";

      

        
        





    
 
?>

<?php
if($_POST) {
    ?>


    <script>

       

        //근로자고용정보현황조회
//         var body = document.getElementById("api_json");
//         let decodedValue = decodeURIComponent(body.innerHTML);
//         body.innerHTML = decodedValue ;
//         let jsonData = decodedValue;


        


        $(document).ready(function() {
        $('#sendData').on('click', function() {
            
            location.href = "onepageAPI_kak_N2.php";
            

        });
    });

     

    </script>

    
        
<?php } ?>



