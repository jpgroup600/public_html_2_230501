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
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

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

  function decode_json($json_string) {
    // Decode the JSON string
    $decoded_json = json_decode($json_string, true);
  
    // Return the decoded JSON array
    return $decoded_json;
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


        return $response_data;

        
        

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
    $userIdentity_r = $userName.$userIdentity2;
    $id = $email.$userIdentity_r."2";

    $userIdentity_long = return_first_word($userIdentity);

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
$_SESSION['date']= date("Y-m-d/H:i");
$_SESSION['identity_long'] = $userIdentity_long;

$date = $_SESSION['date'];



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
            "id" => $id,
            "simpleAuth" => "1", 

        );

        $data4 = array(
            'organization' => '0005',
            'startDate' => "20220101",
            'endDate' => "20221212",
            'identity' => $identity,
            'loginType' => "5",
            'loginTypeLevel' => "1",
            'userName' => $userName,
            'loginIdentity' => $userIdentity_long,
            'phoneNo' => $phoneNo,
            "id" => $id,
            
            

        );

        $END_POINT4 = 'https://development.codef.io/v1/kr/public/nt/report/final-return-tax-base';
        // JSON 요청 데이터
            // userType값 default 는 2 (사업자명의 인증서)
            // identitiy 값은 default로 (사업자 번호)


            $endpoints = array (
                array(
                    "url" => "https://development.codef.io/v1/kr/public/nt/proof-issue/corporate-registration",
                    "data" => array(
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
                        "id" => $id,
                        "simpleAuth" => "1", 
                    ),
                ),
        
                array(
                    "url" => "https://development.codef.io/v1/kr/public/nt/report/final-return-tax-base",
                    "data" => array(
                        'organization' => '0005',
                        'startDate' => "20220101",
                        'endDate' => "20221212",
                        'identity' => $identity,
                        'loginType' => "5",
                        'loginTypeLevel' => "1",
                        'userName' => $userName,
                        'loginIdentity' => $userIdentity_long,
                        'phoneNo' => $phoneNo,
                        "id" => $id,
                    )
                    ),


                );
            
            $curl_arr = array();
            $master = curl_multi_init();

        
                for($i = 0; $i < count($endpoints); $i++)
            {
                $url = $endpoints[$i]['url'];
                $data_string = json_encode($endpoints[$i]['data']);
        
                $curl_arr[$i] = curl_init($url);
                curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_arr[$i], CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl_arr[$i], CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($curl_arr[$i], CURLOPT_HTTPHEADER, array(                                                                          
                    'Content-Type: application/json',                                                                                
                    'Content-Length: ' . strlen($data_string),
                    "Authorization: Bearer ".$token
                    )                                                                       
                );  
                curl_multi_add_handle($master, $curl_arr[$i]);
                sleep(0.7);
            }
        
            do {
                curl_multi_exec($master,$running);
            } while($running > 0);
        
        
            for($i = 0; $i < count($endpoints); $i++)
            {
                $dc = curl_multi_getcontent($curl_arr[$i]);
                $json = urldecode($dc);
                $json = json_decode($json, true);

                $results[] = $json;

               
                    $jtii = $json['data']['jti'];
                    $two = $json['data']['twoWayTimestamp'];
                    $job = $json['data']['jobIndex'];
                    $thread = $json['data']['threadIndex'];
                    $cont = $json['data']['continue2Way'];
             
               
            }
        
            print_r($results);

            $data11_auth = array(
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
                "simpleAuth" => "1", 
                'is2Way' => true,
                "id" => $id,
                'twoWayInfo' => array(
                    'jobIndex' => $job,
                    'threadIndex' => $thread,
                    'jti' => $jtii,
                    'twoWayTimestamp' => $two,
                    )
                );

                $get_data1_auth = send_api($END_POINT11,$data11_auth); 

            

     

      
      
        echo "first";
        // $get_data1 = send_api($END_POINT11,$data11); // 사업자 등록 정보 
        // sleep(0.7);
        // $get_data4 = send_api($END_POINT4,$data4);
       
        
        
        

        $message = $get_data1['result']['message'];
        $res_code = $get_data1['result']['code'];
        $continue2Way = $get_data1['data']['continue2Way'];
        $jti = $get_data1['data']['jti'];
        $jobindex = intval($get_data1['data']['jobIndex']);
        $threadindex = intval($get_data1['data']['threadIndex']);
        $twoWayTimestamp = $get_data1['data']['twoWayTimestamp'];
        
      

        echo "$res_code";
        

        if($get_data1['result']['code'] == "CF-03002")
        {
           
           

            
            sleep(3);

            echo "<p id='api_json'>";
            echo "second";
            
            echo "</p>";
            $is_true = true;
            $cnt = 0;

        

            sleep(30);

            //$get_data1_auth = send_api($END_POINT11,$data11_auth); 
            // $get_data4 = send_api($END_POINT4,$data4_auth);

                while($is_true)
            {

                echo "while";
            

          
                if($get_data1_auth['result']['code'] == "CF-00000")  //succeed
                {
                 
    
                    
                    $is_true = false; 
                    echo "들어옴";
                    $string_get_data1_auth = json_encode($get_data1_auth, JSON_UNESCAPED_UNICODE);
                    //$id,$date,"taxpayment"
                    echo "third";
                   

                    // $message4 = $get_data4['result']['message'];
                    // $res_code4 = $get_data4['result']['code'];
                    // $continue2Way4 = $get_data4['data']['continue2Way'];
                    // $jti4 = $get_data4['data']['jti'];
                    // $twoWayTimestamp4 = $get_data4['data']['twoWayTimestamp'];
                    // $jobindex4 = $get_data4['data']['jobIndex'];
                    // $threadindex4 = $get_data4['data']['threadIndex'];

                    $data4_auth = array(
                        'organization' => '0005',
                        'startDate' => "20220101",
                        'endDate' => "20221212",
                        'identity' => $identity,
                        'loginType' => "5",
                        'loginTypeLevel' => "1",
                        'userName' => $userName,
                        'loginIdentity' => $userIdentity_long,
                        'phoneNo' => $phoneNo,
                        'inquiryType' => "0",
                        'infoViewYn' => "1",
                        "id" => $id,
                        'is2Way' => true,
                        "simpleAuth" => "1", 
                        'twoWayInfo' => array(
                            'jobIndex' => $jobindex4,
                            'threadIndex' => $threadindex4,
                            'jti' => $jti4,
                            'twoWayTimestamp' => $twoWayTimestamp4,
                            )
            
                    );

                    //$get_data4 = send_api($END_POINT4,$data4_auth);

           
                    
                }

                else {
                    sleep(30);

                    echo "$userIdentity_long $userName $identity $usePurposes $submitTargets 
                    $infoViewYn $identity $phoneNo $id " ;
            
                    echo "else";
                    //$get_data1_auth = send_api($END_POINT11,$data11_auth); 
                    $string_get_data1_auth = json_encode($get_data1_auth, JSON_UNESCAPED_UNICODE);
                    // $get_data4 = send_api($END_POINT4,$data4_auth);
                    $cnt = $cnt + 1;
                    if($cnt >= 3)
                    {
                        $is_true = false;
                        echo "<script>alert('시간이 초과했습니다 다시 확인하고 시도해주세요')</script>";
                        //echo "<script>window.history.back();</script>";
                        
                    }
                }
            }  // try till succeed


            

    }

    $sql = "INSERT INTO corporate (id, json_data,date) VALUES ('$id', '$string_get_data1_auth','$date')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    echo "<pre>"; print_r($string_get_data1_auth); echo "</pre>";
    
    // db 연결 종료
    $conn->close();

        


        

        echo "<div><button id='sendData'>2차인증 완료</button></div>";
        sleep(0.5);
        // header('Location: onepageAPI_kak_N2.php');


      

        
        





    }//end if state ment
    
    else {  //else show this
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
    <?php

}
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



