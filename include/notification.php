<?php
function addnotification($fromId,$notificationType,$notificationTitle,$notificationBody)
{
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost:8080/createNotification',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array(
    'notificationFrom' => 'employee',
    'fromId' => $fromId,
    'notificationTo' => 'admin',
    'toId' => '1',
    'hasRead' => '0',
    'notificationType' => $notificationType,
    'notificationTitle' => $notificationTitle,
    'notificationBody' => $notificationBody),
));
$response = curl_exec($curl);
curl_close($curl);
// echo $response;
}
?>