<?php
include 'db.php';

// IMPROVED: Use prepared statement
$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="card header">
            <h2>🛍️ Products</h2>
        </div>

        <div class="card">
            <ul>
            <?php while ($row = $result->fetch_assoc()): ?>
                <li>
                    <a href="product.php?id=<?= htmlspecialchars($row['id']) ?>">
                        <?= htmlspecialchars($row['name']) ?> - $<?= htmlspecialchars($row['price']) ?>
                    </a>
                </li>
            <?php endwhile; ?>
            </ul>
            
            <div style="text-align: center; margin-top: 20px;">
                <a href="index.php">← Back to Home</a>
            </div>
        </div>
    </div>
</body>
</html>

