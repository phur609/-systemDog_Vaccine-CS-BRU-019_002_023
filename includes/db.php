<?php
// เปิดการแสดงข้อผิดพลาด
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ตั้งค่าการเชื่อมต่อฐานข้อมูล
$host = 'localhost';      // โฮสต์ของฐานข้อมูล
$dbname = 'dogs_v';  // ชื่อฐานข้อมูล
$username = 'root';       // ชื่อผู้ใช้ฐานข้อมูล
$password = '';           // รหัสผ่านฐานข้อมูล (หากไม่มีรหัสผ่าน ให้ปล่อยว่างไว้)

try {
    // สร้างการเชื่อมต่อ PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // ตั้งค่าให้แสดงข้อผิดพลาด
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // หากการเชื่อมต่อล้มเหลว
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $e->getMessage());
}
?>