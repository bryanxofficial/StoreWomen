<?php
session_start(); // Start session

// Check if the cart is empty
$cart_empty = !isset($_SESSION['cart']) || empty($_SESSION['cart']);

// Handle deletion of a cart item
if (isset($_POST['delete_item'])) {
    $item_index = $_POST['item_index'];
    // Remove the item from the session cart based on the index
    if (isset($_SESSION['cart'][$item_index])) {
        unset($_SESSION['cart'][$item_index]);
        // Re-index the array to prevent gaps
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

// Handle checkout (this part just simulates a checkout)
if (isset($_POST['checkout'])) {
    // Calculate the total price
    $total_price = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_price += $item['price'];
    }

    // Simulate purchase completion and clear the cart
    $_SESSION['receipt'] = [
        'items' => $_SESSION['cart'],
        'total_price' => $total_price,
        'purchase_time' => date("Y-m-d H:i:s")
    ];
    $_SESSION['cart'] = []; // Clear the cart after purchase

    header("Location: receipt.php"); // Redirect to a receipt page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chess Store - Shopping Cart</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <h1>Your Shopping Cart</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="cart.php">Shopping Cart</a>
        <a href="contact.php">Contact</a>
    </nav>
</header>

<main>
    <h2>Cart Items</h2>

    <?php if ($cart_empty): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Remove</th>
            </tr>
            <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                <tr>
                    <td>
                        <!-- Display the product image from the session -->
                        <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="width: 100px; height: auto;">
                    </td>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td>$<?= htmlspecialchars($item['price']) ?></td>
                    <td>
                        <!-- Add a delete button to remove items -->
                        <form method="post" action="">
                            <input type="hidden" name="item_index" value="<?= $index ?>">
                            <button type="submit" name="delete_item" style="background: none; border: none; color: red; font-size: 20px; cursor: pointer;">&times;</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <form method="post" action="">
            <button type="submit" name="checkout">Proceed to Checkout</button>
        </form>
    <?php endif; ?>
</main>

<footer>
    <p>&copy; 2024 Chess Store</p>
</footer>
</body>
</html>
