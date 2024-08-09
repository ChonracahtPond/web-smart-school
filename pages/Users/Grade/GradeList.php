<?php
// รวมไฟล์การเชื่อมต่อฐานข้อมูล


// รับข้อมูล student_id จากคำขอ
$student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0;

// ตรวจสอบว่ามีการส่งค่า student_id
if ($student_id <= 0) {
    die("Invalid student ID");
}

// สร้างคำสั่ง SQL เพื่อดึงข้อมูล
$sql = "
    SELECT
        e.enrollment_id,
        e.student_id,
        e.course_id,
        e.semester,
        e.academic_year,
        e.grade,
        e.status,
        e.teacher_id,
        s.student_name,
        c.course_name,
        t.teacher_name
    FROM enrollments e
    JOIN students s ON e.student_id = s.student_id
    JOIN courses c ON e.course_id = c.course_id
    JOIN teachers t ON e.teacher_id = t.teacher_id
    WHERE e.student_id = ?
";

// เตรียมและดำเนินการคำสั่ง SQL
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL prepare failed: " . $conn->error);
}

$stmt->bind_param('i', $student_id);
$stmt->execute();

// ตรวจสอบผลลัพธ์
$result = $stmt->get_result();
if (!$result) {
    die("SQL execute failed: " . $stmt->error);
}

// ดึงข้อมูลจากคำสั่ง SQL
$grades = [];
while ($row = $result->fetch_assoc()) {
    $grades[] = $row;
}

// ปิดการเชื่อมต่อฐานข้อมูล
$stmt->close();
$conn->close();
?>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Student Grades</h1>
    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Enrollment ID</th>
                <th class="py-2 px-4 border-b">Student Name</th>
                <th class="py-2 px-4 border-b">Course Name</th>
                <th class="py-2 px-4 border-b">Semester</th>
                <th class="py-2 px-4 border-b">Academic Year</th>
                <th class="py-2 px-4 border-b">Grade</th>
                <th class="py-2 px-4 border-b">Status</th>
                <th class="py-2 px-4 border-b">Teacher Name</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($grades) > 0): ?>
                <?php foreach ($grades as $grade): ?>
                    <tr>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['enrollment_id']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['student_name']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['course_name']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['semester']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['academic_year']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['grade']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['status']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['teacher_name']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="py-2 px-4 border-b text-center">No records found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>