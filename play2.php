<?php



$api_key = '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';

function call_chatgpt_api($messages) {
    global $api_key;
    
    $url = 'https://api.openai.com/v1/chat/completions';
    $headers = array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key
    );
    
    $data = json_encode(array(
        'messages' => $messages,
        'max_tokens' => 50,
        'n' => 1,
        'stop' => null,
        'temperature' => 0.7
    ));
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    
    $response = curl_exec($curl);
    curl_close($curl);
    
    return $response;
}

$messages = array(
    array("role" => "system", "content" => "You are a helpful assistant."),
    array("role" => "user", "content" => "What are the benefits of using AI in businesses?")
);

$response = call_chatgpt_api($messages);

$response_data = json_decode($response, true);
$answer = $response_data['choices'][0]['message']['content'];
echo "Answer: " . $answer;

?>

