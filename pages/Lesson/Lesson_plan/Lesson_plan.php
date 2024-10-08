<div class="bg-white rounded-lg shadow-lg p-8">
    <h1 class="text-4xl font-bold mb-8 text-center text-blue-600">ถามคำถาม</h1>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
        <div>
            <label class="block text-sm font-medium text-gray-700" for="grade_level">เลือก Grade Level:</label>
            <select id="grade_level" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 h-12 bg-gray-100">
                <option>-- เลือก --</option>
                <option value="ประถม">ประถม</option>
                <option value="มัธยม">มัธยม</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700" for="course">เลือก Course:</label>
            <select id="course" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 h-12 bg-gray-100">
                <option>-- เลือก --</option>
                <option value="วิชาคณิตศาสตร์">วิชาคณิตศาสตร์</option>
                <option value="วิชาวิทยาศาสตร์">วิทยาศาสตร์</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700" for="chapter">เลือก Chapter:</label>
            <select id="chapter" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 h-12 bg-gray-100">
                <option>-- เลือก --</option>
                <option value="บทที่ 1">บทที่ 1</option>
                <option value="บทที่ 2">บทที่ 2</option>
            </select>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 mb-8">
        <button onclick="fetchLessonData()" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg shadow-lg transition-transform transform hover:scale-105">
            ค้นหา
        </button>

        <button id="pdfPreviewButton" onclick="showPDFPreview()" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg shadow-lg transition-transform transform hover:scale-105 hidden">
            แสดงตัวอย่าง PDF
        </button>
    </div>

    <table id="dataTable" class="border-collapse w-full mb-6 text-gray-700 hidden">
        <thead>
            <tr class="bg-blue-500 text-white">
                <th class="p-4 font-bold uppercase border-b">ลำดับที่</th>
                <th class="p-4 font-bold uppercase border-b">หัวเรื่อง</th>
                <th class="p-4 font-bold uppercase border-b">ตัวชี้วัด</th>
                <th class="p-4 font-bold uppercase border-b">เนื้อหา</th>
                <th class="p-4 font-bold uppercase border-b">จำนวนชั่วโมง</th>
            </tr>
        </thead>
        <tbody class="bg-gray-50">
            <tr class="hover:bg-gray-100">
                <td class="p-4 border-b"><p id="chapter_display"></p></td>
                <td class="p-4 border-b"><p id="indicators"></p></td>
                <td class="p-4 border-b"><p id="expected_learning_outcomes"></p></td>
                <td class="p-4 border-b"><p id="content"></p></td>
                <td class="p-4 border-b"><p id="study_time"></p></td>
            </tr>
        </tbody>
    </table>

    <h2 id="searchResultsHeader" class="text-2xl font-semibold mb-2 text-blue-600 hidden">ข้อมูลที่ค้นหาได้</h2>
    <p id="no_display" class="border border-gray-300 bg-gray-100 p-4 rounded-md mb-4 hidden"></p>
    <p id="activity" class="border border-gray-300 bg-gray-100 p-4 rounded-md mb-4 hidden"></p>
    <p id="learning_resources" class="border border-gray-300 bg-gray-100 p-4 rounded-md mb-4 hidden"></p>

    <h2 id="questionsHeader" class="text-2xl font-semibold mb-2 text-blue-600 hidden">คำถามและคำตอบ</h2>
    <div id="questions_and_answers" class="border border-gray-300 bg-gray-100 p-4 rounded-md mb-4 hidden"></div>

    <h2 id="noteHeader" class="text-2xl font-semibold mb-2 text-blue-600 hidden">หมายเหตุ</h2>
    <p id="note" class="border border-gray-300 bg-gray-100 p-4 rounded-md mb-4 hidden"></p>

    <h2 id="referHeader" class="text-2xl font-semibold mb-2 text-blue-600 hidden">การอ้างอิง</h2>
    <p id="refer" class="border border-gray-300 bg-gray-100 p-4 rounded-md hidden"></p>
</div>

<!-- Modal -->
<div id="noContentModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 max-w-md">
        <h2 class="text-lg font-bold text-red-600 mb-4">ไม่พบข้อมูล</h2>
        <p class="text-gray-700">ไม่มีข้อมูลที่ตรงกับตัวกรองที่เลือก กรุณาลองใหม่อีกครั้ง.</p>
        <div class="flex justify-end mt-4">
            <button onclick="closeModal()" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                ปิด
            </button>
        </div>
    </div>
</div>



<?php include "sql/script.php";?>
<?php include "sql/Lesson_export_pdf.php";?>
