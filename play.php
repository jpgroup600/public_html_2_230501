<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<textarea id="myTextarea"></textarea>
<div><button onclick="showPrompt()">전송하기</button></div>
<div id="result"></div>



<?php


$API_KEY = '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';
$model = 'text-davinci-003';
$query = 'Hello, how are you?';

$headers = array(
  'Content-Type: application/json',
  'Authorization: Bearer ' . $API_KEY,
);

$data = array(
  'model' => $model,
  'prompt' => $query,
  'temperature' => 0.7,
  'max_tokens' => 60,
  'n' => 1,
  'stop' => '',
);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/completions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);

if (curl_errno($ch)) {
  echo 'Error:' . curl_error($ch);
} else {
  $response_data = json_decode($response, true);
  $result = $response_data['choices'][0]['text'];
  echo $result;
}

curl_close($ch);



?>


    
</body>
</html>