<?php
require_once '../vendor/autoload.php';
include '../../includes/db_connect.php';

use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;

try {
    // การตั้งค่า mPDF
    $defaultConfig = (new ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];
    $defaultFontConfig = (new FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];
    ini_set('pcre.backtrack_limit', '5000000');

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
        'default_font' => 'sarabun'
    ]);

    // รับค่าพารามิเตอร์ items จาก URL
    $itemsParam = isset($_GET['items']) ? $_GET['items'] : '[]';
    $itemsParam = json_decode($itemsParam, true);

    // ตรวจสอบการแปลงค่าพารามิเตอร์
    if (json_last_error() !== JSON_ERROR_NONE || !is_array($itemsParam)) {
        throw new Exception('Invalid items parameter');
    }

    // ปรับคำสั่ง SQL ตามค่าพารามิเตอร์
    $query = "SELECT item_name, item_description, quantity, status FROM items";
    if (!empty($itemsParam)) {
        $itemsParam = array_map(function ($item) use ($conn) {
            return mysqli_real_escape_string($conn, $item);
        }, $itemsParam);
        $itemsList = "'" . implode("','", $itemsParam) . "'";
        $query .= " WHERE item_name IN ($itemsList)";
    }

    $result = mysqli_query($conn, $query);

    if ($result) {
        $items = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $items[] = $row;
        }

        // สร้าง PDF
        $mpdf->AddPage();
        $mpdf->SetFont('sarabun', '', 12);

        // เขียนหัวกระดาษ
        $mpdf->WriteHTML('
            <div style="text-align: center;">
                <h1>รายงานรายการครุภัณฑ์</h1>
                <p>ข้อมูลเกี่ยวกับรายการที่กรองตามพารามิเตอร์</p>
            </div>
            <hr>
        ');

        // จัดรูปแบบตาราง
        $html = '
            <style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                }
                th, td {
                    border: 1px solid #ddd;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                    font-weight: bold;
                }
                tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
            </style>
            <table>
                <thead>
                    <tr>
                        <th>ชื่อ</th>
                        <th>รายละเอียด</th>
                        <th>จำนวน</th>
                        <th>สถานะ</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($items as $item) {
            $html .= '<tr>
                        <td>' . htmlspecialchars($item['item_name']) . '</td>
                        <td>' . htmlspecialchars($item['item_description']) . '</td>
                        <td>' . htmlspecialchars($item['quantity']) . '</td>
                        <td>' . htmlspecialchars($item['status']) . '</td>
                      </tr>';
        }
        $html .= '</tbody></table>';

        $mpdf->WriteHTML($html);
        $mpdf->Output('report.pdf', 'I');
    } else {
        http_response_code(500);
        echo 'Database query error: ' . mysqli_error($conn);
    }
} catch (\Mpdf\MpdfException $e) {
    http_response_code(500);
    echo 'PDF creation error: ' . $e->getMessage();
} catch (Exception $e) {
    http_response_code(400);
    echo 'Error: ' . $e->getMessage();
}
