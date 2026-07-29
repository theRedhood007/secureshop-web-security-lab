<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ⚠️ VULNERABLE: SQL injection via direct concatenation
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $_SESSION['username'] = $username;
        $user = $result->fetch_assoc();
        $_SESSION['is_admin'] = $user['is_admin'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
<h2>Login</h2>
<form method="POST">
    Username: <input name="username"><br>
    Password: <input name="password" type="password"><br>
    <input type="submit" value="Login">
</form>
<?php if (!empty($error)) echo "<p>$error</p>"; ?>
</body>
</html>