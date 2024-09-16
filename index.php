<?php

session_start();



// Database connection

$host = 'localhost';

$dbUsername = 'root';

$dbPassword = '';

$dbName = 'eajlbarx_assignmentiilm';



$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);



// Check connection

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}



// Handle login request

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];

    $password = $_POST['password'];

    $role = $_POST['role'];



    // Initialize response

    $response = ['success' => false, 'message' => 'Invalid credentials'];



    if ($role === 'student') {

        $sql = "SELECT * FROM Students WHERE Stu_email = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();



        if ($result->num_rows > 0) {

            $student = $result->fetch_assoc();

            if (password_verify($password, $student['Stu_password'])) {

                // Create session for student

                $_SESSION['user'] = $student;

                $_SESSION['role'] = 'student';

                $_SESSION['section'] = $student['Stu_course'];



                // Redirect to student view

                header("Location: student-dashboard/student_dashboard.php");

                exit();

            } else {

                $response['message'] = 'Incorrect password';

            }

        } else {

            $response['message'] = 'Email not found';

        }



    } elseif ($role === 'teacher') {

        $sql = "SELECT * FROM Faculty WHERE Fac_email = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();



        if ($result->num_rows > 0) {

            $teacher = $result->fetch_assoc();

            if (password_verify($password, $teacher['Fac_password'])) {

                // Create session for teacher

                $_SESSION['user'] = $teacher;

                $_SESSION['role'] = 'teacher';



                // Redirect to teacher view

                header("Location: student-dashboard/");

                exit();

            } else {

                $response['message'] = 'Incorrect password';

            }

        } else {

            $response['message'] = 'Email not found';

        }



    } elseif ($role === 'admin') {

        // Implement admin login if needed

        // Example: Redirect to admin view

        $_SESSION['role'] = 'admin';

        header("Location: admin-dashboard/admin_dashboard.php");

        exit();

    }



    // If login fails

    echo "<script>alert('{$response['message']}');</script>";

}



$conn->close();

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Assignment Upload Portal</title>

    <link rel="stylesheet" href="style.css">



    <link rel="icon" type="image/png" href="logo.png">

</head>

<body>

    <div class="container">

        <header>

            <img src="iilm.png" alt="IILM Logo" class="logo">

            <h1>Assignment Upload Portal</h1>

        </header>



        <section id="login-section" class="centered-section">

            <h2>Login Panel</h2>

            <form method="POST" action="">

                <label for="email">Email:</label>

                <input type="email" name="email" id="email" placeholder="Enter your registered email address" required>

                <br>

                <label for="password">Password:</label>

                <input type="password" name="password" id="password" placeholder="Enter your password" required>

                <br>

                <label for="role">Select Role:</label>

                <select name="role" id="role">

                    <option value="student">Student</option>

                    <option value="teacher">Teacher</option>

                    <option value="admin">Admin</option>

                </select>

                <br>

                <button type="submit">Login</button>

            </form>

            <hr>

            <p class="support-availability">Haven't registered yet? <a href="studentregister/">Click here to Register</a></p>

            <hr>

            <p class="support-email">For support, email us at <a href="mailto:support@iilm.ssapvtltd.in">support@iilm.ssapvtltd.in</a></p>

            <p class="support-availability">Support available: 9 AM - 5:30 PM, Mon-Sat</p> <!-- Added Support Time -->

        </section>



        <footer>

            <p>Designed with ❤️ by Team SS Animations</p>

        </footer>

    </div>

</body>

</html>

