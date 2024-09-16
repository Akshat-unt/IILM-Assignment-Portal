<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment Management Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <div class="logo">
            <h1>Admin Panel</h1>
        </div>
        <div class="user-info">
            <p>Welcome, Admin | <a href="#">Logout</a></p>
        </div>
    </header>

    <!-- Main Container -->
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Menu</h2>
            <ul>
                <li><a href="#" id="user-management-btn">User Management</a></li>
                <li><a href="#" id="assignment-management-btn">Assignment Management</a></li>
                <li><a href="#" id="course-management-btn">Course Management</a></li>
                <li><a href="#" id="report-management-btn">Reports & Analytics</a></li>
                <li><a href="#" id="settings-btn">Settings</a></li>
                <li><a href="#" id="help-btn">Help & Support</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <section class="main-content">
            <h2 id="panel-title">Welcome to Admin Panel</h2>
            <div id="panel-content">
                <!-- Dashboard Section -->
                <section class="dashboard">
                    <div class="stats">
                        <div class="stat-box">
                            <h3>Users</h3>
                            <p>1,230</p>
                        </div>
                        <div class="stat-box">
                            <h3>Assignments</h3>
                            <p>340</p>
                        </div>
                        <div class="stat-box">
                            <h3>Courses</h3>
                            <p>12</p>
                        </div>
                        <div class="stat-box">
                            <h3>Reports</h3>
                            <p>47</p>
                        </div>
                    </div>
                </section>

                <!-- Notifications Section -->
                <section class="notifications">
                    <h3>Recent Notifications</h3>
                    <ul>
                        <li>New user registration: John Doe</li>
                        <li>Assignment submission: AI Module</li>
                        <li>System update scheduled for next week</li>
                    </ul>
                </section>

                <!-- Quick Actions Section -->
                <section class="quick-actions">
                    <h3>Quick Actions</h3>
                    <div class="actions">
                        <button id="add-user-btn">Add New User</button>
                        <button id="add-assignment-btn">Create New Assignment</button>
                        <button id="generate-report-btn">Generate Report</button>
                    </div>
                </section>
            </div>
        </section>
    </div>

    <!-- Footer Section -->
    <footer class="footer">
        <p>&copy; 2024 Assignment Management System. All rights reserved.</p>
    </footer>

    
</body>
</html>
