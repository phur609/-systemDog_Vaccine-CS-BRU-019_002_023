<?php
session_start();
include '../includes/db.php';

// ตรวจสอบโทเค็น
if (!isset($_GET['token'])) {
    die("ลิงก์ไม่ถูกต้อง");
}

$token = $_GET['token'];

// ค้นหาโทเค็น
$stmt = $conn->prepare("SELECT * FROM Users WHERE ResetToken = ? AND ResetTokenExpire > NOW()");
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user) {
    die("ลิงก์หมดอายุหรือไม่ถูกต้อง");
}

// หากส่งฟอร์มเปลี่ยนรหัสผ่าน
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // อัปเดตรหัสผ่านในฐานข้อมูล
    $stmt = $conn->prepare("UPDATE Users SET Password = ?, ResetToken = NULL, ResetTokenExpire = NULL WHERE ResetToken = ?");
    $stmt->execute([$newPassword, $token]);

    echo "<div class='alert alert-success'>เปลี่ยนรหัสผ่านสำเร็จ! <a href='login.php'>เข้าสู่ระบบ</a></div>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ตั้งค่ารหัสผ่านใหม่</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-header bg-success text-white">
                <h3 class="text-center">ตั้งค่ารหัสผ่านใหม่</h3>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="password" class="form-label">รหัสผ่านใหม่</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">บันทึกรหัสผ่านใหม่</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
