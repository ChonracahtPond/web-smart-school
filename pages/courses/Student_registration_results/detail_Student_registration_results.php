<?php
// รับค่า student_id จาก URL
$student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// ดึงข้อมูลจากตาราง enrollments, students และ courses
$sql = "
SELECT e.enrollment_id, e.student_id, c.course_id, c.course_name, e.semester, e.academic_year, e.grade, e.status, 
e.teacher_id, e.class, e.credits, s.student_name, c.course_type, c.credits , c.course_description , c.course_content
FROM enrollments e
JOIN students s ON e.student_id = s.student_id
JOIN courses c ON e.course_id = c.course_id
WHERE e.student_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
// รับค่า student_id จาก URL

while ($row = $result->fetch_assoc()) {
    $semester = $row['semester'];
    $academicYear = $row['academic_year'];

    // เก็บข้อมูลตาม semester และ academic_year
    if (!isset($groupedData[$semester][$academicYear])) {
        $groupedData[$semester][$academicYear] = [];
    }

    $groupedData[$semester][$academicYear][] = $row;
}


include "sql/sql.php"; // รวมไฟล์ SQL


?>

<div class="w-full mx-auto mb-10 rounded shadow bg-white p-5">
    <h1 class="text-indigo-600 font-bold text-2xl md:text-3xl mb-1">
        รายละเอียดการลงทะเบียนเรียน (รหัสนักศึกษา: <?php echo htmlspecialchars($student_id); ?> ชื่อ: <?php echo htmlspecialchars($student_name); ?>)
    </h1>

    <!-- Select for Semester and Academic Year -->
    <?php include "table_registration_results.php"; ?>
</div>

<div class="rounded-lg shadow-lg bg-white p-6">
    <h2 class="text-xl font-semibold mb-4 text-gray-800">เลือกข้อมูลการลงทะเบียน</h2>

    <div class="ml-5 mb-5 flex ">
        <div>
            <label for="semester" class="block text-gray-700 font-medium mb-1">เลือกเทอม:</label>
            <select id="semester" class="w-64 border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">เลือกเทอม</option>
                <?php foreach (array_keys($groupedData) as $semester): ?>
                    <option value="<?php echo htmlspecialchars($semester); ?>"><?php echo htmlspecialchars($semester); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="ml-10">
            <label for="academicYear" class="block text-gray-700 font-medium mb-1">เลือกปีการศึกษา:</label>
            <select id="academicYear" class="w-64 border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">เลือกปีการศึกษา</option>
                <?php foreach ($groupedData as $semester => $academicYears): ?>
                    <?php foreach (array_keys($academicYears) as $academicYear): ?>
                        <option value="<?php echo htmlspecialchars($academicYear); ?>"><?php echo htmlspecialchars($academicYear); ?></option>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>


    <div class="bg-gray-200 w-full h-0.5 my-5"></div>


    <?php foreach ($groupedData as $semester => $academicYears): ?>
        <?php foreach ($academicYears as $academicYear => $rows): ?>

            <div class="p-6 mt-4 rounded-lg shadow-lg bg-white data-row" data-semester="<?php echo htmlspecialchars($semester); ?>" data-academic-year="<?php echo htmlspecialchars($academicYear); ?>">


                <h2 class="text-lg font-semibold mb-4 text-gray-700">
                    เทอม: <?php echo htmlspecialchars($semester); ?> ปีการศึกษา: <?php echo htmlspecialchars($academicYear); ?>
                </h2>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-indigo-400 text-white">
                        <tr class="text-center">
                            <th class="px-4 py-2">รหัสการลงทะเบียน</th>
                            <th class="px-4 py-2">รหัสหลักสูตร</th>
                            <th class="px-4 py-2">ชื่อหลักสูตร</th>
                            <th class="px-4 py-2">เทอม</th>
                            <th class="px-4 py-2">ปีการศึกษา</th>
                            <th class="px-4 py-2">เกรด</th>
                            <th class="px-4 py-2">รหัสครู</th>
                            <th class="px-4 py-2">หน่วยกิต</th>
                            <th class="px-4 py-2">ประเภท</th>
                            <th class="px-4 py-2 ">การกระทำ</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-center justify-center">
                        <?php foreach ($rows as $row): ?>
                            <tr class="text-center">
                                <td class="px-4 py-2"><?php echo htmlspecialchars($row['enrollment_id']); ?></td>
                                <td class="px-4 py-2"><?php echo htmlspecialchars($row['course_id']); ?></td>
                                <td class="px-4 py-2"><?php echo htmlspecialchars($row['course_name']); ?></td>
                                <td class="px-4 py-2"><?php echo htmlspecialchars($row['semester']); ?></td>
                                <td class="px-4 py-2"><?php echo htmlspecialchars($row['academic_year']); ?></td>
                                <!-- <td class="px-4 py-2 text-red-400"><?php echo htmlspecialchars($row['grade']); ?></td> -->
                                <?php
                                // กำหนดคะแนน (ตัวอย่าง)
                                $grade = $row['grade']; // เปลี่ยนตามโค้ดของคุณ
                                // กำหนดสีตามคะแนน
                                if ($grade >= 4 && $grade <= 4) {
                                    $colorClass = "text-green-600"; // ดีเยี่ยม
                                } elseif ($grade >= 3.5 && $grade < 4) {
                                    $colorClass = "text-green-500"; // ดีมาก
                                } elseif ($grade >= 3 && $grade < 3.5) {
                                    $colorClass = "text-yellow-500"; // ดี
                                } elseif ($grade >= 2.5 && $grade < 3) {
                                    $colorClass = "text-yellow-400"; // ค่อนข้างดี
                                } elseif ($grade >= 2 && $grade < 2.5) {
                                    $colorClass = "text-orange-500"; // ปานกลาง
                                } elseif ($grade >= 1.5 && $grade < 2) {
                                    $colorClass = "text-red-500"; // พอใช้
                                } elseif ($grade >= 1 && $grade < 1.5) {
                                    $colorClass = "text-red-600"; // ผ่านเกณฑ์ขั้นต่ำที่กำหนด
                                } else {
                                    $colorClass = "text-red-700"; // ต่ำกว่าเกณฑ์ต่ำที่กำหนด
                                }
                                ?>
                                <td class="px-4 py-2 <?php echo $colorClass; ?>"><?php echo htmlspecialchars($grade); ?></td>
                                <td class="px-4 py-2"><?php echo htmlspecialchars($row['teacher_id']); ?></td>
                                <td class="px-4 py-2"><?php echo htmlspecialchars($row['credits']); ?></td>
                                <td class="px-4 py-2"><?php echo htmlspecialchars($row['course_type']); ?></td>
                                <td class="px-4 py-2">
                                    <button class="bg-yellow-500 hover:bg-yellow-400 text-white font-bold py-1 px-3 rounded edit-btn flex"
                                        data-student-id="<?php echo htmlspecialchars($row['student_id']); ?>"
                                        data-enrollment-id="<?php echo htmlspecialchars($row['enrollment_id']); ?>"
                                        data-course-id="<?php echo htmlspecialchars($row['course_id']); ?>"
                                        data-course-name="<?php echo htmlspecialchars($row['course_name']); ?>"
                                        data-semester="<?php echo htmlspecialchars($row['semester']); ?>"
                                        data-academic-year="<?php echo htmlspecialchars($row['academic_year']); ?>"
                                        data-grade="<?php echo htmlspecialchars($row['grade']); ?>"
                                        data-status="<?php echo htmlspecialchars($row['status']); ?>"
                                        data-credits="<?php echo htmlspecialchars($row['credits']); ?>">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" />
                                            <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                                            <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
                                            <line x1="16" y1="5" x2="19" y2="8" />
                                        </svg>
                                        แก้ไข
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>
<script>
    // JavaScript for showing/hiding rows based on selected semester and academic year
    const semesterSelect = document.getElementById('semester');
    const academicYearSelect = document.getElementById('academicYear');
    const rows = document.querySelectorAll('.data-row');

    function filterRows() {
        const selectedSemester = semesterSelect.value;
        const selectedAcademicYear = academicYearSelect.value;

        rows.forEach(row => {
            const semester = row.getAttribute('data-semester');
            const academicYear = row.getAttribute('data-academic-year');

            if ((selectedSemester === '' || semester === selectedSemester) &&
                (selectedAcademicYear === '' || academicYear === selectedAcademicYear)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    semesterSelect.addEventListener('change', filterRows);
    academicYearSelect.addEventListener('change', filterRows);
</script>



<?php include "modal/modal.php"; ?>

<!-- jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        // DataTable setup
        $('.stripe').DataTable({
            responsive: true
        });

        // เปิด modal และแสดงข้อมูลเมื่อคลิกปุ่มแก้ไข
        $('.edit-btn').on('click', function() {
            const data = $(this).data(); // ใช้ data() เพื่อดึงข้อมูลทั้งหมด

            $('#student_id').val(data.studentId);
            $('#enrollment_id').val(data.enrollmentId);
            $('#course_id').val(data.courseId);
            $('#course_name').val(data.courseName);
            $('#semester').val(data.semester);
            $('#academic_year').val(data.academicYear);
            $('#grade').val(data.grade);
            $('#status').val(data.status);
            $('#credits').val(data.credits);

            $('#editModal').removeClass('hidden'); // แสดง modal
        });

        // ปิด modal เมื่อคลิกปุ่มยกเลิก
        $('#closeModal').on('click', function() {
            $('#editModal').addClass('hidden'); // ซ่อน modal
        });
    });
</script>