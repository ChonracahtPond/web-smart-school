<div class="mt-8">
    <h2 class="text-2xl font-semibold text-purple-900 mb-4">การบ้าน</h2>
    <?php if ($assignments_result->num_rows > 0) { ?>
        <table class="min-w-full bg-white shadow-lg rounded-lg border border-gray-200">
            <thead>
                <tr class="bg-purple-600 text-white">
                    <th class="py-3 px-4 text-left">Assignment Title</th>
                    <th class="py-3 px-4 text-left">Description</th>
                    <th class="py-3 px-4 text-left">Due Date</th>
                    <th class="py-3 px-4 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($assignment = $assignments_result->fetch_assoc()) { ?>
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-4"><?php echo htmlspecialchars($assignment['assignment_title']); ?></td>
                        <td class="py-3 px-4"><?php echo htmlspecialchars($assignment['assignment_description']); ?></td>
                        <td class="py-3 px-4"><?php echo htmlspecialchars($assignment['due_date']); ?></td>
                        <td class="py-3 px-4"><?php echo htmlspecialchars($assignment['status']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-gray-700">ไม่มีการบ้านที่เกี่ยวข้อง</p>
        <div class="text-center mt-4">
            <button onclick="openModalassignments()" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300">เพิ่มการบ้าน</button>
        </div>
    <?php } ?>


</div>

<!-- โมดัลเพิ่มการฝึกหัด -->
<div id="assignmentModal" class="fixed inset-0 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">

        <div class="bg-white max-w-lg w-full p-6 rounded-lg shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold text-purple-700">เพิ่มการบ้าน</h2>
                <button onclick="closeModalassignments()" class="text-gray-600 hover:text-gray-900">&times;</button>
            </div>
            <form action="?page=add_assignments" method="POST">
                <input type="hidden" name="lesson_id" value="<?php echo htmlspecialchars($lesson_id); ?>">
                <div class="mt-4">
                    <label class="block text-gray-700">ชื่อการบ้าน:</label>
                    <input type="text" name="assignment_title" required class="w-full p-2 border border-gray-300 rounded mt-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="mt-4">
                    <label class="block text-gray-700">รายละเอียด:</label>
                    <textarea name="assignment_description" required class="w-full p-2 border border-gray-300 rounded mt-2 focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                </div>
                <div class="mt-4">
                    <label class="block text-gray-700">กำหนดส่ง:</label>
                    <input type="date" name="due_date" required class="w-full p-2 border border-gray-300 rounded mt-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="mb-5">
                    <label class="block mb-2 text-gray-700">สถานะ:</label>
                    <select name="status" class="border border-gray-300 rounded w-full p-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-300">
                        <option value="active">ใช้งาน</option>
                        <option value="inactive">ไม่ใช้งาน</option>
                    </select>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="button" onclick="closeModalassignments()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg mr-2 hover:bg-gray-400">ยกเลิก</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    function openModalassignments() {
        document.getElementById('assignmentModal').classList.remove('hidden');
    }

    function closeModalassignments() {
        document.getElementById('assignmentModal').classList.add('hidden');
    }
</script>