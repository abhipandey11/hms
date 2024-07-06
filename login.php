<?php
// Start session
session_start();

// Hardcoded usernames and passwords (replace these with your own)
$credentials = array(
    "user1" => "password1",
    "abhi" => "abhi",
    // Add more users as needed
);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if username exists and password matches
    if (isset($credentials[$username]) && $credentials[$username] == $password) {
        // Set session variable to store logged-in user
        $_SESSION["username"] = $username;

        // Redirect to menu page
        header("Location: menu.php");
        exit();
    } else {
        // Invalid username or password, redirect back to login page with error message
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System - Login</title>
    <link rel="stylesheet" href="l_style.css">
    <style>
        .error-message {
            color: red;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <?php if(isset($error)): ?>
                <span class="error-message"><?php echo $error; ?></span>
            <?php endif; ?>
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
