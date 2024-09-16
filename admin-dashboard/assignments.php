<?php

ob_start(); // Start output buffering
include 'admin_session_check.php';
// Include database connection
include 'config.php';

// Fetch courses and subjects for the dropdowns
$courses_query = "SELECT * FROM Courses";
$courses_result = $conn->query($courses_query);

$subjects_query = "SELECT * FROM Subjects";
$subjects_result = $conn->query($subjects_query);

$faculty_query = "SELECT * FROM Faculty";
$faculty_result = $conn->query($faculty_query);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Add a new assignment
    if (isset($_POST['add_assignment'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $course_id = $_POST['course_id'];
        $subject_id = $_POST['subject_id'];
        $fac_id = $_POST['fac_id']; // Faculty ID
        $assign_date = $_POST['assign_date'];
        $due_date = $_POST['due_date'];

        $add_query = "INSERT INTO Assignments (Assign_Title, Assign_des, Course_id, Sub_id, Fac_id, Assign_date, Assign_due) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($add_query);
        $stmt->bind_param("ssiiiss", $title, $description, $course_id, $subject_id, $fac_id, $assign_date, $due_date);
        if ($stmt->execute()) {
            header('Location: admin_dashboard.php?page=assignments');
            exit(); // Ensure to call exit() after header redirection
        } else {
            echo "Error: " . $conn->error;
        }
    }

    // Edit an existing assignment
    if (isset($_POST['edit_assignment'])) {
        $assign_id = $_POST['assign_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $course_id = $_POST['course_id'];
        $subject_id = $_POST['subject_id'];
        $fac_id = $_POST['fac_id']; // Faculty ID
        $assign_date = $_POST['assign_date'];
        $due_date = $_POST['due_date'];

        $edit_query = "UPDATE Assignments SET Assign_Title = ?, Assign_des = ?, Course_id = ?, Sub_id = ?, Fac_id = ?, Assign_date = ?, Assign_due = ? WHERE Assign_id = ?";
        $stmt = $conn->prepare($edit_query);
        $stmt->bind_param("ssiiissi", $title, $description, $course_id, $subject_id, $fac_id, $assign_date, $due_date, $assign_id);
        if ($stmt->execute()) {
            header('Location: admin_dashboard.php?page=assignments');
            exit(); // Ensure to call exit() after header redirection
        } else {
            echo "Error: " . $conn->error;
        }
    }

    // Delete an assignment
    if (isset($_POST['delete_assignment'])) {
        $assign_id = $_POST['assign_id'];
        $delete_query = "DELETE FROM Assignments WHERE Assign_id = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param("i", $assign_id);
        if ($stmt->execute()) {
            header('Location: admin_dashboard.php?page=assignments');
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
    <title>Manage Assignments</title>
    <link rel="stylesheet" href="admin_style.css">
    <script>
        function updateFaculty(subjectId) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_faculty.php?subject_id=' + subjectId, true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    var facultySelect = document.getElementById('fac_id');
                    facultySelect.innerHTML = '<option value="">Select Faculty</option>';
                    response.forEach(function (faculty) {
                        var option = document.createElement('option');
                        option.value = faculty.Fac_id;
                        option.textContent = faculty.Fac_name;
                        facultySelect.appendChild(option);
                    });
                }
            };
            xhr.send();
        }
    </script>
</head>
<body>
    <div class="main-content">
        <h2>Manage Assignments</h2>

        <!-- Add New Assignment Form -->
        <form method="POST" action="" class="assignment-form">
            <h3>Add New Assignment</h3>
            <table class="form-table">
                <tr>
                    <td><label for="title">Title:</label></td>
                    <td><input type="text" name="title" required></td>
                </tr>
                <tr>
                    <td><label for="description">Description:</label></td>
                    <td><textarea name="description" required></textarea></td>
                </tr>
                <tr>
                    <td><label for="course_id">Course:</label></td>
                    <td>
                        <select id="course_id" name="course_id" required>
                            <?php
                            while ($course = $courses_result->fetch_assoc()) {
                                echo "<option value='" . htmlspecialchars($course['Course_id']) . "'>" . htmlspecialchars($course['Course_name']) . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="subject_id">Subject:</label></td>
                    <td>
                        <select id="subject_id" name="subject_id" required onchange="updateFaculty(this.value)">
                            <?php
                            while ($subject = $subjects_result->fetch_assoc()) {
                                echo "<option value='" . htmlspecialchars($subject['Sub_id']) . "'>" . htmlspecialchars($subject['Sub_name']) . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="fac_id">Faculty:</label></td>
                    <td>
                        <select id="fac_id" name="fac_id" required>
                            <option value="">Select Faculty</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="assign_date">Assignment Date:</label></td>
                    <td><input type="date" name="assign_date" required></td>
                </tr>
                <tr>
                    <td><label for="due_date">Due Date:</label></td>
                    <td><input type="date" name="due_date" required></td>
                </tr>
                <tr>
                    <td colspan="2"><button type="submit" name="add_assignment">Add Assignment</button></td>
                </tr>
            </table>
        </form>

        <!-- Assignments Table -->
        <h3>All Assignments</h3>
        <table>
            <thead>
                <tr>
                    <th>Assignment ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Course</th>
                    <th>Subject</th>
                    <th>Faculty</th>
                    <th>Assignment Date</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch all assignments from the database
                $assignments_query = "SELECT Assignments.*, Courses.Course_name, Subjects.Sub_name, Faculty.Fac_name 
                                      FROM Assignments 
                                      JOIN Courses ON Assignments.Course_id = Courses.Course_id 
                                      JOIN Subjects ON Assignments.Sub_id = Subjects.Sub_id
                                      JOIN Faculty ON Assignments.Fac_id = Faculty.Fac_id";
                $assignments_result = $conn->query($assignments_query);

                if ($assignments_result->num_rows > 0) {
                    while ($assignment = $assignments_result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . htmlspecialchars($assignment['Assign_id']) . "</td>
                            <td>" . htmlspecialchars($assignment['Assign_Title']) . "</td>
                            <td>" . htmlspecialchars($assignment['Assign_des']) . "</td>
                            <td>" . htmlspecialchars($assignment['Course_name']) . "</td>
                            <td>" . htmlspecialchars($assignment['Sub_name']) . "</td>
                            <td>" . htmlspecialchars($assignment['Fac_name']) . "</td>
                            <td>" . htmlspecialchars($assignment['Assign_date']) . "</td>
                            <td>" . htmlspecialchars($assignment['Assign_due']) . "</td>
                            <td>
                                <form method='POST' action='' style='display:inline-block;'>
                                    <input type='hidden' name='assign_id' value='" . htmlspecialchars($assignment['Assign_id']) . "'>
                                    <input type='text' name='title' value='" . htmlspecialchars($assignment['Assign_Title']) . "' required>
                                    <input type='text' name='description' value='" . htmlspecialchars($assignment['Assign_des']) . "' required>
                                    <select name='course_id' required>";
                                    // Fetch courses for dropdown
                                    $courses_query = "SELECT * FROM Courses";
                                    $courses_result = $conn->query($courses_query);
                                    while ($course = $courses_result->fetch_assoc()) {
                                        echo "<option value='" . htmlspecialchars($course['Course_id']) . "' " . ($assignment['Course_id'] == $course['Course_id'] ? 'selected' : '') . ">" . htmlspecialchars($course['Course_name']) . "</option>";
                                    }
                                    echo "</select>
                                    <select name='subject_id' required onchange='updateFaculty(this.value)'>";
                                    // Fetch subjects for dropdown
                                    $subjects_query = "SELECT * FROM Subjects";
                                    $subjects_result = $conn->query($subjects_query);
                                    while ($subject = $subjects_result->fetch_assoc()) {
                                        echo "<option value='" . htmlspecialchars($subject['Sub_id']) . "' " . ($assignment['Sub_id'] == $subject['Sub_id'] ? 'selected' : '') . ">" . htmlspecialchars($subject['Sub_name']) . "</option>";
                                    }
                                    echo "</select>
                                    <select name='fac_id' required>
                                        <option value=''>Select Faculty</option>";
                                        // Fetch faculty for dropdown
                                        $faculty_query = "SELECT * FROM Faculty";
                                        $faculty_result = $conn->query($faculty_query);
                                        while ($faculty = $faculty_result->fetch_assoc()) {
                                            echo "<option value='" . htmlspecialchars($faculty['Fac_id']) . "' " . ($assignment['Fac_id'] == $faculty['Fac_id'] ? 'selected' : '') . ">" . htmlspecialchars($faculty['Fac_name']) . "</option>";
                                        }
                                    echo "</select>
                                    <input type='date' name='assign_date' value='" . htmlspecialchars($assignment['Assign_date']) . "' required>
                                    <input type='date' name='due_date' value='" . htmlspecialchars($assignment['Assign_due']) . "' required>
                                    <button type='submit' name='edit_assignment'>Update</button>
                                </form>
                                <form method='POST' action='' style='display:inline-block;'>
                                    <input type='hidden' name='assign_id' value='" . htmlspecialchars($assignment['Assign_id']) . "'>
                                    <button type='submit' name='delete_assignment'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No assignments found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

