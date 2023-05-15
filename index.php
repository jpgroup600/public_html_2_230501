<?php
session_start();
include_once dirname(__FILE__)."/lib.php";
include_once dirname(__FILE__)."/conDB.php";
include 'OAuth2.php';
$kakaologin = new kakaoRestAPI();
if( $kakaologin->auth_apply !== true){ die("카카오로그인을 사용할 수 없습니다."); }

$arrUserInfo = array('id'=>'','nickname'=>'','email'=>'','gender'=>'');
if(!empty($_SESSION['auth_kakao_user_info'])){
    if( !empty($_SESSION['kakao_user_info']['id'])){ $arrUserInfo['id']= $_SESSION['kakao_user_info']['id'];  }
    if( !empty($_SESSION['kakao_user_info']['kakao_account']['profile']['nickname'])){ $arrUserInfo['nickname']= $_SESSION['kakao_user_info']['kakao_account']['profile']['nickname'];  }
    if( !empty($_SESSION['kakao_user_info']['kakao_account']['email'])){ $arrUserInfo['email']= $_SESSION['kakao_user_info']['kakao_account']['email']; }
    if( !empty($_SESSION['kakao_user_info']['kakao_account']['gender'])){ $arrUserInfo['gender']= $_SESSION['kakao_user_info']['kakao_account']['gender']; }

    $username = $arrUserInfo['nickname'];
    $kakao_id = $_SESSION['kakao_user_info']['id'];
    // user_account 테이블에서 username 컬럼 값 가져오기
    $sql = "SELECT * FROM user_account where kakao_id='".$kakao_id."'";
    $result = mysqli_query($conn, $sql);

    // 토큰 생성 or 계정유무 확인 후 계정 생성
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $_SESSION['user_key'] = $row['user_key'];
            $_SESSION['kakao_id'] = $row['kakao_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_birth'] = $row['user_birth'];
            $_SESSION['user_bisnum'] = $row['user_bisnum'];
            if(strtotime($row['token_expiration']) < time()) {
                header('Location: https://taxget.co.kr/OAuth2.php');
            } else {
                $_SESSION['access_token'] = $row['access_token'];
            }
            $_SESSION['userType'] = $row['userType'];
            $_SESSION['manageNo'] = $row['manageNo'];
            $_SESSION['insuranceType'] = $row['insuranceType'];
            $_SESSION['insuranceDate'] = $row['insuranceDate'];
            $_SESSION['phoneNo'] = $row['phoneNo'];
            $_SESSION['email'] = $row['email'];
        }
    } else {
        $sql = "INSERT INTO user_account (username, kakao_id) VALUES ('$username', '$kakao_id')";
        if (mysqli_query($conn, $sql)) {
            echo "새 계정 정보 추가";
        }
    }
}

?>
<div class="wrap-kakao-login">
    <h1>카카오톡 간편로그인 & 간편로그인 후 검증기</h1>
    <ul>
        <li><a href="/index.php">처음화면으로</a></li>
        <?php
        if(isset($_SESSION['kakao_user_info'])) {
            ?>
            <li><a href="./login.php">공동인증서 로그인</a></li>
            <li><a href="<?php echo $kakaologin->redirect_uri; 
            ?>?logout=true">로그아웃</a></li>
            <?php header('Location: https://taxget.co.kr/onepageAPI_kak_N.php'); ?>


            <?php
        } else {
            ?>
            <li><a href="<?php echo $kakaologin->request_url['code'] ?>"  class="kakao-login"><img src="//k.kakaocdn.net/14/dn/btroDszwNrM/I6efHub1SN5KCJqLm1Ovx1/o.jpg" width="180" alt="카카오 로그인 버튼"/></a></li>
            <?php
        }
        ?>
        <!-- <li><a href="./OAuth2.php">Access Token 발급</a></li> -->
        <!-- <li><a href="./testAJAX.php">DB테스트</a></li> -->
        <li><a href="./onepageAPI.php">공동인증서 로그인</a></li>
        <li><a href="./mypage.php">내 API 정보 확인</a></li>
        <li><a href="./gongdong.php">공동인증서 테스트</a></li>
    </ul>
    <h3>인증상태</h3>
    <ul>
        <li>CODEF token인증: <?php echo !empty($_SESSION['access_token']) ? '<font color="blue">인증완료</font>':'<font color="red">인증대기</font>'; ?></li>
        <li>토큰인증: <?php echo !empty($_SESSION['auth_kakao_token_info']) ? '<font color="blue">인증완료</font>':'<font color="red">인증대기</font>'; ?></li>
        <li>사용자인증: <?php echo !empty($_SESSION['auth_kakao_user_info']) ? '<font color="blue">인증완료</font>':'<font color="red">인증대기</font>'; ?></li>
    </ul>
    <h3>인증후 사용자 정보(아이디(고유번호),이메일,닉네임,성별)</h3>
    <ul>
        <?php
        if(isset($_SESSION['kakao_user_info'])) {
            ?>
            <li>아이디(고유번호): <p style="display: inline-block;"><?php echo $arrUserInfo['id'] ?></p></li>
            <li>닉네임: <p style="display: inline-block;"><?php echo $arrUserInfo['nickname'] ?></p></li>
            <li>이메일: <p style="display: inline-block;"><?php echo $arrUserInfo['email'] ?></p></li>
            <li>성별: <p style="display: inline-block;"><?php echo $arrUserInfo['gender'] ?></p></li>
            <li>access_token: <p style="display: inline-block;"><?php echo $_SESSION['access_token']; ?></p></li>
            <?php
        } else {
            ?>
            <p>로그인 후 이용바랍니다.</p>
            <?php
        }
        ?>
    </ul>
</div>
<style>
    .wrap-kakao-login{ padding:2%; }
    .wrap-kakao-login li{ margin:10px 0; }
</style>