<?php

// คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง activity_participants
$participants_sql = "SELECT ap.participant_id, ap.activity_id, ap.student_id, ap.registration_date, ap.status, ap.Credits, s.fullname, a.activity_name 
                      FROM activity_participants ap 
                      JOIN students s ON ap.student_id = s.student_id
                      JOIN activities a ON ap.activity_id = a.activity_id";
$participants_result = $conn->query($participants_sql);

// คำสั่ง SQL สำหรับดึงข้อมูลกิจกรรม
$activities_sql = "SELECT activity_id, activity_name FROM activities";
$activities_result = $conn->query($activities_sql);

// คำสั่ง SQL สำหรับดึงข้อมูลนักเรียน
$students_sql = "SELECT student_id, fullname FROM students";
$students_result = $conn->query($students_sql);
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Manage Credits</h1>

    <!-- ฟอร์มสำหรับเพิ่มข้อมูล -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Add Activity Participant</h2>
        <form action="admin.php?page=add_participant" method="POST" class="mt-4">
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300">Activity:</label>
                <select name="activity_id" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                    <?php while ($activity = $activities_result->fetch_assoc()) : ?>
                        <option value="<?php echo htmlspecialchars($activity['activity_id']); ?>">
                            <?php echo htmlspecialchars($activity['activity_name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300">Student:</label>
                <select name="student_id" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                    <?php while ($student = $students_result->fetch_assoc()) : ?>
                        <option value="<?php echo htmlspecialchars($student['student_id']); ?>">
                            <?php echo htmlspecialchars($student['fullname']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300">Registration Date:</label>
                <input type="date" name="registration_date" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300">Status:</label>
                <!-- <input type="text" name="status" class="mt-1 p-2 w-full border border-gray-300 rounded" required> -->
                <select name="pets" id="pet-select" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                    <option value="">-------- กรุณาเลือกสถานะ --------</option>
                    <option value="0">กำลังทำ</option>
                    <option value="1">สำเร็จ</option>
                    <option value="2">ไม่สำเร็จ</option>
                    <option value="3">พิจารณา</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300">Credits:</label>
                <input type="number" name="credits" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
            </div>
            <button type="submit" name="add" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">Add Participant</button>
        </form>
    </div>

    <!-- ตารางแสดงข้อมูล -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <table class="w-full mt-4 border-collapse">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <th class="px-4 py-2 border-b">Participant ID</th>
                    <th class="px-4 py-2 border-b">Activity Name</th>
                    <th class="px-4 py-2 border-b">Student ID</th>
                    <th class="px-4 py-2 border-b">Student Name</th>

                    <th class="px-4 py-2 border-b">Registration Date</th>
                    <th class="px-4 py-2 border-b">Status</th>
                    <th class="px-4 py-2 border-b">Credits</th>
                    <th class="px-4 py-2 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($participants_result->num_rows > 0) : ?>
                    <?php while ($row = $participants_result->fetch_assoc()) : ?>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['participant_id']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['activity_name']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['student_id']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['fullname']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['registration_date']); ?></td>
                            <td class="px-4 py-2 border-b">
                                <?php
                                // แปลงค่า status เป็นข้อความ
                                switch ($row['status']) {
                                    case 0:
                                        echo 'กำลังทำ';
                                        break;
                                    case 1:
                                        echo 'สำเร็จ';
                                        break;
                                    case 2:
                                        echo 'ไม่สำเร็จ';
                                        break;
                                    case 3:
                                        echo 'พิจารณา';
                                        break;
                                    default:
                                        echo 'ไม่ระบุ';
                                }
                                ?>
                            </td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['Credits']); ?></td>
                            <td class="px-4 py-2 border-b">
                                <!-- ฟอร์มสำหรับแก้ไขเครดิต -->
                                <form action="admin.php?page=update_credits" method="POST" class="inline">
                                    <input type="hidden" name="participant_id" value="<?php echo htmlspecialchars($row['participant_id']); ?>">
                                    <input type="number" name="credits" value="<?php echo htmlspecialchars($row['Credits']); ?>" class="p-2 border border-gray-300 rounded" required>
                                    <button type="submit" name="update" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">Update</button>
                                </form>
                                <!-- ฟอร์มสำหรับลบข้อมูล -->
                                <form action="admin.php?page=delete_participant" method="POST" class="inline">
                                    <input type="hidden" name="participant_id" value="<?php echo htmlspecialchars($row['participant_id']); ?>">
                                    <button type="submit" name="delete" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-red-600">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="9" class="px-4 py-2 text-center">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>