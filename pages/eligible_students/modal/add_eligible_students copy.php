<?php
// ดึงข้อมูลนักเรียนที่มีสิทธิสอบ
$sql = "SELECT es.eligible_students_id, es.student_id, es.enrollment_id, es.exam_id, es.created_at AS date_time, s.student_name , el.course_id 
        FROM eligible_students es
        JOIN students s ON es.student_id = s.student_id
        JOIN enrollments el ON es.enrollment_id = el.enrollment_id
        JOIN courses c ON el.course_id = c.course_id";

$sql1 = "SELECT es.eligible_students_id, es.student_id, es.enrollment_id, es.exam_id, es.created_at AS date_time, s.student_name , el.course_id 
        FROM courses";




// ตรวจสอบว่ามีการส่งคำขอ POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $student_id = $_POST['studentId'];
    $enrollment_id = $_POST['enrollmentId'];
    $exam_id = $_POST['examId'];
    $date_time = $_POST['dateTime'];

    // เตรียมคำสั่ง SQL
    $sql = "INSERT INTO eligible_students (student_id, enrollment_id, exam_id, created_at) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("เกิดข้อผิดพลาดในการเตรียมคำสั่ง: " . $conn->error);
    }

    // Binding parameters
    $stmt->bind_param("ssss", $student_id, $enrollment_id, $exam_id, $date_time);

    // Execute the query
    if ($stmt->execute()) {
        echo "เพิ่มนักเรียนที่มีสิทธิสอบเรียบร้อยแล้ว";
    } else {
        echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูล: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

// ดึงข้อมูลการลงทะเบียน
$enrollmentsResult = $conn->query("SELECT * FROM enrollments"); // ปรับ query ตามฐานข้อมูลที่มี
?>

<div class="mx-auto px-2">
    <h1 class="flex items-center font-sans font-bold break-normal text-indigo-500 px-2 py-8 text-xl md:text-2xl">
        <i class="fas fa-user-graduate mr-2"></i>นักเรียนที่มีสิทธิสอบ
    </h1>

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
            <form id="addEligibleStudentForm">
                <div class="mb-4">
                    <label for="studentId" class="block">รหัสนักเรียน</label>
                    <select id="studentId" name="studentId" class="border rounded w-full p-2" required>
                        <option value="">เลือกนักเรียน</option>
                        <?php while ($student = $studentsResult->fetch_assoc()): ?>
                            <option value="<?php echo $student['student_id']; ?>"><?php echo $student['student_name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="enrollmentId" class="block">รหัสการลงทะเบียน (Course ID)</label>
                    <select id="enrollmentId" name="enrollmentId" class="border rounded w-full p-2" required>
                        <option value="">เลือกการลงทะเบียน</option>
                        <?php while ($enrollment = $enrollmentsResult->fetch_assoc()): ?>
                            <option value="<?php echo $enrollment['enrollment_id']; ?>">
                                <?php echo $enrollment['enrollment_id']; ?> <!-- แสดง course_id -->
                            </option>
                        <?php endwhile; ?>
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

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // ฟังก์ชันเปิด modal เพิ่มข้อมูล
            $('#addEligibleStudentBtn').click(function() {
                $('#addEligibleStudentModal').removeClass('hidden'); // แสดง modal
            });

            // ฟังก์ชันปิด modal
            $('#closeModal').click(function() {
                $('#addEligibleStudentModal').addClass('hidden'); // ซ่อน modal
            });

            // ฟังก์ชันบันทึกข้อมูลเมื่อส่งฟอร์ม
            $('#addEligibleStudentForm').submit(function(event) {
                event.preventDefault(); // ป้องกันการรีเฟรชหน้า

                // ส่งข้อมูลไปยังเซิร์ฟเวอร์
                $.ajax({
                    url: 'add_eligible_student.php', // สคริปต์สำหรับเพิ่มข้อมูล
                    type: 'POST',
                    data: $(this).serialize(), // ส่งข้อมูลในฟอร์ม
                    success: function(response) {
                        alert(response); // แจ้งผลลัพธ์
                        location.reload(); // โหลดหน้าใหม่
                    },
                    error: function() {
                        alert('เกิดข้อผิดพลาดในการเพิ่มข้อมูล');
                    }
                });
            });
        });
    </script>
</div>