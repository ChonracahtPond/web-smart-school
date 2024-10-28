<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มแบบฝึกหัด</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 p-6">
    <button onclick="closeModal()" class="float-right text-gray-500 hover:text-gray-700">×</button>


    <!-- Modal -->
    <!-- <div id="meetingModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden items-center mx-auto justify-center"> -->
    <div class="bg-white max-w-md w-full">
        <h2 class="text-2xl font-semibold text-purple-700 mb-6 text-center">เพิ่มข้อมูลการเรียนออนไลน์</h2>
        <form action="add_meeting.php" method="POST">
            <input type="hidden" name="lesson_id" value="<?php echo htmlspecialchars($lesson_id); ?>">
            <div class="mb-5">
                <label class="block mb-2 text-gray-700">ลิงก์การประชุม:</label>
                <input type="text" name="meeting_link" required class="border border-gray-300 rounded w-full p-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-300" placeholder="กรุณากรอกลิงก์การประชุม">
            </div>
            <div class="mb-5">
                <label class="block mb-2 text-gray-700">วันที่:</label>
                <input type="date" name="meeting_date" required class="border border-gray-300 rounded w-full p-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-300">
            </div>
            <div class="mb-5">
                <label class="block mb-2 text-gray-700">เวลา:</label>
                <input type="time" name="meeting_time" required class="border border-gray-300 rounded w-full p-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-300">
            </div>
            <div class="mb-5">
                <label class="block mb-2 text-gray-700">สถานะ:</label>
                <select name="status" class="border border-gray-300 rounded w-full p-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-300">
                    <option value="active">ใช้งาน</option>
                    <option value="inactive">ไม่ใช้งาน</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="button" id="closeModal" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg mr-2 hover:bg-gray-400 transition duration-300">ยกเลิก</button>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-300">บันทึก</button>
            </div>
        </form>
    </div>
    <!-- </div> -->

</body>

</html>