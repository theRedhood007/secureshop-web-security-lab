<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // IMPROVED: Input validation and sanitization
    if (empty($username) || empty($password)) {
        $error = "Username and password are required";
    } elseif (strlen($username) < 3 || strlen($username) > 50) {
        $error = "Username must be between 3 and 50 characters";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $error = "Username can only contain letters, numbers, and underscores";
    } else {
        // IMPROVED: Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO users (username, password, is_admin) VALUES (?, ?, 0)");
        $stmt->bind_param("ss", $username, $password);
        
        if ($stmt->execute()) {
            echo "Registration successful. <a href='login.php'>Login</a>";
            exit();
        } else {
            // IMPROVED: Don't expose database errors
            $error = "Registration failed. Username might already exist.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
<h2>Register</h2>
<form method="POST">
    Username: <input name="username" maxlength="50"><br>
    Password: <input name="password" type="password" minlength="6"><br>
    <input type="submit" value="Register">
</form>
<?php if (!empty($error)) echo "<p>" . htmlspecialchars($error) . "</p>"; ?>
</body>
</html>
