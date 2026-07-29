<?php
include 'db.php';

if (!isset($_GET['id'])) {
    die("Product ID not specified.");
}

$id = $_GET['id'];

// IMPROVED: Basic input validation
if (!is_numeric($id)) {
    die("Invalid product ID format.");
}

// ⚠️ STILL VULNERABLE: SQL injection (KEPT FOR CTF)
// flag{product_sqli_hidden_here}
$result = $conn->query("SELECT * FROM products WHERE id = $id");

if (!$result || $result->num_rows !== 1) {
    die("Product not found.");
}

$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head><title><?= htmlspecialchars($product['name']) ?> - SecureShop</title></head>
<body>
<h2><?= htmlspecialchars($product['name']) ?></h2>
<p><?= htmlspecialchars($product['description']) ?></p>
<p>Price: $<?= htmlspecialchars($product['price']) ?></p>
<a href="products.php">Back to Products</a>
</body>
</html>
