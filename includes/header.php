<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เว็บไซต์การเรียนออนไลน์</title>
    <!-- <link rel="stylesheet" href="../assets/css/styles.css"> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.7/dist/tailwind.min.css" rel="stylesheet"> -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <link rel="stylesheet" href="https://horizon-tailwind-react-corporate-7s21b54hb-horizon-ui.vercel.app/static/css/main.d7f96858.css" />


</head>
<!-- // รวมไฟล์การเชื่อมต่อฐานข้อมูล -->

<?php include '../includes/db_connect.php'; ?>

<body>
    <header class="bg-gray-800 text-white p-4">
        <nav>
            <ul class="flex space-x-4">
                <li><a href="admin.php" class="hover:underline">หน้าแรก</a></li>
                <li><a href="admin.php" class="hover:underline">ผู้ดูแลระบบ</a></li>
                <li><a href="teacher.php" class="hover:underline">ครู</a></li>
                <li><a href="pages/student.php" class="hover:underline">นักเรียน</a></li>
            </ul>
        </nav>
    </header>

    <div class="flex">
        <?php include 'sidebar.php'; ?>