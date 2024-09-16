<?php
// Assuming $conn is the connection to your database and it's already included
include 'config.php'; 
include 'admin_session_check.php';
// Fetch users from Faculty, Students, and Admins tables
$faculty_query = "SELECT * FROM Faculty";
$faculty_result = $conn->query($faculty_query);

$student_query = "SELECT * FROM Students";
$student_result = $conn->query($student_query);

$admin_query = "SELECT * FROM Admins";
$admin_result = $conn->query($admin_query);
?>

<h2>Manage Users</h2>
<a href="admin_dashboard.php?page=add_user" class="add-user-button">Add User</a>

<!-- Faculty Table -->
<h3>Faculty</h3>
<table>
    <thead>
        <tr>
            <th>S.No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $counter = 1; // Serial number for Faculty
        while ($user = $faculty_result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $counter++; ?></td> <!-- Serial Number -->
                <td><?php echo $user['Fac_name']; ?></td>
                <td><?php echo $user['Fac_email']; ?></td>
                <td>Faculty</td>
                <td>
                    <a href="admin_dashboard.php?page=edit_user&id=<?php echo $user['Fac_id']; ?>&role=Faculty">Edit</a> |
                    <a href="delete_user.php?id=<?php echo $user['Fac_id']; ?>&role=Faculty" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Student Table -->
<h3>Students</h3>
<table>
    <thead>
        <tr>
            <th>S.No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $counter = 1; // Reset serial number for Students
        while ($user = $student_result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $counter++; ?></td> <!-- Serial Number -->
                <td><?php echo $user['Stu_name']; ?></td>
                <td><?php echo $user['Stu_email']; ?></td>
                <td>Student</td>
                <td>
                    <a href="admin_dashboard.php?page=edit_user&id=<?php echo $user['Stu_id']; ?>&role=Student">Edit</a> |
                    <a href="delete_user.php?id=<?php echo $user['Stu_id']; ?>&role=Student" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Admin Table -->
<h3>Admins</h3>
<table>
    <thead>
        <tr>
            <th>S.No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $counter = 1; // Reset serial number for Admins
        while ($user = $admin_result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $counter++; ?></td> <!-- Serial Number -->
                <td><?php echo $user['Admin_name']; ?></td>
                <td><?php echo $user['Admin_email']; ?></td>
                <td>Admin</td>
                <td>
                    <a href="admin_dashboard.php?page=edit_user&id=<?php echo $user['Admin_id']; ?>&role=Admin">Edit</a> |
                    <a href="delete_user.php?id=<?php echo $user['Admin_id']; ?>&role=Admin" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
