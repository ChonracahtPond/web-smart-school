<?php
// ตรวจสอบว่ามีการส่งคำค้นหามาหรือไม่
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง enrollments พร้อมการค้นหา
$sql = "SELECT e.enrollment_id, e.semester, e.academic_year, e.grade, e.status, e.teacher_id, c.course_name, s.student_name, t.teacher_name
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
    /* Overrides for Tailwind CSS */
    .dataTables_wrapper select,
    .dataTables_wrapper input {
        color: #4a5568;
        padding: 0.5rem 1rem;
        border-width: 2px;
        border-radius: .25rem;
        border-color: #edf2f7;
        background-color: #edf2f7;
        width: 100px;
    }

    .dataTables_wrapper .dataTables_filter input {
        width: 500px;
    }

    table.dataTable.hover tbody tr:hover {
        background-color: #ebf4ff;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        font-weight: 700;
        border-radius: .25rem;
        border: 1px solid transparent;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        color: #fff !important;
        background: #667eea !important;
    }

    table.dataTable.no-footer {
        border-bottom: 1px solid #e2e8f0;
        margin: 0.75em 0;
    }
</style>

<div class="mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900">การลงทะเบียนเรียน</h1>
    <div class="bg-white shadow-lg rounded-lg p-4 mt-4">
        <button id="openModalButton" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 mb-4">+ เพิ่มการลงทะเบียนใหม่</button>

        <!-- ฟอร์มค้นหา -->
        <form method="GET" action="" class="mb-4">
            <div class="flex items-center">
                <input id="search-input" type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="ค้นหาตามชื่อรายวิชา ชื่อนักเรียน หรือชื่อครู">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 ml-2">ค้นหา</button>
            </div>
        </form>

        <table id="enrollmentsTable" class="display stripe hover w-full mt-4">
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

<?php include "modaladd_enrollment.php"; ?>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        $('#enrollmentsTable').DataTable({
            responsive: true
        });
    });

    // Modal functionality
    var modal = document.getElementById("myModaladdEnrollment");
    var openModalButton = document.getElementById("openModalButton");
    var closeButton = document.getElementsByClassName("close")[0];
    var closeModalButton = document.getElementById("closeModalButton");

    openModalButton.onclick = function() {
        modal.style.display = "block";
    }

    closeButton.onclick = function() {
        modal.style.display = "none";
    }

    closeModalButton.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>