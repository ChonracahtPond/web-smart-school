<?php
// SQL query to fetch student data
$sql = "SELECT student_id, grade_level, section, username, fullname, nicknames, email, phone_number, date_of_birth, gender, file_images FROM students";
$result = $conn->query($sql);
?>

<link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-semibold text-gray-900 mb-6">ข้อมูลนักเรียน</h1>
    <!-- Import Button -->
    <div class="mb-4 flex space-x-4">
        <a href="?page=add_student" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">+ เพิ่มข้อมูลนักเรียน</a>
        <a href="../mpdf/student_report/student_information_report.php" class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-green-600">ออกรายงาน PDF</a>
        <a href="../exports/student_report/student_information_excel.php" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-yellow-600">ออกรายงาน Excel</a>
        <!-- Button to trigger modal -->
        <button id="importButton" class="bg-purple-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-purple-600">นำเข้าข้อมูลจาก Excel</button>
    </div>

    <!-- Modal -->
    <div id="importModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h2 class="text-xl font-semibold mb-4">นำเข้าข้อมูลจาก Excel</h2>
            <!-- Import Form -->
            <form action="../exports/student_report/import_student_excel.php" method="post" enctype="multipart/form-data" class="flex flex-col space-y-4">
                <input type="file" name="import_file" accept=".xlsx" class="px-4 py-2 border border-gray-300 rounded-lg">
                <button type="submit" class="bg-purple-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-purple-600">นำเข้าข้อมูลจาก Excel</button>
                <button type="button" id="closeModal" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-red-600">ปิด</button>
            </form>
        </div>
    </div>

    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-semibold text-gray-900 mb-6">ข้อมูลนักเรียน</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if ($result->num_rows > 0) : ?>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <div class="max-w-sm mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl">
                        <div class="md:flex">
                            <div class="md:flex-shrink-0">
                                <?php if ($row['file_images']) : ?>
                                    <img class="h-48 w-full object-cover md:w-48" src="<?php echo htmlspecialchars($row['file_images']); ?>" alt="Student Image">
                                <?php else : ?>
                                    <img class="h-48 w-full object-cover md:w-48" src="https://via.placeholder.com/300x200" alt="No Image Available">
                                <?php endif; ?>
                            </div>
                            <div class="p-8">
                                <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">ข้อมูลนักเรียน</div>
                                <div class="block mt-1 text-lg leading-tight font-medium text-black"><?php echo htmlspecialchars($row['fullname']); ?></div>
                                <p class="mt-2 text-gray-500">รหัสนักเรียน: <?php echo htmlspecialchars($row['student_id']); ?></p>
                                <p class="mt-2 text-gray-500">ระดับชั้น: <?php echo htmlspecialchars($row['grade_level']); ?></p>
                                <p class="mt-2 text-gray-500">ห้องเรียน: <?php echo htmlspecialchars($row['section']); ?></p>
                                <p class="mt-2 text-gray-500">ชื่อเล่น: <?php echo htmlspecialchars($row['nicknames']); ?></p>
                                <p class="mt-2 text-gray-500">อีเมล: <?php echo htmlspecialchars($row['email']); ?></p>
                                <p class="mt-2 text-gray-500">หมายเลขโทรศัพท์: <?php echo htmlspecialchars($row['phone_number']); ?></p>
                                <p class="mt-2 text-gray-500">เพศ: <?php echo htmlspecialchars($row['gender']); ?></p>
                                <div class="mt-4">
                                    <a href="../mpdf/student_report/view_register.php?student_id=<?php echo urlencode($row['student_id']); ?>" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">ดูรายละเอียด</a>
                                    <a href="?page=edit_user&id=<?php echo urlencode($row['student_id']); ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 ml-2">แก้ไข</a>
                                    <a href="?page=delete_user&id=<?php echo urlencode($row['student_id']); ?>" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 ml-2" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')">ลบ</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <p class="text-gray-600">ไม่พบข้อมูลนักเรียน</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var importButton = document.getElementById('importButton');
            var importModal = document.getElementById('importModal');
            var closeModal = document.getElementById('closeModal');

            importButton.addEventListener('click', function() {
                importModal.classList.remove('hidden');
            });

            closeModal.addEventListener('click', function() {
                importModal.classList.add('hidden');
            });

            // Close modal when clicking outside of it
            window.addEventListener('click', function(event) {
                if (event.target === importModal) {
                    importModal.classList.add('hidden');
                }
            });
        });
    </script>