<!-- http://localhost/school/web-smart-school/pages/HomeRoom/viewer.php?roomKey=f1b4fc6c91495e39f1c49e6019d0bb06 -->

<?php

// ตรวจสอบว่ามีการล็อกอินหรือไม่
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('กรุณาล็อกอินก่อนดำเนินการ'); window.location.href='?page=Home_Room';</script>";
    exit;
}

// ดึงค่า user_id จากเซสชัน
$user_id = $_SESSION['user_id'];

// ตรวจสอบว่าได้รับ roomKey จาก URL หรือไม่
if (!isset($_GET['room_key'])) {
    echo "<script>alert('ไม่พบรหัสห้อง'); window.location.href='?page=Home_Room';</script>";
    exit;
}

$roomKey = trim($_GET['room_key']);

// ดึงข้อมูลห้องประชุม
$sql = "SELECT room_name FROM homeroom_meetings WHERE room_key = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $roomKey, $user_id);
$stmt->execute();
$result = $stmt->get_result();

// ตรวจสอบข้อมูลห้องประชุม
if ($result->num_rows === 0) {
    echo "<script>alert('ไม่พบข้อมูลห้องประชุม'); window.location.href='?page=Home_Room';</script>";
    exit;
}

$room = $result->fetch_assoc();
$roomName = htmlspecialchars($room['room_name']);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ห้องประชุม: <?php echo $roomName; ?></title>
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

        #screenShareContainer {
            margin-top: 20px;
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
        <button id="shareScreen" class="mt-4 px-4 py-2 bg-green-500 text-white rounded">แชร์หน้าจอ</button>
        <div id="screenShareContainer">
            <!-- Screen sharing video will be appended here by JavaScript -->
        </div>
        <div class="mt-4">
            <p class="mb-2">แชร์ลิ้งค์ห้องประชุม:</p>
            <input id="roomLink" type="text" readonly class="px-4 py-2 border border-gray-300 rounded" value="http://localhost/school/web-smart-school/pages/HomeRoom/viewer.php?roomKey=<?php echo urlencode($roomKey); ?>">
            <button id="copyLink" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded">คัดลอกลิ้งค์</button>
        </div>
    </div>

    <script>
        const startCallButton = document.getElementById('startCall');
        const shareScreenButton = document.getElementById('shareScreen');
        const videoContainer = document.getElementById('videoContainer');
        const screenShareContainer = document.getElementById('screenShareContainer');
        const roomLinkInput = document.getElementById('roomLink');
        const copyLinkButton = document.getElementById('copyLink');

        // Configuration for WebRTC
        const servers = {
            iceServers: [{ urls: 'stun:stun.l.google.com:19302' }]
        };

        let localStream = null;
        let screenStream = null;
        const roomKey = "<?php echo $roomKey; ?>";

        function startCall() {
            navigator.mediaDevices.getUserMedia({ video: true, audio: true })
                .then(stream => {
                    localStream = stream;
                    const localVideo = document.createElement('video');
                    localVideo.srcObject = localStream;
                    localVideo.autoplay = true;
                    localVideo.muted = true; // Mute local video to prevent feedback
                    videoContainer.appendChild(localVideo);

                    connectToSignalingServer();
                })
                .catch(error => {
                    console.error('Error accessing media devices.', error);
                });
        }

        function shareScreen() {
            navigator.mediaDevices.getDisplayMedia({ video: true })
                .then(stream => {
                    screenStream = stream;
                    const screenVideo = document.createElement('video');
                    screenVideo.srcObject = screenStream;
                    screenVideo.autoplay = true;
                    screenShareContainer.appendChild(screenVideo);

                    // Broadcast screen share to other peers
                    broadcastScreenShare();
                })
                .catch(error => {
                    console.error('Error accessing screen.', error);
                });
        }

        function connectToSignalingServer() {
            // Use WebSocket or another signaling method here
            // For this example, this function should be implemented to handle signaling
        }

        function broadcastScreenShare() {
            // Implement broadcasting of screen share to other peers
            // This will involve sending the stream to the signaling server
        }

        // Copy link to clipboard
        copyLinkButton.addEventListener('click', () => {
            roomLinkInput.select();
            document.execCommand('copy');
            alert('ลิ้งค์ถูกคัดลอกไปยังคลิปบอร์ดแล้ว');
        });

        startCallButton.addEventListener('click', startCall);
        shareScreenButton.addEventListener('click', shareScreen);
    </script>
</body>
</html>




















