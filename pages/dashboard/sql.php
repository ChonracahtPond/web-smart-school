<?php
// ตรวจสอบพารามิเตอร์ 'page' และจัดการการรวมไฟล์ตามที่ระบุ
$page = isset($_GET['pages']) ? $_GET['pages'] : 'default';



// Query to count the number of students
$sql_students = "SELECT COUNT(*) AS students_count FROM students";
$result_students = $conn->query($sql_students);

// Query to count the number of teachers
$sql_teachers = "SELECT COUNT(*) AS teachers_count FROM teachers";
$result_teachers = $conn->query($sql_teachers);

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

if ($result_students->num_rows > 0 && $result_teachers->num_rows > 0 && $result_classes_courses->num_rows > 0 && $result_active_courses->num_rows > 0 && $result_activities_upcoming->num_rows > 0) {
    // Fetch the result
    $row_students = $result_students->fetch_assoc();
    $students_count = $row_students['students_count'];

    $row_teachers = $result_teachers->fetch_assoc();
    $teachers_count = $row_teachers['teachers_count'];

    $row_classes_courses = $result_classes_courses->fetch_assoc();
    $classes_courses = $row_classes_courses['classes_courses'];

    $row_active_courses = $result_active_courses->fetch_assoc();
    $active_courses = $row_active_courses['active_courses'];

    $row_activities_upcoming = $result_activities_upcoming->fetch_assoc();
    $activities_upcoming = $row_activities_upcoming['activities_upcoming'];
} else {
    $students_count = 0;
    $teachers_count = 0;
    $classes_courses = 0;
    $active_courses = 0;
    $activities_upcoming = 0;
}
