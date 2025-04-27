<?php
session_start();
require 'connect.php';

// Check if email and password are provided
if (isset($_POST['email'], $_POST['password'])) {
    // Sanitize and validate inputs
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Ensure email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit('Invalid email format.');
    }

    // Check if the email already exists in the database
    $stmt = $dbh->prepare('SELECT * FROM accounts WHERE email = ?');
    $stmt->execute([$email]);
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        exit('Email is already registered.');
    }

    // Hash the password using a secure hashing algorithm
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $stmt = $dbh->prepare('INSERT INTO accounts (email, password, admin) VALUES (?, ?, ?)');
    $stmt->execute([$email, $hashedPassword, 0]); // By default, users are not admins (admin = 0)

    // On successful registration, log the user in automatically
    $_SESSION['account_loggedin'] = true;
    $_SESSION['account_email'] = $email;
    $_SESSION['account_id'] = $dbh->lastInsertId(); // Get the last inserted user ID
    $_SESSION['account_admin'] = 0; // Default to non-admin

    // Redirect to the dashboard
    echo 'success'; // Success response
} else {
    // If email or password is not set, return an error
    exit('Please fill out both fields.');
}
?>