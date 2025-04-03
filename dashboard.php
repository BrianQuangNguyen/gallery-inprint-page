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
    <a href="logout.php">Logout</a>
</body>
</html>