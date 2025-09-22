<?php
// profile.php - User profile management
 
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href = 'login.php';</script>";
    exit;
}
include 'db.php';
 
// Fetch user pins
$stmt = $pdo->prepare("SELECT * FROM pins WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$pins = $stmt->fetchAll();
 
// Fetch user boards
$board_stmt = $pdo->prepare("SELECT * FROM boards WHERE user_id = ?");
$board_stmt->execute([$_SESSION['user_id']]);
$boards = $board_stmt->fetchAll();
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #fafafa; margin: 0; padding: 20px; }
        .container { max-width: 1200px; margin: auto; }
        .grid { column-count: 4; column-gap: 10px; }
        .pin-card { break-inside: avoid; margin-bottom: 10px; background: white; border-radius: 16px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); overflow: hidden; }
        .pin-card img { width: 100%; height: auto; }
        .pin-info { padding: 10px; }
        .boards { margin-top: 40px; }
        .board { background: white; padding: 10px; margin-bottom: 10px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        @media (max-width: 1024px) { .grid { column-count: 3; } }
        @media (max-width: 768px) { .grid { column-count: 2; } }
        @media (max-width: 480px) { .grid { column-count: 1; } }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
        <h2>Your Pins</h2>
        <div class="grid">
            <?php foreach ($pins as $pin): ?>
                <div class="pin-card">
                    <img src="<?php echo htmlspecialchars($pin['image_url']); ?>" alt="<?php echo htmlspecialchars($pin['title']); ?>">
                    <div class="pin-info">
                        <h3><?php echo htmlspecialchars($pin['title']); ?></h3>
                        <p><?php echo htmlspecialchars($pin['description']); ?></p>
                        <button onclick="editPin(<?php echo $pin['id']; ?>)">Edit</button>
                        <button onclick="deletePin(<?php echo $pin['id']; ?>)">Delete</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <h2>Your Boards</h2>
        <div class="boards">
            <?php foreach ($boards as $board): ?>
                <div class="board">
                    <h3><?php echo htmlspecialchars($board['name']); ?></h3>
                    <p><?php echo htmlspecialchars($board['description']); ?></p>
                    <button onclick="viewBoard(<?php echo $board['id']; ?>)">View</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script>
        function editPin(id) { location.href = 'edit_pin.php?id=' + id; }
        function deletePin(id) {
            if (confirm('Delete this pin?')) {
                location.href = 'delete_pin.php?id=' + id;
            }
        }
        function viewBoard(id) { location.href = 'view_board.php?id=' + id; }
    </script>
</body>
</html>
