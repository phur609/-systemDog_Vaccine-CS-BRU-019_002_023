<?php
ob_start(); // เปิด Output Buffering
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'menu.php';
include '../includes/db.php';

// ✅ เพิ่มสุนัข
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_dog'])) {
    $name = $_POST['name'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $ownerName = $_POST['ownerName'];
    $ownerPhone = $_POST['ownerPhone'];  

    // ✅ อัปโหลดภาพสุนัข
    $imagePath = null;
    if (!empty($_FILES['dog_image']['name'])) {
        $targetDir = "uploads/";
        $imagePath = $targetDir . basename($_FILES['dog_image']['name']);
        move_uploaded_file($_FILES['dog_image']['tmp_name'], $imagePath);
    }

    try {
        $stmt = $conn->prepare("INSERT INTO Dogs (Name, Breed, Age, OwnerName, OwnerPhone, ImagePath) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $breed, $age, $ownerName, $ownerPhone, $imagePath]);

        header("Location: dogs.php?success=added");
        exit();
    } catch (PDOException $e) {
        die("เกิดข้อผิดพลาด: " . $e->getMessage());
    }
}

// ✅ ลบสุนัข
if (isset($_GET['delete'])) {
    $dogID = $_GET['delete'];

    try {
        // ✅ ดึงข้อมูลรูปภาพก่อนลบ
        $stmt = $conn->prepare("SELECT ImagePath FROM Dogs WHERE DogID = ?");
        $stmt->execute([$dogID]);
        $dog = $stmt->fetch();

        if ($dog['ImagePath'] && file_exists($dog['ImagePath'])) {
            unlink($dog['ImagePath']); // ลบไฟล์ภาพ
        }

        // ✅ ลบข้อมูลจากตารางที่เกี่ยวข้อง
        $conn->prepare("DELETE FROM vaccinationrecords WHERE DogID = ?")->execute([$dogID]);
        $conn->prepare("DELETE FROM Dogs WHERE DogID = ?")->execute([$dogID]);

        header("Location: dogs.php?success=deleted");
        exit();
    } catch (PDOException $e) {
        die("เกิดข้อผิดพลาด: " . $e->getMessage());
    }
}

// ✅ ค้นหาข้อมูลสุนัข
$search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';
$stmt = $conn->prepare("SELECT * FROM Dogs WHERE Name LIKE ? OR Breed LIKE ? OR OwnerName LIKE ?");
$stmt->execute([$search, $search, $search]);
$dogs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <title>จัดการข้อมูลสุนัข</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="text-center">จัดการข้อมูลสุนัข</h3>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="add_dog" value="1">
                <div class="mb-3">
                    <label class="form-label">ชื่อสุนัข</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">พันธุ์</label>
                    <select name="breed" class="form-select" required>
                        <option value="">-- เลือกพันธุ์สุนัข --</option>
                        <?php
                        $breeds = [
                            "โกลเด้น รีทรีฟเวอร์ (Golden Retriever)",
                            "ลาบราดอร์ รีทรีฟเวอร์ (Labrador Retriever)",
                            "ไซบีเรียน ฮัสกี้ (Siberian Husky)",
                            "ปอมเมอเรเนียน (Pomeranian)",
                            "ชิวาวา (Chihuahua)",
                            "สุนัขบ้าน",
                            "อื่นๆ"
                        ];
                        foreach ($breeds as $breed_option) {
                            echo "<option value='" . htmlspecialchars($breed_option) . "'>" . htmlspecialchars($breed_option) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">อายุ</label>
                    <input type="number" name="age" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">ชื่อเจ้าของ</label>
                    <input type="text" name="ownerName" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">เบอร์โทรศัพท์เจ้าของ</label>
                    <input type="text" name="ownerPhone" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">ภาพสุนัข</label>
                    <input type="file" name="dog_image" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary w-100">เพิ่มสุนัข</button>
            </form>

            <form method="GET" class="mt-4">
                <input type="text" name="search" placeholder="ค้นหาสุนัข" class="form-control mb-2">
                <button type="submit" class="btn btn-secondary w-100">ค้นหา</button>
            </form>

            <table class="table table-bordered table-striped mt-4">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>ภาพ</th>
                    <th>ชื่อ</th>
                    <th>พันธุ์</th>
                    <th>อายุ</th>
                    <th>เจ้าของ</th>
                    <th>เบอร์โทร</th>
                    <th>การจัดการ</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($dogs as $dog): ?>
                    <tr>
                        <td><?= $dog['DogID'] ?></td>
                        <td><?= $dog['ImagePath'] ? "<img src='{$dog['ImagePath']}' width='50'>" : "-" ?></td>
                        <td><?= htmlspecialchars($dog['Name']) ?></td>
                        <td><?= htmlspecialchars($dog['Breed']) ?></td>
                        <td><?= htmlspecialchars($dog['Age']) ?></td>
                        <td><?= htmlspecialchars($dog['OwnerName']) ?></td>
                        <td><?= htmlspecialchars($dog['OwnerPhone']) ?></td>
                        <td>
                            <a href="edit_dog.php?id=<?= $dog['DogID'] ?>" class="btn btn-warning btn-sm">แก้ไข</a>
                            <a href="?delete=<?= $dog['DogID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบ?');">ลบ</a>
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
<?php ob_end_flush(); // ปิด Output Buffering ?>
