<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>내 정보</title>
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
include_once dirname(__FILE__) . "/conDB.php";
$user_key = $_SESSION['user_key'];

$tables = array("balancesheet", "businessincome", "corporate", "employment", "income", "remunerationlist", "taxadjust", "taxcredit", "taxdeducation", "taxexemption", "taxpayment", "taxreport");

foreach ($tables as $table) {
    echo "<h2>$table</h2>";

    $sql_sel = "SELECT * from $table where user_key=$user_key";
    $result = mysqli_query($conn, $sql_sel);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Convert JSON data into an array using the json_decode function
            $json_data = json_decode($row["json_data"], true);

            // Do whatever you need with the JSON data
            echo print_r($json_data);
        }
    } else {
        echo $table."에 저장된 API정보가 없습니다.";
    }
}
