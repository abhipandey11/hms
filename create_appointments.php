<?php
session_start();

if (!isset($_SESSION["username"])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "root";
$database = "hms";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define variables and initialize with empty values
$appointment_id = $date = "";

// Define error variables and initialize with empty values
$appointment_id_err = "";

// Function to validate numbers
function validateNumbers($input) {
    return is_numeric($input);
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Appointment ID
    if (empty(trim($_POST["appointment_id"])) || !validateNumbers($_POST["appointment_id"]) || $_POST["appointment_id"] < 0) {
        $appointment_id_err = "Please enter a valid Appointment ID.";
    } else {
        $appointment_id = trim($_POST["appointment_id"]);
    }

    // If no validation errors, proceed with inserting into database
    if (empty($appointment_id_err)) {
        $patient_id = $_POST["patient_id"];
        $doctor_id = $_POST["doctor_id"];
        $date = $_POST["date"];
        $time_from = $_POST["time_from"];
        $time_to = $_POST["time_to"];

        // Check if appointment ID is negative
        if ($appointment_id < 0) {
            $appointment_id_err = "Appointment ID cannot be negative.";
        } else {
            // Insert the appointment into the database
            $sql = "INSERT INTO appointments (appointment_id, patient_id, doctor_id, date, time_from, time_to) VALUES ('$appointment_id', '$patient_id', '$doctor_id', '$date', '$time_from', '$time_to')";

            if ($conn->query($sql) === TRUE) {
                // Redirect to another page to display receipt
                header("Location: receipt.php?appointment_id=$appointment_id&patient_id=$patient_id&doctor_id=$doctor_id&date=$date&time_from=$time_from&time_to=$time_to");
            } else {
                echo "Error creating appointment: " . $conn->error;
            }
        }
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Appointment - Hospital Management System</title>
    <link rel="stylesheet" href="l_style.css">
    <style>
    .submit-btn {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        /* Button hover effect */
        .submit-btn:hover {
            background-color: #45a049; /* Darker green */
        }
    </style>
</head>
<body>
    <div class="appointments-container">
        <h2>Create Appointment</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <label for="appointment_id">Appointment ID:</label><br>
            <input type="number" id="appointment_id" name="appointment_id" required><br>
            <span class="error"><?php echo $appointment_id_err; ?></span><br>
            <label for="patient_id">Patient ID:</label><br>
            <select id="patient_id" name="patient_id" required>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "root";
                $database = "hms";

                $conn = new mysqli($servername, $username, $password, $database);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT Patient_Id FROM patients";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['Patient_Id'] . "'>" . $row['Patient_Id'] . "</option>";
                    }
                }
                ?>
            </select><br>
            <label for="doctor_id">Doctor ID:</label><br>
            <select id="doctor_id" name="doctor_id" required>
                <?php
                $sql = "SELECT Doctor_Id FROM doctors";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['Doctor_Id'] . "'>" . $row['Doctor_Id'] . "</option>";
                    }
                }
                ?>
            </select><br>
            <label for="date">Date:</label><br>
            <input type="date" id="date" name="date" required><br>
            <label for="time_from">Time From:</label><br>
            <input type="time" id="time_from" name="time_from" required><br>
            <label for="time_to">Time To:</label><br>
            <input type="time" id="time_to" name="time_to" required><br>
            <input type="submit" value="Create Appointment" class="submit-btn">
        </form>
    </div>
</body>
</html>