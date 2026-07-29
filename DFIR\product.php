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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?> - SecureShop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="card header">
            <h2><?= htmlspecialchars($product['name']) ?></h2>
        </div>

        <div class="card">
            <div class="product-card">
                <h3><?= htmlspecialchars($product['name']) ?></h3>
                <p><?= htmlspecialchars($product['description']) ?></p>
                <p class="price">Price: $<?= htmlspecialchars($product['price']) ?></p>
            </div>
            
            <div style="text-align: center; margin-top: 20px;">
                <a href="products.php">← Back to Products</a>
            </div>
        </div>
    </div>
</body>
</html>

