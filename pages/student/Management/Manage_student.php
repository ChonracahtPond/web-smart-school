<?php
// SQL query to fetch student data
$sql = "SELECT student_id, grade_level, section, username, fullname, nicknames, email, phone_number, date_of_birth, gender FROM students";
$result = $conn->query($sql);
?>

<link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    /* Styling for DataTables pagination */
    .dataTables_wrapper .dataTables_paginate {
        margin-top: 1rem;
        text-align: right;
    }

    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 1rem;
        text-align: right;
    }

    .dataTables_wrapper .dataTables_length select {
        padding: 0.5rem;
        border-radius: 0.25rem;
        border: 1px solid #4a5568;
        font-size: 0.875rem;
        color: #4a5568;
        width: 70px;
    }

    .dataTables_wrapper .dataTables_filter input {
        padding: 0.5rem;
        border-radius: 0.25rem;
        border: 1px solid #4a5568;
        font-size: 0.875rem;
        color: #4a5568;
        width: 500px;
    }

    /* Table styles */
    table.dataTable thead th {
        background-color: #f7fafc;
        color: #4a5568;
        text-align: center;
        border-bottom: 2px solid #e2e8f0;
    }

    table.dataTable tbody tr {
        transition: background-color 0.2s;
    }

    table.dataTable tbody tr:hover {
        background-color: #f0f4f8;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        font-weight: 700;
        border-radius: 0.25rem;
        border: 1px solid transparent;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        color: #fff;
        background: #DDD !important;
        border: 1px solid transparent;
    }

    .dataTables_wrapper .dataTables_info {
        font-size: 0.875rem;
        color: #4a5568;
    }

    .text-green-500 i {
        color: #48bb78;
    }

    .text-blue-500 i {
        color: #4299e1;
    }

    .text-red-500 i {
        color: #f56565;
    }
</style>

<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-semibold text-gray-900 mb-6">ข้อมูลนักเรียน</h1>
    <!-- <a href="?page=add_student" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 mb-4 inline-block">+ เพิ่มข้อมูลนักเรียน</a> -->
    <!-- Import Button -->
    <div class="mb-4 flex space-x-4">
        <a href="?page=add_student" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">+ เพิ่มข้อมูลนักเรียน</a>
        <a href="../mpdf/student_report/student_information_report.php" class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-green-600">ออกรายงาน PDF</a>
        <a href="../exports/student_report/student_information_excel.php" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-yellow-600">ออกรายงาน Excel</a>
        <!-- Button to trigger modal -->
        <button id="importButton" class="bg-purple-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-purple-600">นำเข้าข้อมูลจาก Excel</button>
    </div>

    <!-- Modal -->
    <div id="importModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h2 class="text-xl font-semibold mb-4">นำเข้าข้อมูลจาก Excel</h2>
            <!-- Import Form -->
            <form action="../exports/student_report/import_student_excel.php" method="post" enctype="multipart/form-data" class="flex flex-col space-y-4">
                <input type="file" name="import_file" accept=".xlsx" class="px-4 py-2 border border-gray-300 rounded-lg">
                <button type="submit" class="bg-purple-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-purple-600">นำเข้าข้อมูลจาก Excel</button>
                <button type="button" id="closeModal" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-red-600">ปิด</button>
            </form>

        </div>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-4 overflow-x-auto">
        <table id="studentTable" class="display w-full" style="width:100%">
            <thead>
                <tr>
                    <th class="px-6 py-3">รหัสนักเรียน</th>
                    <th class="px-6 py-3">ชื่อเต็ม</th>
                    <th class="px-6 py-3">ระดับชั้น</th>
                    <th class="px-6 py-3">ห้องเรียน</th>
                    <th class="px-6 py-3">ชื่อเล่น</th>
                    <th class="px-6 py-3">อีเมล</th>
                    <th class="px-6 py-3">หมายเลขโทรศัพท์</th>
                    <th class="px-6 py-3">เพศ</th>
                    <th class="px-6 py-3">การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($row['student_id']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($row['fullname']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($row['grade_level']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($row['section']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($row['nicknames']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($row['email']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($row['phone_number']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($row['gender']); ?></td>
                            <td class="px-6 py-4 flex space-x-4 justify-center">
                                <a href="../mpdf/student_report/view_register.php?student_id=<?php echo urlencode($row['student_id']); ?>" class="text-green-500 hover:text-green-600 text-xl " title="ดูรายละเอียด">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="?page=edit_user&id=<?php echo urlencode($row['student_id']); ?>" class="text-blue-500 hover:text-blue-600 text-xl mx-10" title="แก้ไข">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="?page=delete_user&id=<?php echo urlencode($row['student_id']); ?>" class="text-red-500 hover:text-red-600 text-xl " title="ลบ" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center">ไม่พบข้อมูล</td>
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
            responsive: true,
            pageLength: 10
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        var importButton = document.getElementById('importButton');
        var importModal = document.getElementById('importModal');
        var closeModal = document.getElementById('closeModal');

        importButton.addEventListener('click', function() {
            importModal.classList.remove('hidden');
        });

        closeModal.addEventListener('click', function() {
            importModal.classList.add('hidden');
        });

        // Close modal when clicking outside of it
        window.addEventListener('click', function(event) {
            if (event.target === importModal) {
                importModal.classList.add('hidden');
            }
        });
    });
</script>