<?php
include '../includes/db.php';

$stmt = $conn->query("
    SELECT ActivityLogs.LogID, Users.Username, ActivityLogs.Action, ActivityLogs.Timestamp
    FROM ActivityLogs
    JOIN Users ON ActivityLogs.UserID = Users.UserID
    ORDER BY ActivityLogs.Timestamp DESC
");
$logs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <title>ประวัติการทำรายการ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h3 class="text-center">📋 ประวัติการทำรายการ</h3>
        <table class="table table-bordered table-striped mt-4">
            <thead class="bg-dark text-white">
                <tr>
                    <th>ID</th>
                    <th>ผู้ใช้</th>
                    <th>รายละเอียด</th>
                    <th>เวลา</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?= $log['LogID'] ?></td>
                        <td><?= htmlspecialchars($log['Username']) ?></td>
                        <td><?= htmlspecialchars($log['Action']) ?></td>
                        <td><?= $log['Timestamp'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
