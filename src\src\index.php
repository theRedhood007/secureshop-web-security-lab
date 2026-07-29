<?php
session_start();

// IMPROVED: Session timeout (30 minutes)
if (isset($_SESSION['username']) && isset($_SESSION['last_activity'])) {
    if (time() - $_SESSION['last_activity'] > 1800) {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
}
$_SESSION['last_activity'] = time();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureShop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="card header">
            <h1>🛍️ SecureShop</h1>
            <p>Your Premium E-commerce Destination</p>
        </div>

        <div class="card">
            <?php if (isset($_SESSION['username'])): ?>
                <div class="welcome">
                    <p>Hello, <?= htmlspecialchars($_SESSION['username']) ?>! 👋</p>
                </div>
                
                <ul class="nav">
                    <li><a href="products.php">Browse Products</a></li>
                    <?php if ($_SESSION['is_admin'] == 1): ?>
                        <li><a href="admin.php">Admin Panel</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            <?php else: ?>
                <ul class="nav">
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="products.php">Browse Products</a></li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
