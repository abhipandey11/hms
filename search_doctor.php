<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Doctors/staff - Hospital Management System</title>
    <link rel="stylesheet" href="l_style.css">
    
</head>
<body>
    <div class="doctors-container">
        <h2>Search Doctors/staff</h2>
        <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <select name="search_attribute">
                <option value="Doctor_Id">Doctor/staff Id</option>
                <option value="Name">Name</option>
                <option value="Age">Age</option>
                <option value="Gender">Gender</option>
                <option value="Department">Department</option>
                <option value="Contact">Contact</option>

            </select>
            <input type="text" name="search_value" placeholder="Enter Search Value">
            <input type="submit" value="Search">
        </form>
        <hr>
        <h3>Search Results:</h3>
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

                // Initialize search conditions
                $search_attribute = "";
                $search_value = "";

                // Check if search is performed
                if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    if (isset($_GET["search_attribute"]) && isset($_GET["search_value"])) {
                        $search_attribute = $_GET["search_attribute"];
                        $search_value = $_GET["search_value"];

                        // Prepare the search query
                        $sql = "SELECT * FROM doctors WHERE $search_attribute LIKE '%" . mysqli_real_escape_string($conn, $search_value) . "%'";
                        $result = $conn->query($sql);

                        // Display search results
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
                    }
                }
                ?>
            </tbody>
        </table>
        <a href="menu.php">Back to Menu</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>
