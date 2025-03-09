<?php
function logActivity($userID, $action) {
    include '../includes/db.php';
    $stmt = $conn->prepare("INSERT INTO ActivityLogs (UserID, Action) VALUES (?, ?)");
    $stmt->execute([$userID, $action]);
}
?>
