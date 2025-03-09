<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'menu.php';
include '../includes/db.php';

// เพิ่มบันทึกการฉีดวัคซีน
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_record'])) {
    $dogID = $_POST['dogID'];
    $vaccineID = $_POST['vaccineID'];
    $vaccinationDate = $_POST['vaccinationDate'];

    try {
        $stmt = $conn->prepare("INSERT INTO VaccinationRecords (DogID, VaccineID, VaccinationDate) VALUES (?, ?, ?)");
        $stmt->execute([$dogID, $vaccineID, $vaccinationDate]);
    } catch (PDOException $e) {
        die("เกิดข้อผิดพลาด: " . $e->getMessage());
    }
}

// ลบบันทึก
if (isset($_GET['delete'])) {
    $recordID = $_GET['delete'];
    try {
        $stmt = $conn->prepare("DELETE FROM VaccinationRecords WHERE RecordID = ?");
        $stmt->execute([$recordID]);
    } catch (PDOException $e) {
        die("เกิดข้อผิดพลาด: " . $e->getMessage());
    }
}

// ดึงข้อมูลบันทึกการฉีดวัคซีน
$stmt = $conn->query("
    SELECT VaccinationRecords.RecordID, Dogs.Name AS DogName, Vaccines.VaccineName, VaccinationRecords.VaccinationDate  
    FROM VaccinationRecords
    JOIN Dogs ON VaccinationRecords.DogID = Dogs.DogID
    JOIN Vaccines ON VaccinationRecords.VaccineID = Vaccines.VaccineID
");
$records = $stmt->fetchAll();

$dogs = $conn->query("SELECT DogID, Name FROM Dogs")->fetchAll();
$vaccines = $conn->query("SELECT VaccineID, VaccineName FROM Vaccines")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>บันทึกการฉีดวัคซีน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="text-center">บันทึกการฉีดวัคซีน</h3>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="add_record" value="1">
                    <div class="mb-3">
                        <label class="form-label">ชื่อสุนัข</label>
                        <select name="dogID" class="form-control" required>
                            <option value="">เลือกสุนัข</option>
                            <?php foreach ($dogs as $dog): ?>
                                <option value="<?= $dog['DogID'] ?>"><?= $dog['Name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ชื่อวัคซีน</label>
                        <select name="vaccineID" class="form-control" required>
                            <option value="">เลือกวัคซีน</option>
                            <?php foreach ($vaccines as $vaccine): ?>
                                <option value="<?= $vaccine['VaccineID'] ?>"><?= $vaccine['VaccineName'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">วันที่ฉีดวัคซีน</label>
                        <input type="date" name="vaccinationDate" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">เพิ่มบันทึก</button>
                </form>
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ชื่อสุนัข</th>
                            <th>ชื่อวัคซีน</th>
                            <th>วันที่ฉีดวัคซีน</th>
                            <th>การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($records as $record): ?>
                        <tr>
                            <td><?= $record['RecordID'] ?></td>
                            <td><?= $record['DogName'] ?></td>
                            <td><?= $record['VaccineName'] ?></td>
                            <td><?= $record['VaccinationDate'] ?></td>
                            <td>
                            <td>
                            <td>
                            <td>
    <a href="./edit_record.php?id=<?= $record['RecordID'] ?>" class="btn btn-warning btn-sm">แก้ไข</a>
    <a href="?delete=<?= $record['RecordID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบ?');">ลบ</a>
</td>



                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
