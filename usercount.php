<?php
$host='127.0.0.1';
$username='root';
$password='2019023239';
$dbname='db_book_php_15';
$mysqli = mysqli_connect($host, $username, $password,$dbname);
$ip = $_SERVER["REMOTE_ADDR"];
$time = date('Y-m-d H:i:s');
mysqli_query($mysqli, "insert into usercount(ip,time) values ('$ip','$time')");
?>
