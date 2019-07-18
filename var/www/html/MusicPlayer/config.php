<?php
define('HOST','localhost');
define('USER','root');
define('PASS','wnsgusgk3537');
define('DB','player');

$con = mysqli_connect(HOST,USER,PASS,DB) or die('unable to Connect');

$db = new mysqli("localhost","root","wnsgusgk3537","player");
$db->set_charset("utf8");

function mq($sql)
{
    global $db;
    return $db->query($sql);
}
?>