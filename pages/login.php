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
    $password = $_POST['password'];

    try {
        // เตรียมคำสั่ง SQL สำหรับค้นหาผู้ใช้
        $stmt = $conn->prepare("SELECT * FROM Users WHERE Username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // ตรวจสอบรหัสผ่าน
        if ($user && password_verify($password, $user['Password'])) {
            session_start();
            $_SESSION['user_id'] = $user['UserID'];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง!</div>";
        }
    } catch (PDOException $e) {
        die("เกิดข้อผิดพลาด: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>เข้าสู่ระบบ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-header bg-primary text-white">
                <h3 class="text-center">เข้าสู่ระบบ</h3>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">ชื่อผู้ใช้</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">รหัสผ่าน</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">เข้าสู่ระบบ</button>
                </form>
                <p class="mt-3 text-center">
                    <a href="forgot_password.php">ลืมรหัสผ่าน?</a>
                </p>
                <p class="mt-3 text-center">ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิกที่นี่</a></p>
            </div>
        </div>
    </div>
</body>
</html>
