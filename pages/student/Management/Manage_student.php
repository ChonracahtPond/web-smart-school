<?php
// SQL query to fetch student data
$sql = "SELECT student_id, grade_level, section, username, fullname, nicknames, email, phone_number, date_of_birth, gender 
        FROM students 
        WHERE status IN (0, 2)";


$result = $conn->query($sql);
?>
<div class="">
    <div class="bg-white shadow-lg rounded-lg p-4 w-full">

        <h1 class="text-3xl font-semibold text-gray-900 mb-6">นำเข้าข้อมูลนักศึกษา</h1>
        <!-- <a href="?page=add_student" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 mb-4 inline-block">+ เพิ่มข้อมูลนักเรียน</a> -->
        <!-- Import Button -->
        <div class="mb-4 flex space-x-4">
            <a href="?page=add_student" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">+ เพิ่มข้อมูลนักเรียน</a>
            <a href="../mpdf/student_report/student_information_report.php" class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-green-600">ออกรายงาน PDF</a>
            <a href="../exports/student_report/student_information_excel.php" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-yellow-600">ออกรายงาน Excel</a>
            <!-- Button to trigger modal -->
            <button id="importButton" class="bg-purple-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-purple-600">นำเข้าข้อมูลจาก Excel</button>

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



            <a href="../exports/student_report/export_student_excel.php" class="text-red-500">** ดาวน์โหลดตัวอย่าง **</a>

        </div>




        <div class="bg-gray-200 w-full h-0.5 my-5"></div>



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
                            <td class="px-6 py-4 flex space-x-2 justify-center">
                                <a href="../mpdf/student_report/view_register.php?student_id=<?php echo urlencode($row['student_id']); ?>" class="bg-green-500 text-white px-3 py-1 rounded-lg shadow-lg hover:bg-green-600" title="ดูรายละเอียด">
                                    <i class="fas fa-eye"></i>
                                    ดูรายละเอียด
                                </a>
                                <a href="?page=edit_user&id=<?php echo urlencode($row['student_id']); ?>" class="bg-blue-500 text-white px-3 py-1 rounded-lg shadow-lg hover:bg-blue-600" title="แก้ไข">
                                    <i class="fas fa-edit"></i>
                                    แก้ไข
                                </a>
                                <a href="?page=delete_user&id=<?php echo urlencode($row['student_id']); ?>" class="bg-red-500 text-white px-3 py-1 rounded-lg shadow-lg hover:bg-red-600" title="ลบ" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')">
                                    <i class="fas fa-trash"></i>
                                    ลบ
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
            <tfoot>
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
            </tfoot>
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