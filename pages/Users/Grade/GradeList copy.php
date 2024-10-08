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
        c.course_type,
        t.teacher_name,
        e.class,
        e.credits 
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
    // แยกข้อมูลเป็นวิชาบังคับและวิชาเลือก
    $mandatory_courses = array_filter($grades, fn($grade) => $grade['course_type'] === 'mandatory' && $grade['class'] == $class_filter);
    $elective_courses = array_filter($grades, fn($grade) => $grade['course_type'] === 'elective' && $grade['class'] == $class_filter);
?>
    <section class="my-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800"><?php echo htmlspecialchars($title); ?> - วิชาบังคับ</h2>
        <table class="w-full bg-white border border-gray-200 shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-100 text-gray-700">
                <tr class="text-left">
                    <th class="py-3 px-4 border-b">วิชา</th>
                    <th class="py-3 px-4 border-b">เทอม</th>
                    <th class="py-3 px-4 border-b">ปี</th>
                    <th class="py-3 px-4 border-b">เกรดเฉลี่ย</th>
                    <th class="py-3 px-4 border-b">หน่วยกิจ</th>
                    <th class="py-3 px-4 border-b">ครูประจำวิชา</th>
                    <th class="py-3 px-4 border-b">ชั้น</th>
                    <th class="py-3 px-4 border-b">สถานะ</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($mandatory_courses)): ?>
                    <tr>
                        <td colspan="9" class="py-2 px-4 border-b text-center text-gray-500">ไม่พบข้อมูลวิชาบังคับ</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($mandatory_courses as $grade): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['course_name']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['semester']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['academic_year']); ?></td>
                            <td class="py-2 px-4 border-b <?php echo $grade['grade'] < 1.5 ? 'text-red-500' : 'text-green-500'; ?>"><?php echo htmlspecialchars($grade['grade']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['credits']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['teacher_name']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo get_class_name($grade['class']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <section class="my-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800"><?php echo htmlspecialchars($title); ?> - วิชาเลือก</h2>
        <table class="w-full bg-white border border-gray-200 shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-100 text-gray-700">
                <tr class="text-left">
                    <th class="py-3 px-4 border-b">วิชา</th>
                    <th class="py-3 px-4 border-b">ประเภทวิชา</th>
                    <th class="py-3 px-4 border-b">เทอม</th>
                    <th class="py-3 px-4 border-b">ปี</th>
                    <th class="py-3 px-4 border-b">เกรดเฉลี่ย</th>
                    <th class="py-3 px-4 border-b">หน่วยกิจ</th>
                    <th class="py-3 px-4 border-b">ครูประจำวิชา</th>
                    <th class="py-3 px-4 border-b">ชั้น</th>
                    <th class="py-3 px-4 border-b">สถานะ</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($elective_courses)): ?>
                    <tr>
                        <td colspan="9" class="py-2 px-4 border-b text-center text-gray-500">ไม่พบข้อมูลวิชาเลือก</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($elective_courses as $grade): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['course_name']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['course_type']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['semester']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['academic_year']); ?></td>
                            <td class="py-2 px-4 border-b <?php echo $grade['grade'] < 1.5 ? 'text-red-500' : 'text-green-500'; ?>"><?php echo htmlspecialchars($grade['grade']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['credits']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['teacher_name']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo get_class_name($grade['class']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
<?php
}

?>

<div class="container mx-auto p-6 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-extrabold mb-8 text-center text-gray-900">เกรดเฉลี่ยแต่ละรายวิชา</h1>

    <!-- ปุ่มปริ้น PDF -->
    <div class="mb-6 text-center">
        <button id="print-pdf" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            ออกรายงาน PDF
        </button>
    </div>

    <?php
    render_table($grades, 1, "ชั้นประถม");
    render_table($grades, 2, "ชั้นมัธยมต้น");
    render_table($grades, 3, "ชั้นมัธยมปลาย");
    ?>
</div>

<!-- Include jsPDF Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.6.0/jspdf.umd.min.js"></script>

<script>
    document.getElementById('print-pdf').addEventListener('click', function() {
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF();

        let y = 20; // Starting position for content

        doc.text("Student Grades Information", 10, y);
        y += 10;

        const tables = document.querySelectorAll('.container section');

        tables.forEach((table, index) => {
            if (index > 0) {
                doc.addPage();
                y = 10;
            }

            const title = table.querySelector('h2').textContent;
            doc.text(title, 10, y);
            y += 10;

            const rows = table.querySelectorAll('tbody tr');
            rows.forEach((row, rowIndex) => {
                const cells = row.querySelectorAll('td');
                const data = Array.from(cells).map(cell => cell.textContent);

                data.forEach((item, cellIndex) => {
                    doc.text(item, 10 + (cellIndex * 40), y + (rowIndex * 10));
                });

                if ((rowIndex + 1) % 20 === 0) { // Page break after 20 rows
                    doc.addPage();
                    y = 10;
                }
            });

            y += (rows.length * 10) + 10; // Adjust position for next table
        });

        doc.save('student-grades-info.pdf');
    });
</script>