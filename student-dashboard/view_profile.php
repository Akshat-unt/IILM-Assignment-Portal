<?php
// Fetch student profile information from the session
$user = $_SESSION['user'];
?>
<h2>Profile</h2>
<p><strong>Name:</strong> <?php echo htmlspecialchars($user['Stu_name']); ?></p>
<p><strong>Email:</strong> <?php echo htmlspecialchars($user['Stu_email']); ?></p>
<p><strong>Course:</strong> <?php echo htmlspecialchars($user['Stu_course']); ?></p>
