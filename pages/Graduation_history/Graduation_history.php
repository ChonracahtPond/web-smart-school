<?php
// Assume you have a database connection already established in $conn

// Fetch distinct graduation years from graduation_history table for select option
$sql_years = "SELECT DISTINCT graduation_year FROM graduation_history ORDER BY graduation_year DESC";
$years_result = $conn->query($sql_years);

// Check if there was an error with the query
if (!$years_result) {
    die("Error fetching graduation years: " . $conn->error);
}

// Store the years in an array
$graduation_years = [];
while ($row = $years_result->fetch_assoc()) {
    $graduation_years[] = $row['graduation_year'];
}

// Free result set
$years_result->free();

// Fetch students who have graduated from the graduation_history table
$sql_students = "SELECT gh.student_id, s.fullname, gh.graduation_year, gh.education_level, gh.institution, gh.honors, gh.status
                 FROM graduation_history gh
                 JOIN students s ON gh.student_id = s.student_id
                 WHERE s.status = '5'
                 GROUP BY gh.student_id, s.fullname, gh.graduation_year
                 ";
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
            'graduation_year' => $row['graduation_year'],
            'education_level' => $row['education_level'],
            'institution' => $row['institution'],
            'honors' => $row['honors'],
            'status' => $row['status'],
        ];
    }
}

// Free result set
$students_result->free();

?>

<div class="">
    <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">

        <h1 class="text-indigo-600 text-3xl font-bold mb-6">
            นักศึกษาที่จบการศึกษา
        </h1>

        <!-- Select dropdown for graduation year -->
        <div class="mb-4">
            <label for="graduation_year" class="block text-gray-700">เลือกปีการศึกษา:</label>
            <select id="graduation_year" class="form-select mt-1 block w-full" onchange="filterByYear()">
                <option value="all">แสดงทั้งหมด</option>
                <?php foreach ($graduation_years as $year): ?>
                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="bg-gray-200 w-full h-0.5 mt-5 mb-5"></div>



        <table id="students_table" class="stripe hover " style="width:100%; padding-top: 1em; padding-bottom: 1em;">
            <thead class="text-center">
                <tr>
                    <th>ลำดับ</th>
                    <th>รหัสนักศึกษา</th>
                    <th>ชื่อ-สกุล</th>
                    <th>ระดับการศึกษา</th>
                    <th>ปีการศึกษา</th>
                    <th>สถาบัน</th>
                    <th>สถานะ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody class="text-center" id="students_body">
                <?php $no = 1; ?>
                <?php foreach ($students_data as $student_id => $student): ?>
                    <tr data-year="<?php echo htmlspecialchars($student['graduation_year']); ?>">
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($student_id); ?></td>
                        <td><?php echo htmlspecialchars($student['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($student['education_level']); ?></td>
                        <td><?php echo htmlspecialchars($student['graduation_year']); ?></td>
                        <td><?php echo htmlspecialchars($student['institution']); ?></td>
                        <td><?php echo htmlspecialchars($student['status']); ?></td>
                        <td>
                            <a href="?page=&id=<?php echo $student_id; ?>" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all my-10">ดูประวัติ</a>
                            <button class="bg-indigo-400 text-white px-3 py-1 rounded-lg hover:bg-indigo-600 transition-all">ใบจบ</button>
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

    // Function to filter students by graduation year
    function filterByYear() {
        var selectedYear = document.getElementById('graduation_year').value;
        var rows = document.querySelectorAll('#students_body tr');

        rows.forEach(function(row) {
            var year = row.getAttribute('data-year');
            if (selectedYear === 'all' || year === selectedYear) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>