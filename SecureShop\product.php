<?php
include 'db.php';

if (!isset($_GET['id'])) {
    die("Product ID not specified.");
}

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM products WHERE id = $id");

if ($result->num_rows !== 1) {
    die("Product not found.");
}

$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head><title><?= $product['name'] ?> - SecureShop</title></head>
<body>
<h2><?= $product['name'] ?></h2>
<p><?= $product['description'] ?></p>
<p>Price: $<?= $product['price'] ?></p>
<a href="products.php">Back to Products</a>
</body>
</html>