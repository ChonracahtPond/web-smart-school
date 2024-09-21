<?php
// ดึงข้อมูลนักเรียนที่มีสิทธิสอบ
$sql = "SELECT es.eligible_students_id, es.student_id, es.enrollment_id, es.exam_id, es.created_at AS date_time, s.student_name 
        FROM eligible_students es
        JOIN students s ON es.student_id = s.student_id
        JOIN enrollments el ON es.enrollment_id = el.enrollment_id";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("เกิดข้อผิดพลาดในการเตรียมคำสั่ง: " . $conn->error);
}
$stmt->execute();
$result = $stmt->get_result();

// ตรวจสอบผลลัพธ์
if ($result->num_rows === 0) {
    echo "<p class='text-center text-red-500'>ไม่พบข้อมูลนักเรียนที่มีสิทธิสอบ</p>";
}
?>

<div class="mx-auto px-4">
    <h1 class="flex items-center font-sans font-bold text-indigo-500 px-2 py-8 text-xl md:text-2xl">
        <i class="fas fa-user-graduate mr-2"></i>นักเรียนที่มีสิทธิสอบ
    </h1>

    <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded-lg shadow bg-white">
        <?php include "modal/add_eligible_students.php"; ?>

        <table id="eligibleStudentsTable" class="stripe hover text-center" style="width:100%;">
            <thead class="text-white" style="background-color: <?php echo htmlspecialchars($tool_color); ?>;">
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
                    <?php $no = 1; ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row['student_id']; ?></td>
                            <td><?php echo $row['student_name']; ?></td>
                            <td><?php echo $row['enrollment_id']; ?></td>
                            <td><?php echo $row['exam_id']; ?></td>
                            <td><?php echo $row['date_time']; ?></td>
                            <td class="flex justify-center space-x-2">

                                <a href="?page=edit_eligible_students&id=<?php echo $row['eligible_students_id']; ?>" class="bg-blue-500 text-white font-bold h-10 w-18 py-1 px-2 rounded hover:bg-blue-600 transition duration-200 flex items-center">
                                    <svg class="h-5 w-5 mr-1" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                                        <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
                                        <line x1="16" y1="5" x2="19" y2="8" />
                                    </svg>
                                    แก้ไข
                                </a>
                                <a href="?page=delete_eligible_students&id=<?php echo htmlspecialchars($row['eligible_students_id']); ?>" class="bg-red-500 text-white font-bold py-1 px-2 rounded hover:bg-red-600 transition duration-200 flex items-center h-10 w-18" onclick="return confirm('คุณแน่ใจหรือไม่ว่าจะลบการลงทะเบียนนี้?')">
                                    <svg class="h-5 w-5 " width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
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
                        <td colspan="7" class="text-center">ไม่พบข้อมูล</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot class="text-white" style="background-color: <?php echo htmlspecialchars($tool_color); ?>;">
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

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#eligibleStudentsTable').DataTable({
            responsive: true
        });
    });
</script>