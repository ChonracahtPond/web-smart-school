<?php

// รับ student_id จาก query string
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : '';

if ($student_id) {
    // ดึงข้อมูลของนักเรียน
    $sql = "SELECT * FROM students WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    if (!$student) {
        echo "<div class='text-red-500 text-center'>ไม่พบนักเรียน.</div>";
        exit;
    }
} else {
    echo "<div class='text-red-500 text-center'>ไม่ได้ระบุรหัสนักเรียน.</div>";
    exit;
}
?>

<div class="justify-center bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4">
    <?php include "stepper.php"; ?>
    <div class="mx-auto p-6">

        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-6 text-center">รายละเอียดนักเรียน</h1>

        <div class="mt-6 p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-center justify-center">
                    <div class="w-32 h-32 overflow-hidden rounded-full border border-gray-300 shadow-md">
                        <?php if ($student['file_images']) : ?>
                            <img src="<?php echo htmlspecialchars($student['file_images']); ?>" alt="ภาพนักเรียน" class="w-full h-full object-cover">
                        <?php else : ?>
                            <div class="flex items-center justify-center w-full h-full bg-gray-200 text-gray-500">ไม่มีภาพ</div>
                        <?php endif; ?>
                    </div>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">ข้อมูลนักเรียน</h2>
                    <ul class="mt-4 space-y-2">
                        <li><strong>ID:</strong> <?php echo htmlspecialchars($student['student_id']); ?></li>
                        <li><strong>ระดับชั้น:</strong> <?php echo htmlspecialchars($student['grade_level']); ?></li>
                        <li><strong>กลุ่ม:</strong> <?php echo htmlspecialchars($student['section']); ?></li>
                        <li><strong>ชื่อผู้ใช้:</strong> <?php echo htmlspecialchars($student['username']); ?></li>
                        <li><strong>ชื่อเต็ม:</strong> <?php echo htmlspecialchars($student['fullname']); ?></li>
                        <li><strong>ชื่อเล่น:</strong> <?php echo htmlspecialchars($student['nicknames']); ?></li>
                        <li><strong>อีเมล:</strong> <?php echo htmlspecialchars($student['email']); ?></li>
                        <li><strong>หมายเลขโทรศัพท์:</strong> <?php echo htmlspecialchars($student['phone_number']); ?></li>
                        <li><strong>วันเกิด:</strong> <?php echo htmlspecialchars($student['date_of_birth']); ?></li>
                        <li><strong>เพศ:</strong> <?php echo htmlspecialchars($student['gender']); ?></li>
                        <li><strong>สถานะ:</strong> <?php echo htmlspecialchars($student['status']); ?></li>
                        <li><strong>ชื่อของนักเรียน:</strong> <?php echo htmlspecialchars($student['student_name']); ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- ปุ่มสำหรับดาวน์โหลด PDF -->
        <div class="mt-6 text-center">
            <a href="../mpdf/generate_pdf.php?id=<?php echo urlencode($student_id); ?>" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition duration-300">ดาวน์โหลด PDF</a>
        </div>
    </div>
</div>