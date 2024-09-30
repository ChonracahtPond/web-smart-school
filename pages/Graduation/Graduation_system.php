<?php
// Assume you have a database connection already established in $conn

// Fetch students expected to graduate based on enrollments and group by student_id and academic_year
$sql_students = "SELECT s.student_id, s.fullname,
                 GROUP_CONCAT(c.course_name SEPARATOR ', ') AS courses,
                 e.academic_year
                 FROM enrollments e
                 JOIN students s ON e.student_id = s.student_id
                 JOIN courses c ON e.course_id = c.course_id
                 WHERE e.status = '2' 
                 GROUP BY s.student_id, s.fullname, e.academic_year";
$students_result = $conn->query($sql_students);

// Check if there was an error with the query
if (!$students_result) {
    die("Error fetching students: " . $conn->error);
}

// Convert students data to an array
$students_data = [];
while ($row = $students_result->fetch_assoc()) {
    // Combine courses and academic years by student_id
    $student_id = $row['student_id'];
    if (!isset($students_data[$student_id])) {
        $students_data[$student_id] = [
            'fullname' => $row['fullname'],
            'courses' => $row['courses'],
            'academic_years' => [$row['academic_year']]
        ];
    } else {
        $students_data[$student_id]['courses'] .= ', ' . $row['courses'];
        $students_data[$student_id]['academic_years'][] = $row['academic_year'];
    }
}

// Transform $students_data back to an indexed array
$students_data = array_map(function ($student) {
    return [
        'fullname' => $student['fullname'],
        'courses' => $student['courses'],
        'academic_years' => implode(', ', array_unique($student['academic_years']))
    ];
}, $students_data);

// Free result set
$students_result->free();
?>

<div class="mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white text-center">จัดการรายชื่อนักศึกษาที่คาดว่าจะจบการศึกษา</h1>
    <div class="bg-white shadow-lg rounded-lg p-4 mt-4">
        <div class=" my-5">
            <!-- <button id="addStudent" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all">รายชื่อนักศึกษาที่คาดว่าจะจบ</button> -->

            <a href="?page=add_Graduation_system" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all my-10">รายชื่อนักศึกษาที่คาดว่าจะจบ</a>
        </div>
        <table class="min-w-full divide-y divide-gray-300">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ลำดับ</th> <!-- เพิ่มคอลัมน์หมายเลขลำดับ -->
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">รหัสนักศึกษา</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ชื่อ-สกุล</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ปีการศึกษา</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">การจัดการ</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $no = 1; // ตัวแปรสำหรับหมายเลขลำดับ 
                ?>
                <?php foreach ($students_data as $student_id => $student): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $no++; ?></td> <!-- แสดงหมายเลขลำดับ -->
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($student_id); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($student['fullname']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($student['academic_years']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <!-- <button class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition-all" onclick="editStudent('<?php echo $student_id; ?>')">แก้ไข</button> -->
                            <button class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition-all" onclick="deleteStudent('<?php echo $student_id; ?>')">ยกเลิก</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

<script>
    document.getElementById('addStudent').addEventListener('click', function() {
        // Implement the logic to open a modal or redirect to a page for adding a new student
        alert('Implement add student functionality here!');
    });

    function editStudent(studentId) {
        // Implement the logic to open a modal or redirect to a page for editing the student details
        alert('Implement edit student functionality for student ID: ' + studentId);
    }

    function deleteStudent(studentId) {
        // Implement the logic to confirm and delete the student
        if (confirm('คุณแน่ใจว่าต้องการลบข้อมูลนักเรียนนี้?')) {
            // Perform delete operation, e.g., send an AJAX request to the server
            alert('Implement delete functionality for student ID: ' + studentId);
        }
    }
</script>