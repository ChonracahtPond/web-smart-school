<?php
$selected_grade = isset($_GET['grade_level']) ? $_GET['grade_level'] : '';
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// SQL query to fetch student data, filtering by selected grade level and search query if applicable
$sql = "SELECT student_id, grade_level, section, username, fullname, nicknames, email, phone_number, date_of_birth, gender, file_images FROM students";
$conditions = [];

if ($selected_grade) {
    $conditions[] = "grade_level = '" . $conn->real_escape_string($selected_grade) . "'";
}

if ($search_query) {
    $search_query = $conn->real_escape_string($search_query);
    $conditions[] = "fullname LIKE '%$search_query%'";
}

if ($conditions) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$result = $conn->query($sql);

// Fetch unique grade levels for the dropdown
$grades_query = "SELECT DISTINCT grade_level FROM students ORDER BY grade_level";
$grades_result = $conn->query($grades_query);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.7/dist/tailwind.min.css">

<div class="container mx-auto px-6 py-8">
    <h1 class="text-4xl font-bold text-gray-900 mb-8">ข้อมูลนักเรียน</h1>

    <!-- Grade Level Filter Dropdown -->
    <form method="GET" class="mb-8 flex flex-col md:flex-row md:items-center md:space-x-4">
        <div class="flex-1 mb-4 md:mb-0">
            <label for="grade_level" class="block text-lg font-medium text-gray-700 mb-2">กรองตามระดับชั้น</label>
            <select id="grade_level" name="grade_level" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" onchange="this.form.submit()">
                <option value="">แสดงทั้งหมด</option>
                <?php while ($grade_row = $grades_result->fetch_assoc()) : ?>
                    <option value="<?php echo htmlspecialchars($grade_row['grade_level']); ?>" <?php if ($selected_grade == $grade_row['grade_level']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($grade_row['grade_level']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Search Input -->
        <div class="flex-1">
            <label for="search" class="block text-lg font-medium text-gray-700 mb-2">ค้นหาชื่อนักเรียน</label>
            <input id="search" name="search" type="text" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="ค้นหาชื่อ..." class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        <?php if ($result->num_rows > 0) : ?>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200 flex flex-col md:flex-row">
                    <div class="flex-shrink-0 w-full md:w-48">
                        <?php
                        $imagePath = '../uploads/register/' . htmlspecialchars($row['file_images']);
                        ?>
                        <?php if ($row['file_images'] && file_exists($imagePath)) : ?>
                            <img class="h-48 w-full object-cover" src="<?php echo $imagePath; ?>" alt="Student Image">
                        <?php else : ?>
                            <img class="h-48 w-full object-cover" src="https://via.placeholder.com/200x150" alt="No Image Available">
                        <?php endif; ?>
                    </div>
                    <div class="p-6 flex flex-col justify-between w-full md:w-64">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800"><?php echo htmlspecialchars($row['fullname']); ?></h2>
                            <p class="text-gray-600 mt-2">รหัสนักเรียน: <?php echo htmlspecialchars($row['student_id']); ?></p>
                            <p class="text-gray-600">ระดับชั้น: <?php echo htmlspecialchars($row['grade_level']); ?></p>
                            <p class="text-gray-600">ห้องเรียน: <?php echo htmlspecialchars($row['section']); ?></p>
                            <p class="text-gray-600">ชื่อเล่น: <?php echo htmlspecialchars($row['nicknames']); ?></p>
                            <p class="text-gray-600">อีเมล: <?php echo htmlspecialchars($row['email']); ?></p>
                            <p class="text-gray-600">หมายเลขโทรศัพท์: <?php echo htmlspecialchars($row['phone_number']); ?></p>
                            <p class="text-gray-600">เพศ: <?php echo htmlspecialchars($row['gender']); ?></p>
                        </div>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <a href="../mpdf/student_report/view_register.php?student_id=<?php echo urlencode($row['student_id']); ?>" class="bg-indigo-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-600 flex items-center space-x-2">
                                <i class="fas fa-eye"></i>
                                <span>ดูรายละเอียด</span>
                            </a>
                            <a href="?page=edit_user&id=<?php echo urlencode($row['student_id']); ?>" class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-yellow-600 flex items-center space-x-2">
                                <i class="fas fa-pencil-alt"></i>
                                <span>แก้ไข</span>
                            </a>
                            <a href="?page=delete_user&id=<?php echo urlencode($row['student_id']); ?>" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-600 flex items-center space-x-2" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')">
                                <i class="fas fa-trash-alt"></i>
                                <span>ลบ</span>
                            </a>
                        </div>

                    </div>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <p class="text-gray-600 text-center col-span-full">ไม่พบข้อมูลนักเรียน</p>
        <?php endif; ?>
    </div>
</div>

<script>
    // ฟังก์ชันค้นหาชื่อนักเรียน
    document.getElementById('search').addEventListener('input', function() {
        var searchValue = this.value.toLowerCase();
        var cards = document.querySelectorAll('.grid > div');

        cards.forEach(function(card) {
            var fullname = card.querySelector('h2').textContent.toLowerCase();
            if (fullname.includes(searchValue) || searchValue === '') {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>