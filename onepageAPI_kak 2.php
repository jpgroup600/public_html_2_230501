<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form action="" method="post">
        <h1>원페이지 폼</h1>
        <!-- <input type="text" name="certFile" placeholder="인증서 der파일" required>
        <input type="text" name="certPassword" placeholder="인증서 비밀번호" required> -->
        <input type="text" name="userName" placeholder="성명" value="<?= $_SESSION['username'] ?>" required>
        <input type="text" name="userIdentity" placeholder="사용자 주민번호 앞자리" value="<?= $_SESSION['user_birth'] ?>" required>
        <input type="text" name="userIdentity2" placeholder="사용자 주민번호 뒷자리" value="<?= $_SESSION['user_birth2'] ?>" required>
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
        <div class="extra_button" id="extra-button"></div>
    
</body>
</html>