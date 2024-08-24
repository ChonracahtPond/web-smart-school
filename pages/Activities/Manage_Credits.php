<?php

// คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง activity_participants พร้อมกับ Credits ของกิจกรรม
$participants_sql = "SELECT ap.participant_id, ap.activity_id, ap.student_id, ap.registration_date, ap.status, ap.Credits as participant_credits, s.fullname, a.activity_name, a.activity_Credits as activity_credits
                      FROM activity_participants ap 
                      JOIN students s ON ap.student_id = s.student_id
                      JOIN activities a ON ap.activity_id = a.activity_id";
$participants_result = $conn->query($participants_sql);
if (!$participants_result) {
    die("Query failed: " . $conn->error);
}

// คำสั่ง SQL สำหรับดึงข้อมูลกิจกรรม
$activities_sql = "SELECT activity_id, activity_name, activity_Credits FROM activities";
$activities_result = $conn->query($activities_sql);
if (!$activities_result) {
    die("Query failed: " . $conn->error);
}

// คำสั่ง SQL สำหรับดึงข้อมูลนักเรียน
$students_sql = "SELECT student_id, fullname FROM students";
$students_result = $conn->query($students_sql);
if (!$students_result) {
    die("Query failed: " . $conn->error);
}



// ตรวจสอบว่ามีข้อมูล POST หรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $activity_id = $_POST['activity_id'];
        $student_id = $_POST['student_id'];
        $registration_date = $_POST['registration_date'];
        $status = $_POST['status'];

        // ดึงเครดิตของกิจกรรม
        $activity_credit_sql = "SELECT activity_Credits FROM activities WHERE activity_id = ?";
        $stmt = $conn->prepare($activity_credit_sql);
        $stmt->bind_param("i", $activity_id);
        $stmt->execute();
        $stmt->bind_result($activity_credits);
        $stmt->fetch();
        $stmt->close();

        // บันทึกข้อมูลผู้เข้าร่วมกิจกรรม
        $insert_sql = "INSERT INTO activity_participants (activity_id, student_id, registration_date, status, Credits) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("iisii", $activity_id, $student_id, $registration_date, $status, $activity_credits);
        if (!$stmt->execute()) {
            die("Insert failed: " . $stmt->error);
        }
        echo "<script>alert('Activity added successfully'); window.location.href='system.php?page=Manage_Credits';</script>";
        $stmt->close();
    } elseif (isset($_POST['update'])) {
        $participant_id = $_POST['participant_id'];
        $credits = $_POST['credits'];
        $status = $_POST['status'];

        // Prepare the SQL statement to update both Credits and Status
        $update_sql = "UPDATE activity_participants SET Credits = ?, Status = ? WHERE participant_id = ?";
        $stmt = $conn->prepare($update_sql);

        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        // Bind the parameters
        $stmt->bind_param("isi", $credits, $status, $participant_id);

        if (!$stmt->execute()) {
            die("Update failed: " . $stmt->error);
        }

        echo "<script>alert('Activity updated successfully'); window.location.href='system.php?page=Manage_Credits';</script>";

        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        $participant_id = $_POST['participant_id'];

        // ลบข้อมูลผู้เข้าร่วมกิจกรรม
        $delete_sql = "DELETE FROM activity_participants WHERE participant_id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $participant_id);
        if (!$stmt->execute()) {
            die("Delete failed: " . $stmt->error);
        }
        echo "<script>alert('Activity added successfully'); window.location.href='system.php?page=Manage_Credits';</script>";
        $stmt->close();
    }


    // if ($conn->query($sql) === TRUE) {
    //     echo "<script>alert('Activity added successfully'); window.location.href='system.php?page=Manage_Credits';</script>";
    // } else {
    //     echo "Error: " . $sql . "<br>" . $conn->error;
    // }
}


?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">จัดการหน่วยกิต</h1>
    <!-- ฟอร์มสำหรับเพิ่มข้อมูล -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">+ เพิ่มผู้เข้าร่วมกิจกรรม</h2>
        <form action="" method="POST" class="mt-4">
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300">กิจกรรม:</label>
                <select name="activity_id" id="activity-select" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                    <?php while ($activity = $activities_result->fetch_assoc()) : ?>
                        <option value="<?php echo htmlspecialchars($activity['activity_id']); ?>" data-credits="<?php echo htmlspecialchars($activity['activity_Credits']); ?>">
                            <?php echo htmlspecialchars($activity['activity_name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300">นักศึกษา:</label>
                <select name="student_id" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                    <?php while ($student = $students_result->fetch_assoc()) : ?>
                        <option value="<?php echo htmlspecialchars($student['student_id']); ?>">
                            <?php echo htmlspecialchars($student['fullname']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300">วันที่ลงทะเบียน:</label>
                <input type="date" name="registration_date" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300">สถานะ:</label>
                <select name="status" id="status-select" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                    <option value="">-------- กรุณาเลือกสถานะ --------</option>
                    <option value="registered">กำลังทำ</option>
                    <option value="attended">สำเร็จ</option>
                    <option value="cancelled">ไม่สำเร็จ</option>
                    <option value="consider">พิจารณา</option>
                </select>
            </div>
            <button type="submit" name="add" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">+เพิ่มผู้เข้าร่วม</button>
        </form>
    </div>
    <!-- ฟอร์มค้นหา -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">ค้นหาผู้เข้าร่วม</h2>
        <input type="text" id="search-input" class="mt-1 p-2 w-full border border-gray-300 rounded" placeholder="ค้นหาตามชื่อกิจกรรม, ชื่อนักศึกษา หรือวันที่ลงทะเบียน">
    </div>

    <!-- ตารางแสดงข้อมูล -->
    <!-- ตารางแสดงข้อมูล -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <table class="w-full mt-4 border-collapse">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <th class="px-4 py-2 border-b">รหัสผู้เข้าร่วม</th>
                    <th class="px-4 py-2 border-b">ชื่อกิจกรรม</th>
                    <th class="px-4 py-2 border-b">รหัสนักศึกษา</th>
                    <th class="px-4 py-2 border-b">ชื่อ-นามสกุล นักศึกษา</th>
                    <th class="px-4 py-2 border-b">วันที่ลงทะเบียน</th>
                    <th class="px-4 py-2 border-b">สถานะ</th>
                    <th class="px-4 py-2 border-b">หน่วยกิต</th>
                    <th class="px-4 py-2 border-b">การดำเนินการ</th>
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
                            <td class="px-4 py-2 border-b ">
                                <style>
                                    .status-registered,
                                    .status-attended,
                                    .status-cancelled,
                                    .status-consider,
                                    .status-unknown {
                                        display: inline-block;
                                        padding: 8px 16px;
                                        /* เพิ่มความสูงและความกว้าง */
                                        border-radius: 4px;
                                        /* ทำมุมให้โค้งมน */
                                        font-weight: bold;
                                        /* ทำให้ข้อความหนาขึ้น */
                                        color: white;
                                        /* ตั้งสีข้อความเป็นขาว */
                                    }

                                    .status-registered {
                                        background-color: yellow;
                                        color: black;
                                        /* เปลี่ยนสีข้อความเป็นสีดำเพื่อให้แตกต่างจากพื้นหลัง */
                                    }

                                    .status-attended {
                                        background-color: green;
                                    }

                                    .status-cancelled {
                                        background-color: red;
                                    }

                                    .status-consider {
                                        background-color: skyblue;
                                    }

                                    .status-unknown {
                                        background-color: gray;
                                    }
                                </style>


                                <?php
                                $statusClass = '';

                                switch ($row['status']) {
                                    case "registered":
                                        $statusText = 'กำลังทำ';
                                        $statusClass = 'status-registered';
                                        break;
                                    case "attended":
                                        $statusText = 'สำเร็จ';
                                        $statusClass = 'status-attended';
                                        break;
                                    case "cancelled":
                                        $statusText = 'ไม่สำเร็จ';
                                        $statusClass = 'status-cancelled';
                                        break;
                                    case "consider":
                                        $statusText = 'พิจารณา';
                                        $statusClass = 'status-consider';
                                        break;
                                    default:
                                        $statusText = 'ไม่ระบุ';
                                        $statusClass = 'status-unknown';
                                        break;
                                }
                                ?>

                                <span class="<?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                            </td>

                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['participant_credits']); ?></td>
                            <td class="px-4 py-2 border-b">
                                <!-- ปุ่มแก้ไข -->
                                <button onclick="editParticipant('<?php echo htmlspecialchars($row['participant_id']); ?>', <?php echo htmlspecialchars($row['participant_credits']); ?>)" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-yellow-600">แก้ไข</button>
                                <!-- ปุ่มลบ -->
                                <form action="" method="POST" class="inline-block">
                                    <input type="hidden" name="participant_id" value="<?php echo htmlspecialchars($row['participant_id']); ?>">
                                    <button type="submit" name="delete" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-red-600">ลบ</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" class="px-4 py-2 border-b text-center">ไม่พบข้อมูล</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>


<!-- ฟอร์มการแก้ไขที่ซ่อนอยู่ -->
<div id="edit-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4">
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">แก้ไขข้อมูลผู้เข้าร่วม</h2>
        <form action="" method="POST" class="mt-4">
            <input type="hidden" name="participant_id" id="edit-participant-id">
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300">สถานะ:</label>
                <select name="status" id="edit-status-input" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                    <option value="">-------- กรุณาเลือกสถานะ --------</option>
                    <option value="registered">กำลังทำ</option>
                    <option value="attended">สำเร็จ</option>
                    <option value="cancelled">ไม่สำเร็จ</option>
                    <option value="consider">พิจารณา</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300">หน่วยกิจ:</label>
                <input type="number" name="credits" id="edit-credits-input" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
            </div>
            <button type="submit" name="update" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">บันทึกการแก้ไข</button>
            <button type="button" onclick="closeEditModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-gray-600 ml-2">ยกเลิก</button>
        </form>
    </div>
</div>

<script>
    function editParticipant(participantId, status, credits) {
        document.getElementById('edit-participant-id').value = participantId;

        // Set the status
        const statusSelect = document.getElementById('edit-status-input');
        statusSelect.value = status;

        // Set the credits
        document.getElementById('edit-credits-input').value = credits;

        document.getElementById('edit-modal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('edit-modal').classList.add('hidden');
    }

    // เพิ่มการทำงานให้กับ select activity
    document.getElementById('activity-select').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var status = selectedOption.getAttribute('data-status');
        var credits = selectedOption.getAttribute('data-credits');

        if (status !== null) {
            document.getElementById('edit-status-input').value = status;
        }
        if (credits !== null) {
            document.getElementById('edit-credits-input').value = credits;
        }
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const tableBody = document.querySelector('tbody');

        searchInput.addEventListener('input', function() {
            const searchTerm = searchInput.value.toLowerCase();
            const rows = tableBody.querySelectorAll('tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let match = false;

                cells.forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(searchTerm)) {
                        match = true;
                    }
                });

                row.style.display = match ? '' : 'none';
            });
        });
    });
</script>