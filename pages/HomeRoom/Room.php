<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Google Fonts -->
<link
    href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap"
    rel="stylesheet" />

<!-- Custom Styles -->
<style>
    body {
        font-family: "Roboto", sans-serif;
        background-color: #f7fafc;
    }

    .video-container {
        display: grid;
        gap: 1rem;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        justify-content: center;
    }
</style>

<div class="container mx-auto p-4 bg-white shadow-md rounded-lg">
    <div class="mb-6">
        <label for="room_key" class="block text-gray-700 mb-2">คีย์ห้อง:</label>
        <input
            id="room_key"
            type="text"
            class="w-full px-4 py-2 border border-gray-300 rounded"
            placeholder="ป้อนคีย์ห้อง"
            readonly />
    </div>

    <div class="mb-6">
        <label for="inviteLink" class="block text-gray-700 mb-2">ลิงค์เชิญ:</label>
        <input
            id="inviteLink"
            type="text"
            class="w-full px-4 py-2 border border-gray-300 rounded"
            placeholder="ไม่พบลิงค์"
            readonly />
        <button
            id="copyLinkButton"
            class="mt-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            คัดลอกลิงค์เชิญ
        </button>
    </div>

    <div id="joinButton">เข้าร่วมแล้ว....</div>
    <div class="flex flex-wrap justify-center mb-6 space-x-2">
        <button
            id="startButton"
            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
            เริ่มต้น
        </button>
        <button
            id="hangupButton"
            class="ml-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
            วางสาย
        </button>
    </div>

    <!-- Additional buttons for screen sharing, camera, mic, and mute -->
    <div class="flex flex-wrap justify-center mb-6 space-x-2">
        <button
            id="screenShareButton"
            class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50">
            แชร์หน้าจอ
        </button>
        <button
            id="stopScreenShareButton"
            class="bg-yellow-700 text-white px-4 py-2 rounded hover:bg-yellow-800 focus:outline-none focus:ring-2 focus:ring-yellow-700 focus:ring-opacity-50">
            หยุดแชร์หน้าจอ
        </button>
        <button
            id="cameraToggleButton"
            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
            เปิดกล้อง
        </button>
    </div>

    <p id="statusMessage" class="text-center text-gray-600 mb-4"></p>

    <div class="video-container" id="videoContainer">
        <video
            id="localVideo"
            class="w-full h-auto rounded-lg border border-gray-300"
            playsinline
            autoplay
            muted></video>
        <video
            id="sharedScreenVideo"
            class="w-full h-auto rounded-lg border border-gray-300 hidden"
            playsinline
            autoplay></video>
    </div>

    <p class="text-center text-gray-600 mb-4">
        คลิกปุ่มเข้าร่วมเพื่อเข้าร่วมการประชุมหรือปุ่มเริ่มต้นเพื่อเริ่มการประชุม
    </p>
</div>

<!-- Scripts -->
<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
<script type="module" src="HomeRoom/js/room/main.js" async></script>
<script src="HomeRoom/js/room/sharing_screen.js" async></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const room_keyInput = document.getElementById("room_key");
        const inviteLinkInput = document.getElementById("inviteLink");
        const joinButton = document.getElementById("joinButton");
        const startButton = document.getElementById("startButton");
        const statusMessage = document.getElementById("statusMessage");
        const copyLinkButton = document.getElementById("copyLinkButton");

        // The base URL for the invite link
        const baseURL = "http://localhost/school/web-smart-school/pages/teacher.php?page=Room";

        // Check if there's a room_key in the URL
        const urlParams = new URLSearchParams(window.location.search);
        const room_key = urlParams.get("room_key");

        if (room_key) {
            room_keyInput.value = room_key; // Set the room key input
            const inviteLink = `${baseURL}&room_key=${encodeURIComponent(room_key)}`;
            inviteLinkInput.value = inviteLink; // Set the invite link
        } else {
            statusMessage.textContent = "ไม่พบคีย์ห้องใน URL";
        }

        // Handle copy invite link button click
        copyLinkButton.addEventListener("click", () => {
            inviteLinkInput.select();
            inviteLinkInput.setSelectionRange(0, 99999); // For mobile devices
            document.execCommand("copy");
            statusMessage.textContent = "ลิงค์เชิญถูกคัดลอกแล้ว!";
        });

        // Check stored state
        const isStartButtonClicked = localStorage.getItem("startButtonClicked") === "true";

        // Reset stored state (Uncomment the line below to reset start button state)
        // localStorage.removeItem("startButtonClicked");

        if (isStartButtonClicked) {
            // Comment out these lines to ensure the start button is not disabled on page load
            startButton.disabled = true;
            startButton.classList.add("opacity-50");
            statusMessage.textContent = "เริ่มต้นการประชุม";
        } else {
            // Ensure start button is enabled if not clicked before
            startButton.disabled = false;
            startButton.classList.remove("opacity-50");
        }

        // Handle join button click
        joinButton.addEventListener("click", () => {
            statusMessage.textContent = "เข้าร่วมการสนทนาแล้ว";
        });

        // Handle start button click
        startButton.addEventListener("click", () => {
            if (!startButton.disabled) {
                statusMessage.textContent = "เริ่มต้นการประชุม";
                startButton.disabled = true;
                startButton.classList.add("opacity-50");
                localStorage.setItem("startButtonClicked", "true");
                // Add additional logic for starting the meeting here
            }
        });
    });
</script>