<?php
$host = "localhost";  // XAMPP runs MySQL on localhost
$dbname = "login_system";  // Use the database you created in phpMyAdmin
$username = "root";  // Default XAMPP MySQL user
$password = "";  // Default password for root is empty in XAMPP

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
