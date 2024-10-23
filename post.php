<?php
session_start();
include_once 'db.php'; // Include your database connection

// Connect to the database
$conn = connectToDatabase();

// Check if the connection is successful
if (!$conn) {
    die("Database connection failed: " . $conn->connect_error);
}

// Fetch all blog posts from the database
$sql = "SELECT * FROM blog_posts ORDER BY date_added DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Commerce Blog - All Posts</title>
    <link rel="stylesheet" href="blog.css">
</head>
<body>
<header>
    <h1>All e-Commerce Blog Posts</h1>
</header>

<main>
    <h2>Publications, Articles, and Books on e-Commerce</h2>

    <div class="blog-grid">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="blog-card">
                    <!-- Display the image if available -->
                    <?php if (!empty($row['image_url'])): ?>
                        <div class="blog-image">
                            <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                        </div>
                    <?php endif; ?>

                    <div class="blog-content">
                        <h3><?= htmlspecialchars($row['title']) ?></h3>
                        <p><strong>Type:</strong> <?= ucfirst(htmlspecialchars($row['type'])) ?></p>
                        <!-- Full description using nl2br() for paragraph breaks -->
                        <div class="blog-description">
                            <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
                        </div>
                        <p><small><em>Posted on: <?= htmlspecialchars($row['date_added']) ?></em></small></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No blog posts available.</p>
        <?php endif; ?>
    </div>
</main>

<footer>
    <p>&copy; 2024 e-Commerce Blog</p>
</footer>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
