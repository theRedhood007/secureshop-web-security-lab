<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'db.php';

// IMPROVED: Rate limiting (basic)
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt'] = time();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // IMPROVED: Basic rate limiting
    if ($_SESSION['login_attempts'] >= 5 && (time() - $_SESSION['last_attempt']) < 300) {
        $error = "Too many login attempts. Please try again in 5 minutes.";
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // IMPROVED: Basic input validation
        if (empty($username) || empty($password)) {
            $error = "Username and password are required";
        } elseif (strlen($username) > 50 || strlen($password) > 100) {
            $error = "Username or password too long";
        } else {
            // ⚠️ STILL VULNERABLE: SQL injection via direct concatenation (KEPT FOR CTF)
            // flag{login_sql_injection_2024}
            $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
            $result = $conn->query($sql);

            if ($result && $result->num_rows === 1) {
                $_SESSION['username'] = $username;
                $user = $result->fetch_assoc();
                $_SESSION['is_admin'] = $user['is_admin'];
                
                // IMPROVED: Session regeneration
                session_regenerate_id(true);
                
                // Reset login attempts
                $_SESSION['login_attempts'] = 0;
                
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['login_attempts']++;
                $_SESSION['last_attempt'] = time();
                $error = "Invalid credentials";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
<h2>Login</h2>
<form method="POST">
    Username: <input name="username" maxlength="50"><br>
    Password: <input name="password" type="password" maxlength="100"><br>
    <input type="submit" value="Login">
</form>
<?php if (!empty($error)) echo "<p>" . htmlspecialchars($error) . "</p>"; ?>
</body>
</html>
