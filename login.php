<?php
session_start();
include "connect.php";  // Connect to database

$username = filter_input(INPUT_POST, "username");
$password = filter_input(INPUT_POST, "password");
// var_dump($username,$password);

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $username = $_POST['username'];
    // $password = $_POST['password'];

    // Check if user exists
    // $stmt = $dbh->prepare("SELECT `id`, `password` FROM `users` WHERE `username` = ?");
    // $stmt->bind_param("s", $username);
    // $stmt->execute();
    // $stmt->store_result();

    // if ($stmt->num_rows > 0) {
    //     $stmt->bind_result($id, $hashed_password);
    //     $stmt->fetch();

    //     if (password_verify($password, $hashed_password)) {
    //         $_SESSION['user'] = $id;
    //         header("Location: dashboard.php");
    //         exit();
    //     } else {
    //         echo "Invalid password.";
    //     }
    // } else {
    //     echo "User not found.";
    // }
    // $stmt->close();


    $command = "SELECT `id`, `password` FROM `users` WHERE `username` = ?";
    $stmt = $dbh->prepare($command);
    $params = [$username];
    $success = $stmt->execute($params);
    // $success = $stmt->execute([$num]);


    $row = $stmt->fetch();
    if ($password == $row["password"]) {
        $_SESSION['user'] = $id;
        echo "Logged in successfully";
        // header("Location: dashboard.php");
    } else {
        echo "Invalid password.";
    }
// }
