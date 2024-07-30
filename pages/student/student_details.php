<?php

// รับ student_id จาก query string
$student_id = isset($_GET['id']) ? $_GET['id'] : '';

if ($student_id) {
    // ดึงข้อมูลของนักเรียน
    $sql = "SELECT * FROM students WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    if (!$student) {
        echo "Student not found.";
        exit;
    }
} else {
    echo "No student ID provided.";
    exit;
}
?>

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-6">Student Details</h1>

    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg mt-6 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex items-center">
                <div class="w-32 h-32 overflow-hidden rounded-full border border-gray-300">
                    <?php if ($student['file_images']) : ?>
                        <img src="<?php echo htmlspecialchars($student['file_images']); ?>" alt="Student Image" class="w-full h-full object-cover">
                    <?php else : ?>
                        <div class="flex items-center justify-center w-full h-full bg-gray-200 text-gray-500">No Image</div>
                    <?php endif; ?>
                </div>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Student Information</h2>
                <ul class="mt-4 space-y-2">
                    <li><strong>ID:</strong> <?php echo htmlspecialchars($student['student_id']); ?></li>
                    <li><strong>Grade Level:</strong> <?php echo htmlspecialchars($student['grade_level']); ?></li>
                    <li><strong>Section:</strong> <?php echo htmlspecialchars($student['section']); ?></li>
                    <li><strong>Username:</strong> <?php echo htmlspecialchars($student['username']); ?></li>
                    <li><strong>Full Name:</strong> <?php echo htmlspecialchars($student['fullname']); ?></li>
                    <li><strong>Nicknames:</strong> <?php echo htmlspecialchars($student['nicknames']); ?></li>
                    <li><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></li>
                    <li><strong>Phone Number:</strong> <?php echo htmlspecialchars($student['phone_number']); ?></li>
                    <li><strong>Date of Birth:</strong> <?php echo htmlspecialchars($student['date_of_birth']); ?></li>
                    <li><strong>Gender:</strong> <?php echo htmlspecialchars($student['gender']); ?></li>
                    <li><strong>Status:</strong> <?php echo htmlspecialchars($student['status']); ?></li>
                    <li><strong>Student Name:</strong> <?php echo htmlspecialchars($student['student_name']); ?></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- ปุ่มสำหรับดาวน์โหลด PDF -->
    <div class="mt-6">
        <a href="../mpdf/generate_pdf.php?id=<?php echo urlencode($student_id); ?>" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Download PDF</a>
        <!-- <a href="?page=generate_pdf.php?id=<?php echo urlencode($student_id); ?>" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Download PDF</a> -->
    </div>
</div>