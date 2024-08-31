<!-- โมดัลสำหรับเพิ่มบุคลากร -->
<div id="teacher-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 w-full max-w-lg">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-200">เพิ่มบุคลากรใหม่</h2>
        <form id="add-teacher-form" method="POST" action="?page=process_teacher">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="fname" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">ชื่อ</label>
                    <input type="text" id="fname" name="fname" class="form-input rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700" required>
                </div>
                <div>
                    <label for="lname" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">นามสกุล</label>
                    <input type="text" id="lname" name="lname" class="form-input rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700" required>
                </div>
                <div>
                    <label for="rank" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">ตำแหน่ง</label>
                    <input type="text" id="rank" name="rank" class="form-input rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                </div>
                <div>
                    <label for="position" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">ประเภทบุคลากร</label>
                    <select id="edit-position" name="position" class="form-select rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 ">
                        <option>-- เลือกประเภท --</option>
                        <option value="ครูบรรจุ">ครูบรรจุ</option>
                        <option value="ครูอัตราจ้าง">ครูอัตราจ้าง</option>
                    </select>
                </div>
                <div>
                    <label for="address" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">ที่อยู่</label>
                    <input type="text" id="address" name="address" class="form-input rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                </div>
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">อีเมล</label>
                    <input type="email" id="email" name="email" class="form-input rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                </div>
                <div>
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">ชื่อผู้ใช้</label>
                    <input type="text" id="username" name="username" class="form-input rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                </div>
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">รหัสผ่าน</label>
                    <input type="password" id="password" name="password" class="form-input rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                </div>
                <div>
                    <label for="images" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">URL รูปภาพ</label>
                    <input type="text" id="images" name="images" class="form-input rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                </div>
                <div>
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">โทรศัพท์</label>
                    <input type="text" id="phone" name="phone" class="form-input rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                </div>
                <div>
                    <label for="gender" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">เพศ</label>
                    <select id="gender" name="gender" class="form-select rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                        <option>-- เลือกเพศ --</option>
                        <option value="ชาย">ชาย</option>
                        <option value="หญิง">หญิง</option>
                        <option value="อื่นๆ">อื่นๆ</option>
                    </select>
                </div>
                <div>
                    <label for="teacher_name" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">ชื่อบุคลากร</label>
                    <input type="text" id="teacher_name" name="teacher_name" class="form-input rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                </div>
            </div>
            <div class="mt-4 flex justify-end space-x-2">
                <button type="button" id="close-modal" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">ยกเลิก</button>
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">เพิ่มบุคลากร</button>
            </div>
        </form>
    </div>
</div>














<!-- โมดัลสำหรับแก้ไขข้อมูลบุคลากร -->
<div id="edit-teacher-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 w-full max-w-lg">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-200">แก้ไขข้อมูลบุคลากร</h2>
        <form id="edit-teacher-form" method="POST" action="?page=update_teacher" enctype="multipart/form-data">
            <input type="hidden" id="edit-teacher-id" name="teacher_id">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="edit-fname" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">ชื่อ</label>
                    <input type="text" id="edit-fname" name="Fname" class="form-input rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700" required>
                </div>
                <div>
                    <label for="edit-lname" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">นามสกุล</label>
                    <input type="text" id="edit-lname" name="Lname" class="form-input rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700" required>
                </div>
                <div>
                    <label for="edit-rank" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">ตำแหน่ง</label>
                    <input type="text" id="edit-rank" name="Rank" class="form-input rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                </div>
                <div>
                    <label for="edit-position" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300 ">ประเภทบุคลากร</label>
                    <select id="edit-position" name="position" class="form-select rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 ">
                        <option>-- เลือกประเภท --</option>
                        <option value="ครูบรรจุ">ครูบรรจุ</option>
                        <option value="ครูอัตราจ้าง">ครูอัตราจ้าง</option>
                    </select>
                </div>
                <div>
                    <label for="edit-address" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">ที่อยู่</label>
                    <input type="text" id="edit-address" name="address" class="form-input rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                </div>
                <div>
                    <label for="edit-email" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">อีเมล</label>
                    <input type="email" id="edit-email" name="email" class="form-input rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                </div>
                <div>
                    <label for="edit-username" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">ชื่อผู้ใช้</label>
                    <input type="text" id="edit-username" name="username" class="form-input rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                </div>

                <div>
                    <label for="edit-images" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">URL รูปภาพ</label>
                    <input type="text" id="edit-images" name="images" class="form-input rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                </div>
                <div>
                    <label for="edit-phone" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">โทรศัพท์</label>
                    <input type="text" id="edit-phone" name="phone" class="form-input rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                </div>
                <div>
                    <label for="edit-gender" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">เพศ</label>
                    <select id="edit-gender" name="gender" class="form-select rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                        <option value="ชาย">ชาย</option>
                        <option value="หญิง">หญิง</option>
                        <option value="อื่นๆ">อื่นๆ</option>
                    </select>
                </div>
                <div>
                    <label for="edit-teacher_name" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">ชื่อบุคลากร</label>
                    <input type="text" id="edit-teacher_name" name="teacher_name" class="form-input rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                </div>
            </div>
            <div class="mt-4 flex justify-end space-x-2">
                <button type="button" id="close-edit-modal" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">ยกเลิก</button>
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">อัปเดตบุคลากร</button>
            </div>
        </form>
    </div>
</div>

<script>
    // JavaScript สำหรับเปิดโมดัลการแก้ไขและเติมข้อมูลล่วงหน้า
    function openEditModal(teacher) {
        document.getElementById('edit-teacher-id').value = teacher.teacher_id;
        document.getElementById('edit-fname').value = teacher.Fname;
        document.getElementById('edit-lname').value = teacher.Lname;
        document.getElementById('edit-rank').value = teacher.Rank;
        document.getElementById('edit-position').value = teacher.position;
        document.getElementById('edit-address').value = teacher.address;
        document.getElementById('edit-email').value = teacher.email;
        document.getElementById('edit-username').value = teacher.username;
        document.getElementById('edit-images').value = teacher.images;
        document.getElementById('edit-phone').value = teacher.phone;
        document.getElementById('edit-gender').value = teacher.gender;
        document.getElementById('edit-teacher_name').value = teacher.teacher_name;

        document.getElementById('edit-teacher-modal').classList.remove('hidden');
    }


    document.getElementById('close-edit-modal').addEventListener('click', function() {
        document.getElementById('edit-teacher-modal').classList.add('hidden');
    });
</script>