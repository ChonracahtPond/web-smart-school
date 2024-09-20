<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit(); // Ensure no further code is executed
}

// Set status to 'success' if the user is logged in
$status = 'success';
echo "<script>localStorage.setItem('status', 'success');</script>";

// Include the modal file
require 'modal/modallogin.php';

// Set the background color from session or use a default color
$tool_color = isset($_SESSION['tool_color']) ? $_SESSION['tool_color'] : '#6e4db0'; // Default header color
$screen_color = isset($_SESSION['screen_color']) ? $_SESSION['screen_color'] : '#ffffff'; // Default header color
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เว็บไซต์การเรียนออนไลน์</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <link rel="stylesheet" href="https://horizon-tailwind-react-corporate-7s21b54hb-horizon-ui.vercel.app/static/css/main.d7f96858.css" />

    <!-- </// table ///> -->
    <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/table.css">

    <style>
        .marquee-container {
            overflow: hidden;
            white-space: nowrap;
            box-sizing: border-box;
        }

        .marquee {
            display: inline-block;
            padding-left: 100%;
            /* เริ่มต้นจากนอกหน้าจอทางขวา */
            animation: marquee 15s linear infinite;
        }

        @keyframes marquee {
            from {
                transform: translateX(100%);
                /* เริ่มต้นจากนอกหน้าจอทางขวา */
            }

            to {
                transform: translateX(-100%);
                /* เคลื่อนที่ไปที่นอกหน้าจอทางซ้าย */
            }
        }

        .group:hover .group-hover\:block {
            display: block !important;
        }
    </style>
</head>

<?php
require_once "../includes/db_connect.php";
include '../includes/modal/modal.php';

// include "modal/modallogin.php";
?>

<body class="">
    <!-- <script src="../scripts/highlight-nav.js"></script> -->
    <!-- <header class="bg-[#6e4db0] text-white p-4 flex items-center justify-between shadow-md h-[70px]"> -->
    <header class="text-white p-4 flex items-center justify-between shadow-md h-[70px]" style="background-color: <?php echo htmlspecialchars($tool_color); ?>;">
        <!-- Logo and Menu Items -->
        <div class="flex items-center flex-wrap">
            <img src="../assets/images/LOGO@3x.png" class="w-12 h-12 ml-10" alt="Logo">
            <ul class="flex flex-wrap space-x-4 ml-6 text-lg font-medium">
                <li>
                    <a href="system.php" id="system-head" class="flex items-center justify-center hover:underline hover:bg-gray-100 hover:text-gray-800 transition duration-200 py-2 px-4 rounded-lg">
                        ระบบจัดการข้อมูล สกร.
                    </a>
                </li>
                <li>
                    <a href="education.php" class="flex items-center justify-center hover:underline hover:bg-gray-100 hover:text-gray-800 transition duration-200 py-2 px-4 rounded-lg">
                        ระบบจัดการรายวิชา
                    </a>
                </li>
                <li>
                    <a href="student.php" class="flex items-center justify-center hover:underline hover:bg-gray-100 hover:text-gray-800 transition duration-200 py-2 px-4 rounded-lg">
                        ระบบจัดการข้อมูลนักศึกษา
                    </a>
                </li>
                <li>
                    <a href="teacher.php" class="flex items-center justify-center hover:underline hover:bg-gray-100 hover:text-gray-800 transition duration-200 py-2 px-4 rounded-lg">
                        ระบบของครู
                    </a>
                </li>
            </ul>
        </div>


        <?php
        include "fontslide.php";
        // include "sql/sql_register.php";
        ?>





        <!-- Settings and Logout -->
        <div class="flex items-center mr-5 space-x-6">
            <?php include "notify.php"; ?>

            <!-- Settings Button -->
            <a href="setting.php" class="flex items-center hover:text-gray-300 transition duration-200">
                <svg class="h-6 w-6 mr-2" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
                <span class="hover:underline">ตั้งค่าระบบ</span>
            </a>

            <!-- Logout Button -->
            <a href="../logout.php" class="flex items-center hover:text-gray-300 transition duration-200">
                <svg class="h-6 w-6 mr-2" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M13 16l4-4-4-4M17 12H7m7-7H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2z" />
                </svg>
                <span class="hover:underline">ออกจากระบบ</span>
            </a>
        </div>
    </header>




    <div class="flex " style="background-color: <?php echo htmlspecialchars($screen_color); ?>;">
        <?php
        $current_page = basename($_SERVER['SCRIPT_NAME']);

        switch ($current_page) {
            case 'system.php':
                include 'sidebar.php';
                break;
            case 'education.php':
                include 'educationsidebar.php';
                break;
            case 'admin.php':
                include 'adminsidebar.php';
                break;
            case 'student.php':
                include 'studentsidebar.php';
                break;
            case 'teacher.php':
                include 'teachersidebar.php';
                break;
            case 'setting.php':
                include 'settingbar.php';
                break;
            default:
                echo '<p>Default sidebar or no sidebar available.</p>';
                break;
        }
        ?>