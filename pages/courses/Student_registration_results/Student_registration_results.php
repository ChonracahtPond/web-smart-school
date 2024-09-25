<?php
// ดึงข้อมูลระดับชั้นที่ไม่ซ้ำกันจากตาราง students
$gradeLevelSql = "SELECT DISTINCT grade_level FROM students WHERE status = '0'";
$gradeLevelResult = mysqli_query($conn, $gradeLevelSql);

if (!$gradeLevelResult) {
    echo "เกิดข้อผิดพลาดในการดึงข้อมูลระดับชั้น: " . mysqli_error($conn);
    exit;
}

// ค่าของระดับชั้นที่เลือกจากฟอร์ม
$selectedGradeLevel = isset($_POST['grade_level']) ? $_POST['grade_level'] : '';

// ดึงข้อมูลจากตาราง enrollments, students และ courses ตามระดับชั้นที่เลือก
$sql = "
SELECT e.enrollment_id, e.student_id, s.student_name, s.status, s.grade_level, e.course_id, c.course_name, 
       e.semester, e.academic_year, e.grade, e.status, e.teacher_id, e.class, e.credits 
FROM enrollments e
JOIN students s ON e.student_id = s.student_id
JOIN courses c ON e.course_id = c.course_id
WHERE s.status = '0' 
" . ($selectedGradeLevel ? " AND s.grade_level = '{$selectedGradeLevel}'" : "") . "
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
            'grade_level' => $row['grade_level'], // ดึงข้อมูลระดับชั้นจากตาราง students
        ];
    }
}

// เริ่มสร้างหน้า HTML
?>

<div class="">
    <div class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-5">ผลการลงทะเบียนเรียน</h1>

        <!-- ฟอร์มกรองข้อมูล -->
        <form method="post" class="mb-4 mx-auto" id="filterForm">
            <div class="flex items-center mb-4 ">
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
                        echo "<td>{$studentData['grade_level']}</td>"; // แสดงระดับชั้นที่ดึงมาจากฐานข้อมูล
                        echo "<td class='flex justify-center space-x-2'>";
                        echo "<a href='?page=detail_Student_registration_results&id={$studentId}' class='bg-blue-500 text-white font-bold py-1 px-3 rounded hover:bg-blue-600 transition duration-200 flex items-center space-x-2'>
                        <svg class='h-6 w-6' width='24' height='24' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                            <path stroke='none' d='M0 0h24v24H0z' />
                            <circle cx='12' cy='12' r='2' />
                            <path d='M2 12l1.5 2a11 11 0 0 0 17 0l1.5 -2' />
                            <path d='M2 12l1.5 -2a11 11 0 0 1 17 0l1.5 2' />
                        </svg>
                        <span>ดูรายละเอียด</span>
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