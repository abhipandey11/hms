<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Doctors - Hospital Management System</title>
    <link rel="stylesheet" href="l_style.css">
    
</head>
<body>
    <div class="patients-container">
        <h2>Show Doctors</h2>
        <hr>
        <h3>Current Doctors:</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Department</th>
                    <th>Contact</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Start session
                session_start();

                // Check if user is logged in
                if (!isset($_SESSION["username"])) {
                    // Redirect to login page
                    header("Location: login.php");
                    exit();
                }

                // Database connection details
                $servername = "localhost";
                $username = "root"; // Your MySQL username
                $password = "root"; // Your MySQL password
                $database = "hms"; // Your database name

                // Create connection
                $conn = new mysqli($servername, $username, $password, $database);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Retrieve patient details from the database
                $sql = "SELECT * FROM doctors";
                $result = $conn->query($sql);

                // Display patient details
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Output each patient's details in a table row
                        echo "<tr>";
                        echo "<td>" . $row["Doctor_Id"] . "</td>";
                        echo "<td>" . $row["Name"] . "</td>";
                        echo "<td>" . $row["Age"] . "</td>";
                        echo "<td>" . $row["Gender"] . "</td>";
                        echo "<td>" . $row["Department"] . "</td>";
                        echo "<td>" . $row["Contact"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No doctors found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="menu.php">Back to Menu</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
