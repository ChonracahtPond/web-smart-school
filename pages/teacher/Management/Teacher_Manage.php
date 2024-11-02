<?php
// คำสั่ง SQL เพื่อดึงข้อมูลบุคลากร
$sql = "SELECT teacher_id, Fname, Lname, Rank, position, address, email, username, password, images, phone, gender, teacher_name FROM teachers";
$result = $conn->query($sql);
?>



<div class="container mx-auto px-2">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-10">จัดการข้อมูลบุคลากร</h1>
    <button id="open-modal" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">+ เพิ่มข้อมูลบุคลากร</button>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 my-4">
        <table id="teacher-table" class="stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
            <thead>
                <tr>
                    <th>ชื่อ</th>
                    <th>นามสกุล</th>
                    <th>ตำแหน่ง</th>
                    <th>ตำแหน่งงาน</th>
                    <th>ที่อยู่</th>
                    <th>อีเมล</th>
                    <th>โทรศัพท์</th>
                    <th>เพศ</th>
                    <th>ชื่อบุคลากร</th>
                    <th>การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Fname']); ?></td>
                            <td><?php echo htmlspecialchars($row['Lname']); ?></td>
                            <td><?php echo htmlspecialchars($row['Rank']); ?></td>
                            <td><?php echo htmlspecialchars($row['position']); ?></td>
                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><?php echo htmlspecialchars($row['gender']); ?></td>
                            <td><?php echo htmlspecialchars($row['teacher_name']); ?></td>
                            <td>
                                <button onclick='openEditModal(<?php echo json_encode($row); ?>)' class='text-blue-500 hover:underline'>แก้ไข</button> |
                                <a href="?page=delete_teacher&id=<?php echo htmlspecialchars($row['teacher_id']); ?>" class='text-red-500 hover:underline' onclick="return confirm('คุณแน่ใจว่าต้องการลบบุคลากรนี้?')">ลบ</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="10" class="px-4 py-2 text-center">ไม่พบข้อมูล</td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
    </div>
</div>
<?php
include "teachermodal.php";
// include "update_teacher.php"; 

?>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        $('#teacher-table').DataTable({
            responsive: true
        });
    });

    document.getElementById('open-modal').addEventListener('click', function() {
        document.getElementById('teacher-modal').classList.remove('hidden');
    });

    document.getElementById('close-modal').addEventListener('click', function() {
        document.getElementById('teacher-modal').classList.add('hidden');
    });
</script>