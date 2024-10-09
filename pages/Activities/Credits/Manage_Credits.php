<?php

// คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง activity_participants พร้อมกับ Credits ของกิจกรรม
$participants_sql = "SELECT ap.participant_id, ap.activity_id, ap.student_id, ap.registration_date ,s.status , ap.status, ap.Credits as participant_credits, s.fullname, a.activity_name, a.activity_Credits as activity_credits
                      FROM activity_participants ap 
                      JOIN students s ON ap.student_id = s.student_id
                      JOIN activities a ON ap.activity_id = a.activity_id
                      WHERE s.status IN (0 , 2)
                      ";

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
$students_sql = "SELECT student_id, fullname FROM students WHERE status IN (0 , 2)";
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
        $stmt->bind_param("iissi", $activity_id, $student_id, $registration_date, $status, $activity_credits);
        if (!$stmt->execute()) {
            die("Insert failed: " . $stmt->error);
        }
        echo "<script>window.location.href='?page=Manage_Credits&status=1';</script>";
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

        echo "<script> window.location.href='?page=Manage_Credits&status=1';</script>";

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
        echo "<script> window.location.href='?page=Manage_Credits&status=1';</script>";
        $stmt->close();
    }
}

?>


<div class="">
    <div id="recipients" class="p-8 mt-6 lg:mt-0 rounded-lg shadow bg-white">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-5">จัดการหน่วยกิต</h1>
        <button id="open-modal-button" class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-blue-600 transition duration-150 ease-in-out flex items-center">
            <svg class="h-5 w-5 mr-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" />
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>

            เพิ่มผู้เข้าร่วมกิจกรรม
        </button>
        <div class="bg-gray-200 w-full h-0.5 my-5"></div>

        <!-- <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-2">ค้นหาผู้เข้าร่วม</h2> -->
        <!-- <input type="text" id="search-input" class="mt-1 mb-10 p-3 w-full border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400" placeholder="ค้นหาตามชื่อกิจกรรม, ชื่อนักศึกษา หรือวันที่ลงทะเบียน"> -->

        <table id="example" class="display stripe hover" style="width:100%;">
            <thead>
                <tr>
                    <th>No.</th> <!-- เพิ่มคอลัมน์ลำดับเลข -->
                    <th>กิจกรรม</th>
                    <th>นักศึกษา</th>
                    <th>เครดิตกิจกรรม</th>
                    <th>เครดิตผู้เข้าร่วม</th>
                    <th>วันที่ลงทะเบียน</th>
                    <th>สถานะ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php
                $no = 1; // เริ่มต้นเลขลำดับที่ 1
                while ($row = $participants_result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $no++; ?></td> <!-- แสดงเลขลำดับ -->
                        <td><?php echo htmlspecialchars($row['activity_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($row['activity_credits']); ?></td>
                        <td><?php echo htmlspecialchars($row['participant_credits']); ?></td>
                        <td><?php echo htmlspecialchars($row['registration_date']); ?></td>
                        <td>
                            <?php
                            $status = htmlspecialchars($row['status']);
                            $statusClass = '';
                            switch ($status) {
                                case 'กำลังทำ':
                                    $statusClass = 'bg-orange-200 text-orange-800'; // สีส้ม
                                    break;
                                case 'สำเร็จ':
                                    $statusClass = 'bg-green-200 text-green-800'; // สีเขียว
                                    break;
                                case 'ไม่สำเร็จ':
                                    $statusClass = 'bg-red-200 text-red-800'; // สีแดง
                                    break;
                                case 'พิจารณา':
                                    $statusClass = 'bg-gray-200 text-gray-800'; // สีเทา
                                    break;
                                default:
                                    $statusClass = 'bg-gray-100 text-gray-600'; // สีพื้นฐาน
                            }
                            ?>
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold <?php echo $statusClass; ?>">
                                <?php echo $status; ?>
                            </span>
                        </td>
                        <td class="flex space-x-2">
                            <button onclick="openEditModal(<?php echo htmlspecialchars($row['participant_id']); ?>, <?php echo htmlspecialchars($row['participant_credits']); ?>, '<?php echo htmlspecialchars($row['status']); ?>')" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-yellow-600 transition duration-150 ease-in-out flex items-center justify-center h-10">
                                <svg class="h-5 w-5 mr-1" <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                                <span>แก้ไข</span>
                            </button>
                            <form action="" method="POST" class="inline">
                                <input type="hidden" name="participant_id" value="<?php echo htmlspecialchars($row['participant_id']); ?>">
                                <button type="submit" name="delete" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-red-600 transition duration-150 ease-in-out flex items-center justify-center h-10">
                                    <svg class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6" />
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                        <line x1="10" y1="11" x2="10" y2="17" />
                                        <line x1="14" y1="11" x2="14" y2="17" />
                                    </svg>
                                    <span>ลบ</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <th>No.</th> <!-- เพิ่มคอลัมน์ลำดับเลข -->
                    <th>กิจกรรม</th>
                    <th>นักศึกษา</th>
                    <th>เครดิตกิจกรรม</th>
                    <th>เครดิตผู้เข้าร่วม</th>
                    <th>วันที่ลงทะเบียน</th>
                    <th>สถานะ</th>
                    <th>จัดการ</th>
                </tr>
            </tfoot>
        </table>

    </div>
</div>





<?php include "add_Credist_modal.php"; ?>
<?php include "update_Credist_modal.php"; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>

<script>
    // JavaScript for handling modals
    document.getElementById('open-modal-button').addEventListener('click', function() {
        document.getElementById('add-modal').classList.remove('hidden');
    });

    function closeAddModal() {
        document.getElementById('add-modal').classList.add('hidden');
    }

    function openEditModal(id, credits, status) {
        document.getElementById('edit-participant-id').value = id;
        document.getElementById('edit-credits').value = credits;
        document.getElementById('edit-status').value = status;
        document.getElementById('edit-modal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('edit-modal').classList.add('hidden');
    }

    // JavaScript for searching in the table
    document.getElementById('search-input').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#table-body tr');

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
</script>