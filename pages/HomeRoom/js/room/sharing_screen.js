document.addEventListener("DOMContentLoaded", () => {
  const screenShareButton = document.getElementById("screenShareButton");
  const stopScreenShareButton = document.getElementById(
    "stopScreenShareButton"
  );
  const sharedScreenVideo = document.getElementById("sharedScreenVideo");
  let screenStream = null;
  let sender = null; // To keep track of the screen track sender

  // Access global peerConnection
  const peerConnection = window.peerConnection;

  // Handle screen share button click
  screenShareButton.addEventListener("click", async () => {
    if (screenStream) {
      alert("มีการแชร์หน้าจออยู่แล้ว");
      return;
    }

    try {
      screenStream = await navigator.mediaDevices.getDisplayMedia({
        video: true,
      });
      const videoTracks = screenStream.getVideoTracks();
      console.log("Screen sharing started:", videoTracks[0].label);
      sharedScreenVideo.srcObject = screenStream;
      sharedScreenVideo.classList.remove("hidden");

      // Send the screenStream to other participants
      if (peerConnection) {
        // Remove any previous screen share tracks
        if (sender) {
          peerConnection.removeTrack(sender);
        }

        // Add screen stream tracks to the peer connection
        sender = peerConnection.addTrack(
          screenStream.getVideoTracks()[0],
          screenStream
        );
      }

      // Disable the screen share button and enable stop button
      screenShareButton.disabled = true;
      stopScreenShareButton.disabled = false;
    } catch (error) {
      console.error("Error sharing screen:", error);
    }
  });

  // Handle stop screen share button click
  stopScreenShareButton.addEventListener("click", () => {
    if (screenStream) {
      screenStream.getTracks().forEach((track) => track.stop());
      sharedScreenVideo.classList.add("hidden");
      screenStream = null;
      screenShareButton.disabled = false;
      stopScreenShareButton.disabled = true;

      // Notify other participants that screen sharing has stopped
      if (peerConnection && sender) {
        peerConnection.removeTrack(sender);
        sender = null;
      }
    }
  });

  // Listen for screen sharing from other participants
  if (peerConnection) {
    peerConnection.ontrack = (event) => {
      // Check if the track is a video track and is from screen sharing
      if (event.track.kind === "video") {
        console.log("Receiving screen sharing stream");
        sharedScreenVideo.srcObject = event.streams[0];
        sharedScreenVideo.classList.remove("hidden");
      }
    };
  }
});
