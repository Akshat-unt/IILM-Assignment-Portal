<?php
include 'admin_session_check.php';
// Fetch statistics from the database
$students_query = "SELECT COUNT(*) AS total_students FROM Students";
$students_result = $conn->query($students_query);
$total_students = $students_result->fetch_assoc()['total_students'];

$faculty_query = "SELECT COUNT(*) AS total_faculty FROM Faculty";
$faculty_result = $conn->query($faculty_query);
$total_faculty = $faculty_result->fetch_assoc()['total_faculty'];

$courses_query = "SELECT COUNT(*) AS total_courses FROM Courses";
$courses_result = $conn->query($courses_query);
$total_courses = $courses_result->fetch_assoc()['total_courses'];

$assignments_query = "SELECT COUNT(*) AS total_assignments FROM Assignments";
$assignments_result = $conn->query($assignments_query);
$total_assignments = $assignments_result->fetch_assoc()['total_assignments'];

$submissions_query = "SELECT COUNT(*) AS total_submissions FROM Submissions";
$submissions_result = $conn->query($submissions_query);
$total_submissions = $submissions_result->fetch_assoc()['total_submissions'];
?>

<div class="overview-container">
    <h2>Admin Dashboard Overview</h2>
    
        <div class="stat-box">
            <h3>Total Students</h3>
            <p><?php echo $total_students; ?></p>
        </div>
    
        <div class="stat-box">
            <h3>Total Faculty</h3>
            <p><?php echo $total_faculty; ?></p>
        </div>
    
        <div class="stat-box">
            <h3>Total Courses</h3>
            <p><?php echo $total_courses; ?></p>
        </div>
    
        <div class="stat-box">
            <h3>Total Assignments</h3>
            <p><?php echo $total_assignments; ?></p>
        </div>
    
        <div class="stat-box">
            <h3>Total Submissions</h3>
            <p><?php echo $total_submissions; ?></p>
        </div>
    
</div>

<style>
    .overview-container {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
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
</style>
