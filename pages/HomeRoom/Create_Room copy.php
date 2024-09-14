<?php
// Create_Room.php

// Include database configuration (if needed)
// include 'db_config.php';

// Handle form submission or other backend logic here
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สร้างห้องออนไลน์</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.0.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet"> <!-- Include custom styles -->
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Main Content -->
    <main class="container mx-auto p-6">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold">สร้างห้องออนไลน์</h1>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold mb-4">วีดีโอ</h2>
            <div id="video-container">
                <video id="local-video" autoplay muted></video>
                <video id="remote-video" autoplay></video>
            </div>
            <div class="mt-4 text-center">
                <button id="start-call" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">เริ่มการโทร</button>
                <button id="end-call" class="bg-red-600 text-white px-6 py-3 rounded hover:bg-red-700">สิ้นสุดการโทร</button>
                <button id="toggle-microphone" class="bg-gray-600 text-white px-6 py-3 rounded hover:bg-gray-700">เปิด/ปิด ไมค์</button>
                <button id="toggle-camera" class="bg-gray-600 text-white px-6 py-3 rounded hover:bg-gray-700">เปิด/ปิด กล้อง</button>
                <button id="toggle-live" class="bg-gray-600 text-white px-6 py-3 rounded hover:bg-gray-700">เปิด/ปิด การถ่ายทอดสด</button>
                <button id="increase-volume" class="bg-gray-600 text-white px-6 py-3 rounded hover:bg-gray-700">เพิ่มเสียง</button>
                <button id="decrease-volume" class="bg-gray-600 text-white px-6 py-3 rounded hover:bg-gray-700">ลดเสียง</button>
            </div>
        </div>

        <!-- Chat Box -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold mb-4">แชท</h2>
            <div id="chat-box" class="border border-gray-300 p-4 rounded-lg h-60 overflow-y-auto">
                <!-- Messages will appear here -->
            </div>
            <input id="chat-input" type="text" class="w-full mt-4 p-2 border border-gray-300 rounded" placeholder="พิมพ์ข้อความของคุณที่นี่...">
            <button id="send-message" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 mt-2">ส่ง</button>
        </div>
    </main>

    <!-- Include custom JavaScript -->
    <script src="scripts.js"></script> <!-- Include custom JavaScript -->
    <?php include "script.php"; ?> <!-- Include PHP script if needed -->
</body>
</html>
