<?php
// รับค่า course_id จาก URL
$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;

// สร้างคำสั่ง SQL เพื่อดึงข้อมูลจากตาราง enrollments, lessons, students, attendance และ courses
$sql = "SELECT 
            e.enrollment_id, 
            s.student_id, 
            s.student_name AS student_name, 
            e.semester, 
            e.academic_year, 
            e.grade, 
            e.status AS enrollment_status, 
            e.teacher_id, 
            e.class AS enrollment_class, 
            e.credits, 
            l.lesson_id, 
            l.lesson_title, 
            l.lesson_content, 
            l.lesson_date, 
            l.status AS lesson_status,
            a.attendance_id,
            a.attendance_date,
            a.status AS attendance_status,
            c.course_name
        FROM enrollments e 
        LEFT JOIN lessons l ON e.course_id = l.course_id 
        LEFT JOIN students s ON e.student_id = s.student_id 
        LEFT JOIN attendance a ON a.student_id = s.student_id AND a.lesson_id = l.lesson_id 
        LEFT JOIN courses c ON e.course_id = c.course_id 
        WHERE e.course_id = ?
        ORDER BY l.lesson_id ASC";  // เรียงลำดับตาม lesson_id

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("ข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . $conn->error);
}

$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

// ตรวจสอบว่ามีข้อมูลหรือไม่เพื่อดึงชื่อหลักสูตร
if ($result->num_rows > 0) {
    // ดึงชื่อหลักสูตรจากผลลัพธ์
    $row = $result->fetch_assoc();
    $course_name = $row['course_name']; // เก็บชื่อหลักสูตร

    // ปิดการใช้การเก็บข้อมูลของ SQL statement 
    $stmt->close();

    // สร้างคำสั่ง SQL ใหม่เพื่อดึงข้อมูลทั้งหมดอีกครั้ง
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $course_name = "ไม่พบหลักสูตร"; // ถ้าไม่มีข้อมูล
}

?>

<div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white my-3">เช็คชื่อการเข้าเรียน</h1>

    <!-- ปุ่มออกรายงาน -->
    <div class="mb-4 flex space-x-4">
        <!-- ปุ่มออกรายงาน PDF -->
        <a href="../mpdf/Check_students/export_pdf.php?course_id=<?php echo $course_id; ?>" target="_blank"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center w-46 h-10">
            <svg class="h-5 w-5 mr-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" />
                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                <line x1="9" y1="9" x2="10" y2="9" />
                <line x1="9" y1="13" x2="15" y2="13" />
                <line x1="9" y1="17" x2="15" y2="17" />
            </svg>
            ออกรายงาน PDF
        </a>

        <!-- ปุ่มออกรายงาน Excel -->
        <form method="post" action="../exports/Check_students/export_excel.php?course_id=<?php echo $course_id; ?>">
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center w-46 h-10">
                <svg class="h-5 w-5 mr-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    <line x1="9" y1="9" x2="10" y2="9" />
                    <line x1="9" y1="13" x2="15" y2="13" />
                    <line x1="9" y1="17" x2="15" y2="17" />
                </svg>
                ออกข้อมูลเป็น Excel
            </button>
        </form>
    </div>




    <table class="min-w-full bg-white border border-gray-300">
        <thead>
            <tr>
                <!-- <th class="border border-gray-300 px-4 py-2 w-24 h-24">ชื่อ\สัปดาห์</th> -->
                <th class="border border-gray-300 px-4 py-2 w-24 h-20">
                    <p class="inset-y-0.5 text-right">สัปดาห์</p>
                    <!-- <p class="bg-gray-500 w-24 h-2"></p> -->
                    <!-- <p class="absolute inset-0 bg-gray-500 transform rotate-45"></p> -->
                    <p class="relative w-[110px] h-0.5 ">
                        <span class="absolute inset-0 bg-gray-300 transform rotate-45"></span>
                    </p>
                    <p class=" top-1 text-left">ชื่อ</p>
                </th>
                <th class="border border-gray-300 px-4 py-2">1</th>
                <th class="border border-gray-300 px-4 py-2">2</th>
                <th class="border border-gray-300 px-4 py-2">3</th>
                <th class="border border-gray-300 px-4 py-2">4</th>
                <th class="border border-gray-300 px-4 py-2">5</th>
                <th class="border border-gray-300 px-4 py-2">6</th>
                <th class="border border-gray-300 px-4 py-2">7</th>
                <th class="border border-gray-300 px-4 py-2">8</th>
                <th class="border border-gray-300 px-4 py-2">9</th>
                <th class="border border-gray-300 px-4 py-2">10</th>
                <th class="border border-gray-300 px-4 py-2">11</th>
                <th class="border border-gray-300 px-4 py-2">12</th>
                <th class="border border-gray-300 px-4 py-2">13</th>
                <th class="border border-gray-300 px-4 py-2">14</th>
                <th class="border border-gray-300 px-4 py-2">15</th>
                <th class="border border-gray-300 px-4 py-2">16</th>
                <th class="border border-gray-300 px-4 py-2">17</th>
                <th class="border border-gray-300 px-4 py-2">18</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $attendanceData = [];
                // จัดกลุ่มข้อมูลการเข้าเรียนตาม student_id
                while ($row = $result->fetch_assoc()) {
                    $attendanceData[$row['student_id']][] = $row;
                }

                // แสดงข้อมูลในตาราง
                foreach ($attendanceData as $studentData) {
                    $studentName = htmlspecialchars($studentData[0]['student_name']);
                    echo "<tr>";
                    echo "<td class='border border-gray-300 px-4 py-2 w-48'>{$studentName}</td>";

                    // แสดงข้อมูลการเข้าเรียนจาก 1 ถึง 18
                    for ($i = 0; $i < 18; $i++) {
                        if (isset($studentData[$i])) {
                            // กำหนดคลาสพื้นหลังตามสถานะ
                            switch ($studentData[$i]['attendance_status']) {
                                case 0:
                                    $status = 'มาเรียน';
                                    $bgClass = 'bg-green-200'; // สีเขียว
                                    break;
                                case 1:
                                    $status = 'ขาด';
                                    $bgClass = 'bg-red-300'; // สีแดง
                                    break;
                                case 2:
                                    $status = 'ลา';
                                    $bgClass = 'bg-yellow-300'; // สีเหลือง
                                    break;
                                case 3:
                                    $status = 'มาสาย';
                                    $bgClass = 'bg-gray-300'; // สีเทา
                                    break;
                                default:
                                    $status = '-'; // หากสถานะไม่ตรงกัน
                                    $bgClass = ''; // ไม่มีคลาสพื้นหลัง
                            }
                            echo "<td class='border border-gray-300 px-4 py-2 {$bgClass}'>" . htmlspecialchars($status) . "</td>";
                        } else {
                            echo "<td class='border border-gray-300 px-4 py-2'>-</td>"; // แสดง - ถ้าไม่มีข้อมูล
                        }
                    }
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='19' class='border border-gray-300 px-4 py-2 text-center'>ไม่มีข้อมูล</td></tr>";
            }
            ?>
        </tbody>


    </table>
</div>