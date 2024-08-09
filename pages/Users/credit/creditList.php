<?php


// ฟังก์ชันแปลงสถานะเป็นข้อความที่เข้าใจง่าย
function get_status_label($status)
{
    switch ($status) {
        case 'registered':
            return 'ลงทะเบียนแล้ว';
        case 'attended':
            return 'เข้าร่วมแล้ว';
        case 'cancelled':
            return 'ยกเลิก';
        default:
            return 'ไม่ระบุ';
    }
}

// ฟังก์ชันแปลงประเภทกิจกรรมเป็นข้อความที่เข้าใจง่าย
function get_activity_type_label($type)
{
    switch ($type) {
        case 1:
            return 'กิจกรรมการเรียนรู้ที่มุ่งเน้นการพัฒนาทักษะชีวิตของตนเองและครอบครัว';
        case 2:
            return 'กิจกรรมการเรียนรู้ที่มุ่งเน้นการพัฒนาชุมชนและสังคม';
            // case 3:
            //     return 'กิจกรรมการพัฒนาทักษะอาชีพ';
            // case 4:
            //     return 'กิจกรรมเพื่อสุขภาพและการกีฬา';
            // case 5:
            //     return 'กิจกรรมทางวัฒนธรรมและศิลปะ';
        default:
            return 'ไม่ระบุ';
    }
}

// ฟังก์ชันคำนวณหน่วยกิตรวม
function calculate_total_credits($data)
{
    $total_credits = 0;
    foreach ($data as $row) {
        $total_credits += $row['Credits'];
    }
    return $total_credits;
}

// ฟังก์ชันคำนวณหน่วยกิตตามประเภทกิจกรรม
function calculate_credits_by_activity_type($data, $activity_type)
{
    $credits_by_type = 0;
    foreach ($data as $row) {
        if ($row['activity_type'] == $activity_type) {
            $credits_by_type += $row['Credits'];
        }
    }
    return $credits_by_type;
}

// ดึงข้อมูลทั้งหมดจากฐานข้อมูล
$sql = "
    SELECT 
        ap.participant_id, 
        ap.activity_id, 
        ap.student_id, 
        ap.registration_date, 
        ap.status, 
        ap.Credits,
        a.activity_name, 
        a.activity_type, 
        s.fullname AS student_name
    FROM 
        activity_participants ap
    LEFT JOIN 
        activities a ON ap.activity_id = a.activity_id
    LEFT JOIN 
        students s ON ap.student_id = s.student_id
";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    // Move the result pointer back to the start for display
    $result->data_seek(0);
}

// คำนวณหน่วยกิตทั้งหมด
$total_credits = calculate_total_credits($data);
?>

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-6">รายการหน่วยกิตนักเรียน-นักศึกษา</h1>

    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
        <!-- ช่องค้นหา -->
        <div class="mb-6">
            <label for="search-input" class="block text-gray-700 dark:text-gray-300 text-lg font-medium mb-2">ค้นหา:</label>
            <input type="text" id="search-input" class="p-3 w-full border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500" placeholder="ค้นหาด้วย Participant ID, Student ID หรือ Activity ID">
        </div>
        <!-- แสดงหน่วยกิตรวม -->
        <?php if ($result->num_rows > 0) : ?>
            <div class="mt-6 bg-gray-100 dark:bg-gray-700 p-4 rounded-lg mb-5">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">หน่วยกิตรวมทั้งหมด : <?php echo htmlspecialchars($total_credits); ?> หน่วยกิต</h2>
            </div>
        <?php endif; ?>

        <!-- แสดงข้อมูลตามประเภทกิจกรรม -->
        <?php
        // ประเภทกิจกรรมที่คุณต้องการแสดง
        $activity_types = [1, 2,];
        foreach ($activity_types as $type) :
            $credits_by_type = calculate_credits_by_activity_type($data, $type);
        ?>
            <h1 class="text-3xl font-extrabold mb-8 text-center text-gray-900 p-10"><?php echo get_activity_type_label($type); ?></h1>
            <div class="mt-6 bg-gray-100 dark:bg-gray-700 p-4 rounded-lg mb-5">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">หน่วยกิตสำหรับประเภทกิจกรรม "<?php echo get_activity_type_label($type); ?>" : <?php echo htmlspecialchars($credits_by_type); ?> หน่วยกิต</h2>
            </div>
            <table class="w-full border-collapse bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <tr class="text-left">
                        <th class="px-6 py-3 border-b">ชื่อกิจกรรม</th>
                        <th class="px-6 py-3 border-b">ประเภทกิจกรรม</th>
                        <th class="px-6 py-3 border-b">รหัสนักศึกษา</th>
                        <th class="px-6 py-3 border-b">ชื่อ-นามสกุล นักศึกษา</th>
                        <th class="px-6 py-3 border-b">วันลงทะเบียน</th>
                        <th class="px-6 py-3 border-b">สถานะ</th>
                        <th class="px-6 py-3 border-b">หน่วยกิต</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 dark:text-gray-200">
                    <?php
                    $type_data = array_filter($data, function ($row) use ($type) {
                        return $row['activity_type'] == $type;
                    });
                    if (!empty($type_data)) : ?>
                        <?php foreach ($type_data as $row) : ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($row['activity_name']); ?></td>
                                <td class="px-6 py-4 border-b"><?php echo get_activity_type_label($row['activity_type']); ?></td>
                                <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($row['student_id']); ?></td>
                                <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($row['student_name']); ?></td>
                                <td class="px-6 py-4 border-b"><?php echo htmlspecialchars(date('d-m-Y', strtotime($row['registration_date']))); ?></td>
                                <td class="px-6 py-4 border-b"><?php echo get_status_label($row['status']); ?></td>
                                <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($row['Credits']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">ไม่พบข้อมูล</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endforeach; ?>
    </div>
</div>

<script>
    // JavaScript สำหรับการค้นหาแบบเรียลไทม์
    document.getElementById('search-input').addEventListener('input', function() {
        const searchQuery = this.value.toLowerCase();
        const tables = document.querySelectorAll('table');

        tables.forEach(table => {
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const participantId = row.cells[0].textContent.toLowerCase();
                const activityId = row.cells[1].textContent.toLowerCase();
                const studentId = row.cells[3].textContent.toLowerCase();
                row.style.display = participantId.includes(searchQuery) || activityId.includes(searchQuery) || studentId.includes(searchQuery) ? '' : 'none';
            });
        });
    });
</script>