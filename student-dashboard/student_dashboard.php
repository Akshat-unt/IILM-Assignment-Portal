<?php
include 'student_session_check.php'; // Check if the session is valid

// Include database configuration
include 'config.php'; 

// Fetch user information from the session
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="student_style.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Student Dashboard</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="student_dashboard.php?page=overview">Dashboard</a></li>
                    <li><a href="student_dashboard.php?page=assignments">Assignments</a></li>
                    <li><a href="student_dashboard.php?page=submissions">Submissions</a></li>
                    <li><a href="student_dashboard.php?page=grades">Grades</a></li>
                    <li><a href="student_dashboard.php?page=change_password">Change Password</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </aside>
        <!-- Main Content -->
        <div class="main-content">
            <?php
            $page = isset($_GET['page']) ? $_GET['page'] : 'overview';
            include $page . '.php';
            ?>
        </div>
    </div>
</body>
</html>

<?php
ob_end_flush(); // End output buffering
?>
