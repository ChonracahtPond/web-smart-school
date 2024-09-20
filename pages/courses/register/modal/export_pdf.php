<!-- Modal สำหรับเลือกวันที่ -->
<div id="pdfDateModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center hidden">
    <div class="modal-content bg-white rounded-lg shadow-lg p-6 w-[400px]">
        <h2 class="text-lg font-semibold mb-4">เลือกช่วงวันที่ การออกรายงาน PDF</h2>
        <form id="pdfExportForm" action="../mpdf/enrollments/export_pdf.php" target="_blank" method="GET">
            <div class="mb-4">
                <label for="start_date_pdf" class="block text-sm font-medium text-gray-700">วันที่เริ่มต้น</label>
                <input type="date" id="start_date_pdf" name="start_date" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="mb-4">
                <label for="end_date_pdf" class="block text-sm font-medium text-gray-700">วันที่สิ้นสุด</label>
                <input type="date" id="end_date_pdf" name="end_date" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">
                    ส่งออก
                </button>
                <button type="button" onclick="closePdfModal()" class="ml-2 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-red-600">
                    ปิด
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    // ฟังก์ชันเปิดโมดัล
    document.getElementById("exportPdfButton").onclick = function() {
        document.getElementById('pdfDateModal').classList.remove('hidden');
    }

    // ฟังก์ชันปิดโมดัล
    function closePdfModal() {
        document.getElementById('pdfDateModal').classList.add('hidden');
    }
</script>