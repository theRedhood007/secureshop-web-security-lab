<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username']) || $_SESSION['is_admin'] != 1) {
    die("Access denied. Admins only.");
}

// IMPROVED: Use prepared statement
$stmt = $conn->prepare("SELECT id, username, is_admin FROM users");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head><title>Admin Panel - SecureShop</title></head>
<body>
<h2>Admin Panel</h2>
<table border="1">
    <tr><th>ID</th><th>Username</th><th>Is Admin</th></tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= $row['is_admin'] ? "Yes" : "No" ?></td>
        </tr>
    <?php endwhile; ?>
</table>
<a href="index.php">Back to Home</a>
</body>
</html>
