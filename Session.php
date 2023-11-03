<?php
// Start the session
session_start();

// Check if the user is logged in as an admin (role_id = 1)
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    // If not logged in as an admin, redirect to login.php
    header("Location: ../signin.php");
    exit;
}


?>
