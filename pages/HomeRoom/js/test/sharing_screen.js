// const shareButton = document.getElementById("shareButton");
// const stopShareButton = document.getElementById("stopShareButton");
// const screenVideo = document.getElementById("screenVideo");
// const remoteVideoContainer = document.getElementById("remoteVideoContainer");

// let localStream;
// let peerConnections = {}; // ใช้เก็บ RTCPeerConnection หลายตัว

// const configuration = {
//   iceServers: [{ urls: "stun:stun.l.google.com:19302" }],
// };

// // Function to start screen sharing
// async function startScreenSharing() {
//   try {
//     localStream = await navigator.mediaDevices.getDisplayMedia({ video: true });
//     screenVideo.srcObject = localStream;

//     // Create and manage peer connections for multiple remote peers
//     for (const peerId of Object.keys(peerConnections)) {
//       const peerConnection = peerConnections[peerId];
//       localStream
//         .getTracks()
//         .forEach((track) => peerConnection.addTrack(track, localStream));

//       // Set up ICE candidate event handling
//       peerConnection.onicecandidate = (event) => {
//         if (event.candidate) {
//           // Send the ICE candidate to the remote peer
//           sendMessage(peerId, {
//             type: "candidate",
//             candidate: event.candidate,
//           });
//         }
//       };

//       // Handle remote stream
//       peerConnection.ontrack = (event) => {
//         let remoteVideo = document.getElementById(`remoteVideo_${peerId}`);
//         if (!remoteVideo) {
//           remoteVideo = document.createElement("video");
//           remoteVideo.id = `remoteVideo_${peerId}`;
//           remoteVideo.classList.add("remote-video");
//           remoteVideo.autoplay = true;
//           remoteVideo.playsInline = true;
//           remoteVideoContainer.appendChild(remoteVideo);
//         }
//         remoteVideo.srcObject = event.streams[0];
//       };

//       // Create and send offer
//       const offer = await peerConnection.createOffer();
//       await peerConnection.setLocalDescription(offer);
//       sendMessage(peerId, { type: "offer", sdp: offer.sdp });
//     }

//     shareButton.classList.add("hidden");
//     stopShareButton.classList.remove("hidden");
//   } catch (err) {
//     console.error("Error starting screen sharing:", err);
//   }
// }

// // Function to stop screen sharing
// function stopScreenSharing() {
//   if (localStream) {
//     localStream.getTracks().forEach((track) => track.stop());
//     screenVideo.srcObject = null;
//     localStream = null;
//   }

//   for (const peerId of Object.keys(peerConnections)) {
//     const peerConnection = peerConnections[peerId];
//     if (peerConnection) {
//       peerConnection.close();
//       delete peerConnections[peerId];
//     }
//   }

//   stopShareButton.classList.add("hidden");
//   shareButton.classList.remove("hidden");
// }

// // Function to handle new peer connections
// function addPeer(peerId) {
//   if (!peerConnections[peerId]) {
//     const peerConnection = new RTCPeerConnection(configuration);
//     peerConnections[peerId] = peerConnection;

//     // Handle incoming messages from the remote peer
//     peerConnection.onicecandidate = (event) => {
//       if (event.candidate) {
//         sendMessage(peerId, { type: "candidate", candidate: event.candidate });
//       }
//     };

//     peerConnection.ontrack = (event) => {
//       let remoteVideo = document.getElementById(`remoteVideo_${peerId}`);
//       if (!remoteVideo) {
//         remoteVideo = document.createElement("video");
//         remoteVideo.id = `remoteVideo_${peerId}`;
//         remoteVideo.classList.add("remote-video");
//         remoteVideo.autoplay = true;
//         remoteVideo.playsInline = true;
//         remoteVideoContainer.appendChild(remoteVideo);
//       }
//       remoteVideo.srcObject = event.streams[0];
//     };
//   }
// }

// // Event listeners
// shareButton.addEventListener("click", startScreenSharing);
// stopShareButton.addEventListener("click", stopScreenSharing);

// // Mock function to send messages to remote peers
// function sendMessage(peerId, message) {
//   // Implement your signaling mechanism here
//   console.log(`Send message to ${peerId}:`, message);
// }

// // Mock function to handle messages from remote peers
// async function handleMessage(peerId, message) {
//   if (message.type === "offer") {
//     addPeer(peerId);
//     const peerConnection = peerConnections[peerId];
//     await peerConnection.setRemoteDescription(
//       new RTCSessionDescription({ type: "offer", sdp: message.sdp })
//     );
//     const answer = await peerConnection.createAnswer();
//     await peerConnection.setLocalDescription(answer);
//     sendMessage(peerId, { type: "answer", sdp: answer.sdp });
//   } else if (message.type === "answer") {
//     const peerConnection = peerConnections[peerId];
//     await peerConnection.setRemoteDescription(
//       new RTCSessionDescription({ type: "answer", sdp: message.sdp })
//     );
//   } else if (message.type === "candidate") {
//     const peerConnection = peerConnections[peerId];
//     await peerConnection.addIceCandidate(
//       new RTCIceCandidate(message.candidate)
//     );
//   }
// }


const shareButton = document.getElementById("shareButton");
const stopShareButton = document.getElementById("stopShareButton");
const screenVideo = document.getElementById("screenVideo");
const remoteVideo = document.getElementById("remoteVideo");

let localStream;
let peerConnection;
const configuration = { iceServers: [{ urls: 'stun:stun.l.google.com:19302' }] };

// Function to start screen sharing
async function startScreenSharing() {
    try {
        localStream = await navigator.mediaDevices.getDisplayMedia({ video: true });
        screenVideo.srcObject = localStream;

        peerConnection = new RTCPeerConnection(configuration);
        localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));

        peerConnection.onicecandidate = event => {
            if (event.candidate) {
                sendMessage({ type: 'candidate', candidate: event.candidate });
            }
        };

        peerConnection.ontrack = event => {
            remoteVideo.srcObject = event.streams[0];
        };

        const offer = await peerConnection.createOffer();
        await peerConnection.setLocalDescription(offer);
        sendMessage({ type: 'offer', sdp: offer.sdp });

        shareButton.classList.add("hidden");
        stopShareButton.classList.remove("hidden");
    } catch (err) {
        console.error("Error starting screen sharing:", err);
    }
}

// Function to stop screen sharing
function stopScreenSharing() {
    if (localStream) {
        localStream.getTracks().forEach(track => track.stop());
        screenVideo.srcObject = null;
        localStream = null;
    }

    if (peerConnection) {
        peerConnection.close();
        peerConnection = null;
    }

    shareButton.classList.remove("hidden");
    stopShareButton.classList.add("hidden");
}

// Event listeners
shareButton.addEventListener("click", startScreenSharing);
stopShareButton.addEventListener("click", stopScreenSharing);

// Send message to signaling server
async function sendMessage(message) {
    try {
        await fetch('signaling_server.php', {
            method: 'POST',
            body: JSON.stringify(message),
            headers: { 'Content-Type': 'application/json' }
        });
    } catch (err) {
        console.error("Error sending message:", err);
    }
}

// Handle messages from signaling server
async function handleMessage(message) {
    if (message.type === 'offer') {
        await peerConnection.setRemoteDescription(new RTCSessionDescription({ type: 'offer', sdp: message.sdp }));
        const answer = await peerConnection.createAnswer();
        await peerConnection.setLocalDescription(answer);
        sendMessage({ type: 'answer', sdp: answer.sdp });
    } else if (message.type === 'answer') {
        await peerConnection.setRemoteDescription(new RTCSessionDescription({ type: 'answer', sdp: message.sdp }));
    } else if (message.type === 'candidate') {
        await peerConnection.addIceCandidate(new RTCIceCandidate(message.candidate));
    }
}

// Polling for new messages from the server
setInterval(async () => {
    try {
        const response = await fetch('signaling_server.php');
        const messages = await response.json();
        messages.forEach(message => handleMessage(message));
    } catch (err) {
        console.error("Error fetching messages:", err);
    }
}, 1000);
