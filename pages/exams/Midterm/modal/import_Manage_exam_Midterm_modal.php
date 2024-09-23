<!-- Modal for Import Excel -->
<div id="importExcelModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center hidden">
    <div class="modal-content bg-white rounded shadow-lg p-6 w-[500px]">
        <h2 class="text-lg font-semibold mb-4">นำเข้าข้อมูลจากไฟล์ Excel</h2>
        <form action="../exports/exams/import_excel.php" method="POST" enctype="multipart/form-data" class="bg-white">
            <label class="w-full flex flex-col items-center px-4 py-6 bg-white text-blue-500 rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-white">
                <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                </svg>
                <span class="mt-2 text-base leading-normal">เลือกไฟล์</span>
                <div>
                    <span class="mt-3 text-red-400">ชื่อไฟล์ : </span>
                    <span id="fileName" class="mt-3 text-red-400"></span>
                </div>

                <input type='file' name="excel_file" accept=".xlsx, .xls" required class="hidden text-red-400" id="excelFileInput" />
            </label>

            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">นำเข้า</button>
                <button id="closeImportModal" class="close ml-2 bg-red-500 text-white px-4 py-2 rounded">ปิด</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('excelFileInput').addEventListener('change', function(event) {
        const fileName = event.target.files[0] ? event.target.files[0].name : '';
        document.getElementById('fileName').textContent = fileName;
    });
</script>