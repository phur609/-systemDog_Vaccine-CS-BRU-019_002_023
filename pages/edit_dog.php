<?php
ob_start();
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'menu.php';
include '../includes/db.php';
include 'log_activity.php'; // ใช้สำหรับบันทึกกิจกรรม

$userID = $_SESSION['user_id']; // รับ ID ผู้ใช้ที่ล็อกอิน

// ✅ ตรวจสอบค่า DogID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ไม่พบข้อมูลสุนัข");
}
$dogID = $_GET['id'];

// ✅ ดึงข้อมูลสุนัขจากฐานข้อมูล
$stmt = $conn->prepare("SELECT * FROM Dogs WHERE DogID = ?");
$stmt->execute([$dogID]);
$dog = $stmt->fetch();

if (!$dog) {
    die("ไม่พบข้อมูลสุนัขที่ต้องการแก้ไข");
}

// ✅ อัปเดตข้อมูลสุนัข
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $ownerName = $_POST['ownerName'];
    $ownerPhone = $_POST['ownerPhone'];

    // ✅ ตรวจสอบว่ามีการอัปโหลดภาพใหม่หรือไม่
    if (!empty($_FILES['dog_image']['name']) && $_FILES['dog_image']['error'] == 0) {
        $imagePath = 'uploads/' . basename($_FILES['dog_image']['name']);
        move_uploaded_file($_FILES['dog_image']['tmp_name'], $imagePath);
    } else {
        $imagePath = $dog['ImagePath']; // ใช้ภาพเดิมหากไม่มีภาพใหม่
    }

    try {
        $stmt = $conn->prepare("UPDATE Dogs SET Name=?, Breed=?, Age=?, OwnerName=?, OwnerPhone=?, ImagePath=? WHERE DogID=?");
        $stmt->execute([$name, $breed, $age, $ownerName, $ownerPhone, $imagePath, $dogID]);

        // ✅ บันทึกการทำรายการลง Activity Logs
        logActivity($userID, "แก้ไขข้อมูลสุนัข ID: $dogID ($name)");

        header("Location: dogs.php");
        exit();
    } catch (PDOException $e) {
        die("เกิดข้อผิดพลาด: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <title>แก้ไขข้อมูลสุนัข</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h3 class="text-center">แก้ไขข้อมูลสุนัข</h3>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">ชื่อสุนัข</label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($dog['Name']) ?>" required>
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
                                $selected = ($dog['Breed'] == $breed_option) ? 'selected' : '';
                                echo "<option value='" . htmlspecialchars($breed_option) . "' $selected>" . htmlspecialchars($breed_option) . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">อายุ</label>
                        <input type="number" name="age" class="form-control" value="<?= htmlspecialchars($dog['Age']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ชื่อเจ้าของ</label>
                        <input type="text" name="ownerName" class="form-control" value="<?= htmlspecialchars($dog['OwnerName']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">เบอร์โทรศัพท์เจ้าของ</label>
                        <input type="text" name="ownerPhone" class="form-control" value="<?= htmlspecialchars($dog['OwnerPhone'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">รูปภาพปัจจุบัน</label><br>
                        <?php if (!empty($dog['ImagePath'])): ?>
                            <img src="<?= htmlspecialchars($dog['ImagePath']) ?>" alt="dog image" width="150">
                        <?php else: ?>
                            <span>ไม่มีรูปภาพ</span>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">อัปโหลดภาพใหม่ (ถ้ามี)</label>
                        <input type="file" name="dog_image" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success w-100">บันทึกการแก้ไข</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
