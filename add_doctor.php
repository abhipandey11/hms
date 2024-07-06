<?php
// Start session
session_start();


if (!isset($_SESSION["username"])) {
    
    header("Location: login.php");
    exit();
}

// Database connection details
$servername = "localhost";
$username = "root"; 
$password = "root";
$database = "hms"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define variables and initialize with empty values
$doctor_id = $name = $age = $gender = $department = $contact = "";
$doctor_id_err = $name_err = $age_err = $department_err = $contact_err =$gender_err= "";

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
    // Validate Doctor/Staff ID
    if (empty(trim($_POST["doctor_id"])) || !validateNumbers($_POST["doctor_id"])) {
        $doctor_id_err = "Please enter valid Doctor/Staff ID.";
    } else {
        $doctor_id = trim($_POST["doctor_id"]);
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

    // Validate Department
    if (empty(trim($_POST["department"]))) {
        $department_err = "Please enter department.";
    } else {
        $department = trim($_POST["department"]);
    }

    // Validate Contact
    if (empty(trim($_POST["contact"])) || !validateNumbers($_POST["contact"])) {
        $contact_err = "Please enter valid contact number.";
    } else {
        $contact = trim($_POST["contact"]);
    }

    // Check input errors before inserting into database
    if (empty($doctor_id_err) && empty($name_err) && empty($age_err) && empty($gender_err) && empty($department_err) && empty($contact_err)) {
        // Prepare SQL statement to insert data into the database
        $sql = "INSERT INTO Doctors (Doctor_Id, Name, Age, Gender, Department, Contact) VALUES ('$doctor_id', '$name', '$age', '$gender', '$department', '$contact')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Doctor/staff details with ID $doctor_id has been inserted successfully.');</script>";
            // Refresh the page
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
    <title>Add Doctor/staff - Hospital Management System</title>
    <link rel="stylesheet" href="l_style.css">
</head>
<body>
    <div class="menu-container">
        <h2>Add Doctor/staff</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group <?php echo (!empty($doctor_id_err)) ? 'has-error' : ''; ?>">
                <label for="doctor_id">Doctor/staff ID:</label><br>
                <input type="text" id="doctor_id" name="doctor_id" required><br>
                <span class="error"><?php echo $doctor_id_err; ?></span>
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
            <div class="form-group <?php echo (!empty($department_err)) ? 'has-error' : ''; ?>">
                <label for="department">Department:</label><br>
                <textarea id="department" name="department" required></textarea><br>
                <span class="error"><?php echo $department_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($contact_err)) ? 'has-error' : ''; ?>">
                <label for="contact">Contact:</label><br>
                <input type="text" id="contact" name="contact" required><br>
                <span class="error"><?php echo $contact_err; ?></span>
            </div>
            <br>
            <input type="submit" value="Submit">
        </form>
        <a href="menu.php">Back to Menu</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>
