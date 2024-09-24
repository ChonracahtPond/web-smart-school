<?php
// Initialize variables
$student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$midterm_score = 0;
$final_score = 0;
$assignment_score = 0;
$final_grade = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $midterm_score = intval($_POST['midterm_score']);
    $final_score = intval($_POST['final_score']);
    $assignment_score = intval($_POST['assignment_score']);

    // Calculate final grade
    // Calculate final grade
    $total_score = ($midterm_score + $final_score) + $assignment_score;
    $final_grade = calculateGrade($total_score);

    // Save the grades in the database
    $stmt = $conn->prepare("INSERT INTO grades (student_id, midterm_score, final_score, assignment_score, total_score, final_grade) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiiis", $student_id, $midterm_score, $final_score, $assignment_score, $total_score, $final_grade);
    $stmt->execute();
    $stmt->close();
}

// Function to calculate final grade based on total score
function calculateGrade($total_score) {
    if ($total_score >= 90) {
        return 'A';
    } elseif ($total_score >= 80) {
        return 'B';
    } elseif ($total_score >= 70) {
        return 'C';
    } elseif ($total_score >= 60) {
        return 'D';
    } else {
        return 'F';
    }
}

// Fetch student name for display
$stmt = $conn->prepare("SELECT student_name FROM students WHERE student_id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$stmt->bind_result($student_name);
$stmt->fetch();
$stmt->close();
?>

<div class="mx-auto px-2 mt-5">
    <h1 class="flex items-center font-sans font-bold break-normal text-indigo-500 px-2 text-xl md:text-2xl">
        การให้คะแนนนักเรียน (รหัสนักศึกษา: <?php echo htmlspecialchars($student_id); ?>)
    </h1>
    <h1 class="flex items-center font-sans font-bold break-normal text-indigo-500 px-2 text-xl md:text-2xl">
        ชื่อ: <?php echo htmlspecialchars($student_name); ?>
    </h1>

    <form method="post" action="">
        <div class="mt-4">
            <label for="midterm_score" class="block text-gray-700">คะแนนสอบกลางภาค (0-50):</label>
            <input type="number" name="midterm_score" id="midterm_score" class="border rounded p-2 w-full" max="50" required>
        </div>
        <div class="mt-4">
            <label for="final_score" class="block text-gray-700">คะแนนสอบปลายภาค (0-50):</label>
            <input type="number" name="final_score" id="final_score" class="border rounded p-2 w-full" max="50" required>
        </div>
        <div class="mt-4">
            <label for="assignment_score" class="block text-gray-700">คะแนนจากการส่งงาน (0-50):</label>
            <input type="number" name="assignment_score" id="assignment_score" class="border rounded p-2 w-full" max="50" required>
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-indigo-500 text-white rounded p-2">บันทึกคะแนน</button>
        </div>
    </form>

    <?php if ($final_grade): ?>
        <div class="mt-6">
            <h2 class="text-lg">คะแนนรวม: <?php echo $total_score; ?></h2>
            <h2 class="text-lg">เกรดสุดท้าย: <?php echo htmlspecialchars($final_grade); ?></h2>
        </div>
    <?php endif; ?>
</div>

<?php
$conn->close();
?>
