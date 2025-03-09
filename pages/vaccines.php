<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'menu.php';
include '../includes/db.php';

// เพิ่มวัคซีน
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_vaccine'])) {
    $vaccineName = $_POST['vaccineName'];
    $description = $_POST['description'];

    try {
        $stmt = $conn->prepare("INSERT INTO Vaccines (VaccineName, Description) VALUES (?, ?)");
        $stmt->execute([$vaccineName, $description]);
    } catch (PDOException $e) {
        die("เกิดข้อผิดพลาด: " . $e->getMessage());
    }
}

// ลบวัคซีน
if (isset($_GET['delete'])) {
    $vaccineID = $_GET['delete'];
    try {
        $stmt = $conn->prepare("DELETE FROM Vaccines WHERE VaccineID = ?");
        $stmt->execute([$vaccineID]);
    } catch (PDOException $e) {
        die("เกิดข้อผิดพลาด: " . $e->getMessage());
    }
}

// ดึงข้อมูลวัคซีน
$stmt = $conn->query("SELECT * FROM Vaccines");
$vaccines = $stmt->fetchAll();

// รายการวัคซีน
$vaccineOptions = ["วัคซีนพิษสุนัขบ้า", "วัคซีนรวม 5 โรค", "วัคซีนลำไส้อักเสบ", "วัคซีนพาร์โวไวรัส", "วัคซีนไข้หัดสุนัข", "อื่นๆ"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>จัดการข้อมูลวัคซีน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="text-center">จัดการข้อมูลวัคซีน</h3>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="add_vaccine" value="1">
                    <div class="mb-3">
                        <label class="form-label">ชื่อวัคซีน</label>
                        <select name="vaccineName" class="form-select" required>
                            <option value="">-- เลือกชื่อวัคซีน --</option>
                            <?php foreach ($vaccineOptions as $option): ?>
                                <option value="<?= htmlspecialchars($option) ?>"> <?= htmlspecialchars($option) ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">คำอธิบาย</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">เพิ่มวัคซีน</button>
                </form>
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ชื่อวัคซีน</th>
                            <th>คำอธิบาย</th>
                            <th>การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($vaccines as $vaccine): ?>
                        <tr>
                            <td><?= $vaccine['VaccineID'] ?></td>
                            <td><?= $vaccine['VaccineName'] ?></td>
                            <td><?= $vaccine['Description'] ?></td>
                            <td>
                                <a href="?delete=<?= $vaccine['VaccineID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบ?');">ลบ</a>
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
