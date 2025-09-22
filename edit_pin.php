<?php
// edit_pin.php - Edit pin
 
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href = 'login.php';</script>";
    exit;
}
include 'db.php';
 
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM pins WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$pin = $stmt->fetch();
 
if (!$pin) {
    echo "Pin not found";
    exit;
}
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
 
    $update_stmt = $pdo->prepare("UPDATE pins SET title = ?, description = ?, category = ? WHERE id = ?");
    $update_stmt->execute([$title, $description, $category, $id]);
    echo "<script>location.href = 'profile.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pin</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #fafafa; margin: 0; padding: 20px; }
        form { max-width: 400px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        input, select, textarea { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #E60023; color: white; border: none; padding: 10px; width: 100%; border-radius: 4px; cursor: pointer; }
        button:hover { background: #c7001f; }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Edit Pin</h2>
        <input type="text" name="title" value="<?php echo htmlspecialchars($pin['title']); ?>" required>
        <textarea name="description"><?php echo htmlspecialchars($pin['description']); ?></textarea>
        <select name="category" required>
            <option value="Fashion" <?php if($pin['category']=='Fashion') echo 'selected'; ?>>Fashion</option>
            <option value="Art" <?php if($pin['category']=='Art') echo 'selected'; ?>>Art</option>
            <option value="Food" <?php if($pin['category']=='Food') echo 'selected'; ?>>Food</option>
            <option value="Travel" <?php if($pin['category']=='Travel') echo 'selected'; ?>>Travel</option>
            <option value="DIY" <?php if($pin['category']=='DIY') echo 'selected'; ?>>DIY</option>
            <option value="Other" <?php if($pin['category']=='Other') echo 'selected'; ?>>Other</option>
        </select>
        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
