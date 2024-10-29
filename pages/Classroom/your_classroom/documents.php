<div class="mt-8">
    <h2 class="text-2xl font-semibold text-purple-900 mb-4">เอกสารการสอน</h2>
    <?php if ($documents_result->num_rows > 0) { ?>
        <table class="min-w-full bg-white shadow-lg rounded-lg border border-gray-200">
            <thead>
                <tr class="bg-purple-600 text-white">
                    <th class="py-3 px-4 text-left">ชื่อเอกสาร</th>
                    <th class="py-3 px-4 text-left">ประเภท</th>
                    <th class="py-3 px-4 text-left">ขนาดไฟล์ (KB)</th>
                    <th class="py-3 px-4 text-left">ลิงก์เอกสาร</th>
                    <th class="py-3 px-4 text-left">วันที่สร้าง</th>
                    <th class="py-3 px-4 text-left">การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($document = $documents_result->fetch_assoc()) { ?>
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-4"><?php echo htmlspecialchars($document['document_name']); ?></td>
                        <td class="py-3 px-4"><?php echo htmlspecialchars($document['document_type']); ?></td>
                        <td class="py-3 px-4"><?php echo htmlspecialchars($document['file_size'] / 1024); ?> KB</td>
                        <td class="py-3 px-4">
                            <a href="<?php echo htmlspecialchars($document['file_url']); ?>" target="_blank" class="text-blue-500 hover:underline">ดูเอกสาร</a>
                        </td>
                        <td class="py-3 px-4"><?php echo htmlspecialchars($document['created_at']); ?></td>
                        <td class="py-3 px-4">
                            <form action="?page=delete_document" method="POST" style="display: inline;">
                                <input type="hidden" name="document_id" value="<?php echo htmlspecialchars($document['document_id']); ?>">
                                <input type="hidden" name="lesson_id" value="<?php echo htmlspecialchars($lesson_id); ?>">
                                <button type="submit" class="text-red-600 hover:underline">ลบ</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-gray-700">ไม่มีเอกสารที่เกี่ยวข้อง</p>
        <div class="text-center mt-4">
            <button onclick="openModalDocuments()" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300">เพิ่มเอกสาร</button>
        </div>
    <?php } ?>
</div>

<!-- โมดัลเพิ่มเอกสาร -->
<div id="documentModal" class="fixed inset-0 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
        <div class="bg-white max-w-lg w-full p-6 rounded-lg shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold text-purple-700">เพิ่มเอกสาร</h2>
                <button onclick="closeModalDocuments()" class="text-gray-600 hover:text-gray-900">&times;</button>
            </div>
            <form action="?page=add_documents" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="lesson_id" value="<?php echo htmlspecialchars($lesson_id); ?>">
                <div class="mt-4">
                    <label class="block text-gray-700">ชื่อเอกสาร:</label>
                    <input type="text" name="document_name" required class="w-full p-2 border border-gray-300 rounded mt-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="mt-4">
                    <label class="block text-gray-700">ประเภท:</label>
                    <select name="document_type" required class="w-full p-2 border border-gray-300 rounded mt-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="document">เอกสาร</option>
                        <option value="presentation">การนำเสนอ</option>
                        <option value="video">วิดีโอ</option>
                        <option value="other">อื่นๆ</option>
                    </select>
                </div>
                <div class="mt-4">
                    <label class="block text-gray-700">อัปโหลดไฟล์:</label>
                    <input type="file" name="file" required class="w-full p-2 border border-gray-300 rounded mt-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="button" onclick="closeModalDocuments()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg mr-2 hover:bg-gray-400">ยกเลิก</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModalDocuments() {
        document.getElementById('documentModal').classList.remove('hidden');
    }

    function closeModalDocuments() {
        document.getElementById('documentModal').classList.add('hidden');
    }
</script>
