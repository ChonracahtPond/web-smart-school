<?php
// ดึงข้อมูลระดับชั้นที่ไม่ซ้ำจากฐานข้อมูล
$grade_levels_result = $conn->query("SELECT DISTINCT grade_level FROM students");
if ($grade_levels_result === false) {
    die('Query failed: ' . $conn->error); // ตรวจสอบการทำงานของ query
}
$grade_levels = [];
while ($row = $grade_levels_result->fetch_assoc()) {
    $grade_levels[] = $row['grade_level'];
}

// ตรวจสอบว่ามีการเลือกระดับชั้นหรือไม่
$selected_grade_level = isset($_POST['grade_level']) ? $_POST['grade_level'] : '';

// ฟังก์ชันสำหรับดึงข้อมูลนักเรียนตามระดับชั้นที่เลือก
function fetchStudents($conn, $grade_level = null)
{
    // SQL สำหรับดึงข้อมูลนักเรียนที่มีสถานะเป็น 0
    $sql_students = "SELECT student_id, fullname, grade_level FROM students WHERE status = '0'";

    if ($grade_level) {
        $sql_students .= " AND grade_level = '" . $conn->real_escape_string($grade_level) . "'"; // เพิ่มเงื่อนไขตามระดับชั้นที่เลือก
    }

    $result = $conn->query($sql_students);
    if ($result === false) {
        die('Query failed: ' . $conn->error); // ตรวจสอบการทำงานของ query
    }

    // สร้าง array สำหรับ student_ids ที่มีอยู่ใน eligible_students
    $eligible_students = [];
    $sql_check_eligible = "SELECT student_id FROM eligible_students WHERE eligible_type = 'nnet'";
    $eligible_result = $conn->query($sql_check_eligible);

    if ($eligible_result && $eligible_result->num_rows > 0) {
        while ($row = $eligible_result->fetch_assoc()) {
            $eligible_students[] = $row['student_id']; // เพิ่ม student_id ลงใน array
        }
    }

    // สร้าง array สำหรับนักเรียนที่ดึงมาจากฐานข้อมูล
    $students = [];
    while ($row = $result->fetch_assoc()) {
        // ตรวจสอบว่ามีนักเรียนที่มีสิทธิใน eligible_students หรือไม่
        $row['is_eligible'] = in_array($row['student_id'], $eligible_students); // จะให้ true ถ้ามีใน eligible_students
        $students[] = $row; // เก็บนักเรียนทั้งหมดลงใน array
    }

    return $students; // คืนค่ารายการนักเรียนทั้งหมดรวมถึงสถานะ eligible
}

// ดึงข้อมูลนักเรียนตามระดับชั้นที่เลือก
$students = fetchStudents($conn, $selected_grade_level); // แก้ไขเพื่อให้ตัวแปร $students มีค่าเริ่มต้น

// ฟังก์ชันเพื่อตรวจสอบว่านักเรียนมีอยู่ใน eligible_students หรือไม่
function isStudentAlreadyEligible($conn, $student_id)
{
    $sql_check = "SELECT COUNT(*) as count FROM eligible_students WHERE student_id = '" . $conn->real_escape_string($student_id) . "' AND eligible_type = 'nnet'";
    $result = $conn->query($sql_check);
    if ($result === false) {
        die('Query failed: ' . $conn->error);
    }

    $row = $result->fetch_assoc();
    return $row['count'] > 0; // ถ้ามีข้อมูลมากกว่าศูนย์ จะส่งกลับ true
}

// การเพิ่มข้อมูลใน eligible_students
if (isset($_POST['confirm'])) {
    // ตรวจสอบว่ามีนักเรียนที่เลือกหรือไม่
    $selected_students = isset($_POST['selected_students']) ? $_POST['selected_students'] : [];

    // ดึงข้อมูล enrollmentId และ dateTime
    $enrollment_id = $_POST['enrollmentId'];
    $date_time = $_POST['dateTime'];

    // เก็บ student_id ที่มีอยู่ใน eligible_students
    $eligible_students_ids = [];
    $sql_check_eligible = "SELECT student_id FROM eligible_students WHERE eligible_type = 'nnet'";
    $eligible_result = $conn->query($sql_check_eligible);

    if ($eligible_result && $eligible_result->num_rows > 0) {
        while ($row = $eligible_result->fetch_assoc()) {
            $eligible_students_ids[] = $row['student_id'];
        }
    }

    // เพิ่มข้อมูลใน eligible_students
    foreach ($selected_students as $student_id) {
        if (!isStudentAlreadyEligible($conn, $student_id)) {
            $sql_insert = "INSERT INTO eligible_students (student_id, enrollment_id, exam_id, created_at, date_time, eligible_type, status) 
                           VALUES ('" . $conn->real_escape_string($student_id) . "', 
                                   '" . $conn->real_escape_string($enrollment_id) . "', 
                                   'exam_id_value', 
                                   NOW(), 
                                   '" . $conn->real_escape_string($date_time) . "', 
                                   'nnet', 
                                   '1')";
            if ($conn->query($sql_insert) === false) {
                die('Error: ' . $conn->error);
            }
        }
    }

    // ลบข้อมูลนักเรียนที่ไม่เลือก
    foreach ($eligible_students_ids as $eligible_student_id) {
        if (!in_array($eligible_student_id, $selected_students)) {
            $sql_delete = "DELETE FROM eligible_students WHERE student_id = '" . $conn->real_escape_string($eligible_student_id) . "' AND eligible_type = 'nnet'";
            if ($conn->query($sql_delete) === false) {
                die('Error: ' . $conn->error);
            }
        }
    }

    echo "<script>window.location.href='?page=eligible_students_nnet&status=1';</script>";
} else {
    echo "กรุณาเลือกนักเรียนก่อนทำการยืนยัน.";
}

?>

<div class="p-8 mt-6 lg:mt-0 rounded-lg shadow bg-white">
    <h1 class="text-3xl font-semibold text-indigo-500 dark:text-white mb-5">เพิ่มนักศึกษาที่มีสิทธิสอบ N-NET</h1>
    <div class="bg-gray-200 w-full h-0.5 mt-5"></div>

    <form method="POST">
        <div class="mt-4 p-1 flex">
            <label for="grade_level" class="block text-sm font-medium text-gray-700 my-3 mr-5">เลือกระดับชั้น <span class="text-red-500">*</span></label>
            <select id="grade_level" name="grade_level" class="mt-1 block w-56 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="this.form.submit()">
                <option value="">-- กรุณาเลือกระดับชั้น --</option>
                <?php foreach ($grade_levels as $grade_level): ?>
                    <option value="<?php echo htmlspecialchars($grade_level); ?>" <?php echo ($grade_level == $selected_grade_level) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($grade_level); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <table class="min-w-full divide-y divide-gray-300 mt-4 border border-gray-300 rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                        <input type="checkbox" id="selectAll" onclick="toggleCheckboxes(this)" class="mr-2">
                        <span>เลือกทั้งหมด</span>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">รหัสนักศึกษา</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ชื่อ-สกุล</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ระดับชั้น</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($students)): // ใช้ !empty แทน count 
                ?>
                    <?php foreach ($students as $student): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" name="selected_students[]" value="<?php echo htmlspecialchars($student['student_id']); ?>" class="student-checkbox" <?php echo $student['is_eligible'] ? 'checked' : ''; ?>>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900"><?php echo htmlspecialchars($student['student_id']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900"><?php echo htmlspecialchars($student['fullname']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900"><?php echo htmlspecialchars($student['grade_level']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">ไม่พบข้อมูลนักเรียน</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- ฟิลด์ซ่อนสำหรับ enrollmentId และ dateTime -->
        <input type="hidden" name="enrollmentId" value="enrollmentId"> <!-- ปรับค่าให้ตรง -->
        <input type="hidden" name="dateTime" value="<?php echo date('Y-m-d H:i:s'); ?>"> <!-- เวลาในรูปแบบที่ต้องการ -->

        <div class="mt-4">
            <button type="submit" name="confirm" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                ยืนยัน
            </button>
        </div>
    </form>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
    function toggleCheckboxes(selectAll) {
        const checkboxes = document.querySelectorAll('.student-checkbox');
        checkboxes.forEach((checkbox) => {
            checkbox.checked = selectAll.checked; // ตั้งค่าสถานะ checked ของ checkbox ให้ตรงกับสถานะของ selectAll
        });
    }
</script>