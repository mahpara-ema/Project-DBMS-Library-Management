<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "Library_Management";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

?>