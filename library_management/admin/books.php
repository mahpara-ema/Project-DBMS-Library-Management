<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/db.php';
include '../includes/header.php';
include '../includes/navbar.php';

/* ===============================
   SEARCH FUNCTIONALITY
================================ */

$search = "";

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $sql = "SELECT *
            FROM books
            WHERE title LIKE '%$search%'
               OR author LIKE '%$search%'
               OR isbn LIKE '%$search%'
            ORDER BY book_id ASC";
} else {

    $sql = "SELECT *
            FROM books
            ORDER BY book_id ASC";
}

$result = mysqli_query($conn, $sql);

?>

<div class="container">

<?php

if(isset($_GET['success']))
{

    if($_GET['success']=="added")
    {

        echo "<div class='success-message'>
        Book added successfully!
        </div>";

    }
    if($_GET['success']=="updated")
    {
        echo "<div class='success-message'>
        Book updated successfully!
        </div>";
    }

    if($_GET['success']=="deleted")
    {
        echo "<div class='success-message'>
        Book deleted successfully!
        </div>";
    }

}
if(isset($_GET['error']))
{

    if($_GET['error']=="transaction")
    {
        echo "<div class='error-message'>
        Cannot delete this book because it has transaction history.
        </div>";
    }

    if($_GET['error']=="delete")
    {
        echo "<div class='error-message'>
        Failed to delete the book.
        </div>";
    }

}
?>    

<h1 class="page-title">📚 Books Management</h1>

<br>

<div class="top-bar">

<form method="GET">

<input
type="text"
name="search"
placeholder="Search by Title, Author or ISBN"
value="<?php echo htmlspecialchars($search); ?>">

<button type="submit">
Search
</button>

</form>

<a href="add_book.php" class="add-btn">
+ Add New Book
</a>

</div>

<br>

<table>

<tr>

<th>ID</th>

<th>Title</th>

<th>Author</th>

<th>ISBN</th>

<th>Quantity</th>

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

<?php echo $row['book_id']; ?>

</td>

<td>

<?php echo htmlspecialchars($row['title']); ?>

</td>

<td>

<?php echo htmlspecialchars($row['author']); ?>

</td>

<td>

<?php echo htmlspecialchars($row['isbn']); ?>

</td>

<td>

<?php echo $row['quantity']; ?>

</td>

<td>

<a
class="edit-btn"
href="edit_book.php?id=<?php echo $row['book_id']; ?>">
Edit
</a>

<a
class="delete-btn"
href="delete_book.php?id=<?php echo $row['book_id']; ?>"
onclick="return confirm('Are you sure you want to delete this book?');">
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

No books found.

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