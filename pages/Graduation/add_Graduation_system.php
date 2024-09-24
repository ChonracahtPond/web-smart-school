<?php 
// Assume you have a database connection already established in $conn

// Fetch grade_levels from the students table
$grade_levels_result = $conn->query("SELECT DISTINCT grade_level FROM students");
if ($grade_levels_result === false) {
    die('Query failed: ' . $conn->error); // Check if the query failed
}
$grade_levels = [];
while ($row = $grade_levels_result->fetch_assoc()) {
    $grade_levels[] = $row['grade_level'];
}

// Determine the selected grade level (if any)
$selected_grade_level = isset($_POST['grade_level']) ? $_POST['grade_level'] : '';

// Function to fetch students with optional grade level filtering
function fetchStudents($conn, $grade_level = null)
{
    $sql_students = "SELECT student_id, fullname, grade_level FROM students WHERE status = '0'"; // Only get students with status 0

    if ($grade_level) {
        $sql_students .= " AND grade_level = '" . $conn->real_escape_string($grade_level) . "'"; // Change WHERE to AND
    }

    $result = $conn->query($sql_students);
    if ($result === false) {
        die('Query failed: ' . $conn->error); // Check if the query failed
    }
    
    return $result;
}

// Fetch students based on selected grade level
$students_result = fetchStudents($conn, $selected_grade_level);

// Handle form submission for saving selected students
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    if (!empty($_POST['selected_students'])) {
        $selected_students = $_POST['selected_students'];
        foreach ($selected_students as $student_id) {
            // Update the status for each selected student
            $stmt = $conn->prepare("UPDATE students SET status = ? WHERE student_id = ?");
            if ($stmt === false) {
                die('Prepare failed: ' . $conn->error); // Check if prepare failed
            }
            $status = "2"; // Set status to 2
            $stmt->bind_param("si", $status, $student_id);
            $stmt->execute();
        }
        // Redirect after saving
        echo "<script>window.location.href='?page=Graduation_system&status=1';</script>";
    } else {
        echo "<script>alert('กรุณาเลือกนักศึกษาอย่างน้อยหนึ่งคน!');</script>";
    }
}
?>

<div class="mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
    <h1 class="text-2xl font-semibold text-center text-gray-900">
        <i class="fas fa-graduation-cap text-blue-500 mr-2"></i>
        เพิ่มนักศึกษาที่คาดว่าจะจบการศึกษา
    </h1>
    <div class="bg-gray-200 w-full h-0.5 mt-5"></div>

    <form method="POST">
        <div class="mt-4 p-1 flex">
            <label for="grade_level" class="block text-sm font-medium text-gray-700 my-3 mr-5">เลือกระดับชั้น <span class="text-red-500">*</span></label>
            <select id="grade_level" name="grade_level" class="mt-1 block w-56 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="this.form.submit()">
                <option value="">-- กรุณาเลือกระดับชั้น --</option>
                <?php foreach ($grade_levels as $grade_level): ?>
                    <option value="<?php echo htmlspecialchars($grade_level); ?>" <?php echo ($grade_level == $selected_grade_level) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($grade_level); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <table class="min-w-full divide-y divide-gray-300 mt-4 border border-gray-300 rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                        <input type="checkbox" id="selectAll" onclick="toggleCheckboxes(this)" class="mr-2">
                        <span>เลือกทั้งหมด</span>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">รหัสนักศึกษา</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ชื่อ-สกุล</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ระดับชั้น</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php while ($student = $students_result->fetch_assoc()): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" name="selected_students[]" value="<?php echo htmlspecialchars($student['student_id']); ?>" class="student-checkbox">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900"><?php echo htmlspecialchars($student['student_id']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900"><?php echo htmlspecialchars($student['fullname']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900"><?php echo htmlspecialchars($student['grade_level']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="mt-4">
            <button type="submit" name="confirm" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                ยืนยัน
            </button>
        </div>
    </form>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
    function toggleCheckboxes(selectAll) {
        const checkboxes = document.querySelectorAll('.student-checkbox');
        checkboxes.forEach((checkbox) => {
            checkbox.checked = selectAll.checked; // Set the checked state to match the 'selectAll' checkbox
        });
    }
</script>
