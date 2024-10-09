<?php
// Prepare statements for better security
$participants_sql = "SELECT ap.participant_id, ap.activity_id, ap.student_id, ap.registration_date, ap.status, s.status , ap.Credits AS participant_credits, 
                      s.fullname, a.activity_name, a.activity_Credits AS activity_credits ,ap.images AS images
                      FROM activity_participants ap 
                      JOIN students s ON ap.student_id = s.student_id
                      JOIN activities a ON ap.activity_id = a.activity_id 
                      WHERE ap.status = 'พิจารณา' AND s.status IN (0 , 2)";

if ($stmt = $conn->prepare($participants_sql)) {
    $stmt->execute();
    $participants_result = $stmt->get_result();
} else {
    die("Query failed: " . $conn->error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $participant_id = $_POST['participant_id'];

    // Check if action is disapprove
    if ($_POST['action'] === 'disapprove') {
        $update_sql = "UPDATE activity_participants SET status = 'ไม่สำเร็จ' WHERE participant_id = ?";
    } else {
        $update_sql = "UPDATE activity_participants SET status = 'สำเร็จ' WHERE participant_id = ?";
    }

    if ($stmt = $conn->prepare($update_sql)) {
        $stmt->bind_param("i", $participant_id);
        if ($stmt->execute()) {
            // echo "Success";
            echo "<script>window.location.href='?page=Check_Manage_Credits&status=1';</script>";
        } else {
            // echo "Error: " . $stmt->error;
            echo "<script>window.location.href='?page=Check_Manage_Credits&status=0';</script>";
        }
        $stmt->close();
    } else {
        // echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>


<div class="">
    <div id="recipients" class="p-8 mt-6 lg:mt-0 rounded-lg shadow bg-white">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-5 flex items-center space-x-2">
            <i class="fas fa-tasks text-green-500"></i>
            <span>เช็คกิจกรรม กพช.</span>
        </h1>
        <div class="bg-gray-200 w-full h-0.5 my-5"></div>
        <table id="example" class="display stripe hover" style="width:100%;">
            <thead>
                <tr class="bg-gray-100">
                    <th>No.</th>
                    <th>กิจกรรม</th>
                    <th>นักศึกษา</th>
                    <th>เครดิตกิจกรรม</th>
                    <th>เครดิตผู้เข้าร่วม</th>
                    <th>วันที่ลงทะเบียน</th>
                    <th>รูปภาพ</th>
                    <th>สถานะ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php
                $no = 1;
                while ($row = $participants_result->fetch_assoc()) : ?>
                    <tr class="hover:bg-gray-50">
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($row['activity_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($row['activity_credits']); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($row['participant_credits']); ?></td>
                        <td><?php echo htmlspecialchars($row['registration_date']); ?></td>
                        <td class="w-36 h-36">
                            <?php
                            $imagePath = htmlspecialchars($row['images']);
                            if (!empty($imagePath)) {
                                // ถ้า path ของภาพไม่ว่าง ให้แสดงภาพที่คลิกได้เพื่อเปิดหน้าต่างใหม่
                                echo '<a href="' . $imagePath . '" target="_blank">
                             <img src="' . $imagePath . '" alt="Image" class="w-full h-full object-cover">
                                </a>';
                            } else {
                                // ถ้าไม่มีภาพให้แสดงข้อความที่ต้องการ
                                echo 'No image available';
                            }
                            ?>
                        </td>


                        <td>
                            <?php
                            $status = htmlspecialchars($row['status']);
                            $statusClass = '';
                            $statusIcon = '';
                            switch ($status) {
                                case 'กำลังทำ':
                                    $statusClass = 'bg-orange-200 text-orange-800';
                                    $statusIcon = 'fas fa-hourglass-half';
                                    break;
                                case 'สำเร็จ':
                                    $statusClass = 'bg-green-200 text-green-800';
                                    $statusIcon = 'fas fa-check-circle';
                                    break;
                                case 'ไม่สำเร็จ':
                                    $statusClass = 'bg-red-200 text-red-800';
                                    $statusIcon = 'fas fa-times-circle';
                                    break;
                                case 'พิจารณา':
                                    $statusClass = 'bg-gray-200 text-gray-800';
                                    $statusIcon = 'fas fa-info-circle';
                                    break;
                                default:
                                    $statusClass = 'bg-gray-100 text-gray-600';
                                    $statusIcon = 'fas fa-question-circle';
                            }
                            ?>
                            <span class="h-9 inline-block px-3 py-1 rounded-full text-sm font-semibold <?php echo $statusClass; ?> flex items-center space-x-2">
                                <i class="<?php echo $statusIcon; ?>"></i>
                                <span><?php echo $status; ?></span>
                            </span>
                        </td>
                        <td class="flex space-x-2 justify-center mt-10">
                            <button onclick="approveParticipant(<?php echo htmlspecialchars($row['participant_id']); ?>)" class="h-9 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-green-600 transition duration-150 ease-in-out flex items-center justify-center space-x-2">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                    <polyline points="22 4 12 14.01 9 11.01" />
                                </svg>
                                <span>อนุมัติ</span>
                            </button>
                            <button onclick="disapproveParticipant(<?php echo htmlspecialchars($row['participant_id']); ?>)" class="h-9 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-red-600 transition duration-150 ease-in-out flex items-center justify-center space-x-2">
                                <svg class="h-5 w-5 " viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6" />
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                    <line x1="10" y1="11" x2="10" y2="17" />
                                    <line x1="14" y1="11" x2="14" y2="17" />
                                </svg>
                                <span>ไม่อนุมัติ</span>
                            </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <th>No.</th>
                    <th>กิจกรรม</th>
                    <th>นักศึกษา</th>
                    <th>เครดิตกิจกรรม</th>
                    <th>เครดิตผู้เข้าร่วม</th>
                    <th>วันที่ลงทะเบียน</th>
                    <th>รูปภาพ</th>

                    <th>สถานะ</th>
                    <th>จัดการ</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });

    function approveParticipant(participant_id) {
        $.ajax({
            url: '',
            type: 'POST',
            data: {
                participant_id: participant_id
            },
            success: function(response) {
                if (response === "Success") {
                    alert('ผู้เข้าร่วมได้ถูกอนุมัติแล้ว');
                    location.reload();
                } else {
                    alert('เกิดข้อผิดพลาด: ' + response);
                }
            },
            error: function() {
                alert('เกิดข้อผิดพลาดในการอนุมัติผู้เข้าร่วม');
            }
        });
    }

    function disapproveParticipant(participant_id) {
        $.ajax({
            url: '',
            type: 'POST',
            data: {
                participant_id: participant_id,
                action: 'disapprove'
            },
            success: function(response) {
                if (response === "Success") {
                    alert('ผู้เข้าร่วมได้ถูกไม่อนุมัติ');
                    location.reload();
                } else {
                    alert('เกิดข้อผิดพลาด: ' + response);
                }
            },
            error: function() {
                alert('เกิดข้อผิดพลาดในการไม่อนุมัติผู้เข้าร่วม');
            }
        });
    }
</script>