<?php
// Assume you have a database connection already established in $conn

// Handle graduation approval
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_graduation'])) {
    $student_id = $_POST['student_id'];
    $sql = "UPDATE students SET status = 'Approved' WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $student_id);
    if ($stmt->execute()) {
        echo "<script>alert('Graduation approved successfully'); window.location.href='Graduation_system.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Handle student status change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_status'])) {
    $student_id = $_POST['student_id'];
    $new_status = $_POST['new_status'];
    $sql = "UPDATE students SET grade_level = ? WHERE student_id = ?";
    $stmt->bind_param('si', $new_status, $student_id);
    if ($stmt->execute()) {
        echo "<script>alert('Student status updated successfully'); window.location.href='Graduation_system.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Handle ConGraduation file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['congraduation_file'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["congraduation_file"]["fullname"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is a valid image or video
    if ($fileType != "gif" && $fileType != "mp4" && $fileType != "avi" && $fileType != "mov") {
        echo "Sorry, only GIF, MP4, AVI & MOV files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["congraduation_file"]["tmp_name"], $target_file)) {
            echo "<script>alert('File uploaded successfully'); window.location.href='Graduation_system.php';</script>";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Retrieve students and their enrollments for displaying
$sql = "SELECT students.student_id, students.fullname, students.grade_level, students.status, 
               GROUP_CONCAT(enrollments.course_id ORDER BY enrollments.course_id ASC SEPARATOR ', ') AS courses,
               GROUP_CONCAT(enrollments.semester ORDER BY enrollments.course_id ASC SEPARATOR ', ') AS semesters,
               GROUP_CONCAT(enrollments.academic_year ORDER BY enrollments.course_id ASC SEPARATOR ', ') AS academic_years,
               GROUP_CONCAT(enrollments.grade ORDER BY enrollments.course_id ASC SEPARATOR ', ') AS grades,
               GROUP_CONCAT(enrollments.status ORDER BY enrollments.course_id ASC SEPARATOR ', ') AS enrollment_statuses
        FROM students 
        LEFT JOIN enrollments ON students.student_id = enrollments.student_id
        GROUP BY students.student_id, students.fullname, students.grade_level, students.status";
$result = $conn->query($sql);

if ($result === false) {
    die("Error executing query: " . $conn->error);
}
?>


<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">ระบบการสำเร็จการศึกษา</h1>

    <!-- Graduation Approval Section -->
    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-8">อนุมัติการสำเร็จการศึกษา</h2>
    <form method="post">
        <div class="mb-4">
            <label for="student_id" class="block text-gray-700 dark:text-gray-400">รหัสประจำตัวนักศึกษา</label>
            <input type="text" name="student_id" id="student_id" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
        </div>
        <button type="submit" name="approve_graduation" class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-green-600">อนุมัติการสำเร็จการศึกษา</button>
    </form>

    <!-- Display Students and Their Enrollment Details -->
    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-8">รายชื่อนักศึกษาและการลงทะเบียน</h2>
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">รหัสนักศึกษา</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ชื่อ-นามสกุล</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ระดับชั้น</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">สถานะ</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">รหัสวิชา</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ภาคการศึกษา</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ปีการศึกษา</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">เกรด</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">สถานะการลงทะเบียน</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php while($row = $result->fetch_assoc()): 
                // Convert the comma-separated strings into arrays
                $courses = explode(', ', $row['courses']);
                $semesters = explode(', ', $row['semesters']);
                $academic_years = explode(', ', $row['academic_years']);
                $grades = explode(', ', $row['grades']);
                $enrollment_statuses = explode(', ', $row['enrollment_statuses']);
            ?>
            <tr>
                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['student_id']); ?></td>
                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['fullname']); ?></td>
                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['grade_level']); ?></td>
                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['status']); ?></td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <ul class="list-disc list-inside">
                        <?php foreach($courses as $course): ?>
                        <li><?php echo htmlspecialchars($course); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <ul class="list-disc list-inside">
                        <?php foreach($semesters as $semester): ?>
                        <li><?php echo htmlspecialchars($semester); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <ul class="list-disc list-inside">
                        <?php foreach($academic_years as $academic_year): ?>
                        <li><?php echo htmlspecialchars($academic_year); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <ul class="list-disc list-inside">
                        <?php foreach($grades as $grade): ?>
                        <li><?php echo htmlspecialchars($grade); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <ul class="list-disc list-inside">
                        <?php foreach($enrollment_statuses as $enrollment_status): ?>
                        <li><?php echo htmlspecialchars($enrollment_status); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

