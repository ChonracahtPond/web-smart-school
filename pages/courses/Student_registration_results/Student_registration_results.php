<?php
// ดึงข้อมูลจากตาราง enrollments, students และ courses
$sql = "
SELECT e.enrollment_id, e.student_id, s.student_name,s.status , s.grade_level, e.course_id, c.course_name, 
       e.semester, e.academic_year, e.grade, e.status, e.teacher_id, e.class, e.credits 
FROM enrollments e
JOIN students s ON e.student_id = s.student_id
JOIN courses c ON e.course_id = c.course_id
WHERE s.status = '0'
ORDER BY e.student_id, e.grade ASC
"; // เรียงลำดับตาม student_id และเกรด

$result = mysqli_query($conn, $sql);

// ตรวจสอบว่ามีผลลัพธ์หรือไม่
if (!$result) {
    echo "เกิดข้อผิดพลาดในการดึงข้อมูล: " . mysqli_error($conn);
    exit;
}

// จัดกลุ่มข้อมูลตาม student_id
$groupedData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $studentId = $row['student_id'];
    if (!isset($groupedData[$studentId])) {
        $groupedData[$studentId] = [
            'student_name' => $row['student_name'],
            'grade_level' => $row['grade_level'],
        ];
    }
}

// เริ่มสร้างหน้า HTML
?>

<div class="mx-auto px-2 mt-5">
    <h1 class="flex items-center font-sans font-bold break-normal text-indigo-500 px-2 py-8 text-xl md:text-2xl">
        ผลการลงทะเบียนเรียน
    </h1>

    <div class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
        <table id="example" class="stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
            <thead class="text-white" style="background-color: <?php echo htmlspecialchars($tool_color); ?>;">
                <tr>
                    <th>รหัสนักศึกษา</th>
                    <th>ชื่อขนามสกุล</th>
                    <th>ระดับชั้น</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // แสดงข้อมูล
                if (count($groupedData) > 0) {
                    foreach ($groupedData as $studentId => $studentData) {
                        echo "<tr>";
                        echo "<td>{$studentId}</td>";
                        echo "<td>{$studentData['student_name']}</td>";
                        echo "<td>{$studentData['grade_level']}</td>";
                        echo "<td class='flex justify-center space-x-2'>";
                        echo "<a href='?page=detail_Student_registration_results&id={$studentId}' class='bg-blue-500 text-white font-bold py-1 px-2 rounded hover:bg-blue-600 transition duration-200'>ดูรายละเอียด</a>";
                        // echo "<a href='?page=delete_student&id={$studentId}' class='bg-red-500 text-white font-bold py-1 px-2 rounded hover:bg-red-600 transition duration-200' onclick=\"return confirm('คุณแน่ใจหรือไม่ว่าจะลบข้อมูลนี้?')\">ลบ</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>ไม่มีข้อมูล</td></tr>";
                }
                ?>
            </tbody>
            <tfoot class="text-white" style="background-color: <?php echo htmlspecialchars($tool_color); ?>;">
                <tr>
                    <th>รหัสนักศึกษา</th>
                    <th>ชื่อขนามสกุล</th>
                    <th>ระดับชั้น</th>
                    <th>จัดการ</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            responsive: true
        });
    });
</script>

<?php
// ปิดการเชื่อมต่อ
mysqli_close($conn);
?>
