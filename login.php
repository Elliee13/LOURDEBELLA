<?php
require 'db.php';
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate admin credentials (this is a simple example, for production use hashed passwords)
    if ($username == 'admin' && $password == 'password') {
        session_start();
        $_SESSION['admin_logged_in'] = true;
        header('Location: src/admin/admin.php'); // Redirect to admin page
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<form method="POST" action="login.php">
    <label for="username">Username</label>
    <input type="text" id="username" name="username" required>
    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Login</button>
</form>

<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
