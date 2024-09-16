<?php
session_start();
include 'config.php';

// Check if user is logged in as an admin
include 'admin_session_check.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $admin_id = $_SESSION['user']['Admin_id']; // Assuming 'Admin_id' is the primary key for admins

    // Fetch current password from the database
    $sql = "SELECT Admin_password FROM Admins WHERE Admin_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // Verify current password
    if (password_verify($current_password, $admin['Admin_password'])) {
        if ($new_password === $confirm_password) {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password in the database
            $update_sql = "UPDATE Admins SET Admin_password = ? WHERE Admin_id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("si", $hashed_password, $admin_id);
            
            if ($update_stmt->execute()) {
                $message = "Password updated successfully!";
            } else {
                $message = "Error updating password: " . $conn->error;
            }
        } else {
            $message = "New passwords do not match.";
        }
    } else {
        $message = "Current password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .form-container {
            max-width: 600px;
            margin: 0;
            padding: 20px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .main-content {
            display: flex;
            justify-content: flex-start; /* Aligns content to the left */
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="form-container">
            <h2>Change Password</h2>
            <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
            <form method="POST" action="">
                <table>
                    <tr>
                        <th colspan="2">Change Password</th>
                    </tr>
                    <tr>
                        <td><label for="current_password">Current Password:</label></td>
                        <td><input type="password" name="current_password" id="current_password" required></td>
                    </tr>
                    <tr>
                        <td><label for="new_password">New Password:</label></td>
                        <td><input type="password" name="new_password" id="new_password" required></td>
                    </tr>
                    <tr>
                        <td><label for="confirm_password">Confirm New Password:</label></td>
                        <td><input type="password" name="confirm_password" id="confirm_password" required></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit">Change Password</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>
