<?php
// ตรวจสอบว่ามีการส่ง ID ของหลักสูตรมาหรือไม่
if (!isset($_GET['course_id']) || empty($_GET['course_id'])) {
    die("Error: No course ID provided.");
}

$course_id = $_GET['course_id'];

// คำสั่ง SQL สำหรับดึงข้อมูลการลงทะเบียนทั้งหมดที่เกี่ยวข้องกับ course_id พร้อมรวมข้อมูลจากตาราง students และ teachers
$sql = "SELECT e.enrollment_id, e.student_id, e.course_id , e.semester, e.academic_year, e.grade, e.status, e.teacher_id, 
               s.student_name, s.email, 
               t.teacher_name
        FROM enrollments e
        LEFT JOIN students s ON e.student_id = s.student_id 
        LEFT JOIN teachers t ON e.teacher_id = t.teacher_id
        WHERE e.course_id = ?";

$stmt = $conn->prepare($sql);

// ตรวจสอบว่าเตรียมคำสั่งสำเร็จหรือไม่
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param('i', $course_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("ไม่พบข้อมูล: ไม่พบการลงทะเบียนสำหรับหลักสูตรนี้.");
}
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">รายละเอียดการลงทะเบียนเรียน</h1>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">รหัสการลงทะเบียน</th>
                    <th class="py-2 px-4 border-b">รหัสนักเรียน</th>
                    <th class="py-2 px-4 border-b">ชื่อของนักเรียน</th>
                    <th class="py-2 px-4 border-b">อีเมลของนักเรียน</th>
                    <th class="py-2 px-4 border-b">ภาคเรียน</th>
                    <th class="py-2 px-4 border-b">ปีการศึกษา</th>
                    <th class="py-2 px-4 border-b">เกรด</th>
                    <th class="py-2 px-4 border-b">สถานะ</th>
                    <th class="py-2 px-4 border-b">ชื่อครู</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($enrollment = $result->fetch_assoc()) : ?>
                    <tr>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($enrollment['enrollment_id']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($enrollment['student_id']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($enrollment['student_name']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($enrollment['email']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($enrollment['semester']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($enrollment['academic_year']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($enrollment['grade']); ?></td>
                        <td class="py-2 px-4 border-b">
                            <?php
                            $status = htmlspecialchars($enrollment['status']);
                            echo ($status == 1) ? '<span class="text-green-500">กำลังศึกษา</span>' : '<span class="text-red-500">หยุดการศึกษา</span>';
                            ?>
                        </td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($enrollment['teacher_name']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="mt-4">
            <a href="?page=Manage_courses" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">กลับไปที่รายการการลงทะเบียน</a>
        </div>
    </div>
</div>