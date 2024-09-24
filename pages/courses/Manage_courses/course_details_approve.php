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

// ตรวจสอบว่ามีการส่งข้อมูลจากฟอร์มหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับค่าคะแนนจากฟอร์ม
    $midterm_score = $_POST['midterm_score'];
    $final_score = $_POST['final_score'];
    $assignment_score = $_POST['assignment_score'];
    $participation_score = $_POST['participation_score'];
    $status = "1";


    // คำนวณคะแนนรวม
    $total_score = $midterm_score + $final_score + $assignment_score + $participation_score;

    // ตรวจสอบว่าคะแนนรวมไม่เกิน 100
    if ($total_score > 100) {
        echo "<script>alert('คะแนนรวมไม่สามารถเกิน 100 ได้!');</script>";
    } else {
        // คำสั่ง SQL สำหรับอัปเดตข้อมูลคะแนนในตาราง courses
        $update_sql = "UPDATE courses SET midterm_score = ?, final_score = ?, assignment_score = ?, participation_score = ? , status = ? WHERE course_id = ?";

        // เตรียมและบันทึกข้อมูล
        $update_stmt = $conn->prepare($update_sql);

        // ตรวจสอบว่าการเตรียมคำสั่ง SQL สำเร็จหรือไม่
        if ($update_stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        // การผูกตัวแปร
        $update_stmt->bind_param('iiiisi', $midterm_score, $final_score, $assignment_score, $participation_score, $status, $course_id);

        if ($update_stmt->execute()) {
            // echo "<script>alert('บันทึกข้อมูลเรียบร้อย');</script>";
            echo "<script>window.location.href='education.php?page=Manage_courses&status=1';</script>";
        } else {
            // echo "<script>alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $update_stmt->error . "');</script>";
            echo "<script>window.location.href='education.php?page=Manage_courses&status=0';</script>";
        }
    }
}
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">เปิดใช้งานรายวิชา :<?php echo htmlspecialchars($course['course_id']); ?> <?php echo htmlspecialchars($course['course_name']); ?></h1>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">

        <h2 class="mt-6 text-2xl font-semibold">วิธีการให้คะแนน</h2>
        <form action="" method="post" class="mt-4" onsubmit="return validateScores()">
            <div class="mb-4">
                <label for="midterm_score" class="block text-sm font-bold">คะแนนการสอบกลางภาค:</label>
                <input type="number" id="midterm_score" name="midterm_score" class="w-full border rounded px-3 py-2 bg-white" required oninput="calculateTotal()">
            </div>
            <div class="mb-4">
                <label for="final_score" class="block text-sm font-bold">คะแนนการสอบปลายภาค:</label>
                <input type="number" id="final_score" name="final_score" class="w-full border rounded px-3 py-2 bg-white" required oninput="calculateTotal()">
            </div>
            <div class="mb-4">
                <label for="assignment_score" class="block text-sm font-bold">คะแนนการบ้านและการส่งงาน:</label>
                <input type="number" id="assignment_score" name="assignment_score" class="w-full border rounded px-3 py-2 bg-white" required oninput="calculateTotal()">
            </div>
            <div class="mb-4">
                <label for="participation_score" class="block text-sm font-bold">คะแนนการมีส่วนร่วมในชั้นเรียน:</label>
                <input type="number" id="participation_score" name="participation_score" class="w-full border rounded px-3 py-2 bg-white" required oninput="calculateTotal()">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold">คะแนนรวม:</label>
                <input type="text" id="total_score" class="w-full border rounded px-3 py-2 bg-gray-200" disabled>
            </div>
            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">บันทึกข้อมูลและเปิดใช้งาน</button>
        </form>
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
                    <td class="py-2 px-4 border-b">รหัสวิชา</td>
                    <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($course['course_code']); ?></td>
                </tr>
                <tr>
                    <td class="py-2 px-4 border-b">หน่วยกิต</td>
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


    </div>
</div>

<script>
    function calculateTotal() {
        const midtermScore = parseFloat(document.getElementById('midterm_score').value) || 0;
        const finalScore = parseFloat(document.getElementById('final_score').value) || 0;
        const assignmentScore = parseFloat(document.getElementById('assignment_score').value) || 0;
        const participationScore = parseFloat(document.getElementById('participation_score').value) || 0;

        const totalScore = midtermScore + finalScore + assignmentScore + participationScore;
        document.getElementById('total_score').value = totalScore;

        if (totalScore > 100) {
            document.getElementById('total_score').style.color = 'red'; // เปลี่ยนสีตัวอักษรเป็นสีแดง
        } else {
            document.getElementById('total_score').style.color = 'black'; // เปลี่ยนสีตัวอักษรกลับเป็นสีดำ
        }
    }

    function validateScores() {
        const totalScore = parseFloat(document.getElementById('total_score').value) || 0;

        if (totalScore > 100) {
            alert("คะแนนรวมไม่สามารถเกิน 100 ได้!");
            return false; // ยกเลิกการส่งฟอร์ม
        }
        return true; // อนุญาตให้ส่งฟอร์ม
    }
</script>