<div class="mt-8">
    <h2 class="text-2xl font-semibold text-purple-900 mb-4">การเรียนออนไลน์</h2>
    <?php if ($meetings_result->num_rows > 0) { ?>
        <table class="min-w-full bg-white shadow-lg rounded-lg border border-gray-200">
            <thead>
                <tr class="bg-purple-600 text-white">
                    <th class="py-3 px-4 text-left">ลิงก์การประชุม</th>
                    <th class="py-3 px-4 text-left">วันที่</th>
                    <th class="py-3 px-4 text-left">เวลา</th>
                    <th class="py-3 px-4 text-left">สถานะ</th>
                    <th class="py-3 px-4 text-left">การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($meeting = $meetings_result->fetch_assoc()) { ?>
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-4">
                            <a href="https://www.youtube.com/watch?v=<?php echo htmlspecialchars($meeting['meeting_link']); ?>" class="text-blue-500 hover:underline" target="_blank">
                                <?php echo htmlspecialchars($meeting['meeting_link']); ?>
                            </a>
                        </td>
                        <td class="py-3 px-4"><?php echo htmlspecialchars($meeting['meeting_date']); ?></td>
                        <td class="py-3 px-4"><?php echo htmlspecialchars($meeting['meeting_time']); ?></td>
                        <td class="py-3 px-4"><?php echo htmlspecialchars($meeting['status']); ?></td>
                        <td class="py-3 px-4">
                            <form action="?page=delete_meeting" method="POST" style="display: inline;">
                                <input type="hidden" name="meeting_id" value="<?php echo htmlspecialchars($meeting['meeting_id']); ?>">
                                <input type="hidden" name="lesson_id" value="<?php echo htmlspecialchars($lesson_id); ?>">
                                <button type="submit" class="text-red-600 hover:underline">ลบ</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-gray-700">ไม่มีการเรียนออนไลน์ที่เกี่ยวข้อง</p>
        <div class="text-center mt-4">
            <button id="openModal" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-300">เพิ่มข้อมูลการเรียนออนไลน์</button>
        </div>
    <?php } ?>
</div>

<!-- โมดัลเพิ่มการฝึกหัด -->
<div id="meetingModal" class="fixed inset-0 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
        <button onclick="closeModal()" class="float-right text-gray-500 hover:text-gray-700">×</button>
        <div class="bg-white max-w-md w-full mx-auto p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-purple-700 mb-6 text-center">เพิ่มข้อมูลการเรียนออนไลน์</h2>
            <form action="?page=add_onlinemeeting" method="POST">
                <input type="hidden" name="lesson_id" value="<?php echo htmlspecialchars($lesson_id); ?>">
                <div class="mb-5">
                    <label class="block mb-2 text-gray-700">ลิงก์การประชุม:</label>
                    <input type="text" name="meeting_link" required class="border border-gray-300 rounded w-full p-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-300" placeholder="กรุณากรอกลิงก์การประชุม">
                </div>
                <div class="mb-5">
                    <label class="block mb-2 text-gray-700">วันที่:</label>
                    <input type="date" name="meeting_date" required class="border border-gray-300 rounded w-full p-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-300">
                </div>
                <div class="mb-5">
                    <label class="block mb-2 text-gray-700">เวลา:</label>
                    <input type="time" name="meeting_time" required class="border border-gray-300 rounded w-full p-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-300">
                </div>
                <div class="mb-5">
                    <label class="block mb-2 text-gray-700">สถานะ:</label>
                    <select name="status" class="border border-gray-300 rounded w-full p-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-300">
                        <option value="active">ใช้งาน</option>
                        <option value="inactive">ไม่ใช้งาน</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="closeModal" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg mr-2 hover:bg-gray-400 transition duration-300">ยกเลิก</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-300">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById("openModal").onclick = function() {
        document.getElementById("meetingModal").classList.remove("hidden");
    }

    document.getElementById("closeModal").onclick = function() {
        document.getElementById("meetingModal").classList.add("hidden");
    }
</script>