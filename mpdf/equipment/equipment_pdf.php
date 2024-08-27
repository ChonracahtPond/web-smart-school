<?php
require_once("../vendor/autoload.php");
include('../../includes/db_connect.php');
error_reporting(~E_NOTICE);

// ปิดการแสดงข้อผิดพลาดชั่วคราว
ini_set('display_errors', 0);

use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;

$defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];
$defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];
ini_set("pcre.backtrack_limit", "5000000");

$mpdf = new Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/tmp',
    ]),
    'fontdata' => $fontData + [
        'sarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
            'BI' => 'THSarabunNew BoldItalic.ttf'
        ]
    ],
    'default_font' => 'sarabun' // เลือกฟอนต์ที่ต้องการใช้
]);


// รับข้อมูล JSON ที่ส่งมาจาก JavaScript
$data = json_decode(file_get_contents('php://input'), true);

// ตรวจสอบว่ามีข้อมูลหรือไม่
if (isset($data['items']) && is_array($data['items'])) {
    $items = $data['items'];

    // เพิ่มหน้าใหม่
    $mpdf->AddPage();
    $mpdf->SetFont('sarabun', '', 12);

    // ตั้งชื่อเอกสาร
    $mpdf->WriteHTML('<h1>รายงานรายการ</h1>');
    $mpdf->WriteHTML('<br>');

    // แสดงรายการใน PDF
    foreach ($items as $item) {
        $mpdf->WriteHTML('<p>' . htmlspecialchars($item) . '</p>');
    }

    // ส่ง PDF กลับไปยังผู้ใช้
    $mpdf->Output('report.pdf', 'I');
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
}
