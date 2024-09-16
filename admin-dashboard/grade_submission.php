<?php
include 'config.php'; // Database connection
include 'admin_session_check.php';
if (isset($_POST['submission_id'])) {
    $submission_id = $_POST['submission_id'];

    // Fetch submission details for the form
    $submission_query = "
        SELECT Submissions.Submission_id, Submissions.Submission_file, 
               Students.Stu_name, Assignments.Assign_Title 
        FROM Submissions 
        JOIN Students ON Submissions.Stu_id = Students.Stu_id 
        JOIN Assignments ON Submissions.Assign_id = Assignments.Assign_id 
        WHERE Submission_id = ?";
    
    $stmt = $conn->prepare($submission_query);
    $stmt->bind_param("i", $submission_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $submission = $result->fetch_assoc();
}

if (isset($_POST['submit_grade'])) {
    $grade = $_POST['grade'];
    $feedback = $_POST['feedback'];

    // Store grade and feedback (you would need a grades table in your DB)
    $grade_query = "INSERT INTO Grades (Submission_id, Grade, Feedback) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($grade_query);
    $stmt->bind_param("iis", $_POST['submission_id'], $grade, $feedback);
    $stmt->execute();

    echo "Grade and feedback saved successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Submission</title>
</head>
<body>
    <h2>Grade Submission for <?php echo htmlspecialchars($submission['Stu_name']); ?></h2>
    <h3>Assignment: <?php echo htmlspecialchars($submission['Assign_Title']); ?></h3>
    <a href="uploads/<?php echo htmlspecialchars($submission['Submission_file']); ?>" download>Download Submission</a>

    <!-- Grade and Feedback Form -->
    <form method="POST" action="">
        <input type="hidden" name="submission_id" value="<?php echo htmlspecialchars($submission_id); ?>">
        <label for="grade">Grade:</label>
        <input type="number" name="grade" required>

        <label for="feedback">Feedback:</label>
        <textarea name="feedback" required></textarea>

        <button type="submit" name="submit_grade">Submit Grade</button>
    </form>
</body>
</html>
