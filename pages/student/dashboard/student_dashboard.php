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

<div class=" mx-auto px-6 py-8">
    <!-- <h1 class="text-4xl font-bold text-blue-800 mb-8">ข้อมูลนักเรียน</h1> -->

    <!-- Grade Level Filter Dropdown -->
    <form method="GET" class="mb-8 flex flex-col md:flex-row md:items-center md:space-x-4">
        <!-- Search Input -->
        <div class="flex-1 mb-4 md:mb-0">
            <label for="search" class="block text-lg font-medium text-gray-700 mb-2">ค้นหาชื่อนักเรียน</label>
            <input id="search" name="search" type="text" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="ค้นหาชื่อ..." class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

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
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        <?php if ($result->num_rows > 0) : ?>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200 p-4 justify-center  md:flex-row transition-transform transform hover:scale-105 hover:shadow-xl duration-300">
                    <div class="flex">
                        <div class="flex-shrink-0 w-full md:w-48">
                            <?php
                            $imagePath = '../uploads/register/' . htmlspecialchars($row['file_images']);
                            ?>
                            <?php if ($row['file_images'] && file_exists($imagePath)) : ?>
                                <img class="h-48 w-full object-cover transition-opacity duration-300 hover:opacity-80" src="<?php echo $imagePath; ?>" alt="Student Image">
                            <?php else : ?>
                                <img class="h-48 w-full object-cover transition-opacity duration-300 hover:opacity-80" src="https://via.placeholder.com/200x150" alt="No Image Available">
                            <?php endif; ?>
                        </div>
                        <div class="p-4 flex flex-col justify-between w-full md:w-64">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800 mb-2"><?php echo htmlspecialchars($row['fullname']); ?></h2>
                                <p class="text-gray-600">รหัสนักเรียน: <?php echo htmlspecialchars($row['student_id']); ?></p>
                                <p class="text-gray-600">ระดับชั้น: <?php echo htmlspecialchars($row['grade_level']); ?></p>
                                <p class="text-gray-600">ห้องเรียน: <?php echo htmlspecialchars($row['section']); ?></p>
                                <p class="text-gray-600">ชื่อเล่น: <?php echo htmlspecialchars($row['nicknames']); ?></p>
                                <p class="text-gray-600">เพศ: <?php echo htmlspecialchars($row['gender']); ?></p>
                                <p class="text-gray-600">อีเมล: <?php echo htmlspecialchars($row['email']); ?></p>
                                <p class="text-gray-600">โทรศัพท์: <?php echo htmlspecialchars($row['phone_number']); ?></p>
                            </div>
                        </div>

                    </div>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="?page=student_details&student_id=<?php echo urlencode($row['student_id']); ?>" class="bg-indigo-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-600 flex items-center space-x-2 transition-transform transform hover:scale-105 duration-300">
                            <svg class="h-5 w-5 " width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <circle cx="12" cy="12" r="2" />
                                <path d="M2 12l1.5 2a11 11 0 0 0 17 0l1.5 -2" />
                                <path d="M2 12l1.5 -2a11 11 0 0 1 17 0l1.5 2" />
                            </svg>
                            <span>ดูรายละเอียด</span>
                        </a>
                        <a href="../mpdf/student_report/view_register.php?student_id=<?php echo urlencode($row['student_id']); ?>" class="bg-blue-400 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600 flex items-center space-x-2 transition-transform transform hover:scale-105 duration-300">
                            <svg class="h-5 w-5 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>

                            <span>เอกสารสมัคร</span>
                        </a>
                        <a href="?page=students_courses&student_id=<?php echo urlencode($row['student_id']); ?>" class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-yellow-600 flex items-center space-x-2 transition-transform transform hover:scale-105 duration-300">
                            <svg class="h-5 w-5 " width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <path d="M6 4h11a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-11a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1m3 0v18" />
                                <line x1="13" y1="8" x2="15" y2="8" />
                                <line x1="13" y1="12" x2="15" y2="12" />
                            </svg>
                            <span>รายวิชา</span>
                        </a>
                        <a href="?page=GradeList&student_id=<?php echo urlencode($row['student_id']); ?>" class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-600 flex items-center space-x-2 transition-transform transform hover:scale-105 duration-300">
                            <svg class="h-5 w-5 " width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <line x1="4" y1="20" x2="7" y2="20" />
                                <line x1="14" y1="20" x2="21" y2="20" />
                                <line x1="6.9" y1="15" x2="13.8" y2="15" />
                                <line x1="10.2" y1="6.3" x2="16" y2="20" />
                                <polyline points="5 20 11 4 13 4 20 20" />
                            </svg>
                            <span>เกรดเฉลี่ยแต่ละรายวิชา</span>
                        </a>
                        <a href="?page=&id=<?php echo urlencode($row['student_id']); ?>" class="bg-gray-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-600 flex items-center space-x-2 transition-transform transform hover:scale-105 duration-300">
                            <svg class="h-5 w-5 " width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                <line x1="19" y1="7" x2="19" y2="10" />
                                <line x1="19" y1="14" x2="19" y2="14.01" />
                            </svg>
                            <span>หน่วยกิจ กพช.</span>
                        </a>
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