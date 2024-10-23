<?php
session_start(); // Start session

$receipt = $_SESSION['receipt'] ?? null;

if (!$receipt) {
    header("Location: index.php"); // Redirect if no receipt is found
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - Chess Store</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <h1>Receipt</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="cart.php">Shopping Cart</a>
        <a href="contact.php">Contact</a>
    </nav>
</header>

<main>
    <h2>Thank you for your purchase!</h2>
    <p>Purchase Date: <?= htmlspecialchars($receipt['purchase_time']) ?></p>
    <p>Total Price: $<?= htmlspecialchars($receipt['total_price']) ?></p>

    <h3>Items Purchased:</h3>
    <ul>
        <?php foreach ($receipt['items'] as $item): ?>
            <li><?= htmlspecialchars($item['name']) ?> - $<?= htmlspecialchars($item['price']) ?></li>
        <?php endforeach; ?>
    </ul>
</main>

<footer>
    <p>&copy; 2024 Chess Store</p>
</footer>
</body>
</html>
