<?php
include 'config.php';  // Database connection
include 'admin_session_check.php';
// Check if 'id' and 'role' parameters are set
if (isset($_GET['id']) && isset($_GET['role'])) {
    $id = $_GET['id'];
    $role = $_GET['role'];

    // Initialize the delete query
    $delete_query = "";

    // Determine the table and column to delete based on role
    if ($role == 'Faculty') {
        $delete_query = "DELETE FROM Faculty WHERE Fac_id = '$id'";
    } elseif ($role == 'Student') {
        $delete_query = "DELETE FROM Students WHERE Stu_id = '$id'";
    } elseif ($role == 'Admin') {
        $delete_query = "DELETE FROM Admins WHERE Admin_id = '$id'";
    }

    // Execute the query and handle success or error
    if ($delete_query && $conn->query($delete_query) === TRUE) {
        header("Location: admin_dashboard.php?page=manage_users");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid parameters.";
}
?>
