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
            echo '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Registration Successful</title>
                <link rel="stylesheet" href="style.css">
            </head>
            <body>
                <div class="container">
                    <div class="card success">
                        <h2>✅ Registration Successful!</h2>
                        <p><a href="login.php">Click here to login</a></p>
                    </div>
                </div>
            </body>
            </html>';
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="card header">
            <h2>📝 Register</h2>
        </div>

        <div class="card">
            <form method="POST">
                Username: <input name="username" maxlength="50"><br>
                Password: <input name="password" type="password" minlength="6"><br>
                <input type="submit" value="Register">
            </form>
            <?php if (!empty($error)) echo "<p>" . htmlspecialchars($error) . "</p>"; ?>
            
            <div style="text-align: center; margin-top: 20px;">
                <p><a href="login.php">Already have an account? Login here</a></p>
                <p><a href="index.php">← Back to Home</a></p>
            </div>
        </div>
    </div>
</body>
</html>
