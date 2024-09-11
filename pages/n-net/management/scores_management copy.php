<?php
// ดึงข้อมูลคะแนนทั้งหมดโดยใช้ nnet_scores_id
$query = "SELECT sc.nnet_scores_id, st.fullname AS student_fullname, sc.score, sc.exam_date 
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
<link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">

<style>
    .dataTables_wrapper select,
    .dataTables_wrapper .dataTables_filter input {
        color: #4a5568;
        padding: 0.5rem 1rem;
        line-height: 1.25;
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
        color: #fff !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
        font-weight: 700;
        background-color: #667eea !important;
        border: 1px solid transparent;
    }

    table.dataTable.no-footer {
        border-bottom: 1px solid #e2e8f0;
        margin-top: 0.75em;
        margin-bottom: 0.75em;
    }

    table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before,
    table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before {
        background-color: #667eea !important;
    }
</style>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-indigo-600 mb-6">
        ระบบจัดการคะแนน N-NET
    </h1>

    <!-- Card for managing scores -->
    <div id='recipients' class="p-8 rounded-lg shadow-lg bg-white">
        <div class="mb-6 flex justify-between items-center">
            <button id="open-modal-button" class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-700 transition duration-200 flex items-center" onclick="openModal()">
                <i class="fas fa-plus mr-2"></i> + เพิ่มคะแนน
            </button>
        </div>

        <table id="scores-table" class="stripe hover w-full" style="padding-top: 1em; padding-bottom: 1em;">
            <thead>
                <tr>
                    <th class="px-4 py-2">No.</th>
                    <th class="px-4 py-2">นักศึกษา</th>
                    <th class="px-4 py-2">คะแนน</th>
                    <th class="px-4 py-2">สถานะ</th>
                    <th class="px-4 py-2">วันที่สอบ</th>
                    <th class="px-4 py-2">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = $result->fetch_assoc()) :
                    $status = (float)$row['score'] > 50 ? 'ผ่าน' : 'ไม่ผ่าน'; ?>
                    <tr>
                        <td class="px-4 py-2"><?php echo $no++; ?></td>
                        <td class="px-4 py-2 text-center"><?php echo htmlspecialchars($row['student_fullname']); ?></td>
                        <td class="px-4 py-2 text-center"><?php echo htmlspecialchars($row['score']); ?></td>
                        <td class="px-4 py-2 text-center">
                            <span class="<?php echo $status == 'ผ่าน' ? 'text-green-500' : 'text-red-500'; ?>">
                                <?php echo $status; ?>
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center"><?php echo htmlspecialchars($row['exam_date']); ?></td>

                        <td class="px-4 py-2 flex space-x-2 item-center justify-center">
                            <!-- ใช้ nnet_scores_id แทน student_id -->
                            <button onclick="openEditModal(<?php echo htmlspecialchars($row['nnet_scores_id']); ?>, '<?php echo htmlspecialchars($row['score']); ?>', '<?php echo htmlspecialchars($row['exam_date']); ?>')" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-yellow-600 transition duration-200 flex items-center h-10">
                                <i class="fas fa-edit mr-2"></i> แก้ไข
                            </button>
                            <button onclick="confirmDelete(<?php echo htmlspecialchars($row['nnet_scores_id']); ?>)" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-600 transition duration-200 flex items-center h-10">
                                <i class="fas fa-trash mr-2"></i> ลบ
                            </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>

        </table>

    </div>

    <!-- Modal for adding score -->
    <div id="add-score-modal" class="fixed inset-0 flex items-center justify-center hidden bg-gray-800 bg-opacity-60 modal-transition">
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
            <h2 class="text-2xl font-semibold mb-4">เพิ่มคะแนน</h2>
            <form id="add-score-form" action="?page=add_score" method="POST">
                <div class="mb-4">
                    <label for="student_id" class="block text-gray-700 text-sm font-medium">นักศึกษา</label>
                    <select id="student_id" name="student_id" class="mt-1 block w-full border-gray-300 rounded-lg p-2">
                        <?php
                        $students_query = "SELECT student_id, fullname FROM students";
                        $students_result = $conn->query($students_query);
                        while ($student = $students_result->fetch_assoc()) : ?>
                            <option value="<?php echo $student['student_id']; ?>"><?php echo htmlspecialchars($student['fullname']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="score" class="block text-gray-700 text-sm font-medium">คะแนน</label>
                    <input type="number" id="score" name="score" class="mt-1 block w-full border-gray-300 rounded-lg p-2" step="0.01" required>
                </div>
                <div class="mb-4">
                    <label for="exam_date" class="block text-gray-700 text-sm font-medium">วันที่สอบ</label>
                    <input type="date" id="exam_date" name="exam_date" class="mt-1 block w-full border-gray-300 rounded-lg p-2" required>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeModal()" class="bg-gray-600 text-white px-4 py-2 rounded-lg mr-2">ปิด</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">บันทึก</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for editing score -->
    <div id="edit-score-modal" class="fixed inset-0 flex items-center justify-center hidden bg-gray-800 bg-opacity-60 modal-transition">
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
            <h2 class="text-2xl font-semibold mb-4">แก้ไขคะแนน</h2>
            <form id="edit-score-form" action="?page=update_score" method="POST">
                <input type="hidden" id="edit-student-id" name="nnet_scores_id"> <!-- เปลี่ยนจาก student_id เป็น nnet_scores_id -->
                <div class="mb-4">
                    <label for="edit-score" class="block text-gray-700">คะแนน</label>
                    <input type="number" id="edit-score" name="score" class="mt-1 block w-full border-gray-300 rounded-lg" step="0.01" required>
                </div>
                <div class="mb-4">
                    <label for="edit-exam-date" class="block text-gray-700">วันที่สอบ</label>
                    <input type="date" id="edit-exam-date" name="exam_date" class="mt-1 block w-full border-gray-300 rounded-lg" required>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeModal('edit-score-modal')" class="bg-gray-600 text-white px-4 py-2 rounded-lg mr-2">ปิด</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">บันทึกการเปลี่ยนแปลง</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

<script>
    $(document).ready(function() {
        $('#scores-table').DataTable({
            responsive: true,
            pageLength: 10,
            lengthMenu: [10, 25, 50],
            language: {
                searchPlaceholder: "ค้นหา...",
                search: "",
            }
        });
    });

    function openModal() {
        document.getElementById('add-score-modal').classList.remove('hidden');
    }

    function closeModal(modalId = 'add-score-modal') {
        document.getElementById(modalId).classList.add('hidden');
    }

    function openEditModal(nnetScoresId, score, examDate) {
        document.getElementById('edit-student-id').value = nnetScoresId;
        document.getElementById('edit-score').value = score;
        document.getElementById('edit-exam-date').value = examDate;
        document.getElementById('edit-score-modal').classList.remove('hidden');
    }

    function confirmDelete(nnetScoresId) {
        if (confirm('คุณแน่ใจหรือไม่ที่จะลบข้อมูลนี้?')) {
            window.location.href = 'delete_score.php?nnet_scores_id=' + nnetScoresId;
        }
    }
</script>