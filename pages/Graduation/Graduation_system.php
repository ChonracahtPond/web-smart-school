<?php
// Assume you have a database connection already established in $conn

// Fetch students expected to graduate based on enrollments and group by student_id and academic_year
$sql_students = "SELECT s.student_id, s.fullname,
                 GROUP_CONCAT(c.course_name SEPARATOR ', ') AS courses,
                 e.academic_year
                 FROM enrollments e
                 JOIN students s ON e.student_id = s.student_id
                 JOIN courses c ON e.course_id = c.course_id
                 WHERE
                --   e.status = '2' 
                --  AND 
                 s.status = '2' 
                 GROUP BY s.student_id, s.fullname, e.academic_year";
$students_result = $conn->query($sql_students);

// Check if there was an error with the query
if (!$students_result) {
    die("Error fetching students: " . $conn->error);
}

// Convert students data to an array
$students_data = [];
while ($row = $students_result->fetch_assoc()) {
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

<div class="">
    <div id='recipients' class="p-5 mt-6 lg:mt-0 rounded shadow bg-white">
        <h1 class="flex items-center font-sans font-bold break-normal text-indigo-500 px-2 py-8 text-xl md:text-2xl">
            จัดการรายชื่อนักศึกษาที่คาดว่าจะจบการศึกษา
        </h1>
        <div class=" my-5">
            <a href="?page=add_Graduation_system" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all my-10">รายชื่อนักศึกษาที่คาดว่าจะจบ</a>
        </div>
        <div class="bg-gray-200 w-full h-0.5 mt-5 mb-5"></div>

        <table id="students_table" class="stripe hover " style="width:100%; padding-top: 1em; padding-bottom: 1em;">
            <thead class="text-center">
                <tr>
                    <th>ลำดับ</th>
                    <th>รหัสนักศึกษา</th>
                    <th>ชื่อ-สกุล</th>
                    <th>ปีการศึกษา</th>
                    <th>การจัดการ</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php $no = 1; ?>
                <?php foreach ($students_data as $student_id => $student): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($student_id); ?></td>
                        <td><?php echo htmlspecialchars($student['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($student['academic_years']); ?></td>
                        <td>
                            <a href="?page=Graduation_approval&id=<?php echo $student_id; ?>" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all my-10">อนุมัติจบการศึกษา</a>
                            <button class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition-all">ยกเลิก</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

<script>
    $(document).ready(function() {
        $('#students_table').DataTable({
            responsive: true
        }).columns.adjust().responsive.recalc();
    });
</script>