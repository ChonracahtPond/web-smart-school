<?php
// ตรวจสอบว่ามีการส่งคำค้นหามาหรือไม่
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง courses พร้อมการค้นหา และเรียงลำดับจากใหม่ไปเก่า
$sql = "SELECT c.course_id, c.course_name, c.course_description, c.teacher_id, c.course_type, c.course_code, c.credits, c.semester, c.academic_year, c.status, t.teacher_name
        FROM courses c
        LEFT JOIN teachers t ON c.teacher_id = t.teacher_id
        WHERE c.course_name LIKE ? OR c.course_description LIKE ? OR t.teacher_name LIKE ?
        ORDER BY c.course_id DESC";

// เตรียมการค้นหาข้อมูล
$searchTerm = "%$search%";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
<style>
    .dataTables_wrapper .dataTables_filter input {
        border-color: #edf2f7;
        background-color: #edf2f7;
    }

    table.dataTable.no-footer {
        border-bottom: 1px solid #e2e8f0;
    }

    .clickable-row {
        cursor: pointer;
    }
</style>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">จัดการรายวิชา</h1>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <!-- ปุ่มเปิด Modal -->
        <button id="openModal" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 mb-4">+ เพิ่มรายวิชาใหม่</button>

        <button id="exportReport" class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-green-600 mb-4">ออกรายงาน PDF</button>

        <!-- ฟอร์มค้นหา -->
        <form method="GET" action="" class="mb-4">
            <div class="flex items-center">
                <input id="search-input" type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="ค้นหาตามชื่อรายวิชา คำอธิบาย หรืออาจารย์">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 ml-2">ค้นหา</button>
            </div>
        </form>
        <p class="text-red-400">**คลิกที่รายวิชาเพื่อดูรายละเอียดรายวิชา**</p>
        <table id="courses-table" class="display stripe hover w-full" style="width:100%;">
            <thead>
                <tr>
                    <th>รหัสรายวิชา</th>
                    <th>ชื่อรายวิชา</th>
                    <th>คำอธิบาย</th>
                    <th>ชื่อครู</th>
                    <th>ประเภท</th>
                    <th>รหัสรายวิชา</th>
                    <th>หน่วยกิจ</th>
                    <th>ภาคเรียน</th>
                    <th>ปีการศึกษา</th>
                    <th>สถานะ</th>
                    <th>การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr class="clickable-row" data-href="?page=course_details&course_id=<?php echo htmlspecialchars($row['course_id']); ?>">
                            <td><?php echo htmlspecialchars($row['course_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['course_description']); ?></td>
                            <td><?php echo htmlspecialchars($row['teacher_name']); ?></td>
                            <td><?php echo ($row['course_type'] === 'mandatory') ? 'บังคับ' : 'วิชาเลือก'; ?></td>
                            <td><?php echo htmlspecialchars($row['course_code']); ?></td>
                            <td><?php echo htmlspecialchars($row['credits']); ?></td>
                            <td><?php echo htmlspecialchars($row['semester']); ?></td>
                            <td><?php echo htmlspecialchars($row['academic_year']); ?></td>
                            <td>
                                <?php
                                $status = htmlspecialchars($row['status']);
                                echo ($status == 1) ? '<span class="text-green-500">กำลังทำงาน</span>' : '<span class="text-red-500">ไม่ได้ใช้งาน</span>';
                                ?>
                            </td>
                            <td>
                                <a href="?page=edit_course&id=<?php echo htmlspecialchars($row['course_id']); ?>" class="text-blue-500 hover:text-blue-700">แก้ไข</a> |
                                <a href="?page=delete_course&id=<?php echo htmlspecialchars($row['course_id']); ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this course?')">ลบ</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="11" class="px-4 py-2 text-center">ไม่มีข้อมูล</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include "add_course.php"; ?>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- Datatables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        $('#courses-table').DataTable({
            responsive: true
        });

        // JavaScript สำหรับเปิดและปิด Modal
        $('#openModal').click(function() {
            $('#courseModal').removeClass('hidden');
        });

        $('#closeModal').click(function() {
            $('#courseModal').addClass('hidden');
        });

        // JavaScript สำหรับทำให้แถวของตารางคลิกได้
        $('.clickable-row').click(function() {
            window.location = $(this).data('href');
        });
    });
</script>
<script>
    // JavaScript สำหรับการค้นหาแบบเรียลไทม์
    document.getElementById('search-input').addEventListener('input', function() {
        const searchQuery = this.value.toLowerCase();
        const table = document.getElementById('courses-table');
        const rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const cells = row.getElementsByTagName('td');
            const matches = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(searchQuery));
            row.style.display = matches ? '' : 'none';
        });
    });
</script>
<script>
    document.getElementById('exportReport').addEventListener('click', function() {
        const searchQuery = document.getElementById('search-input').value;
        window.location.href = '../mpdf/courses/Manage_courses.php?search=' + encodeURIComponent(searchQuery);
    });
</script>