<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
        case '0':
            return "ว่าง";
        case '1':
            return "ประถม";
        case '2':
            return "มัธยมต้น";
        case '3':
            return "มัธยมปลาย";
        default:
            return "ไม่ระบุ";
    }
}

function get_status_text($status)
{
    switch ($status) {
        case '0':
            return '<i class="fas fa-hourglass-start text-yellow-500 animate-spin"></i> กำลังศึกษา';
        case '1':
            return '<i class="fas fa-check-circle text-green-500"></i> ศึกษาจบแล้ว';
        case '2':
            return '<i class="fas fa-times-circle text-red-500"></i> ดรอปเรียน';
        case '3':
            return '<i class="fas fa-ban text-gray-500"></i> ยกเลิกรายวิชา';
        default:
            return '<i class="fas fa-question-circle text-gray-400"></i> ไม่ทราบสถานะ';
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
                    <th class="py-3 px-4 border-b">หน่วยกิจ</th>
                    <th class="py-3 px-4 border-b">ครูประจำวิชา</th>
                    <th class="py-3 px-4 border-b">ชั้น</th>
                    <th class="py-3 px-4 border-b">สถานะ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $found = false;
                foreach ($grades as $grade) {
                    if ($grade['class'] == $class_filter) {
                        $found = true;

                        // Determine the color based on the grade
                        $grade_color = $grade['grade'] < 1.5 ? 'text-red-500' : 'text-green-500';
                ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['student_name']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['course_name']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['semester']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['academic_year']); ?></td>
                            <td class="py-2 px-4 border-b <?php echo $grade_color; ?>"><?php echo htmlspecialchars($grade['grade']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['credits']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($grade['teacher_name']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo get_class_name($grade['class']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo get_status_text($grade['status']); ?></td>
                        </tr>
                    <?php
                    }
                }
                if (!$found) {
                    ?>
                    <tr>
                        <td colspan="9" class="py-2 px-4 border-b text-center text-gray-500">ไม่พบข้อมูล</td>
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

<div class="container mx-auto p-6 min-h-screen">
    <h1 class="text-4xl font-bold text-blue-800 mb-8">เกรดเฉลี่ยแต่ละรายวิชา</h1>

    <!-- ปุ่มแสดง PDF -->
    <div class="mb-6 text-center">
        <a href="../mpdf/student_report/grade_by_student.php?student_id=<?php echo urlencode($_GET['student_id']); ?>" class="inline-block px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <i class="fas fa-file-pdf"></i> แสดงรายงาน PDF
        </a>
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