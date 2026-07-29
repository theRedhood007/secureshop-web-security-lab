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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - SecureShop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="card header">
            <h2>⚙️ Admin Panel</h2>
        </div>

        <div class="card">
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
            
            <div style="text-align: center; margin-top: 20px;">
                <a href="index.php">← Back to Home</a>
            </div>
        </div>
    </div>
</body>
</html>
