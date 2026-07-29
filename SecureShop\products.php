<?php
include 'db.php';

$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head><title>Products</title></head>
<body>
<h2>Products</h2>
<ul>
<?php while ($row = $result->fetch_assoc()): ?>
    <li>
        <a href="product.php?id=<?= $row['id'] ?>">
            <?= $row['name'] ?> - $<?= $row['price'] ?>
        </a>
    </li>
<?php endwhile; ?>
</ul>
</body>
</html>