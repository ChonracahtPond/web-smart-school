<?php


// ตรวจสอบว่ามีการส่ง ID ของหลักสูตรมาหรือไม่
if (!isset($_GET['course_id']) || empty($_GET['course_id'])) {
    die("Error: No course ID provided.");
}

$course_id = $_GET['course_id'];

// คำสั่ง SQL สำหรับดึงข้อมูลการเข้าชั้นเรียน
$sql = "SELECT a.attendance_id, a.student_id, a.attendance_date, a.status, 
               s.student_name, c.course_name 
        FROM attendance a
        JOIN students s ON a.student_id = s.student_id
        JOIN enrollments e ON a.course_id = e.student_id  -- เปลี่ยนจาก lessons เป็น enrollments
        JOIN courses c ON e.course_id = c.course_id        -- ใช้ enrollments เพื่อเชื่อมกับ courses
        WHERE c.course_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $course_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">ระบบเช็คชื่อ</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Attendance ID</th>
                    <th class="py-2 px-4 border-b">Student Name</th>
                    <th class="py-2 px-4 border-b">Attendance Date</th>
                    <th class="py-2 px-4 border-b">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['attendance_id']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['student_name']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['attendance_date']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo ($row['status'] == 1) ? 'เข้าชั้นเรียน' : 'ไม่เข้าชั้นเรียน'; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>