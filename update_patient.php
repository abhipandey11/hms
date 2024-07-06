<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Patients - Hospital Management System</title>
    <link rel="stylesheet" href="l_style.css">
</head>
<body>
    <div class="patients-container">
        <h2>Update Patients</h2>
        <form method="GET" action="update_patient.php">
            <select name="search_attribute">
                <option value="Patient_Id">Patient ID</option>
                <option value="Name">Name</option>
            </select>
            <input type="text" name="search_value" placeholder="Enter Search Value">
            <input type="submit" value="Search">
        </form>
        <hr>
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

        // Initialize search conditions
        $search_attribute = "";
        $search_value = "";

        // Check if search is performed
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search_attribute"]) && isset($_GET["search_value"])) {
            $search_attribute = $_GET["search_attribute"];
            $search_value = $_GET["search_value"];

            // Prepare the search query
            $sql = "SELECT * FROM patients WHERE $search_attribute LIKE '%" . mysqli_real_escape_string($conn, $search_value) . "%'";
            $result = $conn->query($sql);

            // Display search results
            if ($result->num_rows > 0) {
                echo "<h3>Search Results:</h3>";
                echo "<table>";
                echo "<thead><tr><th>ID</th><th>Name</th><th>Age</th><th>Gender</th><th>Contact</th><th>Address</th><th>Action</th></tr></thead>";
                echo "<tbody>";
                while ($row = $result->fetch_assoc()) {
                    // Output each patient's details in a table row with an update link
                    echo "<tr>";
                    echo "<td>" . $row["Patient_Id"] . "</td>";
                    echo "<td>" . $row["Name"] . "</td>";
                    echo "<td>" . $row["Age"] . "</td>";
                    echo "<td>" . $row["Gender"] . "</td>";
                    echo "<td>" . $row["Contact"] . "</td>";
                    echo "<td>" . $row["Address"] . "</td>";
                    echo "<td><a href='update_patient_details.php?id=" . $row["Patient_Id"] . "'>Update</a></td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "No patients found.";
            }
        }
        ?>
        <a href="menu.php">Back to Menu</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>
