<?php

if (isset($_GET['id'])) {
    $edit_id = intval($_GET['id']);

    // Fetch the data for the student eligibility
    $sql = "SELECT * FROM students_eligible_for_exam WHERE eligible_id = $edit_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<p class='text-red-500'>ไม่พบข้อมูลที่ต้องการแก้ไข</p>";
        exit;
    }
}
?>

<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">แก้ไขข้อมูลนักเรียนที่มีสิทธิ์สอบ</h1>

    <form action="?page=update_students_eligible_for_exam" method="post" class="bg-white shadow-md rounded-lg p-6">
        <input type="hidden" name="eligible_id" value="<?php echo htmlspecialchars($row['eligible_id']); ?>">

        <div class="mb-4">
            <label for="student_id" class="block text-gray-700 text-sm font-medium mb-2">รหัสนักเรียน:</label>
            <select id="student_id" name="student_id" class="form-select mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                <?php
                // Fetch all students for the dropdown
                $students_sql = "SELECT student_id, fullname FROM students";
                $students_result = $conn->query($students_sql);
                while ($student = $students_result->fetch_assoc()) {
                    $selected = ($student['student_id'] == $row['student_id']) ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($student['student_id']) . "' $selected>" . htmlspecialchars($student['fullname']) . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="grade_level" class="block text-gray-700 text-sm font-medium mb-2">ระดับชั้น:</label>
            <select id="grade_level" name="grade_level" class="form-select mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                <option value="" disabled selected>เลือกระดับชั้น</option>
                <option value="ประถม" <?php echo ($row['grade_level'] == 'ประถม') ? 'selected' : ''; ?>>ประถม</option>
                <option value="มัธยมต้น" <?php echo ($row['grade_level'] == 'มัธยมต้น') ? 'selected' : ''; ?>>มัธยมต้น</option>
                <option value="มัธยมปลาย" <?php echo ($row['grade_level'] == 'มัธยมปลาย') ? 'selected' : ''; ?>>มัธยมปลาย</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="exam_status" class="block text-gray-700 text-sm font-medium mb-2">สถานะการสอบ:</label>
            <select id="exam_status" name="exam_status" class="form-select mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                <option value="" disabled selected>เลือกสถานะการสอบ</option>
                <option value="มีสิทธิ์สอบ" <?php echo ($row['exam_status'] == 'มีสิทธิ์สอบ') ? 'selected' : ''; ?>>มีสิทธิ์สอบ</option>
                <option value="ไม่มีสิทธิ์สอบ" <?php echo ($row['exam_status'] == 'ไม่มีสิทธิ์สอบ') ? 'selected' : ''; ?>>ไม่มีสิทธิ์สอบ</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="exam_date" class="block text-gray-700 text-sm font-medium mb-2">วันสอบ:</label>
            <input type="date" id="exam_date" name="exam_date" value="<?php echo htmlspecialchars($row['exam_date']); ?>" class="form-input mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
        </div>

        <div class="mb-4">
            <label for="term" class="block text-gray-700 text-sm font-medium mb-2">เทอม:</label>
            <input type="text" id="term" name="term" value="<?php echo htmlspecialchars($row['term']); ?>" class="form-input mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
        </div>

        <div class="mb-4">
            <label for="academic_year" class="block text-gray-700 text-sm font-medium mb-2">ปีการศึกษา:</label>
            <input type="text" id="academic_year" name="academic_year" value="<?php echo htmlspecialchars($row['academic_year']); ?>" class="form-input mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">บันทึกการเปลี่ยนแปลง</button>
        </div>
    </form>
</div>
