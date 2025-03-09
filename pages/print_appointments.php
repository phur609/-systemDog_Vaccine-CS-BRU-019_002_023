<?php
require_once('../tcpdf/tcpdf.php');  // เรียกใช้ไลบรารี TCPDF
include '../includes/db.php';  // เชื่อมต่อฐานข้อมูล

// สร้าง PDF ใหม่
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('ตารางการฉีดวัคซีนสุนัข');
$pdf->SetHeaderData('', 0, '🐶 ตารางการฉีดวัคซีนสุนัข', 'พิมพ์โดยระบบ');
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 14));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', 10));
$pdf->SetMargins(10, 20, 10);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->AddPage();

// ดึงข้อมูลนัดหมายจากฐานข้อมูล
$stmt = $conn->query("
    SELECT Dogs.Name AS DogName, Vaccines.VaccineName, Appointments.AppointmentDate, Appointments.Status
    FROM Appointments
    JOIN Dogs ON Appointments.DogID = Dogs.DogID
    JOIN Vaccines ON Appointments.VaccineID = Vaccines.VaccineID
    ORDER BY Appointments.AppointmentDate ASC
");
$appointments = $stmt->fetchAll();

// สร้าง HTML ตาราง
$html = '<h2 style="text-align:center;">📅 ตารางการฉีดวัคซีน</h2>
<table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>สุนัข</th>
            <th>วัคซีน</th>
            <th>วันที่นัดหมาย</th>
            <th>สถานะ</th>
        </tr>
    </thead>
    <tbody>';

foreach ($appointments as $appointment) {
    $statusLabel = ($appointment['Status'] == 'รอดำเนินการ') ? '<span style="color:orange;">รอดำเนินการ</span>' : '<span style="color:green;">เสร็จสิ้น</span>';
    
    $html .= "<tr>
                <td>{$appointment['DogName']}</td>
                <td>{$appointment['VaccineName']}</td>
                <td>{$appointment['AppointmentDate']}</td>
                <td>{$statusLabel}</td>
              </tr>";
}

$html .= '</tbody></table>';

// ใส่ HTML ลงใน PDF
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('ตารางการฉีดวัคซีน.pdf', 'I');
?>
