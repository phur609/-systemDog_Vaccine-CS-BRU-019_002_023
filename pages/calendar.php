<?php
include '../includes/db.php';

$stmt = $conn->query("
    SELECT Dogs.Name AS DogName, Vaccines.VaccineName, Appointments.AppointmentDate 
    FROM Appointments
    JOIN Dogs ON Appointments.DogID = Dogs.DogID
    JOIN Vaccines ON Appointments.VaccineID = Vaccines.VaccineID
");
$appointments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <title>ปฏิทินฉีดวัคซีน</title>
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center">📅 ปฏิทินการฉีดวัคซีน</h3>
    <div id="calendar"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: [
            <?php foreach ($appointments as $a): ?>
            {
                title: "<?= htmlspecialchars($a['DogName']) ?> - <?= htmlspecialchars($a['VaccineName']) ?>",
                start: "<?= $a['AppointmentDate'] ?>"
            },
            <?php endforeach; ?>
        ]
    });
    calendar.render();
});
</script>
</body>
</html>
