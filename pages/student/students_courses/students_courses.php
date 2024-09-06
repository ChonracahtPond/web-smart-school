<?php
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : '';

if (!$student_id) {
    die('กรุณาระบุ student_id');
}

// SQL query to fetch enrollment data
$sql = "
    SELECT e.enrollment_id, e.student_id, e.course_id, e.semester, e.academic_year, e.grade, e.status, e.teacher_id, e.class, e.credits,
           s.fullname AS student_fullname, c.course_name
    FROM enrollments e
    JOIN students s ON e.student_id = s.student_id
    JOIN courses c ON e.course_id = c.course_id
    WHERE e.student_id = '" . $conn->real_escape_string($student_id) . "'
";

$result = $conn->query($sql);

// Calculate the average grade and total credits
$total_grade = 0;
$total_courses = 0;
$total_credits = 0;

while ($row = $result->fetch_assoc()) {
    if ($row['status'] == '0') { // Only include completed courses for GPA calculation
        $total_grade += $row['grade'];
        $total_courses++;
        $total_credits += $row['credits'];
    }
}

$average_grade = $total_courses > 0 ? ($total_grade / $total_courses) : 0;
$average_grade = number_format($average_grade, 2); // Format the GPA to 2 decimal places

// Reset result pointer to fetch data again for display
$result->data_seek(0);
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.7/dist/tailwind.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    .table-row {
        transition: background-color 0.3s, transform 0.3s;
    }

    .table-row:hover {
        background-color: #f0f9ff;
        transform: scale(1.02);
    }

    .icon {
        transition: color 0.3s;
    }

    .icon:hover {
        color: #1d4ed8;
    }

    .status-pending {
        color: #2563eb;
    }

    .status-completed {
        color: #16a34a;
    }

    .status-dropped {
        color: #dc2626;
    }

    .status-canceled {
        color: #d97706;
    }
</style>

<div class="container mx-auto px-6 py-8">
    <h1 class="text-4xl font-bold text-blue-800 mb-8">ข้อมูลการลงทะเบียนของนักเรียน</h1>
    <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
        <?php if ($result->num_rows > 0) : ?>
            <div class="p-6 border-b border-gray-200 flex justify-end space-x-8">
                <p class="text-lg font-medium text-gray-700">
                    ค่าเฉลี่ยเกรด:
                    <span class="font-bold text-blue-600"><?php echo $average_grade; ?>/4.00</span>
                </p>
                <p class="text-lg font-medium text-gray-700">
                    รวมหน่วยกิต:
                    <span class="font-bold text-green-600"><?php echo $total_credits; ?></span>
                </p>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID การลงทะเบียน</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ชื่อนักเรียน</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ชื่อวิชา</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">เทอม</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ปีการศึกษา</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">เกรด</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">สถานะ</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">รหัสครู</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ห้องเรียน</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">หน่วยกิต</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr class="table-row">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($row['enrollment_id']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($row['student_fullname']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($row['course_name']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($row['semester']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($row['academic_year']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($row['grade']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php
                                switch ($row['status']) {
                                    case '0':
                                        echo '<i class="fas fa-graduation-cap icon status-pending"></i> กำลังศึกษา';
                                        break;
                                    case '1':
                                        echo '<i class="fas fa-check-circle icon status-completed"></i> ศึกษาจบแล้ว';
                                        break;
                                    case '2':
                                        echo '<i class="fas fa-times-circle icon status-dropped"></i> ดรอปเรียน';
                                        break;
                                    case '3':
                                        echo '<i class="fas fa-ban icon status-canceled"></i> ยกเลิกรายวิชา';
                                        break;
                                    default:
                                        echo 'ไม่ทราบสถานะ';
                                }
                                ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($row['teacher_id']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($row['class']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($row['credits']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p class="text-gray-600 text-center">ไม่พบข้อมูลการลงทะเบียนสำหรับนักเรียนนี้</p>
        <?php endif; ?>
    </div>

</div>


<?php
include "GradeList.php";
?>