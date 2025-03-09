<?php
session_start();
include '../includes/db.php';

// ✅ ดึงข้อมูลสุนัขและวัคซีน
$dogs = $conn->query("SELECT DogID, Name FROM Dogs")->fetchAll();
$vaccines = $conn->query("SELECT VaccineID, VaccineName FROM Vaccines")->fetchAll();

// ✅ เพิ่มการนัดหมาย
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_appointment'])) {
    $dogID = $_POST['dogID'];
    $vaccineID = $_POST['vaccineID'];
    $appointmentDate = $_POST['appointmentDate'];

    try {
        $stmt = $conn->prepare("INSERT INTO Appointments (DogID, VaccineID, AppointmentDate) VALUES (?, ?, ?)");
        $stmt->execute([$dogID, $vaccineID, $appointmentDate]);

        header("Location: appointments.php?success=added");
        exit();
    } catch (PDOException $e) {
        die("เกิดข้อผิดพลาด: " . $e->getMessage());
    }
}

// ✅ ลบการนัดหมาย
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $appointmentID = $_GET['delete'];
    try {
        $stmt = $conn->prepare("DELETE FROM Appointments WHERE AppointmentID = ?");
        $stmt->execute([$appointmentID]);

        header("Location: appointments.php?success=deleted");
        exit();
    } catch (PDOException $e) {
        die("เกิดข้อผิดพลาด: " . $e->getMessage());
    }
}

// ✅ ดึงข้อมูลนัดหมาย
$stmt = $conn->query("
    SELECT Appointments.AppointmentID, Dogs.Name AS DogName, Vaccines.VaccineName, Appointments.AppointmentDate, Appointments.Status
    FROM Appointments
    JOIN Dogs ON Appointments.DogID = Dogs.DogID
    JOIN Vaccines ON Appointments.VaccineID = Vaccines.VaccineID
    ORDER BY Appointments.AppointmentDate ASC
");
$appointments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <title>ตารางการฉีดยา</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center">📅 ตารางการฉีดยา</h3>

    <!-- ✅ ปุ่มย้อนกลับ -->
    <a href="javascript:history.back()" class="btn btn-secondary mb-3">
        ⬅️ ย้อนกลับ
    </a>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-<?= $_GET['success'] == 'added' ? 'success' : 'danger' ?>">
            <?= $_GET['success'] == 'added' ? '✅ เพิ่มการนัดหมายสำเร็จ!' : '🗑 ลบการนัดหมายสำเร็จ!' ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="mb-4">
        <input type="hidden" name="add_appointment" value="1">
        <div class="mb-3">
            <label class="form-label">สุนัข</label>
            <select name="dogID" class="form-control" required>
                <option value="">เลือกสุนัข</option>
                <?php foreach ($dogs as $dog): ?>
                    <option value="<?= $dog['DogID'] ?>"><?= htmlspecialchars($dog['Name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">วัคซีน</label>
            <select name="vaccineID" class="form-control" required>
                <option value="">เลือกวัคซีน</option>
                <?php foreach ($vaccines as $vaccine): ?>
                    <option value="<?= $vaccine['VaccineID'] ?>"><?= htmlspecialchars($vaccine['VaccineName']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">วันที่ฉีดวัคซีน</label>
            <input type="date" name="appointmentDate" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">เพิ่มการนัดหมาย</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>สุนัข</th>
                <th>วัคซีน</th>
                <th>วันที่นัดหมาย</th>
                <th>สถานะ</th>
                <th>การจัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $appointment): ?>
            <tr>
                <td><?= htmlspecialchars($appointment['DogName']) ?></td>
                <td><?= htmlspecialchars($appointment['VaccineName']) ?></td>
                <td><?= htmlspecialchars($appointment['AppointmentDate']) ?></td>
                <td>
                    <?= $appointment['Status'] == 'pending' ? '<span class="badge bg-warning">รอฉีด</span>' : '<span class="badge bg-success">ฉีดแล้ว</span>' ?>
                </td>
                <td>
                    <a href="?delete=<?= $appointment['AppointmentID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('ต้องการลบการนัดหมายนี้หรือไม่?');">ลบ</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- ✅ ปุ่มย้อนกลับ (เพิ่มด้านล่าง) -->
    <a href="javascript:history.back()" class="btn btn-secondary mt-3">
        ⬅️ ย้อนกลับ
    </a>

    <!-- ปุ่มพิมพ์ PDF -->
    <a href="print_appointments.php" class="btn btn-danger">
        🖨️ พิมพ์ PDF
    </a>
</div>
</body>
</html>
