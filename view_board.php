<?php
// view_board.php - View board and saved pins
 
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href = 'login.php';</script>";
    exit;
}
include 'db.php';
 
$board_id = $_GET['id'];
 
// Check ownership
$check_stmt = $pdo->prepare("SELECT * FROM boards WHERE id = ? AND user_id = ?");
$check_stmt->execute([$board_id, $_SESSION['user_id']]);
$board = $check_stmt->fetch();
 
if (!$board) {
    echo "Board not found";
    exit;
}
 
// Fetch pins in board
$stmt = $pdo->prepare("SELECT p.* FROM pins p JOIN board_pins bp ON p.id = bp.pin_id WHERE bp.board_id = ?");
$stmt->execute([$board_id]);
$pins = $stmt->fetchAll();
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Board: <?php echo htmlspecialchars($board['name']); ?></title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #fafafa; margin: 0; padding: 20px; }
        .container { max-width: 1200px; margin: auto; }
        .grid { column-count: 4; column-gap: 10px; }
        .pin-card { break-inside: avoid; margin-bottom: 10px; background: white; border-radius: 16px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); overflow: hidden; }
        .pin-card img { width: 100%; height: auto; }
        .pin-info { padding: 10px; }
        @media (max-width: 1024px) { .grid { column-count: 3; } }
        @media (max-width: 768px) { .grid { column-count: 2; } }
        @media (max-width: 480px) { .grid { column-count: 1; } }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($board['name']); ?></h1>
        <p><?php echo htmlspecialchars($board['description']); ?></p>
        <div class="grid">
            <?php foreach ($pins as $pin): ?>
                <div class="pin-card">
                    <img src="<?php echo htmlspecialchars($pin['image_url']); ?>" alt="<?php echo htmlspecialchars($pin['title']); ?>">
                    <div class="pin-info">
                        <h3><?php echo htmlspecialchars($pin['title']); ?></h3>
                        <p><?php echo htmlspecialchars($pin['description']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
