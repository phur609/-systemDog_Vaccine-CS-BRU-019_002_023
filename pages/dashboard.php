<!DOCTYPE html>
<html lang="th">
<head>
    <title>แดชบอร์ด</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom right, #a8edea, #fed6e3);
            min-height: 100vh;
        }

        .container {
            margin-top: 60px;
        }

        .header-text {
            color: #ffffff;
            font-weight: bold;
            text-shadow: 1px 2px 5px rgba(0,0,0,0.2);
        }

        .card {
            transition: 0.3s;
            border-radius: 15px;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .dog-card {
            background-color: #ffcc80;
        }

        .vaccine-card {
            background-color: #f8bbd0;
        }

        .record-card {
            background-color: #c5cae9;
        }

        footer {
            margin-top: 60px;
            color: #555;
            text-align: center;
            font-weight: 500;
        }

    </style>
</head>
<body>
<div class="container text-center py-5">
    <h2 class="mb-5 header-title card-title header-text card-header bg-transparent border-0 text-center text-dark header-text card-title">
        🐶 <span class="header-text">ระบบจัดการวัคซีนสุนัข</span>
    </h2>

    <div class="row justify-content-center">
        <div class="col-md-3">
            <a href="dogs.php" class="card p-4 text-center text-dark shadow-sm card bg-warning">
                <h4>🐕 ข้อมูลสุนัข</h4>
            </a>
        </div>
        <div class="col-md-3">
            <a href="vaccines.php" class="card p-4 text-center text-dark shadow-sm vaccine-card">
                <h4>💉 ข้อมูลวัคซีน</h4>
            </a>
        </div>
        <div class="col-md-3">
            <a href="records.php" class="card p-4 text-center text-dark shadow-sm record-card">
                <h4>📋 บันทึกการฉีดวัคซีน</h4>
            </a>
        </div>
    </div>

    <footer class="mt-5">
        © 2025 ระบบจัดการวัคซีนสุนัข
    </footer>
</div>
</body>
</html>
