<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/db.php';
include '../includes/header.php';
include '../includes/navbar.php';

/* Search */

$search = "";

if(isset($_GET['search']))
{

    $search = mysqli_real_escape_string($conn,$_GET['search']);

    $sql = "

    SELECT *

    FROM users

    WHERE

    name LIKE '%$search%'

    OR

    email LIKE '%$search%'

    OR

    phone LIKE '%$search%'

    ORDER BY user_id ASC

    ";

}
else
{

    $sql="SELECT * FROM users ORDER BY user_id ASC";

}

$result=mysqli_query($conn,$sql);

?>

<div class="container">

<?php

if(isset($_GET['success']))
{

    if($_GET['success']=="added")
    {
        echo "<div class='success-message'>
        User added successfully!
        </div>";
    }

    if($_GET['success']=="updated")
    {
        echo "<div class='success-message'>
        User updated successfully!
        </div>";
    }

    if($_GET['success']=="deleted")
    {
        echo "<div class='success-message'>
        User deleted successfully!
        </div>";
    }

}

if(isset($_GET['error']))
{

    if($_GET['error']=="transaction")
    {
        echo "<div class='error-message'>
        Cannot delete this user because transaction history exists.
        </div>";
    }

    if($_GET['error']=="delete")
    {
        echo "<div class='error-message'>
        Failed to delete user.
        </div>";
    }

}

?>

<h1 class="page-title">

👤 Users Management

</h1>

<br>

<div class="top-bar">

<form method="GET">

<input
type="text"
name="search"
placeholder="Search by Name, Email or Phone"
value="<?php echo htmlspecialchars($search); ?>">

<button type="submit">

Search

</button>

</form>

<a
href="add_user.php"
class="add-btn">

+ Add User

</a>

</div>

<br>

<table>

<tr>

<th>ID</th>

<th>Name</th>

<th>Email</th>

<th>Phone</th>

<th>Action</th>

</tr>

<?php

if(mysqli_num_rows($result)>0)
{

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td>

<?php echo $row['user_id']; ?>

</td>

<td>

<?php echo htmlspecialchars($row['name']); ?>

</td>

<td>

<?php echo htmlspecialchars($row['email']); ?>

</td>

<td>

<?php echo htmlspecialchars($row['phone']); ?>

</td>

<td>

<a
class="edit-btn"
href="edit_user.php?id=<?php echo $row['user_id']; ?>">

Edit

</a>

<a
class="delete-btn"
href="delete_user.php?id=<?php echo $row['user_id']; ?>"
onclick="return confirm('Delete this user?');">

Delete

</a>

</td>

</tr>

<?php

}

}
else
{

?>

<tr>

<td colspan="6">

No users found.

</td>

</tr>

<?php

}

?>

</table>

</div>

<?php

include '../includes/footer.php';

?>