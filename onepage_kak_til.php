<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

set_include_path(get_include_path() . PATH_SEPARATOR . './vendor/phpseclib/phpseclib1.0.19');
require 'vendor/autoload.php';
include('Net/SSH2.php');
require_once 'Crypt/RSA.php';


$apiHost   = "https://api.tilko.net/";
$apiKey    = "ee6e15f2ccab4348b445945c6591959d";


// AES 암호화 함수 //AES
function aesEncrypt($aesKey, $aesIv, $plainText) {
    $ret = openssl_encrypt($plainText, 'AES-128-CBC', $aesKey, OPENSSL_RAW_DATA, $aesIv);	//default padding은 PKCS7 padding
    return base64_encode($ret);
}


// RSA 공개키(Public Key) 조회 함수
//public key get 
function getPublicKey($apiKey) {
    global $apiHost;

    $url        = $apiHost . "api/Auth/GetPublicKey?APIkey=" . $apiKey;
    echo "<h2>this is the url</h2>";
    print($url);

    $curl       = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL             => $url,
        CURLOPT_RETURNTRANSFER  => true,
        CURLOPT_CUSTOMREQUEST   => "GET",
        CURLOPT_SSL_VERIFYHOST  => 0,
        CURLOPT_SSL_VERIFYPEER  => 0
    ));

    $response   = curl_exec($curl);

    curl_close($curl);

    return json_decode($response, true)["PublicKey"];
}


// RSA Public Key 조회
$rsaPublicKey   = getPublicKey($apiKey);
//print("rsaPublicKey:" . $rsaPublicKey);


// AES Secret Key 및 IV 생성
$aesKey     = random_bytes(16);  //random IV variable 
$aesIv      = str_repeat(chr(0), 16);


// AES Key를 RSA Public Key로 암호화
$rsa = new Crypt_RSA();
$rsa->loadKey($rsaPublicKey);
$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);

$aesCipheredKey = $rsa->encrypt($aesKey);


// API URL 설정(정부24 간편인증 주민등록증진위여부 조회: https://tilko.net/Help/Api/POST-api-apiVersion-GovSimpleAuth-AA090UserJuminCheckResApp)
//this is the acutall API call 

$url        = $apiHost . "api/v2.0/KcomwelSimpleAuth/SimpleAuthRequest";


// 간편인증 요청 후 받은 값 정리
$reqData = array(
    "CxId"                      => "",
    "PrivateAuthType"           => "0",
    "ReqTxId"                   => "",
    "Token"                     => "",
    "TxId"                      => "",
    "UserName"                  => "김수호",
    "BirthDate"                 => "19940328",
    "UserCellphoneNumber"       => "01049986709",
    "IdentityNumber"            => "9403281233817",
    "BusinessNumber"            => "2251801471"
);


// API 요청 파라미터 설정
$headers    = array(
    "Content-Type:"             . "application/json",
    "API-Key:"                  . $apiKey,
    "ENC-Key:"                  . base64_encode($aesCipheredKey),
);

$bodies     = array(
    "IdentityNumber"            => aesEncrypt($aesKey, $aesIv, "9403281233817"),
    "CxId"                      => $reqData["CxId"],
    "PrivateAuthType"           => $reqData["PrivateAuthType"],
    "ReqTxId"                   => $reqData["ReqTxId"],
    "Token"                     => $reqData["Token"],
    "TxId"                      => $reqData["TxId"],
    "UserName"                  => aesEncrypt($aesKey, $aesIv, $reqData["UserName"]),
    "BirthDate"                 => aesEncrypt($aesKey, $aesIv, $reqData["BirthDate"]),
    "UserCellphoneNumber"       => aesEncrypt($aesKey, $aesIv, $reqData["UserCellphoneNumber"]),
    
);


// API 호출
$curl   = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL             => $url,
    CURLOPT_RETURNTRANSFER  => true,
    CURLOPT_CUSTOMREQUEST   => "POST",
    CURLOPT_POSTFIELDS      => json_encode($bodies),
    CURLOPT_HTTPHEADER      => $headers,
    CURLOPT_VERBOSE         => false,
    CURLOPT_SSL_VERIFYHOST  => 0,
    CURLOPT_SSL_VERIFYPEER  => 0
));

$response   = curl_exec($curl);

curl_close($curl);

print($response);

//2차 api  전송
//api call -> 2nd authentication
//2nd auth credtentials -> ID , Transition number 

sleep(30); //

echo "<h1>start from here </h1>";

// 응답을 JSON 형식에서 PHP 배열로 변환
$response_data = json_decode($response, true);

// 이제 응답 데이터는 $response_data 변수에 저장되며, 이를 다음과 같이 사용할 수 있습니다.
$token = $response_data["ResultData"]["Token"];
$cxId = $response_data["ResultData"]["CxId"];
$txId = $response_data["ResultData"]["TxId"];
$reqTxId = $response_data["ResultData"]["ReqTxId"];
$privateAuthType = $response_data["ResultData"]["PrivateAuthType"];



$errorCode = $response_data["ErrorCode"];
//sleep(30);


// all of the one above was preperation 
// this is the acutall data to get 
$url2        = $apiHost . "api/v2.0/KcomwelSimpleAuth/SelectGeunrojaGyIryeok";  //url
$bodies     = array(
    
    "UserGroupFlag"             => "1",
    "IndividualFlag"            => "1",
    "BoheomFg"                  => "2",
    "GyStatusCd"               =>  "3",
    "GwanriNo"                  => "22518014710",
    "BusinessNumber"            => aesEncrypt($aesKey, $aesIv, $reqData["BusinessNumber"]),
    "auth"                  => array(
        "CxId"                      => $cxId,
        "PrivateAuthType"           => $privateAuthType,
        "ReqTxId"                   => $reqTxId,
        "Token"                     => $token,
        "TxId"                      => $txId,
        "IdentityNumber"            => aesEncrypt($aesKey, $aesIv, $reqData["IdentityNumber"]),
        "UserName"                  => aesEncrypt($aesKey, $aesIv, $reqData["UserName"]),
        "BirthDate"                 => aesEncrypt($aesKey, $aesIv, $reqData["BirthDate"]),
        "UserCellphoneNumber"       => aesEncrypt($aesKey, $aesIv, $reqData["UserCellphoneNumber"]),
    ),


);



$curl   = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL             => $url2,
    CURLOPT_RETURNTRANSFER  => true,
    CURLOPT_CUSTOMREQUEST   => "POST",
    CURLOPT_POSTFIELDS      => json_encode($bodies),
    CURLOPT_HTTPHEADER      => $headers,
    CURLOPT_VERBOSE         => false,
    CURLOPT_SSL_VERIFYHOST  => 0,
    CURLOPT_SSL_VERIFYPEER  => 0
));

$response   = curl_exec($curl);

curl_close($curl);

print($response);

//세번쨰 

// $url3        = $apiHost . "api/v2.0/KcomwelSimpleAuth/SelectBosuJeopsuList";
// $bodies     = array(
    
//     "UserGroupFlag"             => "1",
//     "IndividualFlag"            => "1",
//     "BoheomYear"                  => "2022",
//     "GwanriNo"                  => "22518014710",
//     "BusinessNumber"            => aesEncrypt($aesKey, $aesIv, $reqData["BusinessNumber"]),
//     "auth"                  => array(
//         "CxId"                      => $cxId,
//         "PrivateAuthType"           => $privateAuthType,
//         "ReqTxId"                   => $reqTxId,
//         "Token"                     => $token,
//         "TxId"                      => $txId,
//         "IdentityNumber"            => aesEncrypt($aesKey, $aesIv, $reqData["IdentityNumber"]),
//         "UserName"                  => aesEncrypt($aesKey, $aesIv, $reqData["UserName"]),
//         "BirthDate"                 => aesEncrypt($aesKey, $aesIv, $reqData["BirthDate"]),
//         "UserCellphoneNumber"       => aesEncrypt($aesKey, $aesIv, $reqData["UserCellphoneNumber"]),
//     ),


// );

// echo "<h1>this is 3rd</h1>";

// $curl   = curl_init();

// curl_setopt_array($curl, array(
//     CURLOPT_URL             => $url3,
//     CURLOPT_RETURNTRANSFER  => true,
//     CURLOPT_CUSTOMREQUEST   => "POST",
//     CURLOPT_POSTFIELDS      => json_encode($bodies),
//     CURLOPT_HTTPHEADER      => $headers,
//     CURLOPT_VERBOSE         => false,
//     CURLOPT_SSL_VERIFYHOST  => 0,
//     CURLOPT_SSL_VERIFYPEER  => 0
// ));

// $response   = curl_exec($curl);

// curl_close($curl);

// print($response);



?>