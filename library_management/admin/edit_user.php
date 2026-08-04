<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: users.php");
    exit();
}

$id = $_GET['id'];

$result = mysqli_query($conn,
"SELECT * FROM users WHERE user_id='$id'");

if(mysqli_num_rows($result)==0){

    header("Location: users.php");
    exit();

}

$user = mysqli_fetch_assoc($result);

$error="";

if(isset($_POST['update_user'])){

    $user_id=trim($_POST['user_id']);
    $name=trim($_POST['name']);
    $email=trim($_POST['email']);
    $password = trim($_POST['password']);
    $phone=trim($_POST['phone']);

    if(
        empty($user_id)||
        empty($name)||
        empty($email)||
        empty($password)||
        empty($phone)
    ){

        $error="All fields are required.";

    }else{

        $check=mysqli_query($conn,

        "SELECT * FROM users
        WHERE user_id='$user_id'
        AND user_id!='$id'");

        if(mysqli_num_rows($check)>0){

            $error="User ID already exists.";

        }else{

            $checkEmail=mysqli_query($conn,

            "SELECT * FROM users
            WHERE email='$email'
            AND user_id!='$id'");

            if(mysqli_num_rows($checkEmail)>0){

                $error="Email already exists.";

            }else{

                mysqli_query($conn,

                "UPDATE users

                SET

                user_id='$user_id',
                name='$name',
                email='$email',
                password='$password',
                phone='$phone'

                WHERE user_id='$id'");

                header("Location: users.php?success=updated");
                exit();

            }

        }

    }

}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container">

<h1 class="page-title">

✏ Edit User

</h1>

<?php
if($error!=""){
echo "<div class='error-message'>$error</div>";
}
?>

<form method="POST" class="book-form">

<label>User ID</label>

<input
type="number"
name="user_id"
value="<?php echo $user['user_id'];?>"
required>

<label>Name</label>

<input
type="text"
name="name"
value="<?php echo htmlspecialchars($user['name']);?>"
required>

<label>Email</label>

<input
type="email"
name="email"
value="<?php echo htmlspecialchars($user['email']);?>"
required>

<label>Password</label>

<input
type="text"
name="password"
value="<?php echo htmlspecialchars($user['password']); ?>"
required>

<label>Phone</label>

<input
type="text"
name="phone"
value="<?php echo htmlspecialchars($user['phone']);?>"
required>

<br>

<button
type="submit"
name="update_user">

Update User

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