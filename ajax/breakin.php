<?php
session_start();
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost:8080/breakstart',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "employeeId":"'.$_SESSION['employeeId'].'"   
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$resultArray = json_decode($response, true);
    if ($resultArray['status'] == '200') {
      $cookie_name = "breakin";
      $cookie_value = $_SESSION['employeeId'];
      
      setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); 
  
      echo "Cookie '" . $cookie_name . "' is set!";
    }
?>