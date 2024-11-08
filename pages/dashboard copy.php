<?php
// Query to count the number of students
$sql_students = "SELECT COUNT(*) AS students_count FROM students";
$result_students = $conn->query($sql_students);

// Query to count the number of teachers
$sql_teachers = "SELECT COUNT(*) AS teachers_count FROM teachers";
$result_teachers = $conn->query($sql_teachers);

// Query to count the number of classes courses
$sql_classes_courses = "SELECT COUNT(*) AS classes_courses FROM courses";
$result_classes_courses = $conn->query($sql_classes_courses);

$sql_activities_upcoming = "SELECT COUNT(*) AS activities_upcoming FROM activities WHERE start_date > NOW()";
// $sql_activities_upcoming = "SELECT COUNT(*) AS activities_upcoming FROM activities ";
// $sql_activities_upcoming = "SELECT COUNT(*) AS activities_upcoming FROM activities WHERE date > NOW()";
$result_activities_upcoming = $conn->query($sql_activities_upcoming);

if ($result_students->num_rows > 0 && $result_teachers->num_rows > 0 && $result_classes_courses->num_rows > 0 && $result_activities_upcoming->num_rows > 0) {
    // Fetch the result
    $row_students = $result_students->fetch_assoc();
    $students_count = $row_students['students_count'];

    $row_teachers = $result_teachers->fetch_assoc();
    $teachers_count = $row_teachers['teachers_count'];

    $row_classes_courses = $result_classes_courses->fetch_assoc();
    $classes_courses = $row_classes_courses['classes_courses'];

    $row_activities_upcoming = $result_activities_upcoming->fetch_assoc();
    $activities_upcoming = $row_activities_upcoming['activities_upcoming'];
} else {
    $students_count = 0;
    $teachers_count = 0;
    $classes_courses = 0;
    $activities_upcoming = 0;
}

?>

<div class="min-w-[375px] md:min-w-[700px] xl:min-w-[800px] mt-3 grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-3 3xl:grid-cols-6">
    <div class="relative flex flex-grow !flex-row flex-col items-center rounded-[10px] rounded-[10px] border-[1px] border-gray-200 bg-white bg-clip-border shadow-md shadow-[#F3F3F3] dark:border-[#ffffff33] dark:!bg-navy-800 dark:text-white dark:shadow-none">
        <div class="ml-[18px] flex h-[90px] w-auto flex-row items-center">
            <div class="rounded-full bg-lightPrimary p-3 dark:bg-navy-700">
                <span class="flex items-center text-brand-500 dark:text-white">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="h-7 w-7" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path xmlns="http://www.w3.org/2000/svg" d="M19 15C21.2091 15 23 16.7909 23 19V21H21M16 10.874C17.7252 10.4299 19 8.86383 19 6.99999C19 5.13615 17.7252 3.57005 16 3.12601M13 7C13 9.20914 11.2091 11 9 11C6.79086 11 5 9.20914 5 7C5 4.79086 6.79086 3 9 3C11.2091 3 13 4.79086 13 7ZM5 15H13C15.2091 15 17 16.7909 17 19V21H1V19C1 16.7909 2.79086 15 5 15Z" stroke="#DDD" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </div>
        </div>
        <div class="h-50 ml-4 flex w-auto flex-col justify-center">
            <p class="font-dm text-sm font-medium text-gray-600">จำนวนนักเรียน</p>
            <h4 class="text-xl font-bold text-navy-700 dark:text-white"><?php echo $students_count; ?></h4>
        </div>
    </div>
    <div class="relative flex flex-grow !flex-row flex-col items-center rounded-[10px] rounded-[10px] border-[1px] border-gray-200 bg-white bg-clip-border shadow-md shadow-[#F3F3F3] dark:border-[#ffffff33] dark:!bg-navy-800 dark:text-white dark:shadow-none">
        <div class="ml-[18px] flex h-[90px] w-auto flex-row items-center">
            <div class="rounded-full bg-lightPrimary p-3 dark:bg-navy-700">
                <span class="flex items-center text-brand-500 dark:text-white">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" class="h-6 w-6" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path d="M298.39 248a4 4 0 002.86-6.8l-78.4-79.72a4 4 0 00-6.85 2.81V236a12 12 0 0012 12z"></path>
                        <path d="M197 267a43.67 43.67 0 01-13-31v-92h-72a64.19 64.19 0 00-64 64v224a64 64 0 0064 64h144a64 64 0 0064-64V280h-92a43.61 43.61 0 01-31-13zm175-147h70.39a4 4 0 002.86-6.8l-78.4-79.72a4 4 0 00-6.85 2.81V108a12 12 0 0012 12z"></path>
                        <path d="M372 152a44.34 44.34 0 01-44-44V16H220a60.07 60.07 0 00-60 60v36h42.12A40.81 40.81 0 01231 124.14l109.16 111a41.11 41.11 0 0111.83 29V400h53.05c32.51 0 58.95-26.92 58.95-60V152z"></path>
                    </svg>
                </span>
            </div>
        </div>
        <div class="h-50 ml-4 flex w-auto flex-col justify-center">
            <p class="font-dm text-sm font-medium text-gray-600">จำนวนครู</p>
            <h4 class="text-xl font-bold text-navy-700 dark:text-white"><?php echo $teachers_count; ?></h4>
        </div>
    </div>
    <!-- <div class="relative flex flex-grow !flex-row flex-col items-center rounded-[10px] rounded-[10px] border-[1px] border-gray-200 bg-white bg-clip-border shadow-md shadow-[#F3F3F3] dark:border-[#ffffff33] dark:!bg-navy-800 dark:text-white dark:shadow-none">
        <div class="ml-[18px] flex h-[90px] w-auto flex-row items-center">
            <div class="rounded-full bg-lightPrimary p-3 dark:bg-navy-700">
                <span class="flex items-center text-brand-500 dark:text-white">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="h-7 w-7" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path fill="none" d="M0 0h24v24H0z"></path>
                        <path d="M4 9h4v11H4zM16 13h4v7h-4zM10 4h4v16h-4z"></path>
                    </svg>
                </span>
            </div>
        </div>
        <div class="h-50 ml-4 flex w-auto flex-col justify-center">
            <p class="font-dm text-sm font-medium text-gray-600">จำนวนนักศึกษาที่สมัครเข้ามาใหม่</p>
            <h4 class="text-xl font-bold text-navy-700 dark:text-white">0000000</h4>
        </div>
    </div> -->
    <div class="relative flex flex-grow !flex-row flex-col items-center rounded-[10px] border-[1px] border-gray-200 bg-white shadow-md">
        <div class="ml-[18px] flex h-[90px] items-center">
            <div class="rounded-full bg-lightPrimary p-3">
                <span class="flex items-center text-brand-500">
                    <!-- Icon for courses -->
                    <svg stroke="currentColor" fill="currentColor" viewBox="0 0 24 24" class="h-7 w-7" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 3v6H3v9h2v-6h2v6h2v-9H5zM21 3h-6v6h-2V3H9v6H7V3H3v18h4v-6h4v6h4v-6h4v6h4V3z"></path>
                    </svg>
                </span>
            </div>
        </div>
        <div class="h-50 ml-4 flex flex-col justify-center">
            <p class="font-dm text-sm font-medium text-gray-600">รายวิชาทั้งหมด</p>
            <h4 class="text-xl font-bold text-navy-700"><?php echo $classes_courses; ?></h4>
        </div>
    </div>
    <div class="relative flex flex-grow !flex-row flex-col items-center rounded-[10px] border-[1px] border-gray-200 bg-white shadow-md">
        <div class="ml-[18px] flex h-[90px] items-center">
            <div class="rounded-full bg-lightPrimary p-3">
                <span class="flex items-center text-brand-500">
                    <!-- Icon for courses -->
                    <svg stroke="currentColor" fill="currentColor" viewBox="0 0 24 24" class="h-7 w-7" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 3v6H3v9h2v-6h2v6h2v-9H5zM21 3h-6v6h-2V3H9v6H7V3H3v18h4v-6h4v6h4v-6h4v6h4V3z"></path>
                    </svg>
                </span>
            </div>
        </div>
        <div class="h-50 ml-4 flex flex-col justify-center">
            <p class="font-dm text-sm font-medium text-gray-600">การเข้าเรียน</p>
            <h4 class="text-xl font-bold text-navy-700"><?php echo $classes_courses; ?></h4>
        </div>
    </div>
    <div class="relative flex flex-grow !flex-row flex-col items-center rounded-[10px] border-[1px] border-gray-200 bg-white shadow-md">
        <div class="ml-[18px] flex h-[90px] items-center">
            <div class="rounded-full bg-lightPrimary p-3">
                <span class="flex items-center text-brand-500">
                    <!-- Icon for courses -->
                    <svg stroke="currentColor" fill="currentColor" viewBox="0 0 24 24" class="h-7 w-7" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 3v6H3v9h2v-6h2v6h2v-9H5zM21 3h-6v6h-2V3H9v6H7V3H3v18h4v-6h4v6h4v-6h4v6h4V3z"></path>
                    </svg>
                </span>
            </div>
        </div>
        <div class="h-50 ml-4 flex flex-col justify-center">
            <p class="font-dm text-sm font-medium text-gray-600">จำนวนการเข้าชั้นเรียน</p>
            <h4 class="text-xl font-bold text-navy-700"><?php echo $classes_courses; ?></h4>
            <!-- <p class="font-dm text-sm font-medium text-gray-600">--ดูรายละเอียด--</p> -->
        </div>
    </div>

</div>

<div class="">
    <?php require_once "dashboard/calendar.php" ?>
    <?php require_once "dashboard/News.php" ?>
</div>