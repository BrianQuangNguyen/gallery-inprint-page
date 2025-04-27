<?php
// Logout script to end the session and redirect the user to the login page

// Start the session
session_start();
// Get rid of session variables related to the account
unset($_SESSION['account_loggedin']);
unset($_SESSION['account_email']);
unset($_SESSION['account_id']);
unset($_SESSION['account_admin']);

// Redirect to the login page
header('Location: ../account.php');
exit;
?>