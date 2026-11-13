<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "db_antrean";

$connect = new mysqli($hostname, $username, $password, $database);

if($connect->connect_error){
    die("koneksi gagal: ".$connect->connect_error);
}
else{
    echo "terhubung";
}
?>