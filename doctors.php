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
    <title>Patients - Hospital Management System</title>
    <link rel="stylesheet" href="l_style.css">
    
</head>
<body>
    <div class="doctors-container">
        <h2>Patients</h2>
        <ul>
            <li><a href="add_doctor.php">Add doctor/staff</a></li>
            <li><a href="search_doctor.php">Search doctor/staff</a></li>
            <li><a href="update_doctor.php">Update doctor/staff</a></li>
            <li><a href="delete_doctor.php">Delete doctor/staff</a></li>
            <li><a href="show_doctor.php">Show doctor/staff</a></li>

        </ul>
        <a href="menu.php">Back to Menu</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>
