<?php
//  cUrl stands for Client URL
echo 'Hello from the cURL </br>';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/cURL/introCurl/intro.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_response = curl_exec($ch);
curl_close($ch);
$server_response = json_decode($server_response);

echo '<pre>';
print_r($server_response);
echo '</pre>';