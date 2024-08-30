<?php

require_once("../vendor/autoload.php");
include('../../includes/db_connect.php');
error_reporting(~E_NOTICE);

// ปิดการแสดงข้อผิดพลาดชั่วคราว
ini_set('display_errors', 0);

// การตั้งค่า Mpdf
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];
$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];
ini_set("pcre.backtrack_limit", "5000000");

$mpdf = new \Mpdf\Mpdf([
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

// ตรวจสอบว่าได้รับการส่งข้อมูลจากฟอร์มหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_pdf'])) {
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];

    // ตรวจสอบว่า วันที่เริ่มต้น และ วันที่สิ้นสุด ถูกต้องหรือไม่
    if (strtotime($startdate) !== false && strtotime($enddate) !== false) {
        // สร้าง SQL query เพื่อนำข้อมูลตามช่วงวันที่ที่เลือก
        $sql = "SELECT b.borrowing_id, u.first_name, u.last_name, i.item_name, b.quantity, b.return_quantity, b.borrowed_at, 'ยืม-คืน' AS status
                FROM borrowings b
                JOIN items i ON b.item_id = i.item_id
                JOIN users u ON b.user_id = u.user_id
                WHERE b.borrowed_at BETWEEN ? AND ?
                UNION ALL
                SELECT p.permanent_borrowing_id AS borrowing_id, u.first_name, u.last_name, i.item_name, p.quantity, NULL AS return_quantity, p.borrowed_at, 'เบิก' AS status
                FROM permanent_borrowings p
                JOIN items i ON p.item_id = i.item_id
                JOIN users u ON p.user_id = u.user_id
                WHERE p.borrowed_at BETWEEN ? AND ?
                ORDER BY borrowed_at DESC";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssss", $startdate, $enddate, $startdate, $enddate);
            $stmt->execute();
            $result = $stmt->get_result();

            $borrowings = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $borrowings[] = $row;
                }
            }
            $stmt->close();
        } else {
            die("Error preparing statement: " . $conn->error);
        }

        // เริ่มสร้าง PDF
        ob_start();
?>
        <html>

        <head>
            <style>
                body {
                    font-family: 'sarabun', sans-serif;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                }

                th,
                td {
                    border: 1px solid #ddd;
                    padding: 8px;
                }

                th {
                    background-color: #f2f2f2;
                    text-align: left;
                }

                .bg-yellow-100 {
                    background-color: #fefce8;
                }

                .bg-green-100 {
                    background-color: #f0fdf4;
                }

                .text-center {
                    text-align: center;
                }
            </style>
        </head>

        <body>
            <h1>รายงานประวัติการยืม</h1>
            <p>ช่วงวันที่: <?php echo htmlspecialchars($startdate); ?> ถึง <?php echo htmlspecialchars($enddate); ?></p>
            <table>
                <thead>
                    <tr>
                        <th>ชื่อผู้ยืม</th>
                        <th>ชื่ออุปกรณ์</th>
                        <th>จำนวน</th>
                        <th>จำนวนที่คืน</th>
                        <th>วันที่ยืม</th>
                        <th>สถานะ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($borrowings) > 0) { ?>
                        <?php foreach ($borrowings as $borrowing) {
                            // กำหนดสีพื้นหลังตามสถานะ
                            $status_class = $borrowing['status'] == 'ยืม-คืน' ? 'bg-yellow-100' : 'bg-green-100';
                        ?>
                            <tr class="<?php echo $status_class; ?>">
                                <td><?php echo htmlspecialchars($borrowing['first_name'] . ' ' . $borrowing['last_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($borrowing['item_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($borrowing['quantity'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($borrowing['return_quantity'] ?? 'ไม่ต้องคืน', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="text-center"><?php echo htmlspecialchars(date('d/m/Y', strtotime($borrowing['borrowed_at'])), ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($borrowing['status'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="6" class="text-center">ไม่มีข้อมูลการยืม</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </body>

        </html>
<?php
        $html = ob_get_clean();
        $mpdf->WriteHTML($html);
        $mpdf->Output('report.pdf', \Mpdf\Output\Destination::INLINE); // หรือ \Mpdf\Output\Destination::DOWNLOAD เพื่อดาวน์โหลด
    } else {
        echo "วันที่เริ่มต้นหรือวันที่สิ้นสุดไม่ถูกต้อง";
    }
}

?>

<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate PDF Report</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.1/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">เลือกช่วงวันที่เพื่อสร้างรายงาน PDF</h1>
        <form method="post" action="">
            <div class="mb-4">
                <label for="startdate" class="block text-sm font-medium text-gray-700">วันที่เริ่มต้น</label>
                <input type="date" id="startdate" name="startdate" required class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="enddate" class="block text-sm font-medium text-gray-700">วันที่สิ้นสุด</label>
                <input type="date" id="enddate" name="enddate" required class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <button type="submit" name="generate_pdf" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                ออกรายงาน PDF
            </button>
        </form>
    </div>
</body>

</html> -->