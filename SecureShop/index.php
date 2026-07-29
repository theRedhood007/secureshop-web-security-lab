<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head><title>SecureShop</title></head>
<body>
<h1>Welcome to SecureShop</h1>

<?php if (isset($_SESSION['username'])): ?>
    <p>Hello, <?= $_SESSION['username'] ?>!</p>
    <ul>
        <li><a href="products.php">Browse Products</a></li>
        <?php if ($_SESSION['is_admin'] == 1): ?>
            <li><a href="admin.php">Admin Panel</a></li>
        <?php endif; ?>
        <li><a href="logout.php">Logout</a></li>
    </ul>
<?php else: ?>
    <ul>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
        <li><a href="products.php">Browse Products</a></li>
    </ul>
<?php endif; ?>
</body>
</html>