<?php
session_start();
require('db.php'); // Include your database connection

// Check if the form was submitted and the necessary keys exist in $_POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    // Collect form data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];  // Entered password

    // Fixed salt used during hashing
    $salt = 'my_fixed_salt_value';  // The same salt you used when generating the hash

    // Query the database to find the admin user
    $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Manually hash the entered password using the fixed salt
        $hashed_password = hash('sha256', $password . $salt);

        // Compare the entered password hash with the stored hash
        if ($hashed_password === $user['password']) {
            // Correct password, start a session
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['username'] = $user['username'];
            header("Location: src/admin/admin.php");  // Redirect to the admin panel
            exit();
        } else {
            // Incorrect password
            $error = "Invalid password. Please try again.";
        }
    } else {
        // Username doesn't exist
        $error = "Invalid credentials. Please try again.";
    }

    $conn->close(); // Close the database connection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <script>
        // Function to toggle password visibility
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var toggleIcon = document.getElementById("toggle-icon");
            if (passwordField.type === "password") {
                passwordField.type = "text";  // Change input type to text
                toggleIcon.src = "https://img.icons8.com/ios-filled/50/000000/invisible.png"; // Eye icon
            } else {
                passwordField.type = "password";  // Change input type back to password
                toggleIcon.src = "https://img.icons8.com/ios-filled/50/000000/visible.png"; // Eye icon
            }
        }
    </script>
</head>
<body>

<div class="login-container">
    <img src="src/img/LourdebellaLogo.jpeg" alt="LourdeBella Logo" id="logo" class="login-logo">
    <h2>Admin Login</h2>
    <?php if (isset($error)) { ?>
        <div class="error"><?php echo $error; ?></div>
    <?php } ?>
    <form action="login.php" method="POST" class="login-form">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" class="form-input" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <div class="password-container">
                <input type="password" id="password" name="password" class="form-input" required>
                <img id="toggle-icon" src="https://img.icons8.com/ios-filled/50/000000/visible.png" alt="eye icon" onclick="togglePassword()" style="cursor: pointer;">
            </div>
        </div>
        <button type="submit" class="login-btn">Login</button>
    </form>
</div>

</body>
</html>
