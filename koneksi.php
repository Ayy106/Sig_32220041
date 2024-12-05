<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sig_32220041";
$port = 8111;

$koneksi = mysqli_connect($servername, $username, $password, $dbname, $port);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
