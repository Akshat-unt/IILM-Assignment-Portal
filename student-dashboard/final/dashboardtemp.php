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

// Fetch student data
if (isset($_SESSION['user']) && $_SESSION['role'] === 'student') {
    $student = $_SESSION['user'];
    $studentId = $student['Stu_id'];
    $courseId = $student['Stu_course'];

    // Fetch course name
    $sqlCourse = "SELECT Course_name FROM Courses WHERE Course_id = ?";
    $stmtCourse = $conn->prepare($sqlCourse);
    $stmtCourse->bind_param("i", $courseId);
    $stmtCourse->execute();
    $resultCourse = $stmtCourse->get_result();
    $course = $resultCourse->fetch_assoc();

    // Fetch subjects for the student's course
    $sqlSubjects = "SELECT Sub_name FROM Subjects WHERE Course_id = ?";
    $stmtSubjects = $conn->prepare($sqlSubjects);
    $stmtSubjects->bind_param("i", $courseId);
    $stmtSubjects->execute();
    $resultSubjects = $stmtSubjects->get_result();

    // Fetch assignments
    $sqlAssignments = "SELECT Assign_Title, Fac_name, Assign_due FROM Assignments
                        JOIN Faculty ON Assignments.Fac_id = Faculty.Fac_id
                        WHERE Course_id = ?";
    $stmtAssignments = $conn->prepare($sqlAssignments);
    $stmtAssignments->bind_param("i", $courseId);
    $stmtAssignments->execute();
    $resultAssignments = $stmtAssignments->get_result();
} else {
    header('Location: ../');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Student Dashboard</title>
  <link rel="stylesheet" href="dashboard.css">
</head>
<body>
  <!-- Sidebar Section -->
  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <img src="download.png" alt="IILM Logo" class="sidebar-logo">
    </div>
    <img src="avtar.jpg" alt="Student Photo" class="student-photo">
    <a href="#" id="change-info">Change Information</a>
    <a href="../sidebar/raise-query.html">Go to Raise Query Form</a>
    <a href="submitted-assignments.html" id="view-assignments">See Submitted Assignments</a>
    <a href="logout.php" id="view-assignments">Logout</a>
  </div>

  <!-- Main Container -->
  <div class="container" id="container">
    <header>
      <h1>Welcome, <?php echo htmlspecialchars($student['Stu_name']); ?></h1>
      <p>Your Course / Section: <?php echo htmlspecialchars($course['Course_name']); ?></p>
    </header>

    <section id="subjects-section">
      <h2>Select a Subject</h2>
      <ul id="subjects-list">
        <?php while ($subject = $resultSubjects->fetch_assoc()): ?>
          <li><?php echo htmlspecialchars($subject['Sub_name']); ?></li>
        <?php endwhile; ?>
      </ul>
    </section>

    <section id="assignments-section">
      <h2>Your Assignments</h2>
      <table>
        <thead>
          <tr>
            <th>Assignment</th>
            <th>Teacher</th>
            <th>Unit</th>
            <th>Status</th>
            <th>Grade</th>
            <th>Upload Assignment</th>
          </tr>
        </thead>
        <tbody id="assignments-list">
          <?php while ($assignment = $resultAssignments->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($assignment['Assign_Title']); ?></td>
              <td><?php echo htmlspecialchars($assignment['Fac_name']); ?></td>
              <td>Unit Placeholder</td>
              <td>Not Submitted</td>
              <td>Not Graded</td>
              <td><button>Upload</button></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </section>
  </div>
</body>
</html>

<?php
$stmtCourse->close();
$stmtSubjects->close();
$stmtAssignments->close();
$conn->close();
?>
