<?php
// ตรวจสอบว่ามีการล็อกอินหรือไม่
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('กรุณาล็อกอินก่อนดำเนินการ'); window.location.href='?page=Home_Room';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];

// ตรวจสอบว่าได้รับ roomKey จาก URL หรือไม่
if (!isset($_GET['roomKey'])) {
    echo "<script>alert('ไม่พบรหัสห้อง'); window.location.href='?page=Home_Room';</script>";
    exit;
}

$roomKey = $_GET['roomKey'];

// ดึงข้อมูลห้องประชุม
$sql = "SELECT room_name FROM homeroom_meetings WHERE room_key = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $roomKey, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$room = $result->fetch_assoc();

if (!$room) {
    echo "<script>alert('ไม่พบข้อมูลห้องประชุม'); window.location.href='?page=Home_Room';</script>";
    exit;
}

$roomName = htmlspecialchars($room['room_name']);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viewer: <?php echo $roomName; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^3.0/dist/tailwind.min.css" rel="stylesheet">
    <style>
        #videoContainer {
            display: flex;
            flex-wrap: wrap;
        }

        video {
            width: 100%;
            max-width: 300px;
            margin: 10px;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">ผู้ชม: <?php echo $roomName; ?></h1>
        <div id="videoContainer" class="flex flex-wrap">
            <!-- Video elements will be appended here by JavaScript -->
        </div>
    </div>

    <script>
        const videoContainer = document.getElementById('videoContainer');
        const roomKey = "<?php echo $roomKey; ?>";

        function connectToSignalingServer() {
            // Use WebSocket or another signaling method here
            // For this example, this function should be implemented to handle signaling
        }

        function displayRemoteStream(stream) {
            const remoteVideo = document.createElement('video');
            remoteVideo.srcObject = stream;
            remoteVideo.autoplay = true;
            videoContainer.appendChild(remoteVideo);
        }

        // Connect to signaling server and start receiving streams
        connectToSignalingServer();
    </script>
</body>

</html>