<?php
session_start(); // Start the session

// Check if the user is logged in and is a student
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'student') {
    // Redirect to login page if not a student or not logged in
    header("Location: login.php");
    exit();
}
?>
