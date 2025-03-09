<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include '../includes/db.php';
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <title>สถิติการฉีดวัคซีนสุนัข</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">🐶 ระบบวัคซีนสุนัข</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">📊 แดชบอร์ด</a></li>
                <li class="nav-item"><a class="nav-link" href="dogs.php">🐶 สุนัข</a></li>
                <li class="nav-item"><a class="nav-link" href="vaccines.php">💉 วัคซีน</a></li>
                <li class="nav-item"><a class="nav-link" href="records.php">📋 บันทึก</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        📈 รายงานและสถิติ
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="generate_report.php">📝 สร้างรายงาน (Excel)</a></li>
                        <li><a class="dropdown-item" href="charts.php">📊 แสดงสถิติและกราฟ</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link text-danger" href="logout.php">🚪 ออก</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- ✅ ส่วนแสดงกราฟ -->
<div class="container mt-5">
    <h2 class="text-center mb-4">📊 สถิติการฉีดวัคซีนตามพันธุ์สุนัข</h2>
    <div class="card">
        <div class="card-body">
            <canvas id="myChart"></canvas>
        </div>
    </div>
</div>

<?php
// ดึงข้อมูลจำนวนวัคซีนตามพันธุ์สุนัข
$stmt = $conn->query("
    SELECT Dogs.Breed, COUNT(VaccinationRecords.RecordID) AS VaccineCount 
    FROM VaccinationRecords 
    JOIN Dogs ON VaccinationRecords.DogID = Dogs.DogID 
    GROUP BY Dogs.Breed
");
$data = $stmt->fetchAll();

// 🛠 ตรวจสอบว่ามีข้อมูลจริง
if (empty($data)) {
    echo "<p class='text-center text-danger'>ไม่มีข้อมูลการฉีดวัคซีนในระบบ</p>";
    exit();
}

$breeds = [];
$vaccineCounts = [];
foreach ($data as $row) {
    $breeds[] = $row['Breed'];
    $vaccineCounts[] = $row['VaccineCount'];
}
?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const breeds = <?= json_encode($breeds) ?>;
    const vaccineCounts = <?= json_encode($vaccineCounts) ?>;

    if (breeds.length === 0) {
        document.getElementById('myChart').style.display = 'none';
        alert('ไม่มีข้อมูลการฉีดวัคซีน');
        return;
    }

    const ctx = document.getElementById('myChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: breeds,
            datasets: [{
                label: 'จำนวนครั้งการฉีดวัคซีนตามพันธุ์',
                data: vaccineCounts,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'จำนวนครั้ง' }
                },
                x: {
                    title: { display: true, text: 'พันธุ์สุนัข' }
                }
            }
        }
    });
});
</script>

<!-- ✅ เพิ่ม Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
