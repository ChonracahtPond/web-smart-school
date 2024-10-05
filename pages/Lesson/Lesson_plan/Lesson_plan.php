<?php
// Lesson_plan.php

// ฟังก์ชันสำหรับเรียกใช้ AI
function callAI($question) {
    // ตั้งค่า API ของ AI ที่จะเรียกใช้
    $apiUrl = "YOUR_AI_API_URL";
    $apiKey = "YOUR_API_KEY"; // เพิ่ม API Key ถ้าจำเป็น

    // สร้างข้อมูลสำหรับการส่ง
    $data = [
        "question" => $question,
    ];

    // เรียกใช้ API
    $options = [
        'http' => [
            'header' => "Content-Type: application/json\r\n" .
                        "Authorization: Bearer $apiKey\r\n",
            'method' => 'POST',
            'content' => json_encode($data),
        ],
    ];
    
    $context = stream_context_create($options);
    $result = file_get_contents($apiUrl, false, $context);
    
    if ($result === FALSE) {
        return "Error calling AI.";
    }

    // แปลงผลลัพธ์เป็น JSON
    $response = json_decode($result, true);
    
    return $response['answer'] ?? "No answer found.";
}

// ตรวจสอบว่ามีการส่งคำถามมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['question'])) {
    $question = $_POST['question'];
    $answer = callAI($question);
}

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>วางแผนการสอน</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-5">
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-xl font-bold mb-4">ถาม AI เกี่ยวกับการวางแผนการสอนในรายวิชาต่าง ๆ</h1>
        <form method="POST" action="">
            <textarea name="question" rows="4" class="w-full p-2 border border-gray-300 rounded mb-4" placeholder="กรุณาพิมพ์คำถามของคุณที่นี่..."></textarea>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">ส่งคำถาม</button>
        </form>
        <?php if (isset($answer)): ?>
            <div class="mt-4 p-4 bg-gray-200 rounded">
                <h2 class="font-bold">คำตอบ:</h2>
                <p><?php echo $answer; ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
