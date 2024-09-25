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

<div class="">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 ">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-5">ระบบจัดการรายวิชา</h1>

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
        <p class="text-red-400 mb-5">**คลิกที่รายวิชาเพื่อดูรายละเอียดรายวิชา**</p>
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
                    <th>สถานะ</th>
                    <th>การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <!-- <tr class="clickable-row" data-href="?page=course_details&course_id=<?php echo htmlspecialchars($row['course_id']); ?>"> -->
                        <tr>
                            <td><?php echo htmlspecialchars($row['course_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['course_description']); ?></td>
                            <td><?php echo htmlspecialchars($row['teacher_name']); ?></td>
                            <td><?php echo ($row['course_type'] === 'mandatory') ? 'บังคับ' : 'วิชาเลือก'; ?></td>
                            <td><?php echo htmlspecialchars($row['course_code']); ?></td>
                            <td><?php echo htmlspecialchars($row['credits']); ?></td>
                            <!-- <td><?php echo htmlspecialchars($row['semester']); ?></td>
                            <td><?php echo htmlspecialchars($row['academic_year']); ?></td> -->
                            <td>
                                <?php
                                $status = htmlspecialchars($row['status']);
                                echo ($status == 1) ? '<span class="text-green-500">กำลังใช้งาน</span>' : '<span class="text-red-500">ยังไม่เปิดใช้งาน</span>';
                                ?>
                            </td>
                            <td class="flex items-center space-x-4">
                                <!-- ปุ่มสถานะ -->
                                <button onclick="window.location.href='?page=course_details_approve&course_id=<?php echo htmlspecialchars($row['course_id']); ?>'" class="flex items-center space-x-2 px-3 py-1 text-white font-semibold rounded-lg 
                                 <?php echo ($status == 1) ? '' : 'bg-blue-500 hover:bg-blue-600'; ?>">
                                    <?php
                                    $status = htmlspecialchars($row['status']);
                                    if ($status == 1) {
                                        // echo '<i class="fas fa-times-circle"></i> <span>เปิดใช้งาน</span>';

                                    } else {
                                        echo '<svg class="h-5 w-5 "  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            <span>เปิดใช้งาน</span>';
                                        echo '<a href=""></a>';
                                    }
                                    ?>
                                </button>

                                <!-- ปุ่มแก้ไข -->
                                <button onclick="window.location.href='?page=edit_course&id=<?php echo htmlspecialchars($row['course_id']); ?>'"
                                    class="flex items-center space-x-2 bg-yellow-500 text-white hover:text-gray-400 px-3 py-1 rounded-lg hover:bg-yellow-100 transition duration-200">
                                    <svg class="h-5 w-5 " viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                                        <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
                                        <line x1="16" y1="5" x2="19" y2="8" />
                                    </svg>
                                    <span>แก้ไข</span>
                                </button>

                                <!-- ปุ่มลบ -->
                                <button onclick="if(confirm('Are you sure you want to delete this course?')) { window.location.href='?page=delete_course&id=<?php echo htmlspecialchars($row['course_id']); ?>'; }"
                                    class="flex items-center space-x-2 bg-red-500 text-white hover:text-white-700 px-3 py-1 rounded-lg hover:bg-red-100 transition duration-200">
                                    <svg class="h-5 w-5 " width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <line x1="4" y1="7" x2="20" y2="7" />
                                        <line x1="10" y1="11" x2="10" y2="17" />
                                        <line x1="14" y1="11" x2="14" y2="17" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                    <span>ลบ</span>
                                </button>
                            </td>


                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="11" class="px-4 py-2 text-center">ไม่มีข้อมูล</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>รหัสรายวิชา</th>
                    <th>ชื่อรายวิชา</th>
                    <th>คำอธิบาย</th>
                    <th>ชื่อครู</th>
                    <th>ประเภท</th>
                    <th>รหัสรายวิชา</th>
                    <th>หน่วยกิจ</th>
                    <th>สถานะ</th>
                    <th>การดำเนินการ</th>
                </tr>
            </tfoot>
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