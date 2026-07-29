<?php
include 'db.php';

// IMPROVED: Use prepared statement
$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head><title>Products</title></head>
<body>
<h2>Products</h2>
<ul>
<?php while ($row = $result->fetch_assoc()): ?>
    <li>
        <a href="product.php?id=<?= htmlspecialchars($row['id']) ?>">
            <?= htmlspecialchars($row['name']) ?> - $<?= htmlspecialchars($row['price']) ?>
        </a>
    </li>
<?php endwhile; ?>
</ul>
</body>
</html>
