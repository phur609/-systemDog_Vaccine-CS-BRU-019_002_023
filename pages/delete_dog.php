<?php
include '../includes/db.php';
include 'log_activity.php';

session_start();
$userID = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $dogID = $_GET['id'];

    try {
        $stmt = $conn->prepare("SELECT Name FROM Dogs WHERE DogID = ?");
        $stmt->execute([$dogID]);
        $dog = $stmt->fetch();

        $stmt = $conn->prepare("DELETE FROM Dogs WHERE DogID = ?");
        $stmt->execute([$dogID]);

        logActivity($userID, "ลบข้อมูลสุนัข: {$dog['Name']} (ID: $dogID)");
        header("Location: dogs.php");
        exit();
    } catch (PDOException $e) {
        die("เกิดข้อผิดพลาด: " . $e->getMessage());
    }
}
?>
