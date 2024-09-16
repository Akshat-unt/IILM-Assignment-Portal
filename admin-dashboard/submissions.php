<?php
include 'config.php'; // Database connection
include 'admin_session_check.php';
// Fetch the list of assignments for the faculty to select
$assignments_query = "
    SELECT Assignments.Assign_id, Assignments.Assign_Title, Courses.Course_name, Subjects.Sub_name 
    FROM Assignments 
    JOIN Courses ON Assignments.Course_id = Courses.Course_id 
    JOIN Subjects ON Assignments.Sub_id = Subjects.Sub_id";
$assignments_result = $conn->query($assignments_query);

if (isset($_POST['view_submissions'])) {
    $assign_id = $_POST['assign_id'];

    // Fetch submissions for the selected assignment
    $submissions_query = "
        SELECT Submissions.Submission_id, Submissions.Submission_time, Submissions.Submission_file, 
               Students.Stu_name, Students.Stu_id 
        FROM Submissions 
        JOIN Students ON Submissions.Stu_id = Students.Stu_id 
        WHERE Submissions.Assign_id = ?";
    
    $stmt = $conn->prepare($submissions_query);
    $stmt->bind_param("i", $assign_id);
    $stmt->execute();
    $submissions_result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submissions</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <div class="main-content">
        <h2>View Submissions</h2>

        <!-- Form to select an assignment to view submissions -->
        <form method="POST" action="">
            <label for="assign_id">Select Assignment:</label>
            <select name="assign_id" required>
                <?php
                while ($assignment = $assignments_result->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($assignment['Assign_id']) . "'>" . htmlspecialchars($assignment['Assign_Title'] . " - " . $assignment['Course_name'] . " - " . $assignment['Sub_name']) . "</option>";
                }
                ?>
            </select>
            <button type="submit" name="view_submissions">View Submissions</button>
        </form>

        <?php if (isset($submissions_result)): ?>
            <h3>Submissions for Assignment: 
                <?php
                // Fetch and display the selected assignment name
                $selected_assignment_query = "SELECT Assign_Title FROM Assignments WHERE Assign_id = ?";
                $stmt = $conn->prepare($selected_assignment_query);
                $stmt->bind_param("i", $assign_id);
                $stmt->execute();
                $stmt->bind_result($assign_title);
                $stmt->fetch();
                echo htmlspecialchars($assign_title);
                ?>
            </h3>

            <!-- Submissions Table -->
            <table class="submissions-table">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Submission Time</th>
                        <th>Submission File</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($submissions_result->num_rows > 0) {
                        while ($submission = $submissions_result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . htmlspecialchars($submission['Stu_id']) . "</td>
                                <td>" . htmlspecialchars($submission['Stu_name']) . "</td>
                                <td>" . htmlspecialchars($submission['Submission_time']) . "</td>
                                <td><a href='uploads/" . htmlspecialchars($submission['Submission_file']) . "' download>Download</a></td>
                                <td>
                                    <form method='POST' action='grade_submission.php'>
                                        <input type='hidden' name='submission_id' value='" . htmlspecialchars($submission['Submission_id']) . "'>
                                        <button type='submit'>Grade/Feedback</button>
                                    </form>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No submissions found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
