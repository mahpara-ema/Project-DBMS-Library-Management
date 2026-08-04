<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/db.php';

$error = "";
$success = "";

// Process Form Submission
if (isset($_POST['add_book'])) {

    $book_id = trim($_POST['book_id']);
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $isbn = trim($_POST['isbn']);
    $quantity = trim($_POST['quantity']);

    // Validation
    if ( empty($book_id) || empty($title) || empty($author) ||empty($isbn) ||empty($quantity)){

        $error = "All fields are required.";

    } elseif (!is_numeric($quantity) || $quantity < 0) {

        $error = "Quantity must be a valid positive number.";

    } else {

        
    // Check duplicate Book ID
    $checkID = mysqli_query(
      $conn,
      "SELECT * FROM books WHERE book_id='$book_id'"
    );

    if (mysqli_num_rows($checkID) > 0) {

    $error = "Book ID already exists.";

    } else {

    // Check duplicate ISBN
    $check = mysqli_query(
        $conn,
        "SELECT * FROM books WHERE isbn='$isbn'"
    );

    if (mysqli_num_rows($check) > 0) {

        $error = "A book with this ISBN already exists.";

    } else {

            $sql = "INSERT INTO books(book_id,title, author, isbn, quantity)
                    VALUES('$book_id','$title','$author','$isbn','$quantity')";

            if (mysqli_query($conn, $sql)) {

                header("Location: books.php?success=added");
                exit();

            } else {

                $error = "Failed to add the book.";

            }
        }
    }
}
}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container">

<h1 class="page-title">➕ Add New Book</h1>

<?php if($error!=""){ ?>

<div class="error-message">
<?php echo $error; ?>
</div>

<?php } ?>

<form method="POST" class="book-form">

<label>Book Title</label>

<input
type="text"
name="title"
value="<?php if(isset($title)) echo htmlspecialchars($title); ?>"
required>

<label>Book ID</label>

<input
type="number"
name="book_id"
min="1"
value="<?php if(isset($book_id)) echo htmlspecialchars($book_id); ?>"
required>

<label>Author</label>

<input
type="text"
name="author"
value="<?php if(isset($author)) echo htmlspecialchars($author); ?>"
required>

<label>ISBN</label>

<input
type="text"
name="isbn"
value="<?php if(isset($isbn)) echo htmlspecialchars($isbn); ?>"
required>

<label>Quantity</label>

<input
type="number"
name="quantity"
min="0"
value="<?php if(isset($quantity)) echo htmlspecialchars($quantity); ?>"
required>

<br>

<button type="submit" name="add_book">
Save Book
</button>

<a href="books.php" class="cancel-btn">
Cancel
</a>

</form>

</div>

<?php
include '../includes/footer.php';
?>