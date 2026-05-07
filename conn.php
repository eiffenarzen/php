<?php

header("Content-Type: application/json");

$host = getenv('MYSQLHOST') ?: "mysql.railway.internal";
$user = getenv('MYSQLUSER') ?: "root";
$pass = getenv('MYSQLPASSWORD') ?: "LZbymHnnzmaaxbqhtTqfkWxMPuQQnIXG";
$db   = getenv('MYSQLDATABASE') ?: "railway";
$port = getenv('MYSQLPORT') ?: 3306;

$koneksi = mysqli_connect($host, $user, $pass, $db, $port);

if (!$koneksi) {
    die(json_encode([
        "status" => false,
        "message" => "Koneksi gagal",
        "error" => mysqli_connect_error()
    ]));
}
?>
