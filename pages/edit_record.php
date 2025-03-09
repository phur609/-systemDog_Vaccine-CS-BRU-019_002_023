<?php
// ✅ เปิด Output Buffering เพื่อป้องกันปัญหา Header Already Sent
ob_start();
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'menu.php'; // ตรวจสอบว่าไฟล์นี้ไม่มีช่องว่างก่อน `<?php`
include '../includes/db.php';

$recordID = $_GET['id'] ?? null;

// ✅ ตรวจสอบว่ามี `RecordID` ถูกส่งมาหรือไม่
if (!$recordID) {
    die("Record ID ไม่ถูกต้อง!");
}

// ✅ ดึงข้อมูล record เดิม
$stmt = $conn->prepare("SELECT * FROM VaccinationRecords WHERE RecordID = ?");
$stmt->execute([$recordID]);
$record = $stmt->fetch();

// ✅ ตรวจสอบว่าพบข้อมูลหรือไม่
if (!$record) {
    die("ไม่พบข้อมูลบันทึกการฉีดวัคซีน!");
}

// ✅ ถ้ามีการส่งฟอร์มมาให้ทำการอัปเดต
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dogID = $_POST['dogID'];
    $vaccineID = $_POST['vaccineID'];
    $vaccinationDate = $_POST['vaccinationDate'];

    try {
        $stmt = $conn->prepare("UPDATE VaccinationRecords SET DogID=?, VaccineID=?, VaccinationDate=? WHERE RecordID=?");
        $stmt->execute([$dogID, $vaccineID, $vaccinationDate, $recordID]);

        // ✅ Redirect หลังจากอัปเดตข้อมูลสำเร็จ
        header("Location: records.php?success=updated");
        exit();
    } catch (PDOException $e) {
        die("เกิดข้อผิดพลาด: " . $e->getMessage());
    }
}

// ✅ ดึงข้อมูลสุนัขและวัคซีนเพื่อใช้ใน Dropdown
$dogs = $conn->query("SELECT DogID, Name FROM Dogs")->fetchAll();
$vaccines = $conn->query("SELECT VaccineID, VaccineName FROM Vaccines")->fetchAll();

ob_end_flush(); // ✅ ปิด Output Buffering
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <title>แก้ไขบันทึกการฉีดวัคซีน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h3 class="text-center">แก้ไขบันทึกการฉีดวัคซีน</h3>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">ชื่อสุนัข</label>
                        <select name="dogID" class="form-select" required>
                            <?php foreach ($dogs as $dog): ?>
                                <option value="<?= $dog['DogID'] ?>" <?= $dog['DogID'] == $record['DogID'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($dog['Name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ชื่อวัคซีน</label>
                        <select name="vaccineID" class="form-select" required>
                            <?php foreach ($vaccines as $vaccine): ?>
                                <option value="<?= $vaccine['VaccineID'] ?>" <?= $vaccine['VaccineID'] == $record['VaccineID'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($vaccine['VaccineName']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">วันที่ฉีดวัคซีน</label>
                        <input type="date" name="vaccinationDate" class="form-control" value="<?= htmlspecialchars($record['VaccinationDate']) ?>" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">บันทึกการแก้ไข</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
