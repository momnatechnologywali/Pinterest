<?php
// index.php - Homepage displaying trending and popular images (latest pins as trending for simplicity)
 
session_start();
include 'db.php';
 
// Fetch latest pins (trending/popular simulation)
$stmt = $pdo->prepare("SELECT p.*, u.username FROM pins p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC LIMIT 50");
$stmt->execute();
$pins = $stmt->fetchAll();
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinterest Clone - Homepage</title>
    <style>
        /* Amazing CSS: Pinterest-like with red accents, masonry grid, shadows, responsive */
        body { font-family: Arial, sans-serif; background-color: #fafafa; margin: 0; padding: 0; color: #333; }
        header { background-color: #E60023; color: white; padding: 10px; text-align: center; position: fixed; width: 100%; z-index: 10; }
        header a { color: white; margin: 0 15px; text-decoration: none; font-weight: bold; }
        .container { padding-top: 60px; max-width: 1200px; margin: 0 auto; }
        .grid { column-count: 4; column-gap: 10px; }
        .pin-card { break-inside: avoid; margin-bottom: 10px; background: white; border-radius: 16px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); overflow: hidden; transition: transform 0.2s; }
        .pin-card:hover { transform: scale(1.02); box-shadow: 0 4px 8px rgba(0,0,0,0.2); }
        .pin-card img { width: 100%; height: auto; display: block; }
        .pin-info { padding: 10px; }
        .pin-info h3 { margin: 0; font-size: 16px; }
        .pin-info p { margin: 5px 0; font-size: 14px; color: #666; }
        .save-btn { background: #E60023; color: white; border: none; padding: 8px; border-radius: 8px; cursor: pointer; }
        @media (max-width: 1024px) { .grid { column-count: 3; } }
        @media (max-width: 768px) { .grid { column-count: 2; } }
        @media (max-width: 480px) { .grid { column-count: 1; } }
    </style>
</head>
<body>
    <header>
        <a href="index.php">Home</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="profile.php">Profile</a>
            <a href="upload_pin.php">Upload Pin</a>
            <a href="create_board.php">Create Board</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="signup.php">Signup</a>
            <a href="login.php">Login</a>
        <?php endif; ?>
        <a href="search.php">Search</a>
    </header>
    <div class="container">
        <h1>Trending Pins</h1>
        <div class="grid">
            <?php foreach ($pins as $pin): ?>
                <div class="pin-card">
                    <img src="<?php echo htmlspecialchars($pin['image_url']); ?>" alt="<?php echo htmlspecialchars($pin['title']); ?>">
                    <div class="pin-info">
                        <h3><?php echo htmlspecialchars($pin['title']); ?></h3>
                        <p><?php echo htmlspecialchars($pin['description']); ?></p>
                        <p>By: <?php echo htmlspecialchars($pin['username']); ?> | Category: <?php echo htmlspecialchars($pin['category']); ?></p>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <button class="save-btn" onclick="saveToBoard(<?php echo $pin['id']; ?>)">Save to Board</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script>
        function saveToBoard(pinId) {
            // JS for redirection to save page
            location.href = 'save_to_board.php?pin_id=' + pinId;
        }
    </script>
</body>
</html>
