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
        t.teacher_name,
        e.class
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

function get_class_name($class)
{
    switch ($class) {
        case 0:
            return "ว่าง";
        case 1:
            return "ประถม";
        case 2:
            return "มัธยมต้น";
        case 3:
            return "มัธยมปลาย";
        default:
            return "ไม่ระบุ";
    }
}

function render_table($grades, $class_filter, $title)
{
?>
    <section class="my-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800"><?php echo htmlspecialchars($title); ?></h2>
        <table class="w-full bg-white border border-gray-200 shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-100 text-gray-700">
                <tr class="text-left">
                    <th class="py-3 px-4 border-b">ชื่อ-นามสกุล นักศึกษา</th>
                    <th class="py-3 px-4 border-b">วิชา</th>
                    <th class="py-3 px-4 border-b">เทอม</th>
                    <th class="py-3 px-4 border-b">ปี</th>
                    <th class="py-3 px-4 border-b">เกรดเฉลี่ย</th>
                    <th class="py-3 px-4 border-b">สถานะ</th>
                    <th class="py-3 px-4 border-b">ครูประจำวิชา</th>
                    <th class="py-3 px-4 border-b">ชั้น</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $found = false;
                foreach ($grades as $grade) {
                    if ($grade['class'] == $class_filter) {
                        $found = true;
                ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['student_name']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['course_name']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['semester']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['academic_year']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['grade']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['status']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['teacher_name']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo get_class_name($grade['class']); ?></td>
                    </tr>
                <?php
                    }
                }
                if (!$found) {
                ?>
                <tr>
                    <td colspan="8" class="py-2 px-4 border-b text-center text-gray-500">ไม่พบข้อมูล</td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </section>
<?php
}
?>

<div class="container mx-auto p-6 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-extrabold mb-8 text-center text-gray-900">เกรดเฉลี่ยแต่ละรายวิชา</h1>

    <?php
    render_table($grades, 1, "ชั้นประถม");
    render_table($grades, 2, "ชั้นมัธยมต้น");
    render_table($grades, 3, "ชั้นมัธยมปลาย");
    ?>
</div>
