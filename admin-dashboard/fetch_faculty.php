<?php
include 'config.php';

if (isset($_GET['subject_id'])) {
    $subject_id = $_GET['subject_id'];
    
    $faculty_query = "SELECT * FROM Faculty WHERE Fac_id IN (SELECT Fac_id FROM Subjects WHERE Sub_id = ?)";
    $stmt = $conn->prepare($faculty_query);
    $stmt->bind_param("i", $subject_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $faculty = [];
    while ($row = $result->fetch_assoc()) {
        $faculty[] = $row;
    }

    echo json_encode($faculty);
}
?>
