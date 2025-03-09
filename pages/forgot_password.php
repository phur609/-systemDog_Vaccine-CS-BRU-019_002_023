<?php
session_start();
include '../includes/db.php';
require '../vendor/autoload.php'; // โหลด PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // ตรวจสอบว่ามีผู้ใช้งานที่ใช้ Email นี้หรือไม่
    $stmt = $conn->prepare("SELECT * FROM Users WHERE Email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // สร้างโทเค็นสำหรับรีเซ็ตรหัสผ่าน
        $token = bin2hex(random_bytes(50));

        // บันทึกโทเค็นและเวลาหมดอายุ (1 ชั่วโมง)
        $stmt = $conn->prepare("UPDATE Users SET ResetToken = ?, ResetTokenExpire = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE Email = ?");
        $stmt->execute([$token, $email]);

        // สร้างลิงก์สำหรับรีเซ็ตรหัสผ่าน
        $resetLink = "http://localhost/dogs_v/pages/reset_password.php?token=$token";

        // ตั้งค่า PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // ใช้ Gmail SMTP
            $mail->SMTPAuth = true;
            $mail->Username = '650112230002@bru.ac.th'; // ใส่อีเมลที่ใช้ส่ง
            $mail->Password = 'apkr wsyx lxac dxbd'; // ใช้ App Password จาก Google

            // ควรใช้ STARTTLS กับ Port 587
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('your_email@gmail.com', 'Your System');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'รีเซ็ตรหัสผ่าน';
            $mail->Body = "คลิกลิงก์เพื่อรีเซ็ตรหัสผ่าน: <a href='$resetLink'>$resetLink</a>";

            $mail->send();
            echo "<div class='alert alert-success'>✅ กรุณาตรวจสอบอีเมลของคุณ!</div>";
        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>❌ ไม่สามารถส่งอีเมลได้: {$mail->ErrorInfo}</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>❌ ไม่พบอีเมลนี้ในระบบ</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ลืมรหัสผ่าน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-header bg-warning text-white">
                <h3 class="text-center">🔒 ลืมรหัสผ่าน</h3>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">อีเมล</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">📩 ส่งคำขอรีเซ็ตรหัสผ่าน</button>
                </form>
                <p class="mt-3 text-center"><a href="login.php">🔙 กลับไปหน้าเข้าสู่ระบบ</a></p>
            </div>
        </div>
    </div>
</body>
</html>
