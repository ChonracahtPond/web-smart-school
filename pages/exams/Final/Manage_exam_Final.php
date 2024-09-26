<?php

// รับค่าจาก query string
$startDate = $_GET['start_date'] ?? null;
$endDate = $_GET['end_date'] ?? null;

// สร้าง SQL query
$sql = "SELECT e.exam_id, e.enrollment_id, e.exam_type, e.exam_date, e.total_marks, e.created_at, e.updated_at, 
                e.student_id, e.score, e.exams_status,e.criterion, s.student_name, en.course_id , c.course_name ,e.term , e.year
        FROM exams e
        JOIN students s ON e.student_id = s.student_id
        JOIN enrollments en ON e.enrollment_id = en.enrollment_id
        JOIN courses c ON en.course_id = c.course_id
        WHERE e.exam_type = 'ปลายภาค'
        ";

if ($startDate && $endDate) {
    $sql .= " WHERE e.created_at BETWEEN ? AND ?";
}

$stmt = $conn->prepare($sql);
if ($startDate && $endDate) {
    $stmt->bind_param("ss", $startDate, $endDate);
}

$stmt->execute();
$result = $stmt->get_result();


?>

<div>

    <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
        <!-- <h1 class="flex items-center font-sans font-bold break-normal text-indigo-500 px-2 py-8 text-xl md:text-2xl">
        จัดการการสอบปลายภาค
    </h1> -->

        <h1 class="text-3xl font-semibold text-indigo-500 dark:text-white mb-4">จัดการการสอบปลายภาค</h1>

        <div class="flex justify-between items-center mb-4">
            <div class="flex space-x-4">
                <!-- <button id="openModal" class="flex items-center bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">
                    <svg class="w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    เพิ่มข้อมูลการสอบ
                </button> -->
                <a href="?page=add_exams_Final" class="flex items-center bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">
                    <svg class="w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>

                    เพิ่มข้อมูลการสอบ</a>
                <button id="importExcelModalBtn" class="flex items-center bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-green-600">
                    <svg class="w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    นำเข้าข้อมูลด้วย Excel
                </button>
                <button id="exportExcelBtn" class="flex items-center bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-green-600">
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
                <button id="exportPdfBtn" class="flex items-center bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-yellow-600">
                    <svg class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                    ออกรายงานเป็น PDF
                </button>
            </div>

            <div class="flex items-center text-red-400">
                <svg class="h-5 w-5 mr-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <path d="M19 18a3.5 3.5 0 0 0 0 -7h-1a5 4.5 0 0 0 -11 -2a4.6 4.4 0 0 0 -2.1 8.4" />
                    <line x1="12" y1="13" x2="12" y2="22" />
                    <polyline points="9 19 12 22 15 19" />
                </svg>
                <a href="../exports/exams/download_excel.php" class="text-red-500" download>ดาวน์โหลดฟอร์ม Excel</a>
            </div>
        </div>

        <div class="bg-gray-200 w-full h-0.5 my-5"></div>

        <table id="examTable" class="stripe hover text-center" style="width:100%;">
            <thead class="text-white" style="background-color: <?php echo htmlspecialchars($tool_color); ?>;">
                <tr>
                    <th>No</th> <!-- เปลี่ยนจาก "รหัสการสอบ" เป็น "No" -->
                    <th>ชื่อผู้เรียน</th>
                    <th>รหัสรายวิชา</th>
                    <th>ชื่อวิชา</th>
                    <th>วันที่สอบ</th>
                    <th>เทอม</th>
                    <th>ปีการศึกษา</th>
                    <th>คะแนนเต็ม</th>
                    <th>เกณฑ์การผ่าน</th>
                    <th>คะแนน</th>
                    <th>สถานะ</th>
                    <th>การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php $no = 1; // เริ่มนับจาก 1 
                    ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $no++; // แสดงหมายเลข 
                                ?></td> <!-- แสดงหมายเลข -->
                            <td><?php echo $row['student_name']; ?></td>
                            <td><?php echo $row['course_id']; ?></td>
                            <td><?php echo $row['course_name']; ?></td>
                            <td><?php echo $row['exam_date']; ?></td>
                            <td><?php echo $row['term']; ?></td>
                            <td><?php echo $row['year']; ?></td>
                            <td><?php echo $row['total_marks']; ?></td>
                            <td><?php echo $row['criterion']; ?></td>
                            <td><?php echo $row['score']; ?></td>
                            <td class="<?php echo $row['exams_status'] === 'ผ่าน' ? 'text-green-500' : 'text-red-500'; ?>">
                                <?php echo $row['exams_status']; ?>
                            </td>

                            <td class="flex justify-center space-x-2">
                                <!-- <button id="openeditExamModal" class="bg-blue-500 text-white font-bold h-10 w-18 py-1 px-2 rounded hover:bg-blue-600 transition duration-200 flex items-center"> -->
                                <a href="?page=edit_exam_Final&id=<?php echo $row['exam_id']; ?>" class="bg-blue-500 text-white font-bold h-10 w-18 py-1 px-2 rounded hover:bg-blue-600 transition duration-200 flex items-center">
                                    <svg class="h-5 w-5 mr-1" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                                        <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
                                        <line x1="16" y1="5" x2="19" y2="8" />
                                    </svg>
                                    แก้ไข
                                </a>

                                <!-- <a href="#" onclick="openModal(<?php echo $exam['exam_id']; ?>)" class="bg-blue-500 text-white font-bold h-10 w-18 py-1 px-2 rounded hover:bg-blue-600 transition duration-200 flex items-center">Edit</a> -->
                                <a href="?page=delete_exam_Final&id=<?php echo $row['exam_id']; ?>" class="bg-red-500 text-white font-bold py-1 px-2 rounded hover:bg-red-600 transition duration-200 flex items-center h-10 w-18" onclick="return confirm('คุณแน่ใจหรือไม่ว่าจะลบการลงทะเบียนนี้?')">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="4" y1="7" x2="20" y2="7" />
                                        <line x1="10" y1="11" x2="10" y2="17" />
                                        <line x1="14" y1="11" x2="14" y2="17" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                    ลบ
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">ไม่พบข้อมูล</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot class="text-white" style="background-color: <?php echo htmlspecialchars($tool_color); ?>;">
                <tr>
                    <th>No</th> <!-- เปลี่ยนจาก "รหัสการสอบ" เป็น "No" -->
                    <th>ชื่อผู้เรียน</th>
                    <th>รหัสรายวิชา</th>
                    <th>ชื่อวิชา</th>
                    <th>วันที่สอบ</th>
                    <th>เทอม</th>
                    <th>ปีการศึกษา</th>
                    <th>คะแนนเต็ม</th>
                    <th>เกณฑ์การผ่าน</th>
                    <th>คะแนน</th>
                    <th>สถานะ</th>
                    <th>การดำเนินการ</th>
                </tr>
            </tfoot>
        </table>

    </div>
</div>

<?php include "modal/add_exams_modal.php"; ?>
<?php include "modal/import_Manage_exam_Midterm_modal.php"; ?>
<?php include "modal/export_exams_modal.php"; ?>
<?php include "modal/export_pdf_modal.php"; ?>
<?php include "modal/export_pdf_modal.php"; ?>





<!-- jQuery & DataTables -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#examTable').DataTable({
            responsive: true
        });

        $('#openModal').click(function() {
            $('#addExamModal').removeClass('hidden');
        });

        $('#closeModal').click(function() {
            $('#addExamModal').addClass('hidden');
        });

        $('#addExamForm').submit(function(e) {
            e.preventDefault();
            alert("ข้อมูลการสอบถูกเพิ่มเรียบร้อยแล้ว!");
            $('#addExamModal').addClass('hidden');
        });
    });



    $('#importExcelModalBtn').click(function() {
        $('#importExcelModal').removeClass('hidden');
    });

    $('#closeImportModal').click(function() {
        $('#importExcelModal').addClass('hidden');
    });

    $('#exportExcelBtn').click(function() {
        $('#exportDateModal').removeClass('hidden'); // แสดง modal
    });

    $('#closeExportModal').click(function() {
        $('#exportDateModal').addClass('hidden'); // ปิด modal
    });
</script>