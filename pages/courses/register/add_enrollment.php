<?php
// Assume you have a database connection already established in $conn

// Fetch courses for the page
$sql_courses = "SELECT course_id, course_name FROM courses WHERE status = '1'";
$courses_result = $conn->query($sql_courses);

// Check if there was an error with the query
if (!$courses_result) {
    die("Error fetching courses: " . $conn->error);
}

// Fetch students for the dropdown
$sql_students = "SELECT student_id, CONCAT_WS(' ', fullname) AS student_name FROM students WHERE status = '0'";
$students_result = $conn->query($sql_students);

// Check if there was an error with the query
if (!$students_result) {
    die("Error fetching students: " . $conn->error);
}

// Convert courses and students data to JSON for use in JavaScript
$courses_data = [];
while ($row = $courses_result->fetch_assoc()) {
    $courses_data[] = $row;
}

// Free result set
$courses_result->free();

// Fetch students data
$students_data = [];
while ($row = $students_result->fetch_assoc()) {
    $students_data[] = $row;
}

// Free result set
$students_result->free();

include "sql/Add_enrollment.php";
?>

<div class="mx-auto ">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white text-center">ลงทะเบียนเรียน</h1>
    <div class="bg-white h-[60%] dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4 flex flex-col md:flex-row">
        <!-- Left Section: Course List -->
        <div class="md:w-1/3 p-4 border-r border-gray-300 flex flex-col">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">เลือกวิชา</h2>
            <input type="text" id="searchCourses" placeholder="ค้นหาวิชา" class="form-input w-full border-gray-300 rounded-lg mb-4 px-4 py-2 bg-gray-100 focus:bg-white focus:border-blue-500 transition-all" oninput="filterCourses()">
            <ul id="coursesList" class="list-disc pl-5 space-y-2 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                <?php foreach ($courses_data as $course): ?>
                    <li class="flex items-center  justify-between p-2 hover:bg-gray-100 rounded-lg transition-all">
                        <div class="flex-1">
                            <button type="button" onclick="addCourseToSelection('<?php echo $course['course_id']; ?>', '<?php echo htmlspecialchars($course['course_name']); ?>')" class="text-blue-600 hover:underline">
                                <?php echo htmlspecialchars($course['course_id']) . ' ' . htmlspecialchars($course['course_name']); ?>
                            </button>
                        </div>
                        <button type="button" onclick="addCourseToSelection('<?php echo $course['course_id']; ?>', '<?php echo htmlspecialchars($course['course_name']); ?>')" class="bg-green-600 text-white px-3 py-1 rounded-lg hover:bg-green-700 transition-all">
                            เพิ่ม
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Center Section: Selected Courses List -->
        <div class="md:w-1/3 p-4 border-r border-gray-300 flex flex-col">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">วิชาที่เลือก</h2>
            <div id="selectedCoursesList" class="flex-1 overflow-y-auto bg-gray-50 p-4 rounded-lg border border-gray-200 max-h-[60vh]">
                <p class="text-gray-600">ยังไม่มีวิชาที่เลือก</p>
            </div>
        </div>

        <!-- Right Section: Enrollment Info and Form -->
        <div class="md:w-1/3 p-4 flex flex-col">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">ข้อมูลการลงทะเบียน</h2>
            <form id="enrollmentForm" action="" method="POST" class="flex flex-col flex-1">
                <div id="selectedCoursesInputs" class="mb-4">
                    <!-- Dynamically added inputs will go here -->
                </div>
                <div class="mb-4">
                    <label for="student_id" class="block text-gray-700 font-medium">ชื่อผู้ลงทะเบียน:</label>
                    <select id="student_id" name="student_id" class="form-input w-full border-gray-300 rounded-lg mt-1 px-4 py-2 bg-gray-100 focus:bg-white focus:border-blue-500 transition-all" required>
                        <option value="">เลือกชื่อผู้ลงทะเบียน</option>
                        <?php foreach ($students_data as $student): ?>
                            <option value="<?php echo $student['student_id']; ?>"><?php echo htmlspecialchars($student['student_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="semester" class="block text-gray-700 font-medium">ภาคเรียน:</label>
                    <input type="text" id="semester" name="semester" class="form-input w-full border-gray-300 rounded-lg mt-1 px-4 py-2 bg-gray-100 focus:bg-white focus:border-blue-500 transition-all" required>
                </div>
                <div class="mb-4">
                    <label for="academic_year" class="block text-gray-700 font-medium">ปีการศึกษา:</label>
                    <input type="text" id="academic_year" name="academic_year" class="form-input w-full border-gray-300 rounded-lg mt-1 px-4 py-2 bg-gray-100 focus:bg-white focus:border-blue-500 transition-all" required>
                </div>
                <input type="hidden" id="selectedCoursesData" name="selected_courses_data">
                <div class="flex justify-end space-x-2 mt-auto">
                    <button type="submit" name="enroll" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all focus:outline-none focus:ring-2 focus:ring-blue-500">ลงทะเบียน</button>
                    <button type="button" id="clearSelection" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-all focus:outline-none focus:ring-2 focus:ring-gray-500">ล้างการเลือก</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        function filterCourses() {
            const searchInput = document.getElementById('searchCourses').value.toLowerCase();
            const coursesList = document.getElementById('coursesList');
            const items = coursesList.getElementsByTagName('li');

            for (let i = 0; i < items.length; i++) {
                const courseName = items[i].getElementsByTagName('button')[0].textContent.toLowerCase();
                if (courseName.includes(searchInput)) {
                    items[i].style.display = '';
                } else {
                    items[i].style.display = 'none';
                }
            }
        }

        document.getElementById('searchCourses').addEventListener('input', filterCourses);

        window.addCourseToSelection = function(courseId, courseName) {
            const selectedCoursesList = document.getElementById('selectedCoursesList');
            const existingCourse = document.getElementById(`course-${courseId}`);

            if (!existingCourse) {
                const courseDetails = `
                <div id="course-${courseId}" class="flex items-center justify-between border-b border-gray-300 pb-2 mb-2">
                    <p class="text-gray-700">วิชา: ${courseName}</p>
                    <button type="button" onclick="removeCourse('${courseId}')" class="bg-red-500 text-white px-4 py-1 rounded-lg hover:bg-red-600">ลบ</button>
                </div>
                `;
                selectedCoursesList.insertAdjacentHTML('beforeend', courseDetails);
                updateHiddenInput();
            }
        }

        window.removeCourse = function(courseId) {
            const courseElement = document.getElementById(`course-${courseId}`);
            if (courseElement) {
                courseElement.remove();
                updateHiddenInput();
            }
        }

        function updateHiddenInput() {
            const selectedCoursesList = document.getElementById('selectedCoursesList');
            const items = selectedCoursesList.querySelectorAll('div[id^="course-"]');
            const coursesData = [];

            items.forEach(item => {
                const courseId = item.id.replace('course-', '');
                coursesData.push({
                    id: courseId
                });
            });

            document.getElementById('selectedCoursesData').value = JSON.stringify(coursesData);
        }

        document.getElementById('clearSelection').addEventListener('click', function() {
            document.getElementById('selectedCoursesList').innerHTML = '<p class="text-gray-600">ยังไม่มีวิชาที่เลือก</p>';
            updateHiddenInput();
        });
    });
</script>