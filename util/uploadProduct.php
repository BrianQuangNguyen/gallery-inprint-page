<!--
PHP script to handle image uploads in the admin dashboard. This script only works if the session variables indicate that the user is an admin.

By: Logan Lau-McLennan (400589565)
Created: 26/04/2025
-->

<?php
session_start();
require 'connect.php';

if (empty($_SESSION['account_loggedin']) || empty($_SESSION['account_admin'])) {
    exit('Unauthorized.');
}

if (!empty($_POST['name']) && !empty($_POST['fileName']) && !empty($_POST['quantity']) &&
    !empty($_POST['price']) && !empty($_POST['dimensions']) && !empty($_POST['description'])) {
    
    $stmt = $dbh->prepare('INSERT INTO products (name, fileName, quantity, price, dimensions, description, date) VALUES (?, ?, ?, ?, ?, ?, CURDATE())');
    
    if ($stmt->execute([
        $_POST['name'],
        $_POST['fileName'],
        $_POST['quantity'],
        $_POST['price'],
        $_POST['dimensions'],
        $_POST['description']
    ])) {
        echo 'Product added successfully!';
    } else {
        echo 'Failed to add product.';
    }
} else {
    echo 'Please fill out all fields.';
}
?>