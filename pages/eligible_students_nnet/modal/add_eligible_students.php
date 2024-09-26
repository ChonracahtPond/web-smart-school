<?php


// ดึงข้อมูลนักเรียน
$studentsResult = $conn->query("SELECT student_id, student_name FROM students WHERE status = 0");

// ดึงข้อมูลการลงทะเบียนพร้อม course_id
$enrollmentsResult = $conn->query("SELECT enrollment_id, student_id, course_id FROM enrollments");

// ดึงข้อมูลคอร์ส
$coursesResult = $conn->query("SELECT course_id, course_name FROM courses");

// สร้างตัวแปรเพื่อเก็บ course_id และ course_name
$courses = [];
if ($coursesResult) {
    while ($course = $coursesResult->fetch_assoc()) {
        $courses[$course['course_id']] = $course['course_name'];
    }
}

?>

<div class="mx-auto px-2">


    <!-- ปุ่มเพิ่มข้อมูล -->
    <div class="mb-4">
        <button id="addEligibleStudentBtn" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600 transition duration-200 flex">
            <svg class="h-5 w-5" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" />
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            เพิ่มนักเรียนที่มีสิทธิ์สอบ
        </button>
    </div>

    <!-- Modal -->
    <div id="addEligibleStudentModal" class="fixed z-50 inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-white rounded-lg p-4 w-96">
            <h2 class="text-xl mb-4">เพิ่มนักเรียนที่มีสิทธิสอบ</h2>
            <form id="addEligibleStudentForm" action="?page=insert_eligible_students_nnet" method="POST">
                <div class="mb-4">
                    <label for="studentId" class="block">นักเรียน <span class="text-red-400 mr-2">*นักเรียนที่กำลังศึกษาอยู่*</span></label>
                    <select id="studentId" name="studentId" class="border rounded w-full p-2" required onchange="filterEnrollments()">
                        <option value="">เลือกนักเรียน</option>
                        <?php while ($student = $studentsResult->fetch_assoc()): ?>
                            <option value="<?php echo $student['student_id']; ?>"><?php echo $student['student_id']; ?> <?php echo $student['student_name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="enrollmentId" class="block">รหัสการลงทะเบียน</label>
                    <select id="enrollmentId" name="enrollmentId" class="border rounded w-full p-2" required>
                        <option value="">เลือกการลงทะเบียน</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="examId" class="block">รหัสการสอบ</label>
                    <input type="text" id="examId" name="examId" class="border rounded w-full p-2" required>
                </div>
                <div class="mb-4">
                    <label for="dateTime" class="block">วันที่และเวลา</label>
                    <input type="datetime-local" id="dateTime" name="dateTime" class="border rounded w-full p-2" required>
                </div>
                <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 transition duration-200">บันทึก</button>
                <button type="button" id="closeModal" class="bg-red-500 text-white font-bold py-2 px-4 rounded ml-2 hover:bg-red-600 transition duration-200">ยกเลิก</button>
            </form>
        </div>
    </div>

    <script>
        function filterEnrollments() {
            const studentId = document.getElementById('studentId').value;
            const enrollmentSelect = document.getElementById('enrollmentId');
            enrollmentSelect.innerHTML = '<option value="">เลือกการลงทะเบียน</option>'; // เคลียร์ค่าเดิม

            <?php
            // สร้างตัวแปร PHP สำหรับ enrollments
            $enrollments = [];
            if ($enrollmentsResult) {
                while ($enrollment = $enrollmentsResult->fetch_assoc()) {
                    $enrollments[$enrollment['student_id']][] = [
                        'enrollment_id' => $enrollment['enrollment_id'],
                        'course_id' => $enrollment['course_id'],
                    ];
                }
            }
            ?>

            // กรองการลงทะเบียนตาม studentId ที่เลือก
            const enrollments = <?php echo json_encode($enrollments); ?>;
            if (studentId in enrollments) {
                enrollments[studentId].forEach(function(enrollment) {
                    const option = document.createElement('option');
                    option.value = enrollment.enrollment_id;
                    const courseName = <?php echo json_encode($courses); ?>[enrollment.course_id] || 'ไม่ทราบชื่อคอร์ส';
                    // option.textContent = `รหัสการลงทะเบียน: ${enrollment.enrollment_id} (Course ID: ${enrollment.course_id} - ${courseName})`;
                    option.textContent = `${enrollment.course_id} ${courseName}`;
                    enrollmentSelect.appendChild(option);
                });
            }
        }

        // ฟังก์ชันเปิด modal เพิ่มข้อมูล
        document.getElementById('addEligibleStudentBtn').onclick = function() {
            document.getElementById('addEligibleStudentModal').classList.remove('hidden'); // แสดง modal
        };

        // ฟังก์ชันปิด modal
        document.getElementById('closeModal').onclick = function() {
            document.getElementById('addEligibleStudentModal').classList.add('hidden'); // ซ่อน modal
        };
    </script>
</div>