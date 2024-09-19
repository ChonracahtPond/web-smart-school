// JavaScript to make cameraVideo draggable
const cameraVideo = document.getElementById("cameraVideo");
const cameraButton = document.getElementById("cameraButton");
const recordingButton = document.getElementById("recordingButton");
const timerDisplay = document.getElementById("timerDisplay");

let isDragging = false;
let startX, startY, initialX, initialY;
let cameraStream = null;
let isRecording = false;
let startTime = null;
let timerInterval = null;

// Make cameraVideo draggable
cameraVideo.addEventListener("mousedown", (e) => {
  isDragging = true;
  startX = e.clientX;
  startY = e.clientY;
  initialX = cameraVideo.offsetLeft;
  initialY = cameraVideo.offsetTop;
  cameraVideo.style.cursor = "grabbing";
});

document.addEventListener("mousemove", (e) => {
  if (!isDragging) return;
  const dx = e.clientX - startX;
  const dy = e.clientY - startY;
  cameraVideo.style.left = `${initialX + dx}px`;
  cameraVideo.style.top = `${initialY + dy}px`;
});

document.addEventListener("mouseup", () => {
  isDragging = false;
  cameraVideo.style.cursor = "grab";
});

// Toggle camera
cameraButton.addEventListener("click", async () => {
  if (cameraStream) {
    cameraStream.getTracks().forEach((track) => track.stop());
    cameraVideo.srcObject = null;
    cameraButton.textContent = "Start Camera";
    cameraButton.classList.remove("bg-red-500");
    cameraButton.classList.add("bg-green-500");
    cameraButton.classList.remove("hover:bg-red-700");
    cameraButton.classList.add("hover:bg-green-700");
    return;
  }

  try {
    cameraStream = await navigator.mediaDevices.getUserMedia({
      video: true,
    });
    cameraVideo.srcObject = cameraStream;
    cameraButton.textContent = "Stop Camera";
    cameraButton.classList.remove("bg-green-500");
    cameraButton.classList.add("bg-red-500");
    cameraButton.classList.remove("hover:bg-green-700");
    cameraButton.classList.add("hover:bg-red-700");
  } catch (err) {
    console.error("Error accessing camera: ", err);
  }
});

// Toggle recording
recordingButton.addEventListener("click", () => {
  if (isRecording) {
    clearInterval(timerInterval);
    recordingButton.textContent = "Start Recording";
    recordingButton.classList.remove("bg-gray-500");
    recordingButton.classList.add("bg-yellow-500");
    recordingButton.classList.remove("hover:bg-gray-700");
    recordingButton.classList.add("hover:bg-yellow-700");
    timerDisplay.textContent = "00:00";
    isRecording = false;
    // Stop recording logic here
  } else {
    startTime = new Date();
    timerInterval = setInterval(updateTimer, 1000);
    recordingButton.textContent = "Stop Recording";
    recordingButton.classList.remove("bg-yellow-500");
    recordingButton.classList.add("bg-gray-500");
    recordingButton.classList.remove("hover:bg-yellow-700");
    recordingButton.classList.add("hover:bg-gray-700");
    // Start recording logic here
    isRecording = true;
  }
});

function updateTimer() {
  const elapsed = Math.floor((new Date() - startTime) / 1000);
  const minutes = String(Math.floor(elapsed / 60)).padStart(2, "0");
  const seconds = String(elapsed % 60).padStart(2, "0");
  timerDisplay.textContent = `${minutes}:${seconds}`;
}
