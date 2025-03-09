<?php
include '../includes/db.php';

function addNotification($userID, $message) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO notifications (UserID, Message) VALUES (?, ?)");
    $stmt->execute([$userID, $message]);
}
?>
