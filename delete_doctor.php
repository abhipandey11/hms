<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Patients - Hospital Management System</title>
    <link rel="stylesheet" href="l_style.css">
</head>
<body>
    <div class="doctors-container">
        <h2>Delete doctors</h2>
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
                    <th>Action</th>
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

                // Check if form is submitted for deletion
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST["delete_doctor"])) {
                        $doctor_id = $_POST["delete_doctor"];
                        // Prepare delete statement
                        $delete_sql = "DELETE FROM doctors WHERE Doctor_Id = '$doctor_id'";
                        // Attempt to execute the statement
                        if (mysqli_query($conn, $delete_sql)) {
                            echo "<script>alert('Doctor with ID $doctor_id has been deleted successfully.');</script>";
                            // Refresh the page after deletion
                            echo "<meta http-equiv='refresh' content='0'>";
                        } else {
                            echo "Error deleting doctor: " . mysqli_error($conn);
                        }
                    }
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
                        echo "<td><form method='post' onsubmit='return confirm(\"Are you sure you want to delete this doctor?\")'><input type='hidden' name='delete_doctor' value='" . $row["Doctor_Id"] . "'><input type='submit' value='Delete'></form></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No doctorss found.</td></tr>";
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
