<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เว็บไซต์การเรียนออนไลน์</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <link rel="stylesheet" href="https://horizon-tailwind-react-corporate-7s21b54hb-horizon-ui.vercel.app/static/css/main.d7f96858.css" />

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
    </style>
</head>

<?php
require_once "../includes/db_connect.php";
include '../includes/modal/modal.php';
?>

<body class="bg-white">
    <!-- <header class="bg-[#6e4db0] text-white p-3 sticky top-0"> -->
    <header class="bg-[#6e4db0] text-white p-3  top-0">
        <nav class="flex items-center">
            <img src="../assets/images/LOGO@3x.png" class="w-[50px] h-[50px] ml-10" alt="Logo">
            <ul class="flex space-x-6 ml-6">
                <li><a href="system.php" class="hover:underline">ระบบจัดการข้อมูล สกร.</a></li>
                <li><a href="education.php" class="hover:underline">การจัดการรายวิชา</a></li>
                <li><a href="admin.php" class="hover:underline">ผู้ดูแลระบบ</a></li>
                <li><a href="teacher.php" class="hover:underline">ครู</a></li>
                <li><a href="student.php" class="hover:underline">นักเรียน</a></li>
                <?php include "fontslide.php" ?>
            </ul>
        </nav>

    </header>



    <div class="flex bg-white">
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
            default:

                echo '<p>Default sidebar or no sidebar available.</p>';
                break;
        }
        ?>