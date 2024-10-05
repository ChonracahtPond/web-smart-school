<?php

// Fetch student data from the database with status_register = 3
$sql = "SELECT * FROM register WHERE status_register IN (3)";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $students = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $students = [];
}

$conn->close();
?>


<div class=" ">

    <div class="overflow-x-auto bg-white border border-gray-300 rounded-lg shadow-lg p-4">

        <h1 class="text-3xl font-bold mb-6 text-red-800">ผู้ลงทะเบียนสมัครเรียนที่ถูกยกเลิก</h1>

        <table class="min-w-full ">
            <thead>
                <tr class="border-b bg-red-50 border-gray-200">
                    <th class="py-4 px-6 text-left text-sm font-semibold text-red-700">No</th>
                    <th class="py-4 px-6 text-left text-sm font-semibold text-red-700">ชื่อของนักเรียน</th>
                    <th class="py-4 px-6 text-left text-sm font-semibold text-red-700">เพศ</th>
                    <th class="py-4 px-6 text-left text-sm font-semibold text-red-700">อีเมล</th>
                    <th class="py-4 px-6 text-left text-sm font-semibold text-red-700">หมายเลขโทรศัพท์</th>
                    <th class="py-4 px-6 text-left text-sm font-semibold text-red-700">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($students)): ?>
                    <?php $no = 1; // เริ่มต้นลำดับที่ 1 
                    ?>
                    <?php foreach ($students as $student): ?>
                        <tr class="border-b border-gray-200 hover:bg-red-50">
                            <td class="py-3 px-6 text-sm text-gray-700"><?php echo $no++; ?></td>
                            <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['student_name']); ?></td>
                            <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['gender']); ?></td>
                            <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['email']); ?></td>
                            <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['phone_number']); ?></td>
                            <td class="py-3 px-6 text-sm text-gray-700 flex space-x-4">
                                <a href="?page=view_detail&id=<?php echo $student['id']; ?>" class="text-blue-500 hover:text-blue-700 flex items-center">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                    <span class="ml-2">ดูข้อมูลการสมัคร</span>
                                </a>
                                <!-- <a href="edit.php?id=<?php echo $student['id']; ?>" class="text-green-500 hover:text-green-700 flex items-center">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" />
                                            <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                                            <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
                                            <line x1="16" y1="5" x2="19" y2="8" />
                                        </svg>
                                        <span class="ml-2">แก้ไข</span>
                                    </a> -->
                                <!-- <a href="delete.php?id=<?php echo $student['id']; ?>" class="text-red-500 hover:text-red-700 flex items-center">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6" />
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            <line x1="10" y1="11" x2="10" y2="17" />
                                            <line x1="14" y1="11" x2="14" y2="17" />
                                        </svg>
                                        <span class="ml-2">ลบ</span>
                                    </a> -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="py-3 px-6 text-sm text-gray-700 text-center">ไม่พบข้อมูล</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>