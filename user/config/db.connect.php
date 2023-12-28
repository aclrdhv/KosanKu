<?php

$mysql_server = "localhost";
$username = "root";
$password = "";
$database = "kosanku";

try {
    $conn = mysqli_connect($mysql_server, $username, $password, $database);
} catch (Exception $e) {
    echo ("Terjadi error: $e");
}