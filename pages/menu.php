<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// เช็คว่ามีการล็อกอินหรือไม่
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">🐶 ระบบวัคซีนสุนัข</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">📊 แดชบอร์ด</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="activity_logs.php">📜 ล็อกการทำรายการ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dogs.php">🐶 สุนัข</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="vaccines.php">💉 วัคซีน</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="records.php">📋 บันทึก</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="appointments.php">📅 ตารางฉีดวัคซีน</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        📈 รายงานและสถิติ
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="generate_report.php">📝 สร้างรายงาน (Excel)</a></li>
                        <li><a class="dropdown-item" href="charts.php">📊 แสดงสถิติและกราฟ</a></li>
                    </ul>
                </li>
                <!-- 🔔 แจ้งเตือน -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        🔔 แจ้งเตือน <span id="notification-count" class="badge bg-danger">0</span>
                    </a>
                    <ul class="dropdown-menu" id="notification-list">
                        <li><a class="dropdown-item" href="#">ไม่มีการแจ้งเตือน</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout.php">🚪 ออก</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- ✅ Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- 🔔 ระบบแจ้งเตือน -->
<script>
function fetchNotifications() {
    fetch('fetch_notifications.php')
        .then(response => response.json())
        .then(data => {
            let count = data.length;
            document.getElementById('notification-count').innerText = count;
            let list = document.getElementById('notification-list');
            list.innerHTML = "";

            if (count === 0) {
                list.innerHTML = "<li><a class='dropdown-item' href='#'>ไม่มีการแจ้งเตือน</a></li>";
            } else {
                data.forEach(notification => {
                    let item = `<li><a class="dropdown-item mark-read" href="#" data-id="${notification.NotificationID}">${notification.Message}</a></li>`;
                    list.innerHTML += item;
                });
            }
        });
}

document.addEventListener('DOMContentLoaded', function() {
    fetchNotifications();
    document.getElementById('notification-list').addEventListener('click', function(e) {
        if (e.target.classList.contains('mark-read')) {
            let id = e.target.getAttribute('data-id');
            fetch('mark_as_read.php', {
                method: 'POST',
                body: new URLSearchParams({ notificationID: id })
            }).then(() => fetchNotifications());
        }
    });
});
</script>
