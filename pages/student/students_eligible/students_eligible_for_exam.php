<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.0.0/dist/tailwind.min.css" rel="stylesheet">

<?php
// ดึงข้อมูลนักเรียนจากตาราง students
$students_sql = "SELECT student_id, fullname FROM students";
$students_result = $conn->query($students_sql);

// Retrieve distinct terms and academic years for filters
$terms_sql = "SELECT DISTINCT term FROM students_eligible_for_exam ORDER BY term";
$terms_result = $conn->query($terms_sql);

$years_sql = "SELECT DISTINCT academic_year FROM students_eligible_for_exam ORDER BY academic_year";
$years_result = $conn->query($years_sql);

$current_year = date('Y'); // Get the current year
$academic_year_now = $current_year + 543;

// Apply filters if selected
$term_filter = isset($_GET['term']) ? $conn->real_escape_string($_GET['term']) : '';
$year_filter = isset($_GET['academic_year']) ? $conn->real_escape_string($_GET['academic_year']) : $academic_year_now;


$sql = "SELECT e.*, s.fullname
        FROM students_eligible_for_exam e
        JOIN students s ON e.student_id = s.student_id
        WHERE 1";

if ($term_filter) {
    $sql .= " AND e.term = '$term_filter'";
}

if ($year_filter) {
    $sql .= " AND e.academic_year = '$year_filter'";
}

$result = $conn->query($sql);
?>

<style>
    .table-container {
        transition: all 0.3s ease;
    }

    .table-container:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .icon {
        font-size: 1.2rem;
        color: #4A5568;
    }

    /* สไตล์สำหรับ modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 50;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        position: relative;
        margin: auto;
        padding: 20px;
        background-color: white;
        border-radius: 8px;
        width: 90%;
        max-width: 500px;
    }
</style>

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">นักเรียนที่มีสิทธิ์สอบ</h1>
    <!-- การดำเนินการ -->
    <div class="flex mb-5">
        <!-- Filter Section -->

        <!-- Term Filter -->
        <div class="flex items-center space-x-4">
            <label for="termFilter" class="text-gray-700">เทอม:</label>
            <select id="termFilter" name="term" class="form-select block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">ทั้งหมด</option>
                <?php while ($term = $terms_result->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($term['term']) ?>" <?= $term_filter == $term['term'] ? 'selected' : '' ?>><?= htmlspecialchars($term['term']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <!-- Year Filter -->
        <div class="flex items-center space-x-4 mx-8">
            <label for="yearFilter" class="text-gray-700">ปีการศึกษา:</label>
            <select id="yearFilter" name="academic_year" class="form-select block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">ทั้งหมด</option>
                <?php while ($year = $years_result->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($year['academic_year']) ?>" <?= $year_filter == $year['academic_year'] ? 'selected' : '' ?>><?= htmlspecialchars($year['academic_year']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- ปุ่มเพิ่มนักเรียน -->
        <button id="addStudentBtn" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-300 ease-in-out flex items-center space-x-2">
            <i class="fas fa-plus"></i>
            <span>เพิ่มนักเรียน</span>
        </button>
    </div>

    <div class="overflow-x-auto">
        <div class="bg-white shadow-lg rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500">รหัสนักเรียน</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500">ชื่อ</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500">ระดับชั้น</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500">สถานะการสอบ</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500">วันสอบ</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500">เทอม</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500">ปีการศึกษา</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500">การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='hover:bg-gray-50 transition duration-300 ease-in-out'>";
                            echo "<td class='py-4 px-6'>" . htmlspecialchars($row["student_id"]) . "</td>";
                            echo "<td class='py-4 px-6'>" . htmlspecialchars($row["fullname"]) . "</td>";
                            echo "<td class='py-4 px-6'>" . htmlspecialchars($row["grade_level"]) . "</td>";
                            echo "<td class='py-4 px-6'>" . htmlspecialchars($row["exam_status"]) . "</td>";
                            echo "<td class='py-4 px-6'>" . htmlspecialchars($row["exam_date"]) . "</td>";
                            echo "<td class='py-4 px-6'>" . htmlspecialchars($row["term"]) . "</td>";
                            echo "<td class='py-4 px-6'>" . htmlspecialchars($row["academic_year"]) . "</td>";
                            echo "<td class='py-4 px-6 flex items-center space-x-4'>
                            <a href='?page=edit_students_eligible_for_exam&id=" . htmlspecialchars($row["eligible_id"]) . "' class='text-blue-600 hover:text-blue-800 transition duration-300 ease-in-out flex items-center space-x-1'>
                                <i class='fas fa-edit'></i>
                                <span>แก้ไข</span>
                            </a>
                            <a href='?page=delete_students_eligible_for_exam&id=" . htmlspecialchars($row["eligible_id"]) . "' class='text-red-600 hover:text-red-800 transition duration-300 ease-in-out flex items-center space-x-1' onclick='return confirm(\"คุณแน่ใจหรือไม่ที่จะลบข้อมูลนี้?\")'>
                                <i class='fas fa-trash-alt'></i>
                                <span>ลบ</span>
                            </a>
                        </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='py-4 px-6 text-center'>ไม่พบข้อมูล</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>



<?php include "add_students_eligible_for_exam.php"; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php include "script.php"; ?>