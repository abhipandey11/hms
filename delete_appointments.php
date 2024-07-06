<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Appointments - Hospital Management System</title>
    <link rel="stylesheet" href="l_style.css">
</head>
<body>
    <div class="appointments-container">
        <h2>Delete Appointments</h2>
        <hr>
        <h3>Current Appointments:</h3>
        <table>
            <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>Patient ID</th>
                    <th>Doctor ID</th>
                    <th>Date</th>
                    <th>Time From</th>
                    <th>Time To</th>
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
                    if (isset($_POST["delete_appointment"])) {
                        $appointment_id = $_POST["delete_appointment"];
                        // Prepare delete statement
                        $delete_sql = "DELETE FROM appointments WHERE appointment_id = '$appointment_id'";
                        // Attempt to execute the statement
                        if (mysqli_query($conn, $delete_sql)) {
                            echo "<script>alert('Appointment with ID $appointment_id has been deleted successfully.');</script>";
                            // Refresh the page after deletion
                            echo "<meta http-equiv='refresh' content='0'>";
                        } else {
                            echo "Error deleting appointment: " . mysqli_error($conn);
                        }
                    }
                }

                // Retrieve appointment details from the database
                $sql = "SELECT * FROM appointments";
                $result = $conn->query($sql);

                // Display appointment details
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Output each appointment's details in a table row
                        echo "<tr>";
                        echo "<td>" . $row["Appointment_Id"] . "</td>";
                        echo "<td>" . $row["Patient_Id"] . "</td>";
                        echo "<td>" . $row["Doctor_Id"] . "</td>";
                        echo "<td>" . $row["Date"] . "</td>";
                        echo "<td>" . $row["Time_from"] . "</td>";
                        echo "<td>" . $row["Time_to"] . "</td>";
                        echo "<td><form method='post' onsubmit='return confirm(\"Are you sure you want to delete this appointment?\")'><input type='hidden' name='delete_appointment' value='" . $row["Appointment_Id"] . "'><input type='submit' value='Delete'></form></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No appointments found.</td></tr>";
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
