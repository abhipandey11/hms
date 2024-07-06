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

// Define variables and initialize with empty values
$patient_id = $name = $age = $gender = $contact = $address = "";
$patient_id_err = $name_err = $age_err = $gender_err = $contact_err =$address_err="";//validation puprose

// Function to validate alphabets
function validateAlphabets($input) {
    return preg_match("/^[a-zA-Z ]*$/", $input);
}

// Function to validate numbers
function validateNumbers($input) {
    return is_numeric($input);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Patient ID
    if (empty(trim($_POST["patient_id"])) || !validateNumbers($_POST["patient_id"])) {
        $patient_id_err = "Please enter valid Patient ID.";
    } else {
        $patient_id = trim($_POST["patient_id"]);
    }

    // Validate Name
    if (empty(trim($_POST["name"])) || !validateAlphabets($_POST["name"])) {
        $name_err = "Please enter valid name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate Age
    if (empty(trim($_POST["age"])) || !validateNumbers($_POST["age"])) {
        $age_err = "Please enter valid age.";
    } else {
        $age = trim($_POST["age"]);
    }

    // Validate Gender
    if (empty($_POST["gender"])) {
        $gender_err = "Please select gender.";
    } else {
        $gender = $_POST["gender"];
    }

    // Validate Contact
    if (empty(trim($_POST["contact"])) || !validateNumbers($_POST["contact"])) {
        $contact_err = "Please enter valid contact number.";
    } else {
        $contact = trim($_POST["contact"]);
    }

    // Validate Address
    if (empty(trim($_POST["address"]))) {
        $address_err = "Please enter address.";
    } else {
        $address = trim($_POST["address"]);
    }

    // Check input errors before inserting into database
    if (empty($patient_id_err) && empty($name_err) && empty($age_err) && empty($gender_err) && empty($contact_err) && empty($address_err)) {
        // Prepare SQL statement to insert data into the database
        $sql = "INSERT INTO Patients (Patient_Id, Name, Age, Gender, Contact, Address) VALUES ('$patient_id', '$name', '$age', '$gender', '$contact', '$address')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to a success page or back to the menu
            echo "<script>alert('Patient details with ID $patient_id has been inserted successfully.');</script>";
            // Refresh the page after insertion
            echo "<meta http-equiv='refresh' content='0'>";
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient - Hospital Management System</title>
    <link rel="stylesheet" href="l_style.css">
</head>
<body>
    <div class="menu-container">
        <h2>Add Patient</h2>
        <form method="post" action="add_patient.php ">
            <div class="form-group <?php echo (!empty($patient_id_err)) ? 'has-error' : ''; ?>">
                <label for="patient_id">Patient ID:</label><br>
                <input type="text" id="patient_id" name="patient_id" required><br>
                <span class="error"><?php echo $patient_id_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label for="name">Name:</label><br>
                <input type="text" id="name" name="name" required><br>
                <span class="error"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($age_err)) ? 'has-error' : ''; ?>">
                <label for="age">Age:</label><br>
                <input type="number" id="age" name="age" required><br>
                <span class="error"><?php echo $age_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($gender_err)) ? 'has-error' : ''; ?>">
                <label for="gender">Gender:</label><br>
                <select id="gender" name="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select><br>
                <span class="error"><?php echo $gender_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($contact_err)) ? 'has-error' : ''; ?>">
                <label for="contact">Contact:</label><br>
                <input type="text" id="contact" name="contact" required><br>
                <span class="error"><?php echo $contact_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                <label for="address">Address:</label><br>
                <textarea id="address" name="address" required></textarea><br><br>
                <span class="error"><?php echo $address_err; ?></span>
            </div>
            <br>
            <input type="submit" value="Submit">
        </form>
        <a href="menu.php">Back to Menu</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>
