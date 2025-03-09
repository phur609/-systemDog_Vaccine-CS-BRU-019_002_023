<?php
// เปิดการแสดงข้อผิดพลาด
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include ไฟล์เชื่อมต่อฐานข้อมูล
include '../includes/db.php';

// ตรวจสอบว่ามีการส่งข้อมูลแบบ POST มา
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // เข้ารหัสรหัสผ่าน
    $email = $_POST['email'];

    try {
        // เตรียมคำสั่ง SQL สำหรับเพิ่มผู้ใช้ใหม่
        $stmt = $conn->prepare("INSERT INTO Users (Username, Password, Email) VALUES (?, ?, ?)");
        // ทำการ execute คำสั่ง SQL พร้อมกับข้อมูล
        $stmt->execute([$username, $password, $email]);

        // Redirect ไปยังหน้า login หลังจากลงทะเบียนสำเร็จ
        header("Location: login.php");
        exit(); // หยุดการทำงานทันทีหลังจาก redirect
    } catch (PDOException $e) {
        // แสดงข้อผิดพลาดหากมีปัญหาในการ execute คำสั่ง SQL
        die("เกิดข้อผิดพลาด: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>สมัครสมาชิก</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-header bg-primary text-white">
                <h3 class="text-center">สมัครสมาชิก</h3>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">ชื่อผู้ใช้</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">อีเมล</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">รหัสผ่าน</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">สมัครสมาชิก</button>
                </form>
                <p class="mt-3 text-center">มีบัญชีอยู่แล้ว? <a href="login.php">เข้าสู่ระบบที่นี่</a></p>
            </div>
        </div>
    </div>
</body>
</html>