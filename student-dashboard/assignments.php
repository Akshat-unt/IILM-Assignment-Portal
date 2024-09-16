<?php
include 'student_session_check.php'; // Check if the session is valid

// Include database configuration
include 'config.php'; 

// Fetch assignments from the database based on the student's course
$sql = "SELECT Assignments.Assign_id, Assignments.Assign_Title, Assignments.Assign_des, Assignments.Assign_due
        FROM Assignments
        JOIN Courses ON Assignments.Course_id = Courses.Course_id
        WHERE Courses.Course_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['section']);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignments</title>
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
        a.submit-btn {
            background-color: #3498db;
            color: white;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            display: inline-block;
        }
        a.submit-btn:hover {
            background-color: #2980b9;
        }
        .submitted-text {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <h2>Assignments</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                while ($row = $result->fetch_assoc()) { 
                    // Check if the assignment is already submitted by this student
                    $assign_id = $row['Assign_id'];
                    $stu_id = $_SESSION['user']['Stu_id'];

                    $submission_sql = "SELECT Submission_id FROM Submissions WHERE Assign_id = ? AND Stu_id = ?";
                    $submission_stmt = $conn->prepare($submission_sql);
                    $submission_stmt->bind_param("ii", $assign_id, $stu_id);
                    $submission_stmt->execute();
                    $submission_result = $submission_stmt->get_result();
                    $is_submitted = $submission_result->num_rows > 0;
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Assign_Title']); ?></td>
                        <td><?php echo htmlspecialchars($row['Assign_des']); ?></td>
                        <td><?php echo htmlspecialchars($row['Assign_due']); ?></td>
                        <td>
                            <?php if ($is_submitted): ?>
                                <span class="submitted-text">Submitted successfully</span>
                            <?php else: ?>
                                <a href="student_dashboard.php?page=submit_assignment&assign_id=<?php echo $row['Assign_id']; ?>" class="submit-btn">Submit</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
