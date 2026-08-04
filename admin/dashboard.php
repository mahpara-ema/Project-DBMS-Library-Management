<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/db.php';
include '../includes/header.php';
include '../includes/navbar.php';

/* =====================================================
   DASHBOARD SUMMARY
===================================================== */

// Total Books
$bookQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM books");
$totalBooks = mysqli_fetch_assoc($bookQuery)['total'];

// Total Users
$userQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");
$totalUsers = mysqli_fetch_assoc($userQuery)['total'];

// Total Transactions
$transactionQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM transactions");
$totalTransactions = mysqli_fetch_assoc($transactionQuery)['total'];

// Borrowed Books
$borrowedQuery = mysqli_query($conn,
"SELECT COUNT(*) AS total
FROM transactions
WHERE status='Borrowed'");

$totalBorrowed = mysqli_fetch_assoc($borrowedQuery)['total'];

// Returned Books
$returnedQuery = mysqli_query($conn,
"SELECT COUNT(*) AS total
FROM transactions
WHERE status='Returned'");

$totalReturned = mysqli_fetch_assoc($returnedQuery)['total'];


/* =====================================================
   RECENT TRANSACTIONS
===================================================== */

$recentTransactions = mysqli_query($conn,

"SELECT

transactions.transaction_id,
users.name,
books.title,
transactions.borrow_date,
transactions.return_date,
transactions.status

FROM transactions

INNER JOIN users
ON transactions.user_id = users.user_id

INNER JOIN books
ON transactions.book_id = books.book_id

ORDER BY transaction_id DESC

LIMIT 5"

);


/* =====================================================
   PENDING BORROWED BOOKS
===================================================== */

$pendingBooks = mysqli_query($conn,

"SELECT

users.name,
users.phone,
books.title,
transactions.borrow_date

FROM transactions

INNER JOIN users
ON transactions.user_id = users.user_id

INNER JOIN books
ON transactions.book_id = books.book_id

WHERE status='Borrowed'

ORDER BY borrow_date ASC"

);

?>

<div class="container">

<h1 class="page-title">
Library Management Dashboard
</h1>

<p class="welcome-text">
Welcome,
<strong><?php echo $_SESSION['admin']; ?></strong>
</p>


<!-- ===========================================
SUMMARY CARDS
=========================================== -->

<div class="cards">

<div class="card">

<h3>📚 Total Books</h3>

<h2>

<?php echo $totalBooks; ?>

</h2>

</div>

<div class="card">

<h3>👤 Total Users</h3>

<h2>

<?php echo $totalUsers; ?>

</h2>

</div>

<div class="card">

<h3>📑 Transactions</h3>

<h2>

<?php echo $totalTransactions; ?>

</h2>

</div>

<div class="card">

<h3>📖 Borrowed</h3>

<h2>

<?php echo $totalBorrowed; ?>

</h2>

</div>

<div class="card">

<h3>✅ Returned</h3>

<h2>

<?php echo $totalReturned; ?>

</h2>

</div>

</div>


<!-- ===========================================
RECENT TRANSACTIONS
=========================================== -->

<div class="table-section">

<h2>
📋 Recent Transactions
</h2>

<table>

<tr>

<th>ID</th>

<th>User</th>

<th>Book</th>

<th>Borrow Date</th>

<th>Return Date</th>

<th>Status</th>

</tr>

<?php

if(mysqli_num_rows($recentTransactions)>0)
{

while($row=mysqli_fetch_assoc($recentTransactions))
{

?>

<tr>

<td>

<?php echo $row['transaction_id']; ?>

</td>

<td>

<?php echo $row['name']; ?>

</td>

<td>

<?php echo $row['title']; ?>

</td>

<td>

<?php echo $row['borrow_date']; ?>

</td>

<td>

<?php

if($row['return_date']==NULL)
{

echo "-";

}

else
{

echo $row['return_date'];

}

?>

</td>

<td>

<?php

if($row['status']=="Borrowed")
{

echo "<span class='status borrowed'>Borrowed</span>";

}

else
{

echo "<span class='status returned'>Returned</span>";

}

?>

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

No transactions found.

</td>

</tr>

<?php

}

?>

</table>

</div>



<!-- ===========================================
PENDING BORROWED BOOKS
=========================================== -->

<div class="table-section">

<h2>

📚 Pending Borrowed Books

</h2>

<table>

<tr>

<th>User</th>

<th>Phone</th>

<th>Book</th>

<th>Borrow Date</th>

<th>Days Borrowed</th>

</tr>

<?php

if(mysqli_num_rows($pendingBooks)>0)
{

while($row=mysqli_fetch_assoc($pendingBooks))
{

$today = new DateTime();

$borrow = new DateTime($row['borrow_date']);

$days = $borrow->diff($today)->days;


/* Row Color */

$rowClass="";

if($days<=7)
{

$rowClass="safe";

}

elseif($days<=14)
{

$rowClass="warning";

}

else
{

$rowClass="danger";

}

?>

<tr class="<?php echo $rowClass; ?>">

<td>

<?php echo $row['name']; ?>

</td>

<td>

<?php echo $row['phone']; ?>

</td>

<td>

<?php echo $row['title']; ?>

</td>

<td>

<?php echo $row['borrow_date']; ?>

</td>

<td>

<?php

echo $days;

?>

Days

</td>

</tr>

<?php

}

}

else
{

?>

<tr>

<td colspan="5">

No pending borrowed books.

</td>

</tr>

<?php

}

?>

</table>

</div>


</div>

<?php

include '../includes/footer.php';

?>