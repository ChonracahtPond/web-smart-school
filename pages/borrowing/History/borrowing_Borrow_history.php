<?php

// ดึงข้อมูลจากตาราง borrowings และ permanent_borrowings
$sql = "SELECT b.borrowing_id, u.first_name, u.last_name, i.item_name, b.quantity, b.return_quantity, b.borrowed_at, 'ยืม-คืน' AS status
        FROM borrowings b
        JOIN items i ON b.item_id = i.item_id
        JOIN users u ON b.user_id = u.user_id
        UNION ALL
        SELECT p.permanent_borrowing_id AS borrowing_id, u.first_name, u.last_name, i.item_name, p.quantity, NULL AS return_quantity, p.borrowed_at, 'เบิก' AS status
        FROM permanent_borrowings p
        JOIN items i ON p.item_id = i.item_id
        JOIN users u ON p.user_id = u.user_id
        ORDER BY borrowed_at DESC";

$result = $conn->query($sql);

if ($result === false) {
    die("Error: " . $conn->error); // แสดงข้อความผิดพลาดของ SQL
}

// เตรียมข้อมูลสำหรับการแสดงผล
$borrowings = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $borrowings[] = $row;
    }
}

$conn->close();
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">ประวัติการยืม</h1>


    <!-- Date Range Form -->
    <form method="get" action="../mpdf/History/History_Report.php" class="mb-6">
        <div class="flex gap-4">
            <div class="mb-4">
                <label for="startdate" class="block text-sm font-medium text-gray-700">วันที่เริ่มต้น</label>
                <input type="date" id="startdate" name="startdate" required class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="enddate" class="block text-sm font-medium text-gray-700">วันที่สิ้นสุด</label>
                <input type="date" id="enddate" name="enddate" required class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <button type="submit" name="generate_report" class="mt-5 h-[50px] inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                ออกรายงาน PDF
            </button>
        </div>
    </form>

    <!-- Borrowing History Table -->
    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-2 px-4 border-b text-left">ชื่อผู้ยืม</th>
                <th class="py-2 px-4 border-b text-left">ชื่ออุปกรณ์</th>
                <th class="py-2 px-4 border-b text-center">จำนวน</th>
                <th class="py-2 px-4 border-b text-center">จำนวนที่คืน</th>
                <th class="py-2 px-4 border-b text-center">วันที่ยืม</th>
                <th class="py-2 px-4 border-b text-center">สถานะ</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($borrowings) > 0) { ?>
                <?php foreach ($borrowings as $borrowing) {
                    // กำหนดสีพื้นหลังตามสถานะ
                    $status_class = $borrowing['status'] == 'ยืม-คืน' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800';
                ?>
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($borrowing['first_name'] . ' ' . $borrowing['last_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($borrowing['item_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="py-2 px-4 border-b text-center"><?php echo htmlspecialchars($borrowing['quantity'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="py-2 px-4 border-b text-center"><?php echo htmlspecialchars($borrowing['return_quantity'] ?? 'ไม่ต้องคืน', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="py-2 px-4 border-b text-center"><?php echo htmlspecialchars(date('d/m/Y', strtotime($borrowing['borrowed_at'])), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="py-2 px-4 border-b text-center <?php echo $status_class; ?>"><?php echo htmlspecialchars($borrowing['status'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="6" class="py-2 px-4 border-b text-center">ไม่มีข้อมูลการยืม</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>