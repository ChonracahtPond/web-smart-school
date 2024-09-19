const cameraButton = document.getElementById("cameraButton");
const cameraVideo = document.getElementById("cameraVideo");

let cameraStream;
let isDragging = false;
let offsetX, offsetY;

// Function to start or stop camera
async function toggleCamera() {
  if (cameraStream) {
    // Stop the camera stream
    cameraStream.getTracks().forEach(track => track.stop());
    cameraVideo.srcObject = null;
    cameraVideo.style.display = 'none'; // Hide camera video
    cameraButton.textContent = "Start Camera";
    updateCameraButtonStyles('start');
    cameraStream = null;
  } else {
    try {
      // Start the camera stream
      cameraStream = await navigator.mediaDevices.getUserMedia({ video: true });
      cameraVideo.srcObject = cameraStream;
      cameraVideo.style.display = 'block'; // Show camera video
      cameraButton.textContent = "Stop Camera";
      updateCameraButtonStyles('stop');
    } catch (err) {
      console.error("Error starting camera:", err);
    }
  }
}

// Function to update button styles
function updateCameraButtonStyles(state) {
  if (state === 'start') {
    cameraButton.classList.remove("bg-red-500");
    cameraButton.classList.add("bg-green-500");
    cameraButton.classList.remove("hover:bg-red-700");
    cameraButton.classList.add("hover:bg-green-700");
  } else if (state === 'stop') {
    cameraButton.classList.remove("bg-green-500");
    cameraButton.classList.add("bg-red-500");
    cameraButton.classList.remove("hover:bg-green-700");
    cameraButton.classList.add("hover:bg-red-700");
  }
}

// Drag and drop functionality
function initDrag() {
  cameraVideo.addEventListener('mousedown', (e) => {
    isDragging = true;
    offsetX = e.clientX - cameraVideo.getBoundingClientRect().left;
    offsetY = e.clientY - cameraVideo.getBoundingClientRect().top;
    cameraVideo.style.transition = 'none'; // Disable transition while dragging
  });

  document.addEventListener('mousemove', (e) => {
    if (isDragging) {
      const x = e.clientX - offsetX;
      const y = e.clientY - offsetY;
      cameraVideo.style.left = `${x}px`;
      cameraVideo.style.top = `${y}px`;
    }
  });

  document.addEventListener('mouseup', () => {
    isDragging = false;
    cameraVideo.style.transition = 'top 0.3s ease, left 0.3s ease'; // Re-enable transition after dragging
  });
}

// Initialize drag functionality and set up event listener
initDrag();
cameraButton.addEventListener("click", toggleCamera);
