<?php
ob_start(); // Start output buffering

include 'config.php';
include 'admin_session_check.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Dashboard</h2>
            </div>
            <ul class="nav-list">
                <li><a href="admin_dashboard.php?page=overview">Dashboard</a></li>
                <li><a href="admin_dashboard.php?page=manage_users">Manage Users</a></li>
                <li><a href="admin_dashboard.php?page=manage_courses">Manage Courses</a></li>
                <li><a href="admin_dashboard.php?page=manage_subjects">Manage Subjects</a></li>
                <li><a href="admin_dashboard.php?page=assignments">Assignments</a></li>
                <li><a href="admin_dashboard.php?page=submissions">Submissions</a></li>
                <li><a href="admin_dashboard.php?page=change_password">Change Password</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>

        <main class="content">
            <h1>Welcome, Admin!</h1>
            <?php
            // Handle navigation pages dynamically
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                if (file_exists($page . ".php")) {
                    include $page . ".php";
                } else {
                    echo "<p>Page not found.</p>";
                }
            } else {
                include "overview.php";  // Default page is the dashboard overview
            }
            ?>
        </main>
    </div>
</body>
</html>

<?php
ob_end_flush(); // End output buffering
?>
