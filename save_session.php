<?php
session_start();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the JSON data from the request
    $json = file_get_contents('php://input');
    // Save the JSON data in a session
    $_SESSION['formData'] = $json;

    if (isset($_SESSION['formData'])) {
        $formData = json_decode($_SESSION['formData'], true);
    } else {
        echo "No form data found in session.";
        exit;
    }

    echo $formData;

    // Send a success response
    http_response_code(200);
} else {
    // Send an error response if the request method is not POST
    http_response_code(400);
}
?>