<?php
include 'admin_session_check.php';
ob_start(); // Start output buffering

// Include database connection
include 'config.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Add a new course
    if (isset($_POST['add_course'])) {
        $course_name = $_POST['course_name'];
        $add_query = "INSERT INTO Courses (Course_name) VALUES (?)";
        $stmt = $conn->prepare($add_query);
        $stmt->bind_param("s", $course_name);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Course added successfully!";
            header('Location: admin_dashboard.php?page=manage_courses');
            exit(); // Ensure to call exit() after header redirection
        } else {
            echo "Error: " . $conn->error;
        }
    }
    
    // Edit an existing course
    if (isset($_POST['edit_course'])) {
        $course_id = $_POST['course_id'];
        $course_name = $_POST['course_name'];
        $edit_query = "UPDATE Courses SET Course_name = ? WHERE Course_id = ?";
        $stmt = $conn->prepare($edit_query);
        $stmt->bind_param("si", $course_name, $course_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Course updated successfully!";
            header('Location: admin_dashboard.php?page=manage_courses');
            exit(); // Ensure to call exit() after header redirection
        } else {
            echo "Error: " . $conn->error;
        }
    }
    
    // Delete a course
    if (isset($_POST['delete_course'])) {
        $course_id = $_POST['course_id'];
        $delete_query = "DELETE FROM Courses WHERE Course_id = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param("i", $course_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Course deleted successfully!";
            header('Location: admin_dashboard.php?page=manage_courses');
            exit(); // Ensure to call exit() after header redirection
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

ob_end_flush(); // End output buffering
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
    <link rel="stylesheet" href="admin_style.css">
    <script>
        // Display alert message from PHP session
        window.onload = function() {
            var message = "<?php echo isset($_SESSION['message']) ? $_SESSION['message'] : ''; ?>";
            if (message) {
                alert(message);
                <?php unset($_SESSION['message']); // Clear the message after displaying ?>
            }
        };
    </script>
</head>
<body>
    <h2>Manage Courses</h2>
    
    <!-- Add New Course Form -->
    <form method="POST" action="">
        <h3>Add New Course</h3>
        <label for="course_name">Course Name:</label>
        <input type="text" name="course_name" required>
        <button type="submit" name="add_course">Add Course</button>
    </form>
    
    <!-- Courses Table -->
    <h3>All Courses</h3>
    <table>
        <thead>
            <tr>
                <th>Course ID</th>
                <th>Course Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch all courses from the database
            $courses_query = "SELECT * FROM Courses";
            $courses_result = $conn->query($courses_query);
            
            if ($courses_result->num_rows > 0) {
                while ($course = $courses_result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . htmlspecialchars($course['Course_id']) . "</td>
                        <td>" . htmlspecialchars($course['Course_name']) . "</td>
                        <td>
                            <form method='POST' action='' style='display:inline-block;'>
                                <input type='hidden' name='course_id' value='" . htmlspecialchars($course['Course_id']) . "'>
                                <input type='text' name='course_name' value='" . htmlspecialchars($course['Course_name']) . "' required>
                                <button type='submit' name='edit_course'>Edit</button>
                            </form>
                            <form method='POST' action='' style='display:inline-block;'>
                                <input type='hidden' name='course_id' value='" . htmlspecialchars($course['Course_id']) . "'>
                                <button type='submit' name='delete_course' onclick='return confirm(\"Are you sure you want to delete this course?\");'>Delete</button>
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No courses available</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
