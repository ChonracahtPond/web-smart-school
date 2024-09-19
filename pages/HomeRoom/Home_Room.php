<?php include "sql.php"; ?>

<!-- Main Content -->
<main class="container mx-auto p-6">
    <!-- Page Header -->
    <div class="text-center mb-6">
        <h1 class="text-4xl font-extrabold text-gray-800">ระบบสารสนเทศ Homeroom</h1>
    </div>

    <!-- Add Home Room Button -->
    <div class="text-center mb-6">
        <button id="createRoomButton" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 text-lg font-semibold shadow-md transition duration-300 ease-in-out">สร้างห้องออนไลน์</button>
    </div>

    <!-- Data Table for Today's Rooms -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
        <h2 class="text-3xl font-semibold mb-4 text-gray-700">ห้องเรียนที่สร้างวันนี้</h2>
        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-100 text-center">
                <tr class="text-left text-gray-600">
                    <th class="py-3 px-4 border-b">ชื่อห้อง</th>
                    <th class="py-3 px-4 border-b">รหัสห้อง</th>
                    <th class="py-3 px-4 border-b">วันที่สร้าง</th>
                    <th class="py-3 px-4 border-b text-center">การกระทำ</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="hover:bg-gray-50 transition duration-200 ease-in-out">
                            <td class="py-3 px-4 border-b"><?= htmlspecialchars($row['room_name']) ?></td>
                            <td class="py-3 px-4 border-b"><?= htmlspecialchars($row['room_key']) ?></td>
                            <td class="py-3 px-4 border-b"><?= htmlspecialchars($row['created_at']) ?></td>
                            <td class="py-3 px-4 border-b text-center">
                                <a href="?page=Room&room_key=<?= htmlspecialchars($row['room_key']) ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out">เข้าห้อง</a>
                                <button class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition duration-300 ease-in-out mx-2" onclick="editRoom('<?= htmlspecialchars($row['room_key']) ?>', '<?= htmlspecialchars($row['room_name']) ?>', '<?= htmlspecialchars($row['created_at']) ?>')">แก้ไข</button>
                                <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-300 ease-in-out" onclick="confirmDelete('<?= htmlspecialchars($row['room_key']) ?>')">ลบ</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="py-3 px-4 border-b text-center text-gray-500">ไม่มีข้อมูลห้องเรียนในวันนี้</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- 
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-semibold mb-4">ปฏิทิน</h2>
        <div class="w-full" id="calendar-container">
            <?php
            // include "dashboard/calendar/calendar.php";
            ?>
        </div>
    </div> -->



    <div class="mt-10">
        <?php
        include "dashboard/calendar/calendar.php";
        ?>

    </div>

</main>



<?php include "modal.php"; ?>

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.0.0/dist/fullcalendar.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar-container');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'th'
        });
        calendar.render();
    });

    // Modal Functionality
    const createRoomButton = document.getElementById('createRoomButton');
    const createRoomModal = document.getElementById('createRoomModal');
    const cancelButton = document.getElementById('cancelButton');

    // Show Modal
    createRoomButton.addEventListener('click', () => {
        createRoomModal.classList.remove('hidden');
    });

    // Hide Modal
    cancelButton.addEventListener('click', () => {
        createRoomModal.classList.add('hidden');
    });
</script>
<script>
    function editRoom(room_key, roomName) {
        document.getElementById('editroom_key').value = room_key;
        document.getElementById('editRoomName').value = roomName;
        document.getElementById('editRoomModal').classList.remove('hidden');
    }

    function deleteRoom(room_key) {
        if (confirm('คุณแน่ใจว่าต้องการลบห้องนี้?')) {
            window.location.href = 'room.php?room_key=' + encodeURIComponent(room_key) + '&action=delete';
        }
    }

    // Modal Functionality for Edit Room
    const cancelEditButton = document.getElementById('cancelEditButton');

    // Hide Edit Room Modal
    cancelEditButton.addEventListener('click', () => {
        document.getElementById('editRoomModal').classList.add('hidden');
    });
</script>
<script>
    function confirmDelete(room_key) {
        if (confirm("คุณแน่ใจว่าต้องการลบห้องเรียนนี้?")) {
            window.location.href = `?page=Home_Room&room_key=${encodeURIComponent(room_key)}&action=delete`;
        }
    }
</script>