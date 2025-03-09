<?php
$host = "localhost";
$dbname = "dogs_v";
$username = "root"; // ปรับตามการตั้งค่าของคุณ
$password = ""; // ปรับตามการตั้งค่าของคุณ

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
