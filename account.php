<?php
include "connect.php";
session_start();
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<!--
Account Login Page
-->
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Your Account</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div id="container">
        <div id="nav">
            <ul>
                <li><a href="index.php"><img src="images/home.png" title="Home" alt="Home"></a></li>
                <li><a href="store.php"><img src="images/shop.png" title="Shop" alt="Shop"></a></li>
                <li><a href="cart.html"><img src="images/shopping-cart.png" title="Shopping Cart" alt="Shopping Cart"></a></li>
                <li><a href="account.php"><img src="images/profile-picture.png" title="Account" alt="Account"></a></li>               
            </ul>
        </div>
    </div>

    <h1>Login</h1>
    <form action="login.php" method="POST">
        <label>Username:</label>
        <input type="text" name="username" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <input type="submit">
    </form>
</body>

</html>