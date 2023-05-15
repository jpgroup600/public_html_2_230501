<?php
session_start();
include_once dirname(__FILE__) . "/conDB.php";

$user_key = $_SESSION['user_key'];

$jsonData = $_POST['jsonData'];

// decode the JSON data into a PHP array or object
$data = json_decode($jsonData, true);

// process the data and generate a response
// ...

// return the response
echo $data;

?>