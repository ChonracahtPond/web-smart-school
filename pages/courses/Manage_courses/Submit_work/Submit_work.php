<?php
// ดึงข้อมูลจากตาราง submissions เพื่อนำมาแสดง
$sql = "SELECT submission_id, assignment_id, student_id, submission_date, grade, file, status, lesson_id 
        FROM submissions";
$result = $conn->query($sql);
?>

<div class="">
    <!-- แสดงรายการส่งงาน -->
    <div class=" bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">รายการส่งงาน</h2>
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                    <th class="px-6 py-3 border-b border-gray-300">รหัสการส่งงาน</th>
                    <th class="px-6 py-3 border-b border-gray-300">รหัสงาน</th>
                    <th class="px-6 py-3 border-b border-gray-300">รหัสนักเรียน</th>
                    <th class="px-6 py-3 border-b border-gray-300">วันที่ส่ง</th>
                    <th class="px-6 py-3 border-b border-gray-300">ไฟล์</th>
                    <th class="px-6 py-3 border-b border-gray-300">สถานะ</th>
                    <th class="px-6 py-3 border-b border-gray-300">รหัสบทเรียน</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="px-6 py-4 text-center"><?php echo $row['submission_id']; ?></td>
                            <td class="px-6 py-4 text-center"><?php echo $row['assignment_id']; ?></td>
                            <td class="px-6 py-4 text-center"><?php echo $row['student_id']; ?></td>
                            <td class="px-6 py-4 text-center"><?php echo $row['submission_date']; ?></td>
                            <td class="px-6 py-4 text-center">
                                <a href="uploads/<?php echo $row['file']; ?>" class="text-blue-500 hover:underline" download><?php echo $row['file']; ?></a>
                            </td>
                            <td class="px-6 py-4 text-center"><?php echo $row['status']; ?></td>
                            <td class="px-6 py-4 text-center"><?php echo $row['lesson_id']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">ไม่มีข้อมูลการส่งงาน</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
