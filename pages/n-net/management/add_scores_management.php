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

// Prepare to fetch scores
$scores = [];
if ($students_result->num_rows > 0) {
    $student_ids = [];
    while ($student = $students_result->fetch_assoc()) {
        $student_ids[] = $student['student_id'];
    }
    // Fetch scores for these students
    if (!empty($student_ids)) {
        $ids_placeholder = implode(',', array_fill(0, count($student_ids), '?'));
        $stmt = $conn->prepare("SELECT student_id, score FROM nnet_scores WHERE student_id IN ($ids_placeholder)");
        $stmt->bind_param(str_repeat('i', count($student_ids)), ...$student_ids);
        $stmt->execute();
        $result_scores = $stmt->get_result();
        while ($score_row = $result_scores->fetch_assoc()) {
            $scores[$score_row['student_id']] = $score_row['score'];
        }
        $stmt->close();
    }
}

/// Handle form submission to save scores
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    foreach ($_POST['scores'] as $student_id => $score) {
        if ($score !== '') { // Only process if score is not empty
            $score = intval($score); // Convert score to integer
            $exam_date = date('Y-m-d'); // Get current date in 'YYYY-MM-DD' format

            // Check if the score already exists
            $check_stmt = $conn->prepare("SELECT nnet_scores_id FROM nnet_scores WHERE student_id = ?");
            $check_stmt->bind_param('i', $student_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                // Update existing score
                $update_stmt = $conn->prepare("UPDATE nnet_scores SET score = ? WHERE student_id = ?");
                $update_stmt->bind_param('si', $score, $student_id);
                $update_stmt->execute();
                $update_stmt->close();
            } else {
                // Insert new score
                $insert_stmt = $conn->prepare("INSERT INTO nnet_scores (student_id, score, exam_date) VALUES (?, ?, ?)");
                $insert_stmt->bind_param('iis', $student_id, $score, $exam_date);
                $insert_stmt->execute();
                $insert_stmt->close();
            }

            $check_stmt->close();
        }
    }
    // Optionally redirect or display a success message
    echo "<script>window.location.href='?page=scores_management&status=1';</script>"; // Redirect to success page
}


?>

<div class="mx-auto p-6 bg-white shadow-lg rounded-lg ">
    <h1 class="text-2xl font-semibold text-center text-gray-900">
        <i class="fas fa-graduation-cap text-blue-500 mr-2"></i>
        เพิ่มคะแนน N-NET ใหม่
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">รหัสนักศึกษา</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ชื่อ-สกุล</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ระดับชั้น</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">คะแนน</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php
                // Fetch students again for display
                $students_result = fetchStudents($conn, $selected_grade_level);
                while ($student = $students_result->fetch_assoc()): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900"><?php echo htmlspecialchars($student['student_id']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900"><?php echo htmlspecialchars($student['fullname']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900"><?php echo htmlspecialchars($student['grade_level']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="number" name="scores[<?php echo htmlspecialchars($student['student_id']); ?>]"
                                class="border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 w-full p-2"
                                placeholder="กรอกคะแนน"
                                value="<?php echo isset($scores[$student['student_id']]) ? htmlspecialchars($scores[$student['student_id']]) : ''; ?>">
                        </td>
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