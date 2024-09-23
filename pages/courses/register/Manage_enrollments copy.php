<?php
// ตรวจสอบว่ามีการส่งคำค้นหามาหรือไม่
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;

// คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง enrollments พร้อมการค้นหาและกรองตามวันที่
$sql = "SELECT e.enrollment_id, e.semester, e.academic_year, e.grade, e.status, e.teacher_id, c.course_name, c.course_id, s.student_name, t.teacher_name
        FROM enrollments e
        LEFT JOIN courses c ON e.course_id = c.course_id
        LEFT JOIN students s ON e.student_id = s.student_id
        LEFT JOIN teachers t ON e.teacher_id = t.teacher_id
        WHERE (c.course_name LIKE ? OR s.student_name LIKE ? OR t.teacher_name LIKE ?)";

if ($startDate && $endDate) {
    $sql .= " AND e.created_at BETWEEN ? AND ?";
}

// เพิ่มการเรียงลำดับ
$sql .= " ORDER BY e.enrollment_id DESC";

// เตรียมการค้นหาข้อมูล
$searchTerm = "%$search%";
$stmt = $conn->prepare($sql);

if ($startDate && $endDate) {
    $stmt->bind_param('sssss', $searchTerm, $searchTerm, $searchTerm, $startDate, $endDate);
} else {
    $stmt->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);
}

$stmt->execute();
$result = $stmt->get_result();
?>


<div class="mx-auto px-2">
    <h1 class="flex items-center font-sans font-bold break-normal text-indigo-500 px-2 py-8 text-xl md:text-2xl">
        จัดการการลงทะเบียน
    </h1>

    <div id='recipients' class="p-8 mt-6 mb-10 lg:mt-0 rounded shadow bg-white">
        <div class="flex mb-5 col-4 justify-start">
            <button id="openModalButton" class="flex items-center bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 mr-4">
                <svg class="w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                เพิ่มการลงทะเบียนใหม่
            </button>

            <button id="importExcelButton" class="flex items-center bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-green-600 mr-4">
                <svg class="w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                นำเข้าข้อมูลจากไฟล์ Excel
            </button>

            <button onclick="openModal()" class="flex items-center bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-green-600 mr-4">
                <svg class="h-5 w-5 mr-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    <line x1="9" y1="9" x2="10" y2="9" />
                    <line x1="9" y1="13" x2="15" y2="13" />
                    <line x1="9" y1="17" x2="15" y2="17" />
                </svg>
                ส่งออกข้อมูลเป็น Excel
            </button>

            <button id="exportPdfButton" class="flex items-center bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-yellow-600 mr-4">
                <svg class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
                ออกรายงานเป็น PDF
            </button>
        </div>


        <p class="text-red-500 mb-5">**คลิกที่รายวิชาเพื่อดูรายละเอียดรายวิชา**</p>
        <table id="enrollments-table" class="stripe hover " style="width:100%; padding-top: 1em; padding-bottom: 1em;">
            <thead>
                <tr>
                    <th>ลำดับ</th> <!-- เปลี่ยนชื่อหัวข้อ -->
                    <th>ชื่อรายวิชา</th>
                    <th>ชื่อนักเรียน</th>
                    <th>ชื่ออาจารย์</th>
                    <th>ภาคเรียน</th>
                    <th>ปีการศึกษา</th>
                    <th>สถานะ</th>
                    <th>การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php $no = 1; // ตัวนับเริ่มต้น 
                    ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr class="clickable-row" data-href="?page=enrollment_details&course_id=<?php echo htmlspecialchars($row['course_id']); ?>">
                            <!-- <tr class="clickable-row" data-href="?page=enrollment_details&enrollment_id=<?php echo htmlspecialchars($row['enrollment_id']); ?>"> -->
                            <td><?php echo $no++; // แสดงลำดับและเพิ่มค่าขึ้น 
                                ?></td>
                            <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['teacher_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['semester']); ?></td>
                            <td><?php echo htmlspecialchars($row['academic_year']); ?></td>
                            <td><?php echo ($row['status'] == 1) ? '<span class="text-green-500">กำลังศึกษา</span>' : '<span class="text-red-500">ยกเลิก</span>'; ?></td>
                            <td>
                                <a href="?page=edit_enrollment&id=<?php echo htmlspecialchars($row['enrollment_id']); ?>" class="text-blue-500 hover:text-blue-700">แก้ไข</a> |
                                <a href="?page=delete_enrollment&id=<?php echo htmlspecialchars($row['enrollment_id']); ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('คุณแน่ใจหรือไม่ว่าจะลบการลงทะเบียนนี้?')">ลบ</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" class="px-4 py-2 text-center">ไม่มีข้อมูล</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        </table>
    </div>
</div>

<?php include "modal/modaladd_enrollment.php"; ?>
<?php include "modal/import_excel.php"; ?>
<?php include "modal/export_excel.php"; ?>
<?php include "modal/export_pdf.php"; ?>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#enrollments-table').DataTable({
            responsive: true
        });
        $('.clickable-row').click(function() {
            window.location = $(this).data('href');
        });
    });

    // Modal functionality for adding enrollment
    var modalAdd = document.getElementById("myModaladdEnrollment");
    var openModalButton = document.getElementById("openModalButton");
    var closeButtonAdd = modalAdd.getElementsByClassName("close")[0];

    openModalButton.onclick = function() {
        modalAdd.style.display = "block";
    }

    closeButtonAdd.onclick = function() {
        modalAdd.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modalAdd) {
            modalAdd.style.display = "none";
        }
    }
</script>

<script>
    // Modal functionality for import Excel
    var modalImport = document.getElementById("importModal");
    var importExcelButton = document.getElementById("importExcelButton");
    var closeButtonImport = modalImport.getElementsByClassName("close")[0];

    importExcelButton.onclick = function() {
        modalImport.classList.remove("hidden"); // แสดง modal
    }

    closeButtonImport.onclick = function() {
        modalImport.classList.add("hidden"); // ซ่อน modal
    }

    window.onclick = function(event) {
        if (event.target == modalImport) {
            modalImport.classList.add("hidden"); // ซ่อน modal ถ้าคลิกนอก modal
        }
    }
</script>