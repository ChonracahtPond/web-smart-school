<?php
// SQL query to fetch student data
$sql = "SELECT student_id, grade_level, section, username, fullname, nicknames, email, phone_number, date_of_birth, gender FROM students";
$result = $conn->query($sql);
?>

<link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
<style>
    .dataTables_wrapper select,
    .dataTables_wrapper .dataTables_filter input {
        color: #4a5568;
        padding: 0.5rem 1rem;
        border-width: 2px;
        border-radius: 0.25rem;
        border-color: #edf2f7;
        background-color: #edf2f7;
    }

    table.dataTable.hover tbody tr:hover,
    table.dataTable.display tbody tr:hover {
        background-color: #ebf4ff;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        font-weight: 700;
        border-radius: 0.25rem;
        border: 1px solid transparent;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        color: #fff;
        background: #667eea !important;
        border: 1px solid transparent;
    }

    table.dataTable.no-footer {
        border-bottom: 1px solid #e2e8f0;
    }

    table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before,
    table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before {
        background-color: #667eea !important;
    }
</style>

<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-semibold text-gray-900 mb-6">ข้อมูลนักเรียน</h1>
    <a href="?page=add_student" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">+ เพิ่มข้อมูลนักเรียน</a>
    <div class="bg-white shadow-lg rounded-lg p-4 my-4 overflow-x-auto">
        <table id="studentTable" class="display w-full" style="width:100%">
            <thead>
                <tr>
                    <th>รหัสนักเรียน</th>
                    <th>ระดับชั้น</th>
                    <th>ห้องเรียน</th>
                    <th>ชื่อผู้ใช้</th>
                    <th>ชื่อเต็ม</th>
                    <th>ชื่อเล่น</th>
                    <th>อีเมล</th>
                    <th>หมายเลขโทรศัพท์</th>
                    <th>เพศ</th>
                    <th>การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['grade_level']); ?></td>
                            <td><?php echo htmlspecialchars($row['section']); ?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                            <td><?php echo htmlspecialchars($row['nicknames']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
                            <td><?php echo htmlspecialchars($row['gender']); ?></td>
                            <td>
                                <a href="../mpdf/pdf_register/view_register.php?id=<?php echo urlencode($row['student_id']); ?>" class="text-green-500 hover:underline">ดูรายละเอียด</a> |

                                <a href="?page=edit_user&id=<?php echo urlencode($row['student_id']); ?>" class="text-blue-500 hover:underline">แก้ไข</a> |
                                <a href="?page=delete_user&id=<?php echo urlencode($row['student_id']); ?>" class="text-red-500 hover:underline" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')">ลบ</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="11" class="px-4 py-2 text-center">ไม่พบข้อมูล</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#studentTable').DataTable({
            responsive: true
        });

        // Modal functionality
        var modal = document.getElementById("studentModal");
        var openModal = document.getElementById("openModal");
        var closeModal = document.getElementById("closeModal");
        var closeSpan = document.getElementsByClassName("close")[0];

        // Open modal
        openModal.addEventListener('click', function() {
            modal.classList.remove('hidden');
        });

        // Close modal using button
        closeModal.addEventListener('click', function() {
            modal.classList.add('hidden');
        });

        // Close modal using span
        closeSpan.addEventListener('click', function() {
            modal.classList.add('hidden');
        });

        // Close modal when clicking outside of it
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });
</script>