<?php
include 'config.php'; // Database connection
include 'admin_session_check.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    if ($role == 'Faculty') {
        $insert_faculty = "INSERT INTO Faculty (Fac_name, Fac_email, Fac_password) VALUES ('$name', '$email', '$password')";
        if ($conn->query($insert_faculty)) {
            header('Location: admin_dashboard.php?page=manage_users');
        } else {
            echo "Error: " . $conn->error;
        }
    } elseif ($role == 'Student') {
        $course = $_POST['course'];
        $insert_student = "INSERT INTO Students (Stu_name, Stu_email, Stu_password, Stu_course) VALUES ('$name', '$email', '$password', '$course')";
        if ($conn->query($insert_student)) {
            header('Location: admin_dashboard.php?page=manage_users');
        } else {
            echo "Error: " . $conn->error;
        }
    } elseif ($role == 'Admin') {
        $insert_admin = "INSERT INTO Admins (Admin_name, Admin_email, Admin_password) VALUES ('$name', '$email', '$password')";
        if ($conn->query($insert_admin)) {
            header('Location: admin_dashboard.php?page=manage_users');
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New User</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <h2>Add New User</h2>
    <form method="POST" action="add_user.php">
        <table>
            <tr>
                <td><label for="name">Name:</label></td>
                <td><input type="text" name="name" required></td>
            </tr>
            <tr>
                <td><label for="email">Email:</label></td>
                <td><input type="email" name="email" required></td>
            </tr>
            <tr>
                <td><label for="password">Password:</label></td>
                <td><input type="password" name="password" required></td>
            </tr>
            <tr>
                <td><label for="role">Role:</label></td>
                <td>
                    <select name="role" id="role" onchange="toggleCourseField()">
                        <option value="Faculty">Faculty</option>
                        <option value="Student">Student</option>
                        <option value="Admin">Admin</option>
                    </select>
                </td>
            </tr>
            <tr id="courseFieldRow" style="display: none;">
                <td><label for="course">Course:</label></td>
                <td>
                    <select name="course">
                        <?php
                        $courses_query = "SELECT Course_id, Course_name FROM Courses";
                        $courses_result = $conn->query($courses_query);
                        while ($row = $courses_result->fetch_assoc()) {
                            echo "<option value='" . $row['Course_id'] . "'>" . $row['Course_name'] . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <button type="submit">Add User</button>
                </td>
            </tr>
        </table>
    </form>

    <script>
        function toggleCourseField() {
            const role = document.getElementById('role').value;
            const courseFieldRow = document.getElementById('courseFieldRow');
            if (role === 'Student') {
                courseFieldRow.style.display = 'table-row';
            } else {
                courseFieldRow.style.display = 'none';
            }
        }
    </script>
</body>
</html>
