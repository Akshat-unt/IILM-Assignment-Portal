<?php
// Start output buffering
ob_start();

session_start();
include 'student_session_check.php'; // Check if the session is valid

// Include database configuration
include 'config.php'; 

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submission_id'])) {
    $submission_id = $_POST['submission_id'];
    
    // Fetch submission details to get file path
    $fetch_sql = "SELECT Submission_file, Submission_time FROM Submissions WHERE Submission_id = ?";
    $fetch_stmt = $conn->prepare($fetch_sql);
    $fetch_stmt->bind_param("i", $submission_id);
    $fetch_stmt->execute();
    $fetch_result = $fetch_stmt->get_result();
    $submission = $fetch_result->fetch_assoc();
    
    if ($submission) {
        // Check if the submission time difference is less than 5 hours
        $submission_time = new DateTime($submission['Submission_time']);
        $current_time = new DateTime();
        $interval = $current_time->diff($submission_time);
        $hours_difference = $interval->h + ($interval->days * 24);
        
        if ($hours_difference <= 5) {
            // Delete the submission
            $delete_sql = "DELETE FROM Submissions WHERE Submission_id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $submission_id);
            
            if ($delete_stmt->execute()) {
                // Optionally, delete the file from the server
                unlink($submission['Submission_file']);
                // Redirect with a success message
                header('Location: submissions.php?message=Submission deleted successfully.');
                exit();
            } else {
                echo "Error deleting submission: " . $conn->error;
            }
        } else {
            echo "You cannot delete submissions after 5 hours.";
        }
    } else {
        echo "Submission not found.";
    }
}

// Fetch submissions for the student
$sql = "SELECT * FROM Submissions WHERE Stu_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user']['Stu_id']);
$stmt->execute();
$result = $stmt->get_result();

// Flush output buffer at the end of the script
ob_end_flush();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submissions</title>
    <link rel="stylesheet" href="student_dashboard_style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .delete-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
        }
        .delete-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <h2>Submissions</h2>

        <?php if (isset($_GET['message'])): ?>
            <p><?php echo htmlspecialchars($_GET['message']); ?></p>
        <?php endif; ?>
        
        <!-- Submissions Table -->
        <table>
            <thead>
                <tr>
                    <th>Assignment Title</th>
                    <th>Submission Time</th>
                    <th>File</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <?php
                    // Fetch assignment title
                    $assign_sql = "SELECT Assign_Title FROM Assignments WHERE Assign_id = ?";
                    $assign_stmt = $conn->prepare($assign_sql);
                    $assign_stmt->bind_param("i", $row['Assign_id']);
                    $assign_stmt->execute();
                    $assign_result = $assign_stmt->get_result();
                    $assign = $assign_result->fetch_assoc();

                    // Calculate time difference
                    $submission_time = new DateTime($row['Submission_time']);
                    $current_time = new DateTime();
                    $interval = $current_time->diff($submission_time);
                    $hours_difference = $interval->h + ($interval->days * 24);
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($assign['Assign_Title']); ?></td>
                        <td><?php echo htmlspecialchars($row['Submission_time']); ?></td>
                        <td><a href="<?php echo htmlspecialchars($row['Submission_file']); ?>" target="_blank">View File</a></td>
                        <td>
                            <?php if ($hours_difference <= 5): ?>
                                <form method="post" action="">
                                    <input type="hidden" name="submission_id" value="<?php echo htmlspecialchars($row['Submission_id']); ?>">
                                    <button type="submit" class="delete-btn">Delete</button>
                                </form>
                            <?php else: ?>
                                <p>Cannot delete. More than 5 hours since submission.</p>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <p>Note: You can only delete the submission file within 5 hours of submission.</p>
    </div>
</body>
</html>
