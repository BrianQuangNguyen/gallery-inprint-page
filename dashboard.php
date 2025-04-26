<!-- 
Gallery Inprint Error Page

- An HTML page which the user is directed to if any error occurs when receiving HTTP paramters
- Provides the user with a link to return to the site's homepage

Team: Brick Plug
Members: Aleina Elizabeth Biju, Abigail	Fong, Logan Lau-McLennan, Brian Nguyen

Author: Abigail Fong (400567541)
Created: 19/04/2025
-->

<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: account.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome to Your Dashboard</h2>
    <a href="util/logout.php">Logout</a>
</body>
</html>