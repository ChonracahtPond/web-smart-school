<div id="exportDateModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <h2 class="font-bold text-xl text-center mb-4 text-indigo-600">เลือกวันที่</h2>

        <label for="startDate" class="block text-gray-700 mb-2">วันที่เริ่มต้น:</label>
        <input type="date" id="startDate" class="border border-gray-300 rounded-lg p-2 mb-4 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500">

        <label for="endDate" class="block text-gray-700 mb-2">วันที่สิ้นสุด:</label>
        <input type="date" id="endDate" class="border border-gray-300 rounded-lg p-2 mb-4 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500">

        <div class="flex justify-between mt-6">
            <button id="exportBtn" class="bg-yellow-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-yellow-600 transition duration-200">ส่งออก</button>
            <button id="closeExportModal" class="bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded-lg hover:bg-gray-400 transition duration-200">ปิด</button>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<script>
    $(document).ready(function() {
        // ฟังก์ชันสำหรับส่งออก Excel
        $('#exportBtn').click(function() {
            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val();

            // ตรวจสอบว่ามีการเลือกวันที่หรือไม่
            if (!startDate || !endDate) {
                alert('กรุณาเลือกวันที่ให้ครบถ้วน!');
                return;
            }

            // ตรวจสอบว่าข้อมูลวันที่ถูกต้อง
            if (new Date(startDate) > new Date(endDate)) {
                alert('วันที่เริ่มต้นต้องไม่มากกว่าวันที่สิ้นสุด!');
                return;
            }

            // ส่งข้อมูลวันที่ไปยังไฟล์ export_excel.php
            window.location.href = '../exports/exams/export_excel.php?start_date=' + startDate + '&end_date=' + endDate;

            // ปิด modal
            $('#exportDateModal').addClass('hidden');
        });

        // ปิด modal เมื่อคลิกปุ่มปิด
        $('#closeExportModal').click(function() {
            $('#exportDateModal').addClass('hidden'); // ปิด modal
        });
    });
</script>