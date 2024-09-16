<?php

include 'student_session_check.php'; // Check if the session is valid

// Include database configuration
include 'config.php'; 

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submission_id'])) {
    $submission_id = $_POST['submission_id'];

    // Prepare and execute the deletion query
    $sql = "DELETE FROM Submissions WHERE Submission_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $submission_id);

    if ($stmt->execute()) {
        // Redirect back to the submissions page with a success message
        header("Location: student_dashboard.php?page=submissions&message=Submission+deleted+successfully");
    } else {
        // Redirect back with an error message
        header("Location: student_dashboard.php?page=submissions&message=Error+deleting+submission");
    }
    
    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();

ob_end_flush(); // End output buffering
?>

