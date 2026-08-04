<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/db.php';

if(!isset($_GET['id'])){
    header("Location: users.php");
    exit();
}

$id=mysqli_real_escape_string($conn,$_GET['id']);

$check=mysqli_query($conn,

"SELECT *
FROM transactions
WHERE user_id='$id'");

if(mysqli_num_rows($check)>0){

    header("Location: users.php?error=transaction");
    exit();

}

mysqli_query($conn,

"DELETE FROM users
WHERE user_id='$id'");

header("Location: users.php?success=deleted");
exit();
?>