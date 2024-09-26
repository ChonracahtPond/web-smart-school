<?php
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$current_year = date('Y') + 543;
$filter_exam_year = isset($_GET['exam_year']) ? $conn->real_escape_string($_GET['exam_year']) : ''; // ตั้งค่าเริ่มต้นเป็นปีปัจจุบัน

$filter_exam_year_sql = !empty($filter_exam_year) ? $filter_exam_year - 543 : '';

$sql = "SELECT nnet_scores.nnet_scores_id, students.fullname AS student_name, nnet_scores.exam_id, nnet_scores.score, nnet_scores.exam_date, nnet_scores.created_at, nnet_scores.updated_at
        FROM nnet_scores
        JOIN students ON nnet_scores.student_id = students.student_id
        WHERE students.fullname LIKE '%$search%'";

if (!empty($filter_exam_year_sql)) {
    $sql .= " AND YEAR(nnet_scores.exam_date) = '$filter_exam_year_sql'";
}

$sql .= " ORDER BY nnet_scores.created_at DESC";

$result = $conn->query($sql);

// สร้างตัวเลือกสำหรับฟิลเตอร์ปี พ.ศ.
$year_sql = "SELECT DISTINCT YEAR(exam_date) + 543 AS exam_year FROM nnet_scores ORDER BY exam_year";
$year_result = $conn->query($year_sql);
?>


<style>
    .modal.show {
        display: flex;
    }
</style>

<div class="">



    <!-- ตารางแสดงข้อมูลคะแนน -->
    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">

        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-4">จัดการคะแนน N-NET</h1>

        <!-- ปุ่มเพิ่มคะแนนใหม่ -->
        <a href="?page=add_scores_management" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 mb-4 inline-block">+ เพิ่มคะแนนใหม่</a>


        <div class="bg-gray-200 w-full h-0.5 my-5"></div>

        <!-- ฟอร์มค้นหา -->
        <form method="GET" action="" class="relative flex  p-4 mt-4">
            <input type="text" name="search" id="search-input" placeholder="ค้นหานักเรียน..." class="px-4 py-2 border rounded-lg w-full mb-4 mr-5" value="<?php echo htmlspecialchars($search); ?>" />

            <!-- ฟิลเตอร์ปี พ.ศ. -->
            <select name="exam_year" class="px-4 py-2 border rounded-lg w-full mb-4">
                <option value="">-- เลือกปี พ.ศ. --</option>
                <?php while ($year_row = $year_result->fetch_assoc()) : ?>
                    <option value="<?php echo htmlspecialchars($year_row['exam_year']); ?>" <?php if ($filter_exam_year == $year_row['exam_year']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($year_row['exam_year']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </form>

        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <th class="px-4 py-2 border-b">รหัสคะแนน</th>
                    <th class="px-4 py-2 border-b">ชื่อเต็มนักเรียน</th>
                    <th class="px-4 py-2 border-b">รหัสการสอบ</th>
                    <th class="px-4 py-2 border-b">คะแนน</th>
                    <th class="px-4 py-2 border-b">วันที่สอบ</th>
                    <th class="px-4 py-2 border-b">ผลการสอบ</th>
                    <th class="px-4 py-2 border-b">การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['nnet_scores_id']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['student_name']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['exam_id']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['score']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['exam_date']); ?></td>
                            <td class="px-4 py-2 border-b">
                                <?php echo (intval($row['score']) >= 50) ? '<span class="text-green-500 font-semibold">ผ่าน</span>' : '<span class="text-red-500 font-semibold">ไม่ผ่าน</span>'; ?>
                            </td>
                            <td class="px-4 py-2 border-b flex space-x-4">
                                <button
                                    class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-yellow-600 transition-colors duration-300 ease-in-out"
                                    data-edit-id="<?php echo htmlspecialchars($row['nnet_scores_id']); ?>"
                                    onclick="openEditModal(this)">
                                    <i class="fas fa-edit text-xl"></i>
                                    <span class="hidden md:inline">แก้ไข</span>
                                </button>
                                <a href="?page=delete_score&id=<?php echo htmlspecialchars($row['nnet_scores_id']); ?>"
                                    class="text-red-500 hover:text-red-700 flex items-center space-x-2 transition-colors duration-300 ease-in-out transform hover:scale-110"
                                    onclick="return confirm('คุณแน่ใจที่จะลบคะแนนนี้ใช่หรือไม่?')">
                                    <i class="fas fa-trash text-xl"></i>
                                    <span class="hidden md:inline">ลบ</span>
                                </a>
                            </td>



                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="px-4 py-2 text-center">ไม่พบข้อมูล</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include "modal_add_score.php"; ?>
<?php include "modal_edit_score.php"; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ฟังก์ชันค้นหาข้อมูล
        document.getElementById('search-input').addEventListener('input', function() {
            const searchQuery = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let isMatch = false;

                cells.forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(searchQuery)) {
                        isMatch = true;
                    }
                });

                row.style.display = isMatch ? '' : 'none';
            });
        });

        // ฟังก์ชันฟิลเตอร์ปี
        document.querySelector('select[name="exam_year"]').addEventListener('change', function() {
            const selectedExamYear = this.value;
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const examDateCell = row.querySelector('td:nth-child(5)').textContent; // เปลี่ยนตามลำดับของคอลัมน์วันที่สอบ
                const examDate = new Date(examDateCell);
                const examYear = examDate.getFullYear() + 543; // แปลงเป็นปี พ.ศ.

                if (selectedExamYear === '' || examYear.toString() === selectedExamYear) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // ฟังก์ชันเปิดและปิดโมดอล
        const openAddScoreBtn = document.getElementById('openAddScoreModal');
        const closeAddScoreBtn = document.getElementById('closeAddScoreModal');
        const addScoreModal = document.getElementById('addScoreModal');
        const closeModalBtns = document.querySelectorAll('.close-modal');
        const modals = document.querySelectorAll('.modal');

        openAddScoreBtn.addEventListener('click', function(e) {
            e.preventDefault(); // ป้องกันการรีเฟรชหน้า
            addScoreModal.classList.add('show');
        });

        closeAddScoreBtn.addEventListener('click', function() {
            addScoreModal.classList.remove('show');
        });

        closeModalBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                modals.forEach(modal => modal.classList.remove('show'));
            });
        });

        window.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('show');
            }
        });

        // ฟังก์ชันเปิดโมดอลแก้ไข
        window.openEditModal = function(button) {
            const modal = document.getElementById('editScoreModal');
            const editId = button.getAttribute('data-edit-id');

            // กำหนดค่าในฟอร์มของ modal
            document.getElementById('edit_id').value = editId;

            // แสดง modal
            modal.classList.add('show');
        };
    });
</script>