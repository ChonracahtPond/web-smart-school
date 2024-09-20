<?php

// ดึงข้อมูลการสอบทั้งหมด
$sql = "SELECT e.exam_id, e.enrollment_id, e.exam_type, e.exam_date, e.duration, e.total_marks, e.created_at, e.updated_at, e.student_id, e.score, s.student_name AS student_name, en.course_id
        FROM exams e
        JOIN students s ON e.student_id = s.student_id
        JOIN enrollments en ON e.enrollment_id = en.enrollment_id";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("เกิดข้อผิดพลาดในการเตรียมคำสั่ง: " . $conn->error);
}

$stmt->execute();
$result = $stmt->get_result();

?>

<div class="mx-auto px-2">
    <h1 class="flex items-center font-sans font-bold break-normal text-indigo-500 px-2 py-8 text-xl md:text-2xl">
        จัดการการสอบกลางภาคปลายภาค
    </h1>


    <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
        <div class="flex justify-start mb-4">
            <button id="openModal" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">เพิ่มข้อมูลการสอบ</button>
        </div>




        <table id="examTable" class="stripe hover text-center" style="width:100%;">
            <thead>
                <tr>
                    <th>รหัสการสอบ</th>
                    <th>รหัสการลงทะเบียน</th>
                    <th>ชื่อผู้เรียน</th>
                    <th>ประเภทการสอบ</th>
                    <th>วันที่สอบ</th>
                    <th>ระยะเวลา</th>
                    <th>คะแนนเต็ม</th>
                    <th>คะแนน</th>
                    <th>การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['exam_id']; ?></td>
                            <td><?php echo $row['enrollment_id']; ?></td>
                            <td><?php echo $row['student_name']; ?></td>
                            <td><?php echo $row['exam_type']; ?></td>
                            <td><?php echo $row['exam_date']; ?></td>
                            <td><?php echo $row['duration']; ?></td>
                            <td><?php echo $row['total_marks']; ?></td>
                            <td><?php echo $row['score']; ?></td>
                            <td>
                                <a href="edit_exam.php?id=<?php echo $row['exam_id']; ?>" class="text-blue-500">แก้ไข</a> |
                                <a href="delete_exam.php?id=<?php echo $row['exam_id']; ?>" class="text-red-500">ลบ</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">ไม่พบข้อมูล</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>รหัสการสอบ</th>
                    <th>รหัสการลงทะเบียน</th>
                    <th>ชื่อผู้เรียน</th>
                    <th>ประเภทการสอบ</th>
                    <th>วันที่สอบ</th>
                    <th>ระยะเวลา</th>
                    <th>คะแนนเต็ม</th>
                    <th>คะแนน</th>
                    <th>การดำเนินการ</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<?php include "modal/add_exams.php"; ?>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        $('#examTable').DataTable({
            responsive: true
        });
    });
</script>
<script>
    document.getElementById('openModal').onclick = function() {
        document.getElementById('addExamModal').classList.remove('hidden');
    }

    document.getElementById('closeModal').onclick = function() {
        document.getElementById('addExamModal').classList.add('hidden');
    }

    document.getElementById('addExamForm').onsubmit = function(e) {
        e.preventDefault();
        // ที่นี่คุณสามารถจัดการส่งข้อมูลไปยังเซิร์ฟเวอร์ได้
        alert("ข้อมูลการสอบถูกเพิ่มเรียบร้อยแล้ว!");
        // ปิด modal หลังจากบันทึกข้อมูล
        document.getElementById('addExamModal').classList.add('hidden');
    }
</script>