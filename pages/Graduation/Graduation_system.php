<?php
// ดึงข้อมูลจากตาราง enrollments โดยเลือกเฉพาะสถานะที่เป็น '0' และรวมข้อมูลจากตาราง students และ courses
$sql = "
SELECT e.*, s.student_name AS student_name, c.course_name AS course_name 
FROM enrollments e
JOIN students s ON e.student_id = s.student_id
JOIN courses c ON e.course_id = c.course_id
WHERE e.status = '1'
ORDER BY e.status ASC";
$result = mysqli_query($conn, $sql);

// ตรวจสอบว่ามีผลลัพธ์หรือไม่
if (!$result) {
    echo "เกิดข้อผิดพลาดในการดึงข้อมูล: " . mysqli_error($conn);
    exit;
}

// สร้างอาร์เรย์เพื่อเก็บข้อมูลที่รวมกัน
$groupedData = [];

// ตรวจสอบว่ามีข้อมูลหรือไม่
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $studentId = $row['student_id'];

        // ถ้า student_id ยังไม่อยู่ในอาร์เรย์ ให้เพิ่มเข้าไป
        if (!isset($groupedData[$studentId])) {
            $groupedData[$studentId] = [
                'enrollment_id' => $row['enrollment_id'],
                'student_id' => $row['student_id'],
                'student_name' => $row['student_name'], // เพิ่มชื่อของนักเรียน
                'course_names' => [$row['course_name']], // เพิ่มชื่อหลักสูตร
                'semesters' => [$row['semester']],
                'academic_years' => [$row['academic_year']],
                'grades' => [$row['grade']],
                'statuses' => [$row['status']],
                'teacher_ids' => [$row['teacher_id']],
                'classes' => [$row['class']],
                'credits' => [$row['credits']]
            ];
        } else {
            // ถ้า student_id มีอยู่แล้ว ให้เพิ่มข้อมูลเข้าไป
            $groupedData[$studentId]['course_names'][] = $row['course_name']; // เพิ่มชื่อหลักสูตร
            $groupedData[$studentId]['semesters'][] = $row['semester'];
            $groupedData[$studentId]['academic_years'][] = $row['academic_year'];
            $groupedData[$studentId]['grades'][] = $row['grade'];
            $groupedData[$studentId]['statuses'][] = $row['status'];
            $groupedData[$studentId]['teacher_ids'][] = $row['teacher_id'];
            $groupedData[$studentId]['classes'][] = $row['class'];
            $groupedData[$studentId]['credits'][] = $row['credits'];
        }
    }
} else {
    echo "<tr><td colspan='11' class='py-2 px-4 border-b text-center'>ไม่มีข้อมูล</td></tr>";
}


// เริ่มสร้างหน้า HTML
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>ระบบจบการศึกษา</title>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-5">
        <h1 class="text-2xl font-bold mb-4">ระบบจบการศึกษา</h1>
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Student ID</th>
                    <th class="py-2 px-4 border-b">Student Name</th>
                    <th class="py-2 px-4 border-b">Course Names</th> <!-- เพิ่มคอลัมน์ชื่อหลักสูตร -->
                    <th class="py-2 px-4 border-b">Semesters</th>
                    <th class="py-2 px-4 border-b">Academic Years</th>
                    <th class="py-2 px-4 border-b">Grades</th>
                    <th class="py-2 px-4 border-b">Teacher IDs</th>
                    <th class="py-2 px-4 border-b">Classes</th>
                    <th class="py-2 px-4 border-b">Credits</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // แสดงข้อมูลที่รวมกัน
                foreach ($groupedData as $data) {
                    echo "<tr>";
                    echo "<td class='py-2 px-4 border-b'>{$data['student_id']}</td>";
                    echo "<td class='py-2 px-4 border-b'>{$data['student_name']}</td>"; // แสดงชื่อของนักเรียน
                    echo "<td class='py-2 px-4 border-b'>" . implode(", ", $data['course_names']) . "</td>"; // แสดงชื่อหลักสูตร
                    echo "<td class='py-2 px-4 border-b'>" . implode(", ", $data['semesters']) . "</td>";
                    echo "<td class='py-2 px-4 border-b'>" . implode(", ", $data['academic_years']) . "</td>";
                    echo "<td class='py-2 px-4 border-b'>" . implode(", ", $data['grades']) . "</td>";
                    echo "<td class='py-2 px-4 border-b'>" . implode(", ", $data['teacher_ids']) . "</td>";
                    echo "<td class='py-2 px-4 border-b'>" . implode(", ", $data['classes']) . "</td>";
                    echo "<td class='py-2 px-4 border-b'>" . implode(", ", $data['credits']) . "</td>";
                    echo "<td class='py-2 px-4 border-b'>";
                    echo "<form action='approve_graduation.php' method='POST'>";
                    echo "<input type='hidden' name='student_id' value='{$data['student_id']}'>";
                    echo "<button type='submit' class='px-2 py-1 bg-green-500 text-white font-semibold rounded hover:bg-green-600 transition duration-200'>อนุมัติ</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

    </div>
</body>

</html>

<?php
// ปิดการเชื่อมต่อ
mysqli_close($conn);
?>