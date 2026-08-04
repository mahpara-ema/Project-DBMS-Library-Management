<?php
session_start();
include 'includes/db.php';

$error = "";

if(isset($_POST['login']))
{
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);

    $sql = "SELECT * FROM admins
            WHERE username='$username'
            AND password='$password'";

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result)==1)
    {
        $_SESSION['admin']=$username;

        header("Location: admin/dashboard.php");
        exit();
    }
    else
    {
        $error="Invalid Username or Password!";
    }
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="container">

    <h2>Admin Login</h2>

    <br>

    <?php
    if($error!="")
    {
        echo "<p style='color:red;'>$error</p>";
    }
    ?>

    <form method="POST">

        <label>Username</label>

        <br><br>

        <input
            type="text"
            name="username"
            required
        >

        <br><br>

        <label>Password</label>

        <br><br>

        <input
            type="password"
            name="password"
            required
        >

        <br><br>

        <button type="submit" name="login">
            Login
        </button>

    </form>

</div>

<?php include 'includes/footer.php'; ?>