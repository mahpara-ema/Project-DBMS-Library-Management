<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/db.php';

$error = "";

if (isset($_POST['add_user'])) {

    $user_id = trim($_POST['user_id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $phone = trim($_POST['phone']);

    if (
        empty($user_id) ||
        empty($name) ||
        empty($email) ||
        empty($password) ||
        empty($phone)
    ) {

        $error = "All fields are required.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Invalid email address.";

    } else {

        // Check duplicate User ID
        $checkID = mysqli_query($conn,
            "SELECT * FROM users WHERE user_id='$user_id'");

        if (mysqli_num_rows($checkID) > 0) {

            $error = "User ID already exists.";

        } else {

            // Check duplicate Email
            $checkEmail = mysqli_query($conn,
                "SELECT * FROM users WHERE email='$email'");

            if (mysqli_num_rows($checkEmail) > 0) {

                $error = "Email already exists.";

            } else {

                $sql = "INSERT INTO users
                (user_id, name, email, password, phone)

                VALUES

                ('$user_id','$name','$email', '$password','$phone')";

                if (mysqli_query($conn, $sql)) {

                    header("Location: users.php?success=added");
                    exit();

                } else {

                    $error = "Failed to add user.";

                }

            }

        }

    }

}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container">

<h1 class="page-title">

➕ Add User

</h1>

<?php

if($error!="")
{
echo "<div class='error-message'>$error</div>";
}

?>

<form method="POST" class="book-form">

<label>User ID</label>

<input
type="number"
name="user_id"
min="1"
required>

<label>Name</label>

<input
type="text"
name="name"
required>

<label>Email</label>

<input
type="email"
name="email"
required>

<label>Password</label>

<input
type="password"
name="password"
required>

<label>Phone</label>

<input
type="text"
name="phone"
required>

<br>

<button
type="submit"
name="add_user">

Save User

</button>

<a
href="users.php"
class="cancel-btn">

Cancel

</a>

</form>

</div>

<?php

include '../includes/footer.php';

?>