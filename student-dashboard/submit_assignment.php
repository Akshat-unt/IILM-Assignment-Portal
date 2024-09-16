<?php
ob_start();
include 'student_session_check.php'; // Check if the session is valid
include 'config.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $assign_id = $_POST['assign_id'];
    $file = $_FILES['submission_file'];

    // Check if file was uploaded without errors
    if ($file['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $file['tmp_name'];
        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileType = $file['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = './uploads/';
        $dest_path = $uploadFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $stmt = $conn->prepare("INSERT INTO Submissions (Assign_id, Stu_id, Submission_file) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $assign_id, $_SESSION['user']['Stu_id'], $dest_path);
            if ($stmt->execute()) {
                echo "<script>alert('Assignment submitted successfully!');</script>";
                header("Location: student_dashboard.php?page=submissions");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Error moving the uploaded file.";
        }
    } else {
        echo "Error uploading the file.";
    }
}

// Fetch assignment details
$assign_id = isset($_GET['assign_id']) ? intval($_GET['assign_id']) : 0;
$sql = "SELECT Assign_Title FROM Assignments WHERE Assign_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $assign_id);
$stmt->execute();
$assign = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Assignment</title>
    <link rel="stylesheet" href="student_dashboard_style.css">
    <style>
        .container2 {
            padding: 20px;
        }
        form {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        form, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        table {
            width: auto; /* Make table width fit its content */
            max-width: 600px; /* Optional: Limit maximum width */
            margin: 0 auto; /* Center the table */
            border-collapse: collapse;
        }
        th {
            background-color: #f2f2f2;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container2">
        <h2>Submit Assignment</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <table>
                <tr>
                    <th>Assignment Title</th>
                    <td><?php echo htmlspecialchars($assign['Assign_Title']); ?></td>
                </tr>
                <tr>
                    <th>Select File</th>
                    <td><input type="file" name="submission_file" id="submission_file" required></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <input type="hidden" name="assign_id" value="<?php echo htmlspecialchars($assign_id); ?>">
                        <button type="submit">Submit Assignment</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>

<?php
ob_end_flush(); // End output buffering
?>