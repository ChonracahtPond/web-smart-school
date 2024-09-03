<?php
// ตรวจสอบพารามิเตอร์ 'page' และจัดการการรวมไฟล์ตามที่ระบุ
$page = isset($_GET['pages']) ? $_GET['pages'] : 'default';

// Query to count the total number of students
$sql_students = "SELECT COUNT(*) AS students_count FROM students";
$result_students = $conn->query($sql_students);

// Query to count the number of male students
$sql_male_students = "SELECT COUNT(*) AS male_count FROM students WHERE gender = 'ชาย'";
$result_male_students = $conn->query($sql_male_students);

// Query to count the number of female students
$sql_female_students = "SELECT COUNT(*) AS female_count FROM students WHERE gender = 'หญิง'";
$result_female_students = $conn->query($sql_female_students);

// Query to count the total number of primary school students (ประถม)
$sql_primary_students = "SELECT COUNT(*) AS primary_count FROM students WHERE grade_level = 'ประถม'";
$result_primary_students = $conn->query($sql_primary_students);

// Query to count the number of male primary school students
$sql_primary_male_students = "SELECT COUNT(*) AS primary_male_count FROM students WHERE grade_level = 'ประถม' AND gender = 'ชาย'";
$result_primary_male_students = $conn->query($sql_primary_male_students);

// Query to count the number of female primary school students
$sql_primary_female_students = "SELECT COUNT(*) AS primary_female_count FROM students WHERE grade_level = 'ประถม' AND gender = 'หญิง'";
$result_primary_female_students = $conn->query($sql_primary_female_students);

// Query to count the total number of lower secondary school students (มัธยมต้น)
$sql_lower_secondary_students = "SELECT COUNT(*) AS lower_secondary_count FROM students WHERE grade_level = 'มัธยมต้น'";
$result_lower_secondary_students = $conn->query($sql_lower_secondary_students);

// Query to count the number of male lower secondary school students
$sql_lower_secondary_male_students = "SELECT COUNT(*) AS lower_secondary_male_count FROM students WHERE grade_level = 'มัธยมต้น' AND gender = 'ชาย'";
$result_lower_secondary_male_students = $conn->query($sql_lower_secondary_male_students);

// Query to count the number of female lower secondary school students
$sql_lower_secondary_female_students = "SELECT COUNT(*) AS lower_secondary_female_count FROM students WHERE grade_level = 'มัธยมต้น' AND gender = 'หญิง'";
$result_lower_secondary_female_students = $conn->query($sql_lower_secondary_female_students);

// Query to count the total number of upper secondary school students (มัธยมปลาย)
$sql_upper_secondary_students = "SELECT COUNT(*) AS upper_secondary_count FROM students WHERE grade_level = 'มัธยมปลาย'";
$result_upper_secondary_students = $conn->query($sql_upper_secondary_students);

// Query to count the number of male upper secondary school students
$sql_upper_secondary_male_students = "SELECT COUNT(*) AS upper_secondary_male_count FROM students WHERE grade_level = 'มัธยมปลาย' AND gender = 'ชาย'";
$result_upper_secondary_male_students = $conn->query($sql_upper_secondary_male_students);

// Query to count the number of female upper secondary school students
$sql_upper_secondary_female_students = "SELECT COUNT(*) AS upper_secondary_female_count FROM students WHERE grade_level = 'มัธยมปลาย' AND gender = 'หญิง'";
$result_upper_secondary_female_students = $conn->query($sql_upper_secondary_female_students);


// Query to count the number of teachers
$sql_teachers = "SELECT COUNT(*) AS teachers_count FROM teachers";
$result_teachers = $conn->query($sql_teachers);

// Query to count the number of teachers with the position 'ครู'
$sql_kru_teachers = "SELECT COUNT(*) AS kru_count FROM teachers WHERE position = 'ครู'";
$result_kru_teachers = $conn->query($sql_kru_teachers);

// Query to count the number of teachers with the position 'ครูบรรจุ'
$sql_krubanju_teachers = "SELECT COUNT(*) AS krubanju_count FROM teachers WHERE position = 'ครูบรรจุ'";
$result_krubanju_teachers = $conn->query($sql_krubanju_teachers);

// Query to count the total number of courses
$sql_classes_courses = "SELECT COUNT(*) AS classes_courses FROM courses";
$result_classes_courses = $conn->query($sql_classes_courses);

// Query to count the number of active courses (status = 1)
$sql_active_courses = "SELECT COUNT(*) AS active_courses FROM courses WHERE status = 1";
$result_active_courses = $conn->query($sql_active_courses);

// Query to count the number of upcoming activities
$sql_activities_upcoming = "SELECT COUNT(*) AS activities_upcoming FROM activities WHERE start_date > NOW()";
$result_activities_upcoming = $conn->query($sql_activities_upcoming);

// Query to fetch news data
$sql_news = "SELECT New_id, News_name, News_detail, News_images FROM news ORDER BY New_id DESC LIMIT 5"; // Fetch the latest 5 news
$result_news = $conn->query($sql_news);

if (
    $result_students->num_rows > 0 && $result_teachers->num_rows > 0 && $result_classes_courses->num_rows > 0 && $result_active_courses->num_rows > 0 && $result_activities_upcoming->num_rows > 0 && $result_male_students->num_rows > 0 && $result_female_students->num_rows > 0
    && $result_primary_students->num_rows > 0 && $result_primary_male_students->num_rows > 0 && $result_primary_female_students->num_rows > 0 &&
    $result_lower_secondary_students->num_rows > 0 && $result_lower_secondary_male_students->num_rows > 0 && $result_lower_secondary_female_students->num_rows > 0 &&
    $result_upper_secondary_students->num_rows > 0 && $result_upper_secondary_male_students->num_rows > 0 && $result_upper_secondary_female_students->num_rows > 0
    && $result_kru_teachers->num_rows > 0 && $result_krubanju_teachers->num_rows > 0
) {
    // Fetch the result
    $row_students = $result_students->fetch_assoc();
    $students_count = $row_students['students_count'];

    $row_male_students = $result_male_students->fetch_assoc();
    $male_count = $row_male_students['male_count'];

    $row_female_students = $result_female_students->fetch_assoc();
    $female_count = $row_female_students['female_count'];

    $row_teachers = $result_teachers->fetch_assoc();
    $teachers_count = $row_teachers['teachers_count'];

    $row_classes_courses = $result_classes_courses->fetch_assoc();
    $classes_courses = $row_classes_courses['classes_courses'];

    $row_active_courses = $result_active_courses->fetch_assoc();
    $active_courses = $row_active_courses['active_courses'];

    $row_activities_upcoming = $result_activities_upcoming->fetch_assoc();
    $activities_upcoming = $row_activities_upcoming['activities_upcoming'];

    // Primary school
    $row_primary_students = $result_primary_students->fetch_assoc();
    $primary_count = $row_primary_students['primary_count'];

    $row_primary_male_students = $result_primary_male_students->fetch_assoc();
    $primary_male_count = $row_primary_male_students['primary_male_count'];

    $row_primary_female_students = $result_primary_female_students->fetch_assoc();
    $primary_female_count = $row_primary_female_students['primary_female_count'];

    // Lower secondary school
    $row_lower_secondary_students = $result_lower_secondary_students->fetch_assoc();
    $lower_secondary_count = $row_lower_secondary_students['lower_secondary_count'];

    $row_lower_secondary_male_students = $result_lower_secondary_male_students->fetch_assoc();
    $lower_secondary_male_count = $row_lower_secondary_male_students['lower_secondary_male_count'];

    $row_lower_secondary_female_students = $result_lower_secondary_female_students->fetch_assoc();
    $lower_secondary_female_count = $row_lower_secondary_female_students['lower_secondary_female_count'];

    // Upper secondary school
    $row_upper_secondary_students = $result_upper_secondary_students->fetch_assoc();
    $upper_secondary_count = $row_upper_secondary_students['upper_secondary_count'];

    $row_upper_secondary_male_students = $result_upper_secondary_male_students->fetch_assoc();
    $upper_secondary_male_count = $row_upper_secondary_male_students['upper_secondary_male_count'];

    $row_upper_secondary_female_students = $result_upper_secondary_female_students->fetch_assoc();
    $upper_secondary_female_count = $row_upper_secondary_female_students['upper_secondary_female_count'];
    // Fetch the result
    $row_kru_teachers = $result_kru_teachers->fetch_assoc();
    $kru_count = $row_kru_teachers['kru_count'];

    $row_krubanju_teachers = $result_krubanju_teachers->fetch_assoc();
    $krubanju_count = $row_krubanju_teachers['krubanju_count'];
} else {
    $students_count = 0;
    $male_count = 0;
    $female_count = 0;
    $teachers_count = 0;
    $classes_courses = 0;
    $active_courses = 0;
    $activities_upcoming = 0;
    $primary_count = 0;
    $primary_male_count = 0;
    $primary_female_count = 0;
    $lower_secondary_count = 0;
    $lower_secondary_male_count = 0;
    $lower_secondary_female_count = 0;
    $upper_secondary_count = 0;
    $upper_secondary_male_count = 0;
    $upper_secondary_female_count = 0;
    $kru_count = 0;
    $krubanju_count = 0;
}

// // Display the counts (example)
// echo "จำนวนนักเรียนทั้งหมด: $students_count<br>";
// echo "จำนวนผู้ชาย: $male_count<br>";
// echo "จำนวนผู้หญิง: $female_count<br>";
// echo "จำนวนครู: $teachers_count<br>";
// echo "จำนวนรายวิชา: $classes_courses<br>";
// echo "จำนวนรายวิชาที่เปิดสอน: $active_courses<br>";
// echo "จำนวนกิจกรรมที่กำลังจะมาถึง: $activities_upcoming<br>";
// Display the counts
// echo "ประถม - ทั้งหมด: $primary_count คน, ชาย: $primary_male_count คน, หญิง: $primary_female_count คน<br>";
// echo "มัธยมต้น - ทั้งหมด: $lower_secondary_count คน, ชาย: $lower_secondary_male_count คน, หญิง: $lower_secondary_female_count คน<br>";
// echo "มัธยมปลาย - ทั้งหมด: $upper_secondary_count คน, ชาย: $upper_secondary_male_count คน, หญิง: $upper_secondary_female_count คน<br>";
// Display the counts (example)
// echo "จำนวนครู: $kru_count<br>";
// echo "จำนวนครูบรรจุ: $krubanju_count<br>";