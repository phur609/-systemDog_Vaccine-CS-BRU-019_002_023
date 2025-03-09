<?php
include '../includes/db.php';

if (isset($_POST['notificationID'])) {
    $stmt = $conn->prepare("UPDATE notifications SET Status = 'Read' WHERE NotificationID = ?");
    $stmt->execute([$_POST['notificationID']]);
    echo json_encode(["success" => true]);
}
?>
