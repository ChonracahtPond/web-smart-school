<?php
// ดึงข้อมูลนักเรียนที่มีสิทธิสอบ
$sql = "SELECT es.eligible_students_id, es.student_id, es.enrollment_id, es.exam_id, es.created_at AS date_time, s.student_name , el.course_id 
        FROM eligible_students es
        JOIN students s ON es.student_id = s.student_id
        JOIN enrollments el ON es.enrollment_id = el.enrollment_id
        JOIN courses c ON el.course_id = c.course_id";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("เกิดข้อผิดพลาดในการเตรียมคำสั่ง: " . $conn->error);
}
$stmt->execute();
$result = $stmt->get_result();

// ดึงข้อมูลนักเรียน
$studentsSql = "SELECT student_id, student_name FROM students";
$studentsStmt = $conn->prepare($studentsSql);
if (!$studentsStmt) {
    die("เกิดข้อผิดพลาดในการเตรียมคำสั่ง: " . $conn->error);
}
$studentsStmt->execute();
$studentsResult = $studentsStmt->get_result();

// ดึงข้อมูลการลงทะเบียน
$enrollmentsSql = "SELECT enrollment_id, student_id FROM enrollments";
$enrollmentsStmt = $conn->prepare($enrollmentsSql);
if (!$enrollmentsStmt) {
    die("เกิดข้อผิดพลาดในการเตรียมคำสั่ง: " . $conn->error);
}
$enrollmentsStmt->execute();
$enrollmentsResult = $enrollmentsStmt->get_result();

// สร้างอาร์เรย์เพื่อเก็บข้อมูลการลงทะเบียนตามนักเรียน
$enrollmentsData = [];
while ($enrollment = $enrollmentsResult->fetch_assoc()) {
    $enrollmentsData[$enrollment['student_id']][] = [
        'enrollment_id' => $enrollment['enrollment_id'],
    ];
}

// ตรวจสอบผลลัพธ์
if ($result->num_rows === 0) {
    echo "<p class='text-center text-red-500'>ไม่พบข้อมูลนักเรียนที่มีสิทธิสอบ</p>";
}
?>

<div class="mx-auto px-2">
    <h1 class="flex items-center font-sans font-bold break-normal text-indigo-500 px-2 py-8 text-xl md:text-2xl">
        <i class="fas fa-user-graduate mr-2"></i>นักเรียนที่มีสิทธิสอบ
    </h1>



    <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
        <table id="eligibleStudentsTable" class="stripe hover text-center" style="width:100%;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>รหัสนักเรียน</th>
                    <th>ชื่อผู้เรียน</th>
                    <th>รหัสการลงทะเบียน</th>
                    <th>รหัสการสอบ</th>
                    <th>วันที่และเวลา</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['eligible_students_id']; ?></td>
                            <td><?php echo $row['student_id']; ?></td>
                            <td><?php echo $row['student_name']; ?></td>
                            <td><?php echo $row['enrollment_id']; ?></td>
                            <td><?php echo $row['exam_id']; ?></td>
                            <td><?php echo $row['date_time']; ?></td>
                            <td>
                                <button class="bg-blue-500 text-white font-bold py-1 px-2 rounded hover:bg-blue-600 transition duration-200">
                                    <i class="fas fa-edit"></i> แก้ไข
                                </button>
                                <button class="bg-red-500 text-white font-bold py-1 px-2 rounded hover:bg-red-600 transition duration-200" onclick="deleteStudent(<?php echo $row['eligible_students_id']; ?>)">
                                    <i class="fas fa-trash"></i> ลบ
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">ไม่พบข้อมูล</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>รหัสนักเรียน</th>
                    <th>รหัสการลงทะเบียน</th>
                    <th>รหัสการสอบ</th>
                    <th>วันที่และเวลา</th>
                    <th>ชื่อผู้เรียน</th>
                    <th>จัดการ</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<?php include "modal/add_eligible_students.php"; ?>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        $('#eligibleStudentsTable').DataTable({
            responsive: true
        });

        $('#studentId').change(function() {
            var studentId = $(this).val();
            var enrollments = <?php echo json_encode($enrollmentsData); ?>;

            // ล้างตัวเลือกการลงทะเบียน
            $('#enrollmentId').empty().append('<option value="">เลือกการลงทะเบียน</option>');

            // ตรวจสอบว่ามีข้อมูลการลงทะเบียนสำหรับนักเรียนที่เลือก
            if (studentId in enrollments) {
                enrollments[studentId].forEach(function(enrollment) {
                    $('#enrollmentId').append('<option value="' + enrollment.enrollment_id + '">' + enrollment.course_name + '</option>');
                });
            }
        });
    });
</script>