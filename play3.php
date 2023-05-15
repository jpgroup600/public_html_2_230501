<?php
function call_chat_gpt($input_text) {
    $api_key = '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';
    $url = 'https://api.openai.com/v1/engines/davinci-codex/completions';

    $headers = [
        'Content-Type: application/json',
        "Authorization: Bearer {$api_key}",
    ];

    // Simplify the prompt
    // $prompt = "User: you are a chef and when someone tells you their ingredients you see and recomend them 
    // at least 5 menus made with them you dont have to use all the ingredients however
    // you have to only make them with the ingredients you have been listed above
    // and when you recomend the menus tell them the recipie that actually exsists in the world
    // dont be creative be objective {$input_text}\nAI:";

    $prompt = "You are an AI language model, and your task is to provide helpful and accurate responses to user inputs. The user has provided the following input:\n\nUser: {$input_text}\n\nAI:";

    $data = [
        'prompt' => $prompt,
        'max_tokens' => 2048,
        'n' => 1,
        'stop' => null, // Stop at a newline character
        'temperature' => 0.8,
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    $response_data = json_decode($response, true);

    curl_close($ch);

    if (isset($response_data['choices'][0]['text'])) {
        // Remove the character limit and return the full response
        return trim($response_data['choices'][0]['text']);
    } else {
        return "Error: Unable to get a response from GPT.";
    }

}



$user_input = isset($_POST['user_input']) ? $_POST['user_input'] : '';
$gpt_response = call_chat_gpt($user_input);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>ChatGPT Response</title>
</head>
<body>
  <h1>ChatGPT Response</h1>
  <p><strong>You said:</strong></p>
  <p><?php echo htmlspecialchars($user_input); ?></p>
  <p><strong>GPT replied:</strong></p>
  <p><?php echo htmlspecialchars($gpt_response); ?></p>
  <p><a href="play2.php">Back to Chat</a></p>
</body>
</html>
