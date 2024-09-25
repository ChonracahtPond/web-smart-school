<?php
// ตรวจสอบว่ามีการกรองข้อมูลระดับชั้นหรือไม่
$selectedGradeLevel = $_POST['grade_level'] ?? '';

// สร้าง SQL เพื่อดึงข้อมูลจากตาราง enrollments, students และ courses โดยเพิ่มเงื่อนไขการกรองระดับชั้น
$sql = "
SELECT e.enrollment_id, e.student_id, s.student_name, s.status, s.grade_level, e.course_id, c.course_name, 
       e.semester, e.academic_year, e.grade, e.status, e.teacher_id, e.class, e.credits 
FROM enrollments e
JOIN students s ON e.student_id = s.student_id 
JOIN courses c ON e.course_id = c.course_id
WHERE s.status = '0'";

// หากเลือกระดับชั้น ให้เพิ่มเงื่อนไขการกรองใน SQL
if (!empty($selectedGradeLevel)) {
    $sql .= " AND s.grade_level = '" . mysqli_real_escape_string($conn, $selectedGradeLevel) . "'";
}

$sql .= " ORDER BY e.student_id, e.grade ASC"; // เรียงลำดับตาม student_id และเกรด

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

// ดึงข้อมูลระดับชั้น
$gradeLevelQuery = "SELECT DISTINCT grade_level FROM students ORDER BY grade_level";
$gradeLevelResult = mysqli_query($conn, $gradeLevelQuery);

// เริ่มสร้างหน้า HTML
?>

<div class="container mx-auto">
    <div class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
        <h1 class="text-3xl font-semibold text-indigo-500 dark:text-white mb-5">จัดการผลการเรียน</h1>

        <!-- ฟอร์มกรองข้อมูล -->
        <form method="post" class="mb-4 mx-auto" id="filterForm">
            <div class="flex items-center mb-4">
                <label for="grade_level" class="mr-4 font-semibold text-gray-700">ระดับชั้น <span class="text-red-500">*</span></label>
                <select name="grade_level" id="grade_level" class="w-64 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" onchange="document.getElementById('filterForm').submit();">
                    <option value="">ทั้งหมด</option>
                    <?php while ($grade = mysqli_fetch_assoc($gradeLevelResult)): ?>
                        <option value="<?php echo htmlspecialchars($grade['grade_level']); ?>" <?php echo ($selectedGradeLevel === $grade['grade_level']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($grade['grade_level']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </form>

        <div class="bg-gray-200 w-full h-0.5 my-5"></div>

        <table id="example" class="stripe hover w-full" style="padding-top: 1em; padding-bottom: 1em;">
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
                        echo "<a href='?page=detail_Manage_academic_results&id={$studentId}' class='bg-blue-500 text-white font-bold py-1 px-2 rounded hover:bg-blue-600 transition duration-200'>
                        
                        ดูรายละเอียด
                        </a>";
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
