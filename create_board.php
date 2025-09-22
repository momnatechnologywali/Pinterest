<?php
// create_board.php - Create board
 
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href = 'login.php';</script>";
    exit;
}
include 'db.php';
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
 
    $stmt = $pdo->prepare("INSERT INTO boards (user_id, name, description) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $name, $description]);
    echo "<script>location.href = 'profile.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Board</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #fafafa; margin: 0; padding: 20px; }
        form { max-width: 400px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        input, textarea { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #E60023; color: white; border: none; padding: 10px; width: 100%; border-radius: 4px; cursor: pointer; }
        button:hover { background: #c7001f; }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Create Board</h2>
        <input type="text" name="name" placeholder="Board Name" required>
        <textarea name="description" placeholder="Description"></textarea>
        <button type="submit">Create</button>
    </form>
</body>
</html>
