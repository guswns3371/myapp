<?php
$db = new mysqli("localhost","root","wnsgusgk3537","test");
$db->set_charset("utf8");
function mq($sql)
{
    global $db;
    return $db->query($sql);
}
require_once('config.php');
$message = $_POST['message'];
$title = $_POST['title'];
$path_to_fcm = "https://fcm.googleapis.com/fcm/send";

$server_key = "AAAAf40I4rk:APA91bFSwHq0-Ewxfq3PskjJSFcOIoky_gTQUM6UsG3lphRoHK91HU4eFO6Pz8aBz6NlBBmyirLIYfhAwzoDzt5_BCOKUB-XDNV6FxXbp1AIH4hTu1vL2yfQ9pLDqdUx5UIaS0Gy7CNx";
$sql = "SELECT Token FROM FCMToken";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_row($result);
$key = $row[0];
$message = "나는 하현준입니다";
$title = "fuck you";

$key="dfeSRJjJZNo:APA91bHMnpHIeuBDQOgw8YkStSp9klrlglFH4DtMUlTIvVH2DjGDNxdm65INOBm6FMPGGdcjY9Wq2cOaQMpJEyBzVKF6IvTI84koq3pGYnhByy9ZknUujPxI1sthEpz0DaGRUipc8h3h";
//key 는 firebasetoken 이다

$headers = array(
    'Authorization:key='.$server_key,
    'Content-Type:application/json'
);
$fields = array(
    'to'=> $key,
    'notification'=>array(
        'title'=>$title,'body'=>$message
    )
);
$payload = json_encode($fields);

$curl_session = curl_init();
curl_setopt($curl_session, CURLOPT_URL, $path_to_fcm);
curl_setopt($curl_session, CURLOPT_POST, true);
curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
//curl_setopt ($curl_session, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
curl_setopt($curl_session, CURLOPT_POSTFIELDS, $payload);

$result = curl_exec($curl_session);
if ($result === FALSE) {
    die('Curl failed: ' . curl_error($curl_session));
}
curl_close($curl_session);
mysqli_close($con);
?>