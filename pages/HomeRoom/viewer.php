<?php
session_start();

// ตรวจสอบว่ามีการล็อกอินหรือไม่
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('กรุณาล็อกอินก่อนดำเนินการ'); window.location.href='?page=Home_Room';</script>";
    exit;
}

// ตรวจสอบว่าได้รับ roomKey จาก URL หรือไม่
if (!isset($_GET['roomKey'])) {
    echo "<script>alert('ไม่พบรหัสห้อง'); window.location.href='?page=Home_Room';</script>";
    exit;
}

$roomKey = trim($_GET['roomKey']);

include "../../includes/db_connect.php";

// ดึงข้อมูลห้องประชุม
$sql = "SELECT room_name FROM homeroom_meetings WHERE room_key = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $roomKey, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

// ตรวจสอบข้อมูลห้องประชุม
if ($result->num_rows === 0) {
    echo "<script>alert('ไม่พบข้อมูลห้องประชุม'); window.location.href='?page=Home_Room';</script>";
    exit;
}

$room = $result->fetch_assoc();
$roomName = htmlspecialchars($room['room_name']);
$conn->close();
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
            max-width: 600px;
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
        <div class="mt-4">
            <p class="mb-2">แชร์ลิ้งค์ห้องประชุม:</p>
            <input id="roomLink" type="text" readonly class="px-4 py-2 border border-gray-300 rounded" value="viewer.php?roomKey=<?php echo urlencode($roomKey); ?>">
            <button id="copyLink" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded">คัดลอกลิ้งค์</button>
        </div>
    </div>

    <script>
        const videoContainer = document.getElementById('videoContainer');
        const roomLinkInput = document.getElementById('roomLink');
        const copyLinkButton = document.getElementById('copyLink');

        // Configuration for WebRTC
        const servers = {
            iceServers: [{ urls: 'stun:stun.l.google.com:19302' }]
        };

        const roomKey = "<?php echo $roomKey; ?>";
        let peerConnection = null;

        function connectToSignalingServer() {
            // Replace with actual signaling server URL
            const signalingServerUrl = 'wss://your-signaling-server.com';
            const signalingSocket = new WebSocket(signalingServerUrl);

            signalingSocket.onopen = () => {
                console.log('Connected to signaling server');
                
                peerConnection = new RTCPeerConnection(servers);

                peerConnection.onicecandidate = event => {
                    if (event.candidate) {
                        signalingSocket.send(JSON.stringify({ 'candidate': event.candidate, 'roomKey': roomKey }));
                    }
                };

                peerConnection.ontrack = event => {
                    const remoteVideo = document.createElement('video');
                    remoteVideo.srcObject = event.streams[0];
                    remoteVideo.autoplay = true;
                    remoteVideo.playsInline = true; // Improved compatibility on mobile
                    videoContainer.appendChild(remoteVideo);
                };

                signalingSocket.onmessage = message => {
                    const data = JSON.parse(message.data);

                    if (data.offer) {
                        peerConnection.setRemoteDescription(new RTCSessionDescription(data.offer))
                            .then(() => peerConnection.createAnswer())
                            .then(answer => peerConnection.setLocalDescription(answer))
                            .then(() => {
                                signalingSocket.send(JSON.stringify({ 'answer': peerConnection.localDescription, 'roomKey': roomKey }));
                            });
                    } else if (data.answer) {
                        peerConnection.setRemoteDescription(new RTCSessionDescription(data.answer));
                    } else if (data.candidate) {
                        peerConnection.addIceCandidate(new RTCIceCandidate(data.candidate));
                    }
                };

                signalingSocket.onclose = () => {
                    console.log('Disconnected from signaling server');
                };

                // Join the room
                signalingSocket.send(JSON.stringify({ 'join': roomKey }));
            };

            signalingSocket.onerror = (error) => {
                console.error('Signaling server error:', error);
            };
        }

        // Copy link to clipboard
        copyLinkButton.addEventListener('click', () => {
            roomLinkInput.select();
            document.execCommand('copy');
            alert('ลิ้งค์ถูกคัดลอกไปยังคลิปบอร์ดแล้ว');
        });

        // Connect to the signaling server when the page loads
        window.onload = connectToSignalingServer;
    </script>
</body>
</html>
