<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>

<h2>Welcome, Admin <?php echo $_SESSION['name']; ?>!</h2>

<ul>
    <li><a href="users.php">Manage Users</a></li>
    <li><a href="subjects.php">Manage Subjects</a></li>
    <li><a href="schedules.php">Manage Tutor Schedules</a></li>
    <li><a href="bookings.php">Manage Bookings</a></li>
    <li><a href="reviews.php">Manage Reviews</a></li>
    <li><a href="change_admin_password.php">Change Password</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>

</body>
</html>
