<?php
// Assuming $conn is the connection to your database and it's already included
include 'config.php'; 
include 'admin_session_check.php';
$id = $_GET['id'];
$role = $_GET['role'];
$user_data = [];

// Fetch the user data based on role
if ($role == 'Faculty') {
    $query = "SELECT * FROM Faculty WHERE Fac_id = '$id'";
    $user_data = $conn->query($query)->fetch_assoc();
} elseif ($role == 'Student') {
    $query = "SELECT * FROM Students WHERE Stu_id = '$id'";
    $user_data = $conn->query($query)->fetch_assoc();
} elseif ($role == 'Admin') {
    $query = "SELECT * FROM Admins WHERE Admin_id = '$id'";
    $user_data = $conn->query($query)->fetch_assoc();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    if ($role == 'Faculty') {
        $fac_subject = $_POST['fac_subject']; // Get selected subject code

        // Update query for faculty
        $update_faculty = "UPDATE Faculty SET Fac_name = '$name', Fac_email = '$email', Fac_subjects = '$fac_subject' WHERE Fac_id = '$id'";
        if ($conn->query($update_faculty)) {
            header('Location: admin_dashboard.php?page=manage_users');
        } else {
            echo "Error: " . $conn->error;
        }
    } elseif ($role == 'Student') {
        $course = $_POST['course'];

        // Update query for students
        $update_student = "UPDATE Students SET Stu_name = '$name', Stu_email = '$email', Stu_course = '$course' WHERE Stu_id = '$id'";
        if ($conn->query($update_student)) {
            header('Location: admin_dashboard.php?page=manage_users');
        } else {
            echo "Error: " . $conn->error;
        }
    } elseif ($role == 'Admin') {
        // Update query for admin
        $update_admin = "UPDATE Admins SET Admin_name = '$name', Admin_email = '$email' WHERE Admin_id = '$id'";
        if ($conn->query($update_admin)) {
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
    <title>Edit User</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <div class="main-content">
        <h2>Edit User</h2>
        <form method="POST" action="edit_user.php?id=<?php echo $id; ?>&role=<?php echo $role; ?>">
            <table class="form-table">
                <tr>
                    <td><label for="name">Name:</label></td>
                    <td><input type="text" name="name" value="<?php echo htmlspecialchars($user_data['Fac_name'] ?? $user_data['Stu_name'] ?? $user_data['Admin_name']); ?>" required></td>
                </tr>
                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="email" name="email" value="<?php echo htmlspecialchars($user_data['Fac_email'] ?? $user_data['Stu_email'] ?? $user_data['Admin_email']); ?>" required></td>
                </tr>

                <!-- Faculty-specific fields -->
                <?php if ($role == 'Faculty') { ?>
                    <tr>
                        <td><label for="fac_subject">Select Subject:</label></td>
                        <td>
                            <select id="fac_subject" name="fac_subject" required>
                                <option value="">--Select a Course - Subject--</option>
                                <?php
                                // Fetch courses and subjects from the database
                                $subjects_query = "SELECT Courses.Course_name, Subjects.Sub_id, Subjects.Sub_name 
                                                    FROM Courses 
                                                    JOIN Subjects ON Courses.Course_id = Subjects.Course_id";
                                $subjects_result = $conn->query($subjects_query);

                                if ($subjects_result->num_rows > 0) {
                                    while ($row = $subjects_result->fetch_assoc()) {
                                        // Pre-select the current subject
                                        $selected = $row['Sub_id'] == $user_data['Fac_subjects'] ? "selected" : "";
                                        echo "<option value='" . htmlspecialchars($row['Sub_id']) . "' $selected>" . htmlspecialchars($row['Course_name']) . " - " . htmlspecialchars($row['Sub_name']) . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>No subjects available</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                <?php } ?>

                <!-- Student-specific fields -->
                <?php if ($role == 'Student') { ?>
                    <tr>
                        <td><label for="course">Course:</label></td>
                        <td>
                            <select name="course" required>
                                <?php
                                $courses_query = "SELECT Course_id, Course_name FROM Courses";
                                $courses_result = $conn->query($courses_query);
                                while ($row = $courses_result->fetch_assoc()) {
                                    $selected = $row['Course_id'] == $user_data['Stu_course'] ? "selected" : "";
                                    echo "<option value='" . htmlspecialchars($row['Course_id']) . "' $selected>" . htmlspecialchars($row['Course_name']) . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                <?php } ?>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($id); ?>">
                        <button type="submit">Update User</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
