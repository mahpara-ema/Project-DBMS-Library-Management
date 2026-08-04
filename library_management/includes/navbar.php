<nav class="navbar">

<div class="logo">
Library Management
</div>

<ul>

<li><a href="/library_management/index.php">Home</a></li>

<?php

if(isset($_SESSION['admin']))
{

?>

<li><a href="/library_management/admin/dashboard.php">Dashboard</a></li>

<li><a href="/library_management/admin/books.php">Books</a></li>

<li><a href="/library_management/admin/users.php">Users</a></li>

<li><a href="#">Transactions</a></li>

<li><a href="/library_management/logout.php">Logout</a></li>

<?php

}
else
{

?>

<li><a href="/library_management/login.php">Login</a></li>

<?php

}

?>

</ul>

</nav>