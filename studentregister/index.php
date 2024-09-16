<?php
session_start();

// Database connection
$host = 'localhost';
$dbUsername = 'eajlbarx_iilmuniversity';
$dbPassword = 'Shivansh@IILM2k24';
$dbName = 'eajlbarx_assignmentiilm';

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Include the email function
include 'email.php';

// Function to check password strength
function isStrongPassword($password) {
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{10,}$/', $password);
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stu_name = $_POST['stu_name'];
    $stu_email = $_POST['stu_email'];
    $stu_password = $_POST['stu_password'];
    $stu_course = $_POST['stu_course'];

    // Validate email (ends with @iilm.edu)
    if (!preg_match("/@iilm\.edu$/", $stu_email)) {
        echo "<script>alert('Use your official IILM Email!');</script>";
    } else {
        // Check if email already exists
        $check_email_query = "SELECT Stu_email FROM Students WHERE Stu_email = ?";
        $stmt = $conn->prepare($check_email_query);
        $stmt->bind_param("s", $stu_email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>alert('This email is already registered! Please contact support if this is an error.');</script>";
        } else {
            // Check password strength
            if (!isStrongPassword($stu_password)) {
                echo "<script>alert('Password must be at least 10 characters long, contain an uppercase letter, a lowercase letter, a digit, and a special character!');</script>";
            } else {
                // Hash the password
                $hashed_password = password_hash($stu_password, PASSWORD_DEFAULT);

                // Fetch all subjects for the selected course
                $subjects_query = "SELECT Sub_id FROM Subjects WHERE Course_id = ?";
                $stmt = $conn->prepare($subjects_query);
                $stmt->bind_param("i", $stu_course);
                $stmt->execute();
                $result = $stmt->get_result();

                $subject_ids = [];
                while ($row = $result->fetch_assoc()) {
                    $subject_ids[] = $row['Sub_id'];  // Collect all subject IDs for the course
                }
                $stu_subjects_json = json_encode($subject_ids);  // Convert subject IDs to JSON

                // Insert data into the database
                $sql = "INSERT INTO Students (Stu_name, Stu_email, Stu_password, Stu_course, Stu_subjects) 
                        VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssss", $stu_name, $stu_email, $hashed_password, $stu_course, $stu_subjects_json);

                if ($stmt->execute()) {
                    // Send registration confirmation email
                    if (sendRegistrationEmail($stu_email, $stu_name)) {
                        echo "<script>alert('Student registered successfully! A confirmation email has been sent.');</script>";
                    } else {
                        echo "<script>alert('Student registered successfully, but email failed to send!');</script>";
                    }
                } else {
                    echo "<script>alert('Error: " . $stmt->error . "');</script>";
                }
            }
        }
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment Upload Portal</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="logo.png">

    <script>
        function validateForm() {
            var email = document.getElementById('stu_email').value;
            var password = document.getElementById('stu_password').value;
            var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{10,}$/;
            var emailPattern = /@iilm\.edu$/;

            if (!emailPattern.test(email)) {
                alert('Use Your Official IILM Email Address!');
                return false;
            }

            if (!passwordPattern.test(password)) {
                alert('Password must be at least 10 characters long, contain an uppercase letter, a lowercase letter, a digit, and a special character!');
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <header>
            <img src="iilm.png" alt="IILM Logo" class="logo">
            <h1>Assignment Upload Portal</h1>
        </header>

        <section id="registration-section" class="centered-section">
            <h2>Student Registration</h2>
            <form action="" method="POST" onsubmit="return validateForm()">
                <label for="stu_name">Name:</label><br>
                <input type="text" id="stu_name" name="stu_name" placeholder="Enter your name" required><br><br>

                <label for="stu_email">Email:</label><br>
                <input type="email" id="stu_email" name="stu_email" placeholder="Enter your email" required><br><br>

                <label for="stu_password">Password:</label><br>
                <input type="password" id="stu_password" name="stu_password" placeholder="Enter a password" required><br><br>

                <label for="stu_course">Select Course:</label><br>
                <select id="stu_course" name="stu_course" required>
                    <option value="">--Select a Course--</option>
                    <?php
                    // Fetch courses from the database
                    $courses_query = "SELECT Course_id, Course_name FROM Courses";
                    $courses_result = $conn->query($courses_query);
                    if ($courses_result->num_rows > 0) {
                        while ($row = $courses_result->fetch_assoc()) {
                            echo "<option value='" . $row['Course_id'] . "'>" . $row['Course_name'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No courses available</option>";
                    }
                    ?>
                </select><br><br>

                <button type="submit">Register</button>
            </form>
        </section>

        <footer>
            <p>Designed with ❤️ by <span class="devsynergy">Team SS Animations </span></p>
        </footer>
    </div>
</body>
</html>
