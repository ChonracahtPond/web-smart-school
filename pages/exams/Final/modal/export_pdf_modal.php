<div id="exportPdfModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <h2 class="font-bold text-xl text-center mb-4 text-indigo-600">เลือกวันที่</h2>

        <label for="pdfStartDate" class="block text-gray-700 mb-2">วันที่เริ่มต้น:</label>
        <input type="date" id="pdfStartDate" class="border border-gray-300 rounded-lg p-2 mb-4 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500">

        <label for="pdfEndDate" class="block text-gray-700 mb-2">วันที่สิ้นสุด:</label>
        <input type="date" id="pdfEndDate" class="border border-gray-300 rounded-lg p-2 mb-4 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500">

        <div class="flex justify-between mt-6">
            <button id="generatePdfBtn" class="bg-yellow-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-yellow-600 transition duration-200">สร้าง PDF</button>
            <button id="closePdfModal" class="bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded-lg hover:bg-gray-400 transition duration-200">ปิด</button>
        </div>
    </div>
</div>

<script>
    // เปิด modal สำหรับ PDF
    $('#exportPdfBtn').click(function() {
        $('#exportPdfModal').removeClass('hidden');
    });

    // ปิด modal เมื่อคลิกปุ่มปิด
    $('#closePdfModal').click(function() {
        $('#exportPdfModal').addClass('hidden');
    });

    // ฟังก์ชันสำหรับสร้าง PDF
    $('#generatePdfBtn').click(function() {
        const startDate = $('#pdfStartDate').val();
        const endDate = $('#pdfEndDate').val();

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

        // ส่งข้อมูลวันที่ไปยังไฟล์ generate_pdf.php
        window.open('../mpdf/exams/generate_pdf_exams.php?start_date=' + startDate + '&end_date=' + endDate, '_blank');


        // ปิด modal
        $('#exportPdfModal').addClass('hidden');
    });
</script>