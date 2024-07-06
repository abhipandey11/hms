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

// Initialize variables
$doctor_id = ""; // Initialize to avoid undefined variable error
$name = $age = $gender = $department = $contact = "";

// Check if Doctor ID is provided in the URL
if (isset($_GET["id"])) {
    $doctor_id = $_GET["id"];

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate and sanitize inputs
        $name = mysqli_real_escape_string($conn, $_POST["name"]);
        $age = intval($_POST["age"]);
        $gender = mysqli_real_escape_string($conn, $_POST["gender"]);
        $department = mysqli_real_escape_string($conn, $_POST["department"]);
        $contact = mysqli_real_escape_string($conn, $_POST["contact"]);

        // Prepare update statement
        $update_sql = "UPDATE doctors SET Name='$name', Age=$age, Gender='$gender', Department='$department', Contact='$contact' WHERE Doctor_Id=$doctor_id";

        // Attempt to execute the statement
        if ($conn->query($update_sql) === TRUE) {
            echo "Doctor/staff details updated successfully.";
        } else {
            echo "Error updating doctor/staff details: " . $conn->error;
        }
    }

    // Retrieve doctor details
    $select_sql = "SELECT * FROM doctors WHERE Doctor_Id=$doctor_id";
    $result = $conn->query($select_sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row["Name"];
        $age = $row["Age"];
        $gender = $row["Gender"];
        $department = $row["Department"]; // Corrected variable name
        $contact = $row["Contact"];
    } else {
        echo "Doctor/staff not found.";
    }
} else {
    echo "Doctor ID not provided.";
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update doctor Details - Hospital Management System</title>
    <link rel="stylesheet" href="l_style.css">
</head>
<body>
    <div class="doctors-container">
        <h2>Update Details</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $doctor_id; ?>">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>"><br>
            <label for="age">Age:</label><br>
            <input type="text" id="age" name="age" value="<?php echo $age; ?>"><br>
            <label for="gender">Gender:</label><br>
            <select id="gender" name="gender">
                <option value="Male" <?php if ($gender === "Male") echo "selected"; ?>>Male</option>
                <option value="Female" <?php if ($gender === "Female") echo "selected"; ?>>Female</option>
                <option value="Other" <?php if ($gender === "Other") echo "selected"; ?>>Other</option>
            </select><br>
            <label for="department">Department:</label><br>
            <input type="text" id="department" name="department" value="<?php echo $department; ?>"><br>
            <label for="contact">Contact:</label><br>
            <input type="text" id="contact" name="contact" value="<?php echo $contact; ?>"><br>

            <input type="submit" value="Update">
        </form>
        <a href="update_doctor.php">Back to Search</a>
    </div>
</body>
</html>
