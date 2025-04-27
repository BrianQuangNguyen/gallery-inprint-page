<?php
/*
Gallery Inprint Account Page

- Registration page for new users
- Uses most of the HTML from account.php
- 

Team: Brick Plug
Members: Aleina Elizabeth Biju, Abigail	Fong, Logan Lau-McLennan, Brian Nguyen

Author: Logan Lau-McLennan (400589565)
Created: 26/04/2025
*/

include 'util/connect.php';

// Check if the user is already logged in
session_start();
if (isset($_SESSION['account_loggedin'])) {
    header("Location: dashboard.php"); // If so, redirect to dashboard
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/navbar.js"></script>
</head>

<body>
    <div id="container">
        <div id="mobileNav">
            <img id="menu" src="images/menu.png" title="Menu" alt="Menu">
            <ul id="navlinks">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="cart.html">Your Cart</a></li>
                <li><a href="account.php">Account Login</a></li>
            </ul>
        </div>
        <div id="nav">
            <ul>
                <li><a href="index.php"><img src="images/home.png" title="Home" alt="Home"></a></li>
                <li><a href="about.html"><img src="images/about.png" title="About Us" alt="About Us"></a></li>
                <li><a href="shop.php"><img src="images/shop.png" title="Shop" alt="Shop"></a></li>
                <li><a href="cart.html"><img src="images/shopping-cart.png" title="Shopping Cart"
                            alt="Shopping Cart"></a></li>
                <li><a href="account.php"><img src="images/profile-picture.png" title="Account" alt="Account"></a></li>
            </ul>
        </div>
    </div>

    <h1>Member Register</h1>
    <div class="login">

        <form id="login-form">
            
            <label class="form-label" for="email">Email</label>
            <div class="form-group">
                <input class="form-input" type="email" name="email" placeholder="Email" id="email" required>
            </div>

            <label class="form-label" for="password">Password</label>
            <div class="form-group">
                <input class="form-input" type="password" name="password" placeholder="Password" id="password" autocomplete="new-password" required>
            </div>

            <button type="submit">Register</button>

            <p class="register-link">Already have an account? <a href="account.php" class="form-link">Login</a></p>

        </form>

    </div>

    <script>
        window.onload = function () {
            // Add event listener to the login form
            document.getElementById("login-form").addEventListener("submit", function (event) {
                event.preventDefault(); // Stop the form from submitting normally

                // Get the email and password values
                const formData = new FormData(this);

                fetch('util/addUser.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    console.log('Response from PHP:', data);
                    if(data.trim() === 'success') {
                        window.location.href = 'dashboard.php'; // Redirect to dashboard on success
                    } else {
                        document.getElementById('message').innerHTML = data; // Display error message
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        };
    </script>
</body>

</html>