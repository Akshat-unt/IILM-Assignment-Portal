<?php
// Fetch grades for the student
$sql = "SELECT Courses.Course_name, Subjects.Sub_name, Grades.Grade
        FROM Grades
        JOIN Courses ON Grades.Course_id = Courses.Course_id
        JOIN Subjects ON Grades.Subject_id = Subjects.Sub_id
        WHERE Grades.Stu_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user']['Stu_id']);
$stmt->execute();
$result = $stmt->get_result();
?>
<h2>Grades</h2>
<table>
    <thead>
        <tr>
            <th>Course</th>
            <th>Subject</th>
            <th>Grade</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['Course_name']); ?></td>
                <td><?php echo htmlspecialchars($row['Sub_name']); ?></td>
                <td><?php echo htmlspecialchars($row['Grade']); ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
