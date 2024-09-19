// record.js
let mediaRecorder;
let recordedChunks = [];
let isRecording = false;
let startTime;
let timerInterval;
const recordingButton = document.getElementById("recordingButton");
const timerDisplay = document.getElementById("timerDisplay");
const screenVideo = document.getElementById("screenVideo");

// Function to start or stop recording
async function toggleRecording() {
  if (isRecording) {
    mediaRecorder.stop();
    clearInterval(timerInterval);
    recordingButton.textContent = "Start Recording";
    updateRecordingButtonStyles('start');
  } else {
    if (screenVideo.srcObject) {
      try {
        mediaRecorder = new MediaRecorder(screenVideo.srcObject, { mimeType: 'video/webm' });
        mediaRecorder.ondataavailable = (event) => {
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
        updateRecordingButtonStyles('stop');
      } catch (err) {
        console.error("Error starting recording:", err);
      }
    } else {
      console.error("No media stream available for recording.");
    }
  }
  isRecording = !isRecording;
}

// Function to update button styles
function updateRecordingButtonStyles(state) {
  if (state === 'start') {
    recordingButton.classList.remove("bg-gray-500");
    recordingButton.classList.add("bg-yellow-500");
    recordingButton.classList.remove("hover:bg-gray-700");
    recordingButton.classList.add("hover:bg-yellow-700");
  } else if (state === 'stop') {
    recordingButton.classList.remove("bg-yellow-500");
    recordingButton.classList.add("bg-gray-500");
    recordingButton.classList.remove("hover:bg-yellow-700");
    recordingButton.classList.add("hover:bg-gray-700");
  }
}

// Function to update timer display
function updateTimer() {
  const elapsedTime = Math.floor((Date.now() - startTime) / 1000);
  const minutes = Math.floor(elapsedTime / 60);
  const seconds = elapsedTime % 60;
  timerDisplay.textContent = `${String(minutes).padStart(2, "0")}:${String(seconds).padStart(2, "0")}`;
}

recordingButton.addEventListener("click", toggleRecording);
