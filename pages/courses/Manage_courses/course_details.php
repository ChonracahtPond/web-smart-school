<?php

// ตรวจสอบว่ามีการส่ง ID ของหลักสูตรมาหรือไม่
if (!isset($_GET['course_id']) || empty($_GET['course_id'])) {
    die("Error: No course ID provided.");
}

$course_id = $_GET['course_id'];

// คำสั่ง SQL สำหรับดึงข้อมูลหลักสูตรที่เลือก
$sql = "SELECT c.course_id, c.course_name, c.course_description, c.teacher_id, c.course_type, c.course_code, c.credits, c.semester, c.academic_year, c.status, t.teacher_name
        FROM courses c
        LEFT JOIN teachers t ON c.teacher_id = t.teacher_id
        WHERE c.course_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $course_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Error: Course not found.");
}

$course = $result->fetch_assoc();
?>

<div class="">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">รายละเอียดรายวิชา</h1>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">ชื่อฟิลด์</th>
                    <th class="py-2 px-4 border-b">ข้อมูล</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="py-2 px-4 border-b">รหัสหลักสูตร</td>
                    <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($course['course_id']); ?></td>
                </tr>
                <tr>
                    <td class="py-2 px-4 border-b">ชื่อหลักสูตร</td>
                    <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($course['course_name']); ?></td>
                </tr>
                <tr>
                    <td class="py-2 px-4 border-b">คำอธิบาย</td>
                    <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($course['course_description']); ?></td>
                </tr>
                <tr>
                    <td class="py-2 px-4 border-b">ชื่อครู</td>
                    <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($course['teacher_name']); ?></td>
                </tr>
                <tr>
                    <td class="py-2 px-4 border-b">ประเภท</td>
                    <td class="py-2 px-4 border-b"><?php echo ($course['course_type'] === 'mandatory') ? 'บังคับ' : 'วิชาเลือก'; ?></td>
                </tr>
                <tr>
                    <td class="py-2 px-4 border-b">รหัสหลักสูตร</td>
                    <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($course['course_code']); ?></td>
                </tr>
                <tr>
                    <td class="py-2 px-4 border-b">หน่วยกิจ</td>
                    <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($course['credits']); ?></td>
                </tr>
                <tr>
                    <td class="py-2 px-4 border-b">ภาคเรียน</td>
                    <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($course['semester']); ?></td>
                </tr>
                <tr>
                    <td class="py-2 px-4 border-b">ปีการศึกษา</td>
                    <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($course['academic_year']); ?></td>
                </tr>
                <tr>
                    <td class="py-2 px-4 border-b">สถานะ</td>
                    <td class="py-2 px-4 border-b">
                        <?php
                        $status = htmlspecialchars($course['status']);
                        echo ($status == 1) ? '<span class="text-green-500">กำลังทำงาน</span>' : '<span class="text-red-500">ไม่ได้ใช้งาน</span>';
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mt-4 flex">
            <!-- <a href="?page=Check_class_name&course_id=<?php echo $course_id ?>" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 mr-4">ระบบเช็คชื่อ</a> -->
            <a href="?page=Submit_work&course_id=<?php echo $course_id ?>" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">เช็คการส่งงาน</a>
        </div>
    </div>
    <?php include "enrollment_details.php"; ?>
    <?php include "attendance/Check_class_name.php"; ?>

</div>