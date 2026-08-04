<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: books.php");
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

/* Check if book exists */

$book = mysqli_query($conn,

"SELECT *
 FROM books
 WHERE book_id='$id'");

if(mysqli_num_rows($book)==0){

    header("Location: books.php");
    exit();

}

/* Check transaction history */

$checkTransaction = mysqli_query($conn,

"SELECT *
 FROM transactions
 WHERE book_id='$id'");

if(mysqli_num_rows($checkTransaction)>0){

    header("Location: books.php?error=transaction");
    exit();

}

/* Delete Book */

$delete = mysqli_query($conn,

"DELETE FROM books
 WHERE book_id='$id'");

if($delete){

    header("Location: books.php?success=deleted");
    exit();

}
else{

    header("Location: books.php?error=delete");
    exit();

}
?>