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
    $fac_name = $_POST['fac_name'];
    $fac_email = $_POST['fac_email'];
    $fac_password = $_POST['fac_password'];
    $fac_subject = $_POST['fac_subject'];

    // Validate email (ends with @iilm.edu)
    if (!preg_match("/@iilm\.edu$/", $fac_email)) {
        echo "<script>alert('Use your official IILM Email!');</script>";
    } else {
        // Check if email already exists
        $check_email_query = "SELECT Fac_email FROM Faculty WHERE Fac_email = ?";
        $stmt = $conn->prepare($check_email_query);
        $stmt->bind_param("s", $fac_email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>alert('This email is already registered! Please contact support if this is an error.');</script>";
        } else {
            // Check password strength
            if (!isStrongPassword($fac_password)) {
                echo "<script>alert('Password must be at least 10 characters long, contain an uppercase letter, a lowercase letter, a digit, and a special character!');</script>";
            } else {
                // Hash the password
                $hashed_password = password_hash($fac_password, PASSWORD_DEFAULT);

                // Insert data into the database
                $sql = "INSERT INTO Faculty (Fac_name, Fac_email, Fac_password, Fac_subjects) 
                        VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $fac_name, $fac_email, $hashed_password, $fac_subject);

                if ($stmt->execute()) {
                    // Send registration confirmation email
                    if (sendRegistrationEmail($fac_email, $fac_name)) {
                        echo "<script>alert('Faculty member registered successfully! A confirmation email has been sent.');</script>";
                    } else {
                        echo "<script>alert('Faculty member registered successfully, but email failed to send!');</script>";
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
    <title>Faculty Registration</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="logo.png">

    <script>
        function validateForm() {
            var email = document.getElementById('fac_email').value;
            var password = document.getElementById('fac_password').value;
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
            <h1>Faculty Registration</h1>
        </header>

        <section id="registration-section" class="centered-section">
            <h2>Register as Faculty</h2>
            <form action="" method="POST" onsubmit="return validateForm()">
                <label for="fac_name">Name:</label><br>
                <input type="text" id="fac_name" name="fac_name" placeholder="Enter your name" required><br><br>

                <label for="fac_email">Email:</label><br>
                <input type="email" id="fac_email" name="fac_email" placeholder="Enter your email" required><br><br>

                <label for="fac_password">Password:</label><br>
                <input type="password" id="fac_password" name="fac_password" placeholder="Enter a password" required><br><br>

                <label for="fac_subject">Select Subject:</label><br>
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
                            echo "<option value='" . $row['Sub_id'] . "'>" . $row['Course_name'] . " - " . $row['Sub_name'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No subjects available</option>";
                    }
                    ?>
                </select><br><br>

                <button type="submit">Register</button>
            </form>
        </section>

        <footer>
            <p>Designed with ❤️ by <span class="devsynergy">Team SS Animations</span></p>
        </footer>
    </div>
</body>
</html>
