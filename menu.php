<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System - Menu</title>
    <link rel="stylesheet" href="l_style.css">
    
</head>
<body>
    <div class="menu-container">
        <h2>Welcome, <?php echo $_SESSION["username"]; ?>!</h2>
        <ul>
            <li><a href="patients.php">Manage Patients</a></li>
            <li><a href="doctors.php">Manage Doctors</a></li>
            <li><a href="appointments.php">Manage Appointments</a></li>
        </ul>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>
