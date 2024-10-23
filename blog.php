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
    <title>e-Commerce Blog - Professional Development</title>
    <link rel="stylesheet" href="blog.css">
    <script>
        function toggleDescription(id) {
            var desc = document.getElementById('desc-' + id);
            var btn = document.getElementById('btn-' + id);
            var card = document.getElementById('card-' + id); // Get the card element

            // If the description is collapsed, expand it
            if (desc.classList.contains('collapsed')) {
                desc.classList.remove('collapsed');
                btn.textContent = 'Read Less';
                card.classList.add('expanded'); // Expand the card
            } else {
                // Collapse the description
                desc.classList.add('collapsed');
                btn.textContent = 'Read More';
                card.classList.remove('expanded'); // Collapse the card
            }
        }
    </script>
</head>
<body>
<header>
    <div class="header-container">
        <h1>Professional Development in e-Commerce</h1>
    </div>
</header>

<main>
    <h2 class="section-title">Publications, Articles, and Books on e-Commerce</h2>

    <div class="blog-grid">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="blog-card" id="card-<?= htmlspecialchars($row['id']) ?>">
                    <!-- Display the image if available -->
                    <?php if (!empty($row['image_url'])): ?>
                        <div class="blog-image">
                            <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                        </div>
                    <?php endif; ?>

                    <div class="blog-content">
                        <h3 class="blog-title"><?= htmlspecialchars($row['title']) ?></h3>
                        <p class="blog-type"><strong>Type:</strong> <?= ucfirst(htmlspecialchars($row['type'])) ?></p>
                        <!-- Description with collapse functionality -->
                        <div id="desc-<?= htmlspecialchars($row['id']) ?>" class="blog-description collapsed">
                            <p><?= nl2br(htmlspecialchars($row['description'])) ?></p> <!-- Convert \n to <br> -->
                        </div>
                        <button id="btn-<?= htmlspecialchars($row['id']) ?>" class="read-more-btn" onclick="toggleDescription(<?= htmlspecialchars($row['id']) ?>)">Read More</button>
                        <p class="blog-date"><small><em>Posted on: <?= htmlspecialchars($row['date_added']) ?></em></small></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No blog posts available.</p>
        <?php endif; ?>
    </div>
</main>

<footer>
    <div class="footer-container">
        <p>&copy; 2024 e-Commerce Blog. All rights reserved.</p>
    </div>
</footer>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
