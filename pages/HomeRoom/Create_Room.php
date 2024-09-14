<script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/live.css"> <!-- ลิงก์ไปยังไฟล์ CSS -->

<!-- แถบเครื่องมือ -->
<header class="bg-gray-900 text-white p-4 shadow-md">
    <div class="container mx-auto flex justify-center space-x-4">
        <button id="startLiveButton" class="toolbar-button bg-teal-500 text-white px-6 py-3 rounded flex items-center space-x-2 hover:bg-teal-700">
            <i class="fas fa-video"></i>
            <span>เริ่มถ่ายทอดสด</span>
        </button>
        <button id="stopShareButton" class="toolbar-button bg-red-500 text-white px-6 py-3 rounded flex items-center space-x-2 hover:bg-red-700 transition hidden">
            <i class="fas fa-stop"></i>
            <span>หยุดการแชร์</span>
        </button>
        <button id="shareButton" class="toolbar-button bg-blue-500 text-white px-6 py-3 rounded flex items-center space-x-2 hover:bg-blue-700">
            <i class="fas fa-share-alt"></i>
            <span>แชร์หน้าจอ</span>
        </button>
        <button id="cameraButton" class="toolbar-button bg-green-500 text-white px-6 py-3 rounded flex items-center space-x-2 hover:bg-green-700">
            <i class="fas fa-video"></i>
            <span>เริ่มกล้อง</span>
        </button>
        <button id="recordingButton" class="toolbar-button bg-yellow-500 text-white px-6 py-3 rounded flex items-center space-x-2 hover:bg-yellow-700">
            <i class="fas fa-record-vinyl"></i>
            <span>เริ่มบันทึก</span>
        </button>
        <button id="muteButton" class="toolbar-button text-white px-6 py-3 rounded flex items-center space-x-2 hover:bg-gray-700">
            <i class="fas fa-volume-mute"></i>
            <span>ปิดเสียง</span>
        </button>
        <button id="unmuteButton" class="toolbar-button text-white px-6 py-3 rounded flex items-center space-x-2 hover:bg-green-700">
            <i class="fas fa-volume-up"></i>
            <span>เปิดเสียง</span>
        </button>
        <button id="volumeDownButton" class="toolbar-button text-white px-6 py-3 rounded flex items-center space-x-2 hover:bg-blue-700">
            <i class="fas fa-volume-down"></i>
            <span>ลดเสียง</span>
        </button>
        <button id="volumeUpButton" class="toolbar-button text-white px-6 py-3 rounded flex items-center space-x-2 hover:bg-red-700">
            <i class="fas fa-volume-up"></i>
            <span>เพิ่มเสียง</span>
        </button>
    </div>
</header>

<!-- เนื้อหาหลัก -->
<main class="flex-grow flex p-4">
    <div class="relative w-full h-full">
        <video id="screenVideo" class="w-full h-full bg-black rounded-lg shadow-lg fade-in" autoplay playsinline></video>
        <video id="cameraVideo" class="absolute top-4 right-4 w-1/4 h-1/4 bg-black rounded-lg shadow-lg draggable fade-in" autoplay playsinline></video>
    </div>
    <!-- กล่องแชท -->
    <div id="chatBox" class="w-1/4 bg-white border border-gray-300 rounded-lg shadow-lg p-4 ml-4 flex flex-col">
        <div id="chatHeader" class="flex justify-between items-center mb-2 p-2">
            <h2 class="text-lg font-semibold text-gray-800">แชท</h2>
            <button id="chatCloseButton" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="chatMessages" class="overflow-y-auto mb-2 p-2 border border-gray-200 rounded-lg">
            <!-- ข้อความจะปรากฏที่นี่ -->
        </div>
        <div class="flex items-center">
            <input id="chatInput" type="text" placeholder="พิมพ์ข้อความ..." class="flex-grow px-3 py-2 border border-gray-300 rounded-lg mr-2" />
            <button id="chatSendButton" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                ส่ง
            </button>
        </div>
    </div>
</main>

<script src="HomeRoom/app.js" type="module"></script>