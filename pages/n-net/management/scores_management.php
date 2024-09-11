<?php
// ดึงข้อมูลคะแนนทั้งหมด
$query = "SELECT sc.student_id, st.fullname AS student_fullname, sc.score, sc.exam_date 
          FROM nnet_scores sc
          JOIN students st ON sc.student_id = st.student_id";
$result = $conn->query($query);

// ตรวจสอบข้อผิดพลาดของการคิวรี
if (!$result) {
    die('Error: ' . $conn->error);
}
?>
<link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<style>
    table.dataTable.hover tbody tr:hover {
        background-color: #ebf4ff;
    }
</style>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900">ระบบจัดการคะแนน N-NET</h1>

    <!-- ปุ่มสำหรับเปิดโมดัลเพิ่มคะแนน -->
    <div class="bg-white shadow-lg rounded-lg p-4 mt-4 flex">
        <button id="open-modal-button" class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-blue-600 transition duration-150 ease-in-out flex items-center" onclick="openModal()">
            <i class="fas fa-plus mr-2"></i> เพิ่มคะแนน
        </button>
    </div>

    <!-- ตารางแสดงข้อมูลคะแนน -->
    <div class="bg-white shadow-lg rounded-lg p-4 mt-4">
        <table id="scores-table" class="display stripe hover" style="width:100%;">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>นักศึกษา</th>
                    <th>คะแนน</th>
                    <th>วันที่สอบ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($row['student_fullname']); ?></td>
                        <td><?php echo htmlspecialchars($row['score']); ?></td>
                        <td><?php echo htmlspecialchars($row['exam_date']); ?></td>
                        <td class="flex space-x-2">
                            <button onclick="openEditModal(<?php echo htmlspecialchars($row['student_id']); ?>, '<?php echo htmlspecialchars($row['score']); ?>', '<?php echo htmlspecialchars($row['exam_date']); ?>')" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-yellow-600 transition duration-150 ease-in-out flex items-center">
                                <i class="fas fa-edit text-lg mr-2"></i> แก้ไข
                            </button>
                            <form action="delete_score.php" method="POST" class="inline">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['student_id']); ?>">
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-red-600 transition duration-150 ease-in-out flex items-center">
                                    <i class="fas fa-trash text-lg mr-2"></i> ลบ
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- ฟอร์มเพิ่มคะแนน -->
    <div id="add-score-modal" class="fixed inset-0 flex items-center justify-center hidden bg-gray-800 bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h2 class="text-2xl font-semibold mb-4">เพิ่มคะแนน</h2>
            <form id="add-score-form" action="add_score.php" method="POST">
                <div class="mb-4">
                    <label for="student_id" class="block text-gray-700">นักศึกษา</label>
                    <select id="student_id" name="student_id" class="mt-1 block w-full border-gray-300 rounded-lg">
                        <?php
                        $students_query = "SELECT id, fullname FROM students";
                        $students_result = $conn->query($students_query);
                        while ($student = $students_result->fetch_assoc()) : ?>
                            <option value="<?php echo $student['id']; ?>"><?php echo htmlspecialchars($student['fullname']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="score" class="block text-gray-700">คะแนน</label>
                    <input type="number" id="score" name="score" class="mt-1 block w-full border-gray-300 rounded-lg" step="0.01" required>
                </div>
                <div class="mb-4">
                    <label for="exam_date" class="block text-gray-700">วันที่สอบ</label>
                    <input type="date" id="exam_date" name="exam_date" class="mt-1 block w-full border-gray-300 rounded-lg" required>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2">ปิด</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">บันทึก</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // ฟังก์ชันเปิดโมดัล
        function openModal() {
            document.getElementById('add-score-modal').classList.remove('hidden');
        }

        // ฟังก์ชันปิดโมดัล
        function closeModal() {
            document.getElementById('add-score-modal').classList.add('hidden');
        }

        // ฟังก์ชันเปิดโมดัลแก้ไข
        function openEditModal(id, score, exam_date) {
            // Implement edit functionality here
        }

        // Initializing DataTable
        $(document).ready(function() {
            $('#scores-table').DataTable();
        });
    </script>
</div>
