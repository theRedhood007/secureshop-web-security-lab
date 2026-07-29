<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ⚠️ No validation/sanitization
    $sql = "INSERT INTO users (username, password, is_admin) VALUES ('$username', '$password', 0)";
    if ($conn->query($sql)) {
        echo "Registration successful. <a href='login.php'>Login</a>";
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
<h2>Register</h2>
<form method="POST">
    Username: <input name="username"><br>
    Password: <input name="password" type="password"><br>
    <input type="submit" value="Register">
</form>
</body>
</html>