<?php
include '../includes/db.php';

$stmt = $conn->query("SELECT DogID, Name, Breed, Age, OwnerName, COALESCE(Phone, 'ไม่มีข้อมูล') AS Phone FROM Dogs");
$dogs = $stmt->fetchAll();

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=dog_report.xls");
?>
<table border="1">
<tr>
    <th>ID</th>
    <th>ชื่อสุนัข</th>
    <th>พันธุ์</th>
    <th>อายุ</th>
    <th>ชื่อเจ้าของ</th>
    <th>เบอร์โทรศัพท์</th>
</tr>
<?php foreach ($dogs as $dog): ?>
<tr>
    <td><?= $dog['DogID'] ?></td>
    <td><?= htmlspecialchars($dog['Name']) ?></td>
    <td><?= htmlspecialchars($dog['Breed']) ?></td>
    <td><?= htmlspecialchars($dog['Age']) ?></td>
    <td><?= htmlspecialchars($dog['OwnerName']) ?></td>
    <td><?= isset($dog['Phone']) && !empty($dog['Phone']) ? htmlspecialchars($dog['Phone']) : 'ไม่มีข้อมูล' ?></td>
</tr>
<?php endforeach; ?>
</table>
