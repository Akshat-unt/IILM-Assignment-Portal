<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Submitted Assignments</title>
  <link rel="stylesheet" href="submitted-assignments.css">
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="sidebar-header">
      <img src="download.png" alt="IILM Logo" class="sidebar-logo">
    </div>
    <img src="images.jpeg" alt="Student Photo" class="student-photo">
    <a href="student-dashboard.html">Home</a>
    <a href="#" id="change-info">Change Information</a>
    <a href="../sidebar/raise-query.html">Go to Raise Query Form</a>
    <a href="submitted-assignments.html">See Submitted Assignments</a>
  </div>

  <!-- Main Container -->
  <div class="container">
    <header>
      <h1>Submitted Assignments</h1>
    </header>

    <section id="submitted-assignments-section">
      <table>
        <thead>
          <tr>
            <th>Subject</th>
            <th>Assignment</th>
            <th>Teacher</th>
            <th>Unit</th>
            <th>Status</th>
            <th>Grade</th>
          </tr>
        </thead>
        <tbody id="submitted-assignments-list">
          <!-- Assignment rows will be dynamically inserted here -->
        </tbody>
      </table>
    </section>
  </div>

  <script src="submitted-assignments.js"></script>
</body>
</html>
 