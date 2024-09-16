<?php
include 'admin_session_check.php';
ob_start(); // Start output buffering

// Include database connection
include 'config.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Add a new subject
    if (isset($_POST['add_subject'])) {
        $subject_name = $_POST['subject_name'];
        $course_id = $_POST['course_id'];
        $add_query = "INSERT INTO Subjects (Sub_name, Course_id) VALUES (?, ?)";
        $stmt = $conn->prepare($add_query);
        $stmt->bind_param("si", $subject_name, $course_id);
        if ($stmt->execute()) {
            header('Location: admin_dashboard.php?page=manage_subjects');
            exit(); // Ensure to call exit() after header redirection
        } else {
            echo "Error: " . $conn->error;
        }
    }
    
    // Edit an existing subject
    if (isset($_POST['edit_subject'])) {
        $subject_id = $_POST['subject_id'];
        $subject_name = $_POST['subject_name'];
        $course_id = $_POST['course_id'];
        $edit_query = "UPDATE Subjects SET Sub_name = ?, Course_id = ? WHERE Sub_id = ?";
        $stmt = $conn->prepare($edit_query);
        $stmt->bind_param("sii", $subject_name, $course_id, $subject_id);
        if ($stmt->execute()) {
            header('Location: admin_dashboard.php?page=manage_subjects');
            exit(); // Ensure to call exit() after header redirection
        } else {
            echo "Error: " . $conn->error;
        }
    }
    
    // Delete a subject
    if (isset($_POST['delete_subject'])) {
        $subject_id = $_POST['subject_id'];
        $delete_query = "DELETE FROM Subjects WHERE Sub_id = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param("i", $subject_id);
        if ($stmt->execute()) {
            header('Location: admin_dashboard.php?page=manage_subjects');
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
    <title>Manage Subjects</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <h2>Manage Subjects</h2>
    
    <!-- Add New Subject Form -->
    <form method="POST" action="">
        <h3>Add New Subject</h3>
        <label for="subject_name">Subject Name:</label>
        <input type="text" name="subject_name" required>
        
        <label for="course_id">Course:</label>
        <select id="course_id" name="course_id" required>
            <option value="">--Select a Course--</option>
            <?php
            // Fetch courses from the database
            $courses_query = "SELECT * FROM Courses";
            $courses_result = $conn->query($courses_query);
            if ($courses_result->num_rows > 0) {
                while ($row = $courses_result->fetch_assoc()) {
                    echo "<option value='" . $row['Course_id'] . "'>" . $row['Course_name'] . "</option>";
                }
            } else {
                echo "<option value=''>No courses available</option>";
            }
            ?>
        </select>
        <button type="submit" name="add_subject">Add Subject</button>
    </form>
    
    <!-- Subjects Table -->
    <h3>All Subjects</h3>
    <table>
        <thead>
            <tr>
                <th>Subject ID</th>
                <th>Subject Name</th>
                <th>Course</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch all subjects from the database
            $subjects_query = "SELECT Subjects.Sub_id, Subjects.Sub_name, Courses.Course_name, Subjects.Course_id 
                               FROM Subjects 
                               JOIN Courses ON Subjects.Course_id = Courses.Course_id";
            $subjects_result = $conn->query($subjects_query);
            
            if ($subjects_result->num_rows > 0) {
                while ($subject = $subjects_result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . htmlspecialchars($subject['Sub_id']) . "</td>
                        <td>" . htmlspecialchars($subject['Sub_name']) . "</td>
                        <td>" . htmlspecialchars($subject['Course_name']) . "</td>
                        <td>
                            <form method='POST' action='' style='display:inline-block;'>
                                <input type='hidden' name='subject_id' value='" . htmlspecialchars($subject['Sub_id']) . "'>
                                <input type='text' name='subject_name' value='" . htmlspecialchars($subject['Sub_name']) . "' required>
                                <select name='course_id' required>
                                    <option value=''>--Select a Course--</option>";
                                    // Fetch courses for the dropdown
                                    $courses_result = $conn->query($courses_query);
                                    while ($course = $courses_result->fetch_assoc()) {
                                        $selected = $course['Course_id'] == $subject['Course_id'] ? 'selected' : '';
                                        echo "<option value='" . $course['Course_id'] . "' $selected>" . $course['Course_name'] . "</option>";
                                    }
                                    echo "</select>
                                <button type='submit' name='edit_subject'>Edit</button>
                            </form>
                            <form method='POST' action='' style='display:inline-block;'>
                                <input type='hidden' name='subject_id' value='" . htmlspecialchars($subject['Sub_id']) . "'>
                                <button type='submit' name='delete_subject' onclick='return confirm(\"Are you sure you want to delete this subject?\");'>Delete</button>
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No subjects available</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
