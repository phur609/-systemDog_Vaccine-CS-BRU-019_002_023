<?php
include '../includes/db.php';
session_start();

$userID = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM notifications WHERE UserID = ? AND Status = 'Unread' ORDER BY CreatedAt DESC");
$stmt->execute([$userID]);
$notifications = $stmt->fetchAll();

header('Content-Type: application/json');
echo json_encode($notifications);
?>
