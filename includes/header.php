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

        .group:hover .group-hover\:block {
            display: block !important;
        }
    </style>
</head>

<?php
require_once "../includes/db_connect.php";
include '../includes/modal/modal.php';
?>

<body class="bg-white">
    <header class="bg-[#6e4db0] text-white p-2  flex items-center justify-between">
        <div class="flex items-center">
            <img src="../assets/images/LOGO@3x.png" class="w-[50px] h-[50px] ml-10" alt="Logo">
            <ul class="flex space-x-6 ml-6">
                <li><a href="system.php" class="hover:underline">ระบบจัดการข้อมูล สกร.</a></li>
                <li><a href="education.php" class="hover:underline">ระบบจัดการรายวิชา</a></li>
                <li><a href="teacher.php" class="hover:underline">ระบบจัดการข้อมูลครู</a></li>
                <li><a href="student.php" class="hover:underline">ระบบจัดการข้อมูลผู้เรียน</a></li>
            </ul>
        </div>
        <div class="flex items-center mr-5">
            <?php include "fontslide.php" ?>
            <a href="setting.php" class="hover:underline flex items-center ml-4">
                <svg class="h-6 w-6 text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
                <p class="hover:underline">ตั้งค่าระบบ</p>
                <!-- ---------------- -->


                <script>
                    // JavaScript to toggle the dropdown
                    const dropdownButton = document.getElementById('dropdown-button');
                    const dropdownMenu = document.getElementById('dropdown-menu');
                    const searchInput = document.getElementById('search-input');
                    let isOpen = false; // Set to true to open the dropdown by default

                    // Function to toggle the dropdown state
                    function toggleDropdown() {
                        isOpen = !isOpen;
                        dropdownMenu.classList.toggle('hidden', !isOpen);
                    }

                    // Set initial state
                    toggleDropdown();

                    dropdownButton.addEventListener('click', () => {
                        toggleDropdown();
                    });

                    // Add event listener to filter items based on input
                    searchInput.addEventListener('input', () => {
                        const searchTerm = searchInput.value.toLowerCase();
                        const items = dropdownMenu.querySelectorAll('a');

                        items.forEach((item) => {
                            const text = item.textContent.toLowerCase();
                            if (text.includes(searchTerm)) {
                                item.style.display = 'block';
                            } else {
                                item.style.display = 'none';
                            }
                        });
                    });
                </script>
            </a>
            <a href="../logout.php" class="hover:underline flex items-center ml-4">
                <svg class="h-6 w-6 text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <path d="M13 16l4-4-4-4M17 12H7m7-7H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2z" />
                </svg>
                <p class="hover:underline">ออกจากระบบ</p>
            </a>
        </div>
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
            case 'setting.php':
                include 'settingbar.php';
                break;
            default:
                echo '<p>Default sidebar or no sidebar available.</p>';
                break;
        }
        ?>