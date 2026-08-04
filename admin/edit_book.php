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

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM books WHERE book_id='$id'");

if (mysqli_num_rows($result) == 0) {
    header("Location: books.php");
    exit();
}

$book = mysqli_fetch_assoc($result);

$error = "";

if (isset($_POST['update_book'])) {

    $book_id = trim($_POST['book_id']);
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $isbn = trim($_POST['isbn']);
    $quantity = trim($_POST['quantity']);

    if (
        empty($book_id) ||
        empty($title) ||
        empty($author) ||
        empty($isbn) ||
        empty($quantity)
    ) {

        $error = "All fields are required.";

    } else {

        $check = mysqli_query($conn,

        "SELECT *
         FROM books
         WHERE book_id='$book_id'
         AND book_id!='$id'");

        if (mysqli_num_rows($check) > 0) {

            $error = "Book ID already exists.";

        } else {

            $checkISBN = mysqli_query($conn,

            "SELECT *
             FROM books
             WHERE isbn='$isbn'
             AND book_id!='$id'");

            if (mysqli_num_rows($checkISBN) > 0) {

                $error = "ISBN already exists.";

            } else {

                $sql = "

                UPDATE books

                SET

                book_id='$book_id',
                title='$title',
                author='$author',
                isbn='$isbn',
                quantity='$quantity'

                WHERE book_id='$id'

                ";

                if (mysqli_query($conn, $sql)) {

                    header("Location: books.php?success=updated");
                    exit();

                } else {

                    $error = "Update failed.";

                }

            }

        }

    }

}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container">

<h1 class="page-title">✏ Edit Book</h1>

<?php
if($error!=""){
echo "<div class='error-message'>$error</div>";
}
?>

<form method="POST" class="book-form">

<label>Book ID</label>

<input
type="number"
name="book_id"
value="<?php echo $book['book_id']; ?>"
required>

<label>Book Title</label>

<input
type="text"
name="title"
value="<?php echo htmlspecialchars($book['title']); ?>"
required>

<label>Author</label>

<input
type="text"
name="author"
value="<?php echo htmlspecialchars($book['author']); ?>"
required>

<label>ISBN</label>

<input
type="text"
name="isbn"
value="<?php echo htmlspecialchars($book['isbn']); ?>"
required>

<label>Quantity</label>

<input
type="number"
name="quantity"
min="0"
value="<?php echo $book['quantity']; ?>"
required>

<br>

<button
type="submit"
name="update_book">

Update Book

</button>

<a
href="books.php"
class="cancel-btn">

Cancel

</a>

</form>

</div>

<?php
include '../includes/footer.php';
?>