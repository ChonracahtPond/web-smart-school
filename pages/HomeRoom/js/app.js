// app.js
const shareButton = document.getElementById("shareButton");
const cameraButton = document.getElementById("cameraButton");
const recordingButton = document.getElementById("recordingButton");
const timerDisplay = document.getElementById("timerDisplay");

const screenVideo = document.getElementById("screenVideo");
const cameraVideo = document.getElementById("cameraVideo");

let mediaStream;
let cameraStream;
let mediaRecorder;
let recordedChunks = [];
let isRecording = false;
let startTime;
let timerInterval;

// Function to share screen
async function shareScreen() {
  try {
    mediaStream = await navigator.mediaDevices.getDisplayMedia({ video: true });
    screenVideo.srcObject = mediaStream;
    mediaStream.getTracks().forEach(track => {
      track.onended = () => {
        screenVideo.srcObject = null;
      };
    });
  } catch (err) {
    console.error("Error sharing screen:", err);
  }
}

// Function to start or stop camera
async function toggleCamera() {
  if (cameraStream) {
    cameraStream.getTracks().forEach(track => track.stop());
    cameraVideo.srcObject = null;
    cameraButton.textContent = "Start Camera";
    cameraButton.classList.remove("bg-red-500");
    cameraButton.classList.add("bg-green-500");
    cameraButton.classList.remove("hover:bg-red-700");
    cameraButton.classList.add("hover:bg-green-700");
    cameraStream = null;
  } else {
    try {
      cameraStream = await navigator.mediaDevices.getUserMedia({ video: true });
      cameraVideo.srcObject = cameraStream;
      cameraButton.textContent = "Stop Camera";
      cameraButton.classList.remove("bg-green-500");
      cameraButton.classList.add("bg-red-500");
      cameraButton.classList.remove("hover:bg-green-700");
      cameraButton.classList.add("hover:bg-red-700");
    } catch (err) {
      console.error("Error starting camera:", err);
    }
  }
}

// Function to start and stop recording
function toggleRecording() {
  if (isRecording) {
    mediaRecorder.stop();
    clearInterval(timerInterval);
    recordingButton.textContent = "Start Recording";
    recordingButton.classList.remove("bg-gray-500");
    recordingButton.classList.add("bg-yellow-500");
    recordingButton.classList.remove("hover:bg-gray-700");
    recordingButton.classList.add("hover:bg-yellow-700");
  } else {
    if (mediaStream) {
      mediaRecorder = new MediaRecorder(mediaStream);
      mediaRecorder.ondataavailable = event => {
        if (event.data.size > 0) {
          recordedChunks.push(event.data);
        }
      };
      mediaRecorder.onstop = () => {
        const blob = new Blob(recordedChunks, { type: "video/webm" });
        const url = URL.createObjectURL(blob);
        const a = document.createElement("a");
        a.href = url;
        a.download = "recording.webm";
        a.click();
        recordedChunks = [];
      };
      mediaRecorder.start();
      startTime = Date.now();
      timerInterval = setInterval(updateTimer, 1000);
      recordingButton.textContent = "Stop Recording";
      recordingButton.classList.remove("bg-yellow-500");
      recordingButton.classList.add("bg-gray-500");
      recordingButton.classList.remove("hover:bg-yellow-700");
      recordingButton.classList.add("hover:bg-gray-700");
    } else {
      console.error("No media stream available for recording.");
    }
  }
  isRecording = !isRecording;
}

// Function to update timer display
function updateTimer() {
  const elapsedTime = Math.floor((Date.now() - startTime) / 1000);
  const minutes = Math.floor(elapsedTime / 60);
  const seconds = elapsedTime % 60;
  timerDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
}

// Event listeners
shareButton.addEventListener("click", shareScreen);
cameraButton.addEventListener("click", toggleCamera);
recordingButton.addEventListener("click", toggleRecording);
