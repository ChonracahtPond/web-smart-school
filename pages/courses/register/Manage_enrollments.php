<?php
// ตรวจสอบว่ามีการส่งคำค้นหามาหรือไม่
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง enrollments พร้อมการค้นหา
$sql = "SELECT e.enrollment_id, e.student_id, e.course_id, e.semester, e.academic_year, e.grade, e.status, e.teacher_id, c.course_name, s.student_name, t.teacher_name
        FROM enrollments e
        LEFT JOIN courses c ON e.course_id = c.course_id
        LEFT JOIN students s ON e.student_id = s.student_id
        LEFT JOIN teachers t ON e.teacher_id = t.teacher_id
        WHERE c.course_name LIKE ? OR s.student_name LIKE ? OR t.teacher_name LIKE ?";

// เตรียมการค้นหาข้อมูล
$searchTerm = "%$search%";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>


<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
<style>
    /*Overrides for Tailwind CSS */
    .dataTables_wrapper .dataTables_filter input {
        color: #4a5568;
        /* text-gray-700 */
        padding: .5rem;
        border-width: 2px;
        border-radius: .25rem;
        border-color: #edf2f7;
        /* border-gray-200 */
        background-color: #edf2f7;
        /* bg-gray-200 */
    }

    table.dataTable.no-footer {
        border-bottom: 1px solid #e2e8f0;
        /* border-b-1 border-gray-300 */
    }

    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 50;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">การลงทะเบียนเรียน</h1>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <!-- Button to open the modal -->
        <button id="openModalButton" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 mb-4 inline-block">+ เพิ่มการลงทะเบียนใหม่</button>



        <!-- ฟอร์มค้นหา -->
        <!-- <form method="GET" action="" class="mb-4">
            <div class="flex items-center">
                <input id="search-input" type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="ค้นหาตามชื่อรายวิชา คำอธิบาย หรืออาจารย์">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 ml-2">ค้นหา</button>
            </div>
        </form> -->

        <!-- ตารางแสดงข้อมูล -->
        <table id="enrollmentsTable" class="display stripe hover w-full mt-4" style="width:100%;">
            <thead>
                <tr>
                    <th>รหัสการลงทะเบียน</th>
                    <th>ภาคเรียน</th>
                    <th>ปีการศึกษา</th>
                    <th>ระดับ</th>
                    <th>สถานะ</th>
                    <th>ชื่อครู</th>
                    <th>ชื่อรายวิชา</th>
                    <th>ชื่อนักเรียน</th>
                    <th>การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['enrollment_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['semester']); ?></td>
                            <td><?php echo htmlspecialchars($row['academic_year']); ?></td>
                            <td><?php echo htmlspecialchars($row['grade']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td><?php echo htmlspecialchars($row['teacher_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                            <td>
                                <a href="?page=edit_enrollment&id=<?php echo htmlspecialchars($row['enrollment_id']); ?>" class="text-blue-500 hover:text-blue-700">แก้ไข</a>
                                |
                                <a href="?page=delete_enrollment&id=<?php echo htmlspecialchars($row['enrollment_id']); ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this enrollment?')">ลบ</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="9" class="text-center">ไม่พบข้อมูล</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include "modaladd_enrollment.php" ?>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        $('#enrollmentsTable').DataTable({
            responsive: true
        });
    });

    // Get modal element
    var modal = document.getElementById("myModaladdEnrollment");

    // Get open modal button
    var openModalButton = document.getElementById("openModalButton");

    // Get close button
    var closeButton = document.getElementsByClassName("close")[0];
    var closeModalButton = document.getElementById("closeModalButton");

    // When the user clicks the button, open the modal
    openModalButton.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    closeButton.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks on the close button, close the modal
    closeModalButton.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>