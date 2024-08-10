<?php


// ตั้งค่าตัวแปรสำหรับกรองวันที่
$startDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$endDate = isset($_POST['end_date']) ? $_POST['end_date'] : '';

// ดึงข้อมูลการเข้าร่วม
$sql = "SELECT a.attendance_id, a.student_id, a.lesson_id, a.attendance_date, a.status,
               s.student_name, l.lesson_title, c.course_name
        FROM attendance a
        JOIN students s ON a.student_id = s.student_id
        JOIN lessons l ON a.lesson_id = l.lesson_id
        JOIN courses c ON l.course_id = c.course_id
        WHERE a.attendance_date BETWEEN ? AND ?";

// เตรียมและรันคำสั่ง SQL
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $startDate, $endDate);
$stmt->execute();
$result = $stmt->get_result();

// ตรวจสอบข้อผิดพลาดของ SQL
if (!$result) {
    die("ข้อผิดพลาดในการดำเนินการ SQL: " . $conn->error);
}
?>

<style>
    .status-missingclass {
        color: #f1381f;
        /* Red for missing class */
    }

    .status-studyleave {
        color: #f6e05e;
        /* Yellow for study leave */
    }

    .status-arrivelate {
        color: #48bb78;
        /* Green for arrival late */
    }
</style>

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">รายงานการขาด ลา มาสาย</h1>

    <!-- Filter form -->
    <form method="POST" class="mb-6">
        <div class="flex space-x-4">
            <div>
                <label for="start_date" class="block text-gray-700 mt-5">วันที่เริ่มต้น</label>
                <input type="date" id="start_date" name="start_date" class="border border-gray-300 rounded-md p-2" value="<?php echo htmlspecialchars($startDate); ?>">
            </div>
            <div>
                <label for="end_date" class="block text-gray-700 mt-5">วันที่สิ้นสุด</label>
                <input type="date" id="end_date" name="end_date" class="border border-gray-300 rounded-md p-2" value="<?php echo htmlspecialchars($endDate); ?>">
            </div>
            <button type="submit" class="self-end px-4 py-2 bg-blue-600 text-white rounded-md shadow-md hover:bg-blue-700">กรอง</button>
        </div>
    </form>

    <!-- Form to generate PDF -->
    <form action="?page=attendance_pdf" target="_blank" method="POST" class="mb-6">
        <input type="hidden" name="start_date" value="<?php echo htmlspecialchars($startDate); ?>">
        <input type="hidden" name="end_date" value="<?php echo htmlspecialchars($endDate); ?>">
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg shadow-lg hover:bg-green-700 transition duration-150">
            สร้าง PDF
        </button>
    </form>

    <!-- Table of attendance -->
    <div class="bg-white shadow-lg rounded-lg mt-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4 px-6 py-4">ข้อมูลการเข้าร่วม</h2>
        <table class="w-full mt-4 border-collapse">
            <thead>
                <tr class="bg-gray-200 text-gray-600">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ชื่อผู้เรียน</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ชื่อหลักสูตร</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ชื่อบทเรียน</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">วันที่เข้าร่วม</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">สถานะ</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900"><?php echo htmlspecialchars($row['student_name']); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-900"><?php echo htmlspecialchars($row['course_name']); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-900"><?php echo htmlspecialchars($row['lesson_title']); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-900"><?php echo htmlspecialchars($row['attendance_date']); ?></td>
                        <td class="px-6 py-4 text-sm <?php
                                                        // Apply class based on status
                                                        switch ($row['status']) {
                                                            case 'Missingclass':
                                                                echo 'status-missingclass';
                                                                break;
                                                            case 'Studyleave':
                                                                echo 'status-studyleave';
                                                                break;
                                                            case 'Arrivelate':
                                                                echo 'status-arrivelate';
                                                                break;
                                                            default:
                                                                echo 'text-gray-900'; // Default color
                                                        }
                                                        ?>">
                            <?php
                            // Display status as text
                            switch ($row['status']) {
                                case 'Missingclass':
                                    echo 'ขาด';
                                    break;
                                case 'Studyleave':
                                    echo 'ลา';
                                    break;
                                case 'Arrivelate':
                                    echo 'มาสาย';
                                    break;
                                default:
                                    echo 'ไม่ทราบ'; // Default text
                            }
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>