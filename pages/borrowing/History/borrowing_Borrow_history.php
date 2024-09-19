<link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
<style>
    /* Overrides for Tailwind CSS */
    .dataTables_wrapper select,
    .dataTables_wrapper input {
        color: #4a5568;
        padding-left: 1rem;
        padding-right: 1rem;
        padding-top: .5rem;
        padding-bottom: .5rem;
        line-height: 1.25;
        border-width: 2px;
        border-radius: .25rem;
        border-color: #edf2f7;
        background-color: #edf2f7;
        width: 100px;
    }



    .dataTables_filter input {
        color: #4a5568;
        padding-left: 1rem;
        padding-right: 1rem;
        padding-top: .5rem;
        padding-bottom: .5rem;
        line-height: 1.25;
        border-width: 2px;
        border-radius: .25rem;
        border-color: #edf2f7;
        background-color: #edf2f7;
        width: 500px;
    }




    table.dataTable.hover tbody tr:hover,
    table.dataTable.display tbody tr:hover {
        background-color: #ebf4ff;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        font-weight: 700;
        border-radius: .25rem;
        border: 1px solid transparent;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        color: #fff !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
        font-weight: 700;
        border-radius: .25rem;
        background: #667eea !important;
        border: 1px solid transparent;
        /* width: 500px; */
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        color: #fff !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
        font-weight: 700;
        border-radius: .25rem;
        background: #667eea !important;
        border: 1px solid transparent;
        /* width: 500px; */
    }

    table.dataTable.no-footer {
        border-bottom: 1px solid #e2e8f0;
        margin-top: 0.75em;
        margin-bottom: 0.75em;
    }

    table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before,
    table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before {
        background-color: #667eea !important;
    }
</style>




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
$sql = "SELECT * FROM (
            SELECT b.borrowing_id AS borrowing_id, u.first_name, u.last_name, i.item_name, b.quantity, b.return_quantity, b.borrowed_at, 'ยืม-คืน' AS status
            FROM borrowings b
            JOIN items i ON b.item_id = i.item_id
            JOIN users u ON b.user_id = u.user_id
            UNION ALL
            SELECT p.permanent_borrowing_id AS borrowing_id, u.first_name, u.last_name, i.item_name, p.quantity, NULL AS return_quantity, p.borrowed_at, 'เบิก' AS status
            FROM permanent_borrowings p
            JOIN items i ON p.item_id = i.item_id
            JOIN users u ON p.user_id = u.user_id
        ) AS all_borrowings
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

<div class="mx-auto px-2">
    <h1 class="flex items-center font-sans font-bold break-normal text-indigo-500 px-2 py-8 text-xl md:text-2xl">
        ประวัติการยืม
    </h1>

    <!-- Date Range Form -->
    <form method="get" action="../mpdf/History/History_Report.php" target="_blank" class="mb-6">
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

    <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
        <table id="example" class="display stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
            <thead>
                <tr>
                    <th>No</th>
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
                    <?php $counter = 1; ?>
                    <?php foreach ($borrowings as $borrowing) {
                        $status_class = $borrowing['status'] == 'ยืม-คืน' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800';
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $counter; ?></td>
                            <td><?php echo htmlspecialchars($borrowing['first_name'] . ' ' . $borrowing['last_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($borrowing['item_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($borrowing['quantity'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($borrowing['return_quantity'] ?? 'ไม่ต้องคืน', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($borrowing['borrowed_at'])), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="<?php echo $status_class; ?>"><?php echo htmlspecialchars($borrowing['status'], ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                        <?php $counter++; ?>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="7" class="py-2 px-4 text-center">ไม่มีข้อมูลการยืม</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            responsive: true
        });
    });
</script>