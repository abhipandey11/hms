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
    <div class="patients-container">
        <h2>Patients</h2>
        <ul>
            <li><a href="add_patient.php">Add Patient</a></li>
            <li><a href="search_patient.php">Search Patient</a></li>
            <li><a href="update_patient.php">Update Patient</a></li>
            <li><a href="delete_patient.php">Delete Patient</a></li>
            <li><a href="show_patient.php">Show Patients</a></li>

        </ul>
        <a href="menu.php">Back to Menu</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>
