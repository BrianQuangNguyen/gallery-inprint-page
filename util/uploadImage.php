<?php
/*
PHP script to handle image uploads in the admin dashboard. 
It checks if the user is logged in and has admin privileges, validates the uploaded file type, and moves the file to the specified directory. 
If successful, it returns a success message; otherwise, it returns an error message.

Team: Brick Plug
Members: Aleina Elizabeth Biju, Abigail	Fong, Logan Lau-McLennan, Brian Nguyen

By: Logan Lau-McLennan (400589565)
Created: 26/04/2025
*/

session_start();
if (empty($_SESSION['account_loggedin']) || empty($_SESSION['account_admin'])) {
    exit('Unauthorized.');
}

$target_dir = '../images/';

if (!empty($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $file_name = basename($_FILES['image']['name']);
    $target_file = $target_dir . $file_name;

    // Validate file type (only images)
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'webp'];

    if (in_array($file_type, $allowed_types)) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            echo 'Image uploaded successfully!';
        } else {
            echo 'Failed to upload image.';
        }
    } else {
        echo 'Only JPG, PNG, and WEBP files are allowed.';
    }
} else {
    echo 'No file uploaded or upload error.';
}
?>