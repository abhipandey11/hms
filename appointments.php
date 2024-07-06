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
    <title>Appointments - Hospital Management System</title>
    <link rel="stylesheet" href="l_style.css">
    
</head>
<body>
    <div class="appointments-container">
        <h2>Appointments</h2>
        <ul>
            <li><a href="create_appointments.php">Create Appointments</a></li>
            <li><a href="delete_appointments.php">Delete Appointments</a></li>
            <li><a href="show_appointments.php">Show Appointments</a></li>

        </ul>
        <a href="menu.php">Back to Menu</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>
