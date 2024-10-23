<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chess Store - Contact</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <h1>Contact Us</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="contact.php">Contact</a>
    </nav>
</header>

<main>
    <h2>Get in Touch</h2>
    <form action="contact.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea><br>

        <input type="submit" value="Send Message">
    </form>
</main>

<footer>
    <p>&copy; 2024 Chess Store</p>
</footer>
</body>
</html>
