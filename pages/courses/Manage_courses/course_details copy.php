<!-- <?php

        // ตรวจสอบว่ามีการส่ง ID ของหลักสูตรมาหรือไม่
        // if (!isset($_GET['course_id']) || empty($_GET['course_id'])) {
        //     die("Error: No course ID provided.");
        // }

        // $course_id = $_GET['course_id'];

        // // คำสั่ง SQL สำหรับดึงข้อมูลหลักสูตรที่เลือก
        // $sql = "SELECT c.course_id, c.course_name, c.course_description, c.teacher_id, c.course_type, c.course_code, c.credits, c.semester, c.academic_year, c.status, t.teacher_name
        // FROM courses c
        // LEFT JOIN teachers t ON c.teacher_id = t.teacher_id
        // WHERE c.course_id = ?";

        // $stmt = $conn->prepare($sql);
        // $stmt->bind_param('i', $course_id);
        // $stmt->execute();
        // $result = $stmt->get_result();

        // if ($result->num_rows === 0) {
        //     die("Error: Course not found.");
        // }

        // $course = $result->fetch_assoc();
        ?>

    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">รายละเอียดหลักสูตร</h1>
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
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
            <div class="mt-4">
                <a href="manage_courses.php" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">กลับไปที่รายการหลักสูตร</a>
            </div>
            <?php include "enrollment_details.php"; ?>
        </div>
    </div> -->



<?php
// ตรวจสอบว่ามีการส่ง ID ของหลักสูตรมาหรือไม่
if (!isset($_GET['course_id']) || empty($_GET['course_id'])) {
    die("Error: No course ID provided.");
}

$course_id = $_GET['course_id'];

// คำสั่ง SQL สำหรับดึงข้อมูลการลงทะเบียนทั้งหมดที่เกี่ยวข้องกับ course_id พร้อมรวมข้อมูลจากตาราง students และ teachers
$sql = "SELECT e.enrollment_id, e.student_id, e.course_id, e.semester, e.academic_year, e.grade, e.status, e.teacher_id, 
               s.student_name, s.student_email, 
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
    die("Error: No enrollments found for this course.");
}
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">รายละเอียดการลงทะเบียน</h1>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <?php while ($enrollment = $result->fetch_assoc()) : ?>
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">การลงทะเบียนรหัส <?php echo htmlspecialchars($enrollment['enrollment_id']); ?></h2>
                <table class="min-w-full bg-white border border-gray-200 mt-4">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">หัวข้อ</th>
                            <th class="py-2 px-4 border-b">ข้อมูล</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2 px-4 border-b">รหัสการลงทะเบียน</td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($enrollment['enrollment_id']); ?></td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">รหัสนักเรียน</td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($enrollment['student_id']); ?></td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">ชื่อของนักเรียน</td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($enrollment['student_name']); ?></td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">อีเมลของนักเรียน</td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($enrollment['student_email']); ?></td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">รหัสหลักสูตร</td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($enrollment['course_id']); ?></td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">ภาคเรียน</td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($enrollment['semester']); ?></td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">ปีการศึกษา</td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($enrollment['academic_year']); ?></td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">เกรด</td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($enrollment['grade']); ?></td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">สถานะ</td>
                            <td class="py-2 px-4 border-b">
                                <?php
                                $status = htmlspecialchars($enrollment['status']);
                                echo ($status == 1) ? '<span class="text-green-500">เปิดใช้งาน</span>' : '<span class="text-red-500">ปิดใช้งาน</span>';
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">ชื่อครู</td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($enrollment['teacher_name']); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php endwhile; ?>
        <div class="mt-4">
            <a href="manage_enrollments.php" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">กลับไปที่รายการการลงทะเบียน</a>
        </div>
    </div>
</div>