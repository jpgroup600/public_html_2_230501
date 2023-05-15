<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
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
        window.location.replace("https://taxget.co.kr");
    </script>
    <?php
}



echo "<div>";
$token = $ACCESS_TOKEN;
echo "<script>var token = '" . $token . "';</script>";


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
    
</body>
<script>
const formData = {};
const form = document.querySelector('form');


function send_ajax_to_php(url,json_data){
    url = String(url);
    const headers = new Headers({
  'Content-Type': 'application/json',
  'Content-Length': JSON.stringify(json_data).length.toString(),
  'Authorization': `Bearer ${token}`
    });

    fetch(url, {
    method: 'POST',
    headers: headers,
    body: JSON.stringify(json_data)
  }).then(response => {
    if (response.ok) {
      console.log('Form data saved in session');
      return response.text();
    } else {
      console.error('Error saving form data in session');
    }
  }).then(data => {
    console.log('Response data:', JSON.parse(data));
  }).catch(error => {
    console.error('Error:', error);
  });
}


function returnFirstWord(userIdentity) {
  const checkUser = parseInt(userIdentity.substring(0, 2), 10);

  let userIdentityLong;
  if (checkUser > 20) {
    userIdentityLong = "19" + userIdentity;
  } else {
    userIdentityLong = "20" + userIdentity;
  }

  return userIdentityLong;
}


//run function when on submit
form.addEventListener('submit', function(event) {
  event.preventDefault();

  formData.userName = form.querySelector('input[name="userName"]').value;
  formData.userIdentity = form.querySelector('input[name="userIdentity"]').value;
  formData.userIdentity2 = form.querySelector('input[name="userIdentity2"]').value;
  formData.userType = form.querySelector('select[name="userType"]').value;
  formData.identity = form.querySelector('input[name="identity"]').value;
  formData.manageNo = form.querySelector('input[name="manageNo"]').value;
  formData.insuranceType = form.querySelector('select[name="insuranceType"]').value;
  formData.startDate = form.querySelector('input[name="startDate"]').value;
  formData.endDate = form.querySelector('input[name="endDate"]').value;
  formData.inquiryType = form.querySelector('select[name="inquiryType"]').value;
  formData.infoViewYn = form.querySelector('select[name="infoViewYn"]').value;
  formData.phoneNo = form.querySelector('input[name="phoneNo"]').value;
  formData.email = form.querySelector('input[name="email"]').value;
  formData.userIdentity_r = formData.userIdentity+formData.userIdentity2;
  
  id = formData.userName+formData.userIdentity_r;


  console.log("token"+token);

 


//send_ajax_to_php('save_session.php',formData)   //ajax request save as php session

const data1 = {
  organization: "0001",
  userType: "0",
  identity: formData.identity,
  manageNo: formData.manageNo,
  insuranceType: formData.insuranceType,
  userIdentity: formData.userIdentity_r,
  userName: formData.userName,
  loginType: "5",
  loginTypeLevel: "1",
  loginUserName: formData.userName,
  phoneNo: formData.phoneNo,
  id: id,
};

send_ajax_to_php('https://development.codef.io/v1/kr/public/cw/kcomwel-employment/detail',data1);



 

});



</script>

</html>