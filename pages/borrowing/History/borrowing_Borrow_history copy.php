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

    <!-- Pagination Controls -->
    <div class="flex justify-between items-center mt-4">
        <div>
            <?php if ($page > 1) { ?>
                <a href="?page=<?php echo $page - 1; ?>" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-300">
                    &laquo; ก่อนหน้า
                </a>
            <?php } ?>
        </div>
        <div class="text-sm text-gray-600">
            หน้า <?php echo $page; ?> ของ <?php echo $total_pages; ?>
        </div>
        <div>
            <?php if ($page < $total_pages) { ?>
                <a href="?page=<?php echo $page + 1; ?>" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-300">
                    ถัดไป &raquo;
                </a>
            <?php } ?>
        </div>
    </div>
</div>



<?php

// กำหนดค่าเริ่มต้น
$items_per_page = isset($_GET['items_per_page']) ? intval($_GET['items_per_page']) : 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// ตรวจสอบค่าตัวแปร
if ($items_per_page <= 0) {
    $items_per_page = 5; // กำหนดค่าเริ่มต้นหากไม่ถูกต้อง
}
if ($page <= 0) {
    $page = 1; // กำหนดค่าเริ่มต้นหากไม่ถูกต้อง
}

$offset = ($page - 1) * $items_per_page;

// คำสั่ง SQL
$sql = "SELECT b.borrowing_id, u.first_name, u.last_name, i.item_name, b.quantity, b.return_quantity, b.borrowed_at, 'ยืม-คืน' AS status
        FROM borrowings b
        JOIN items i ON b.item_id = i.item_id
        JOIN users u ON b.user_id = u.user_id
        UNION ALL
        SELECT p.permanent_borrowing_id AS borrowing_id, u.first_name, u.last_name, i.item_name, p.quantity, NULL AS return_quantity, p.borrowed_at, 'เบิก' AS status
        FROM permanent_borrowings p
        JOIN items i ON p.item_id = i.item_id
        JOIN users u ON p.user_id = u.user_id
        ORDER BY borrowed_at DESC
        LIMIT ? OFFSET ?";

// เตรียมคำสั่ง SQL และทำการ bind ตัวแปร
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $items_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

// ตรวจสอบข้อมูล
if ($result === false) {
    die("Error: " . $conn->error); // แสดงข้อความผิดพลาดของ SQL
}

// การดึงข้อมูลและแสดงผล
$borrowings = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $borrowings[] = $row;
    }
}

// คำนวณจำนวนหน้าทั้งหมด
$count_sql = "SELECT COUNT(*) as total FROM (
                SELECT b.borrowing_id
                FROM borrowings b
                UNION ALL
                SELECT p.permanent_borrowing_id
                FROM permanent_borrowings p
              ) as all_borrowings";

$count_result = $conn->query($count_sql);
$total_items = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_items / $items_per_page);

$conn->close();
?>


<div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="border rounded-lg divide-y divide-gray-200 dark:border-gray-700 dark:divide-gray-700">
                <div class="py-3 px-4">
                    <div class="relative max-w-xs">
                        <label class="sr-only">Search</label>
                        <input type="text" name="hs-table-with-pagination-search" id="hs-table-with-pagination-search" class="py-2 px-3 ps-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Search for items">
                        <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="py-3 px-4 pe-0"></th>
                                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">ชื่อผู้ยืม</th>
                                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">ชื่ออุปกรณ์</th>
                                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">จำนวน</th>
                                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">จำนวนที่คืน</th>
                                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">วันที่ยืม</th>
                                <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">สถานะ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <?php if (count($borrowings) > 0) { ?>
                                <?php foreach ($borrowings as $borrowing) {
                                    $status_class = $borrowing['status'] == 'ยืม-คืน' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800';
                                ?>
                                    <tr>
                                        <td class="py-3 ps-4">
                                            <div class="flex items-center h-5">
                                                <input type="checkbox" class="border-gray-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                                                <label class="sr-only">Checkbox</label>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200"><?php echo htmlspecialchars($borrowing['first_name'] . ' ' . $borrowing['last_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"><?php echo htmlspecialchars($borrowing['item_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"><?php echo htmlspecialchars($borrowing['quantity'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"><?php echo htmlspecialchars($borrowing['return_quantity'] ?? 'ไม่ต้องคืน', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"><?php echo htmlspecialchars(date('d/m/Y', strtotime($borrowing['borrowed_at'])), ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200 <?php echo $status_class; ?>"><?php echo htmlspecialchars($borrowing['status'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="7" class="py-2 px-4 border-b text-center">ไม่มีข้อมูลการยืม</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="py-1 px-4">
                    <nav class="flex items-center space-x-1">
                        <a href="?page=1" class="p-2.5 inline-flex items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" aria-label="First Page">
                            <span aria-hidden="true">««</span>
                        </a>
                        <a href="?page=<?php echo max(1, $page - 1); ?>" class="p-2.5 inline-flex items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" aria-label="Previous">
                            <span aria-hidden="true">«</span>
                        </a>
                        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                            <a href="?page=<?php echo $i; ?>" class="min-w-[40px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2.5 text-sm rounded-full <?php echo ($i == $page) ? 'bg-gray-200' : ''; ?> dark:text-white dark:hover:bg-white/10" aria-current="<?php echo ($i == $page) ? 'page' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php } ?>
                        <a href="?page=<?php echo min($total_pages, $page + 1); ?>" class="p-2.5 inline-flex items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" aria-label="Next">
                            <span aria-hidden="true">»</span>
                        </a>
                        <a href="?page=<?php echo $total_pages; ?>" class="p-2.5 inline-flex items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" aria-label="Last Page">
                            <span aria-hidden="true">»»</span>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>