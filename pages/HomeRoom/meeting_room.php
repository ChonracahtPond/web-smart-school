<?php
session_start();
include 'db_connection.php'; // รวมไฟล์การเชื่อมต่อฐานข้อมูล

// ตรวจสอบว่ามีการล็อกอินหรือไม่
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('กรุณาล็อกอินก่อนดำเนินการ'); window.location.href='?page=Home_Room';</script>";
    exit;
}

// ดึงค่า user_id จากเซสชัน
$user_id = $_SESSION['user_id'];

// ตรวจสอบว่าได้รับ room_key จาก URL หรือไม่
if (!isset($_GET['room_key'])) {
    echo "<script>alert('ไม่พบรหัสห้อง'); window.location.href='?page=Home_Room';</script>";
    exit;
}

$room_key = $_GET['room_key'];

// ดึงข้อมูลห้องประชุม
$sql = "SELECT room_name FROM homeroom_meetings WHERE room_key = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $room_key, $user_id);
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
    <title>Meeting Room: <?php echo $roomName; ?></title>
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
        <h1 class="text-2xl font-bold mb-4">ห้องประชุม: <?php echo $roomName; ?></h1>
        <div id="videoContainer" class="flex flex-wrap">
            <!-- Video elements will be appended here by JavaScript -->
        </div>
        <button id="startCall" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">เริ่มการประชุม</button>
    </div>

    <script>
        const startCallButton = document.getElementById('startCall');
        const videoContainer = document.getElementById('videoContainer');

        // Configuration for WebRTC
        const servers = {
            iceServers: [{ urls: 'stun:stun.l.google.com:19302' }]
        };

        const peerConnections = {};
        const localStream = null;
        const room_key = "<?php echo $room_key; ?>";

        function startCall() {
            navigator.mediaDevices.getUserMedia({ video: true, audio: true })
                .then(stream => {
                    localStream = stream;
                    // Create and display local video
                    const localVideo = document.createElement('video');
                    localVideo.srcObject = localStream;
                    localVideo.autoplay = true;
                    videoContainer.appendChild(localVideo);

                    // Connect to signaling server and other peers
                    connectToSignalingServer();
                })
                .catch(error => {
                    console.error('Error accessing media devices.', error);
                });
        }

        function connectToSignalingServer() {
            // Use WebSocket or another signaling method here
            // For this example, this function should be implemented to handle signaling
        }

        startCallButton.addEventListener('click', startCall);
    </script>
</body>
</html>
