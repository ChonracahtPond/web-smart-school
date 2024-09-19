    <!-- Modal Structure -->
    <div id="createRoomModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden" style="z-index: 1000;">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-2xl font-semibold mb-4 text-gray-800">สร้างห้องออนไลน์</h3>
            <form id="createRoomForm" method="POST" action="">
                <div class="mb-4">
                    <label for="roomName" class="block text-gray-700 text-sm font-medium mb-2">ชื่อห้อง</label>
                    <input type="text" id="roomName" name="roomName" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="roomPassword" class="block text-gray-700 text-sm font-medium mb-2">รหัสผ่านเข้าห้อง</label>
                    <input type="password" id="roomPassword" name="roomPassword" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex justify-end">
                    <button type="button" id="cancelButton" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-300 ease-in-out mr-2">ยกเลิก</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out">สร้างห้อง</button>
                </div>
            </form>
        </div>
    </div>



    <!-- Edit Room Modal Structure -->
    <div id="editRoomModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden" style="z-index: 1000;">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-2xl font-semibold mb-4 text-gray-800">แก้ไขห้องออนไลน์</h3>
            <form id="editRoomForm" method="POST" action="">
                <input type="hidden" id="editroom_key" name="room_key">
                <input type="hidden" name="action" value="update">
                <div class="mb-4">
                    <label for="editRoomName" class="block text-gray-700 text-sm font-medium mb-2">ชื่อห้อง</label>
                    <input type="text" id="editRoomName" name="roomName" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="editRoomPassword" class="block text-gray-700 text-sm font-medium mb-2">รหัสผ่านใหม่ (ถ้ามีการเปลี่ยนแปลง)</label>
                    <input type="password" id="editRoomPassword" name="roomPassword" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex justify-end">
                    <button type="button" id="cancelEditButton" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-300 ease-in-out mr-2">ยกเลิก</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out">บันทึกการเปลี่ยนแปลง</button>
                </div>
            </form>
        </div>
    </div>