<?php

// Include the config.php file
require_once 'config.php';
// Receive the JSON data from the request body
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// Make sure data is received and decoded successfully
if ($data === null) {
    http_response_code(400); // Bad Request
    echo json_encode(array("error" => "Invalid JSON data received."));
} else {
    // Perform any processing you need on $data here

    // Set up cURL to call another API
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, BASE_URL . 'new-path');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($json_data)
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Execute cURL and get the response
    $response = curl_exec($ch);
    
    // Close cURL
    curl_close($ch);
    
    // You can also process the $response here if needed

    // Return a response to the original request
    header("Content-Type: application/json");
    echo $response;
}
?>
