<?php
session_start();
include 'student_session_check.php'; // Check if the session is valid

// Include database configuration
include 'config.php'; 

// Fetch user information from the session
$user = $_SESSION['user'];

// Fetch course name based on course ID
$course_query = "SELECT Course_name FROM Courses JOIN Students ON Courses.Course_id = Students.Stu_course WHERE Students.Stu_id = ?";
$stmt = $conn->prepare($course_query);
$stmt->bind_param("i", $user['Stu_id']);
$stmt->execute();
$course_result = $stmt->get_result();
$course_name = $course_result->fetch_assoc()['Course_name'];

// Fetch total assignments for the user's course
$assignments_query = "SELECT COUNT(*) AS total_assignments FROM Assignments WHERE Course_id = ?";
$stmt = $conn->prepare($assignments_query);
$stmt->bind_param("i", $user['Stu_course']);
$stmt->execute();
$total_assignments_result = $stmt->get_result();
$total_assignments = $total_assignments_result->fetch_assoc()['total_assignments'];

// Fetch completed assignments
$submissions_query = "SELECT COUNT(*) AS completed_assignments FROM Submissions WHERE Stu_id = ?";
$stmt = $conn->prepare($submissions_query);
$stmt->bind_param("i", $user['Stu_id']);
$stmt->execute();
$completed_assignments_result = $stmt->get_result();
$completed_assignments = $completed_assignments_result->fetch_assoc()['completed_assignments'];

$pending_assignments = $total_assignments - $completed_assignments;

// Fetch subjects for the user
$subjects_query = "SELECT Sub_name FROM Subjects WHERE Course_id = ?";
$stmt = $conn->prepare($subjects_query);
$stmt->bind_param("i", $user['Stu_course']);
$stmt->execute();
$subjects_result = $stmt->get_result();
$subjects = [];
while ($row = $subjects_result->fetch_assoc()) {
    $subjects[] = $row['Sub_name'];
}
$subjects_list = implode('<li>', $subjects);
$subjects_list = "<ul><li>" . $subjects_list . "</li></ul>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard Overview</title>
    <link rel="stylesheet" href="student_dashboard_style.css">
    <style>
        .overview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
            margin-top: 20px;
        }

        .stat-box {
            width: 22%;
            background-color: #4A90E2;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .stat-box h3 {
            margin: 0 0 10px;
            font-size: 18px;
        }

        .stat-box p {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }

        .welcome-container {
            margin-bottom: 20px;
        }

        .welcome-container h2 {
            margin: 0;
        }

        .profile-table {
            width: 85%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .profile-table th, .profile-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .profile-table th {
            background-color: #f2f2f2;
            text-align: left;
        }

        .profile-table td {
            background-color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="welcome-container">
                <h2>Welcome, <?php echo htmlspecialchars($user['Stu_name']); ?>!</h2>
            </div>
            <div class="overview-container">
                <div class="stat-box">
                    <h3>Total Assignments</h3>
                    <p><?php echo $total_assignments; ?></p>
                </div>
                <div class="stat-box">
                    <h3>Completed Assignments</h3>
                    <p><?php echo $completed_assignments; ?></p>
                </div>
                <div class="stat-box">
                    <h3>Pending Assignments</h3>
                    <p><?php echo $pending_assignments; ?></p>
                </div>
                <!--<div class="stat-box">
                    <h3>Course</h3>
                    <p><?php echo htmlspecialchars($course_name); ?></p>
                </div>-->
            </div>

            <!-- Profile Table -->
            <table class="profile-table">
                <tr>
                    <th>Your Name</th>
                    <td><?php echo htmlspecialchars($user['Stu_name']); ?></td>
                </tr>
                <tr>
                    <th>Your Email</th>
                    <td><?php echo htmlspecialchars($user['Stu_email']); ?></td>
                </tr>
                <tr>
                    <th>Your Course/Sections</th>
                    <td><?php echo htmlspecialchars($course_name); ?></td>
                </tr>
                <tr>
                    <th>Your Subjects</th>
                    <td><?php echo $subjects_list; ?></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
