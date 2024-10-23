<?php
session_start(); // Start session
include_once 'db.php'; // Include the database connection

// Connect to the database
$conn = connectToDatabase();

// Check if the connection is successful
if (!$conn) {
    die("Database connection failed: " . $conn->connect_error);
}

// Message to show after adding an item to the cart
$cart_message = "";

// Add product to cart without redirecting to cart.php
if (isset($_POST['add_to_cart'])) {
    $watch_id = $_POST['watch_id'];
    $watch_name = $_POST['watch_name'];
    $watch_price = $_POST['watch_price'];
    $watch_stock = $_POST['watch_stock'];
    $watch_image_url = $_POST['image_url']; // Get image URL

    // Ensure watch_stock is a valid number before updating stock
    if ($watch_stock > 0) {
        // Reduce stock by 1 and update the database
        $new_stock = $watch_stock - 1;
        $stmt = $conn->prepare("UPDATE watches SET stock = ? WHERE id = ?");
        $stmt->bind_param('ii', $new_stock, $watch_id);

        if ($stmt->execute()) {
            // Add to session cart, including image_url
            $_SESSION['cart'][] = [
                'id' => $watch_id,
                'name' => $watch_name,
                'price' => $watch_price,
                'image_url' => $watch_image_url
            ];

            // Show a message that the product was added to the cart
            $cart_message = "Watch '{$watch_name}' has been added to your cart!";
        } else {
            echo "Failed to update stock.";
        }
        $stmt->close();
    } else {
        $cart_message = "Sorry, this watch is out of stock.";
    }
}

// Fetch watches from the database
$sql = "SELECT * FROM watches";
$result = $conn->query($sql);

?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Women's Watch Store - Products</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
    <header>
        <h1>Our Women's Watch Collection</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="cart.php">Shopping Cart</a>
            <a href="promotions.php">Promotions</a>
            <a href="contact.php">Contact</a>
        </nav>
    </header>

    <main>
        <!-- Add a "Proceed to Checkout" button at the top -->
        <div class="checkout-button">
            <a href="cart.php" style="background-color: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Proceed to Checkout</a>
        </div>

        <!-- Show message when a product is added to the cart -->
        <?php if (!empty($cart_message)): ?>
            <p style="color: green;"><?= htmlspecialchars($cart_message) ?></p>
        <?php endif; ?>

        <h2>Available Watches</h2>
        <div class="product-list">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="product">
                        <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" style="width: 150px; height: auto;">
                        <h3><?= htmlspecialchars($row['name']) ?></h3>
                        <p><?= htmlspecialchars($row['description']) ?></p>
                        <p>Price: $<?= htmlspecialchars($row['price']) ?></p>
                        <p>Stock: <?= htmlspecialchars($row['stock']) ?></p>

                        <form method="post" action="products.php">
                            <input type="hidden" name="watch_id" value="<?= htmlspecialchars($row['id']) ?>">
                            <input type="hidden" name="watch_name" value="<?= htmlspecialchars($row['name']) ?>">
                            <input type="hidden" name="watch_price" value="<?= htmlspecialchars($row['price']) ?>">
                            <input type="hidden" name="watch_stock" value="<?= htmlspecialchars($row['stock']) ?>">
                            <input type="hidden" name="image_url" value="<?= htmlspecialchars($row['image_url']) ?>">

                            <!-- Disable the button if out of stock -->
                            <button type="submit" name="add_to_cart" <?= $row['stock'] <= 0 ? 'disabled' : '' ?> class="cart-button">
                                <?= $row['stock'] > 0 ? 'Add to Cart' : 'Out of Stock' ?>
                            </button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No watches available.</p>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Women's Watch Store</p>
    </footer>
    </body>
    </html>

<?php
$conn->close(); // Close the database connection
