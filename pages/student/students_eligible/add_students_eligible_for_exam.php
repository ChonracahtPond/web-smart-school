<?php
// ตรวจสอบการส่งฟอร์ม
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $grade_level = $_POST['grade_level'];
    $exam_status = $_POST['exam_status'];
    $exam_date = $_POST['exam_date'];
    $term = $_POST['term'];  // Added
    $academic_year = $_POST['academic_year'];  // Added

    // คำสั่ง SQL สำหรับเพิ่มข้อมูล
    $sql = "INSERT INTO students_eligible_for_exam (student_id, grade_level, exam_status, exam_date, term, academic_year) VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    // แก้ไขการ bind parameter ให้ตรงกับประเภทข้อมูล
    $stmt->bind_param("sissss", $student_id, $grade_level, $exam_status, $exam_date, $term, $academic_year);

    if ($stmt->execute()) {
        echo "<script>window.location.href = '?page=students_eligible_for_exam&status=1';</script>";
    } else {
        echo "<script>window.location.href = '?page=students_eligible_for_exam&status=0';</script>";
    }

    $stmt->close();
}

$conn->close();
?>




<!-- Modal สำหรับฟอร์มเพิ่มนักเรียน -->
<div id="addStudentModal" class="modal">
    <div class="modal-content">
        <span id="closeModal" class="text-red-500 float-right cursor-pointer text-xl">&times;</span>
        <h2 class="text-2xl font-bold mb-4">เพิ่มนักเรียนที่มีสิทธิ์สอบ</h2>
        <form action="" method="POST">
            <div class="mb-4">
                <label for="student_id" class="block text-sm font-medium text-gray-700">นักเรียน</label>
                <select id="student_id" name="student_id" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                    <option value="">เลือกนักเรียน</option>
                    <?php
                    if ($students_result->num_rows > 0) {
                        while ($student = $students_result->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($student['student_id']) . "'>" . htmlspecialchars($student['fullname']) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="grade_level" class="block text-sm font-medium text-gray-700">ระดับชั้น</label>
                <input type="number" id="grade_level" name="grade_level" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="mb-4">
                <label for="exam_status" class="block text-sm font-medium text-gray-700">สถานะการสอบ</label>
                <select id="exam_status" name="exam_status" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                    <option value="มีสิทธิ์สอบ">มีสิทธิ์สอบ</option>
                    <option value="ไม่มีสิทธิ์สอบ">ไม่มีสิทธิ์สอบ</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="exam_date" class="block text-sm font-medium text-gray-700">วันสอบ</label>
                <input type="date" id="exam_date" name="exam_date" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="mb-4">
                <label for="term" class="block text-sm font-medium text-gray-700">เทอม</label>
                <input type="text" id="term" name="term" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="mb-4">
                <label for="academic_year" class="block text-sm font-medium text-gray-700">ปีการศึกษา</label>
                <input type="text" id="academic_year" name="academic_year" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-700 focus:outline-none">บันทึก</button>
            </div>
        </form>
    </div>
</div>