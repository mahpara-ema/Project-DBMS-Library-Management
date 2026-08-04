<?php

$host = "sql103.infinityfree.com";
$user = "if0_42577844";
$password = "271828ma";
$database = "if0_42577844_llibrary_management";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>