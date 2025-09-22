<?php
// delete_pin.php - Delete pin
 
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>location.href = 'login.php';</script>";
    exit;
}
include 'db.php';
 
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT image_url FROM pins WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$pin = $stmt->fetch();
 
if ($pin) {
    unlink($pin['image_url']);  // Delete image file
    $delete_stmt = $pdo->prepare("DELETE FROM pins WHERE id = ?");
    $delete_stmt->execute([$id]);
}
echo "<script>location.href = 'profile.php';</script>";
?>
