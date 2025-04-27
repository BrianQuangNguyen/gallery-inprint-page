<?php
// Start the session
session_start();

include "connect.php";

// Now we check if the data from the login form was submitted, isset() will check if the data exists
if (!isset($_POST['email'], $_POST['password'])) {
    // Could not get the data that should have been sent
    exit('Please fill both the email and password fields!');
}

// Prepare our SQL, which will prevent SQL injection
$stmt = $dbh->prepare('SELECT id, password, admin FROM accounts WHERE email = ?');
if ($stmt) {
    // Execute the statement with the email parameter
    $stmt->execute([$_POST['email']]);

    // Fetch the result
    $account = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if account exists with the input email
    if ($account) {
        // Account exists
        $id = $account['id'];
        $password = $account['password'];

        // Verify the password
        if (password_verify($_POST['password'], $password)) {
            // Password is correct! User has logged in!
            session_regenerate_id();
            $_SESSION['account_loggedin'] = TRUE;
            $_SESSION['account_email'] = $_POST['email'];
            $_SESSION['account_id'] = $id;
            $_SESSION['account_admin'] = $account['admin'];
            echo 'success'; // Success code to return to the dashboard
        } else {
            // Incorrect password
            echo 'Incorrect email and/or password!';
        }
    } else {
        // Incorrect email
        echo 'Incorrect email and/or password!';
    }
}
?>