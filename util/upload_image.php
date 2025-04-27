<?php
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