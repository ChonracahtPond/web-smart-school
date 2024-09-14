const shareButton = document.getElementById("shareButton");
const stopShareButton = document.getElementById("stopShareButton");
const screenVideo = document.getElementById("screenVideo");
const remoteVideo = document.getElementById("remoteVideo");

let localStream;
let peerConnection;

const configuration = { 
    iceServers: [{ urls: 'stun:stun.l.google.com:19302' }] 
};

// Function to start screen sharing
async function startScreenSharing() {
    try {
        localStream = await navigator.mediaDevices.getDisplayMedia({ video: true });
        screenVideo.srcObject = localStream;

        peerConnection = new RTCPeerConnection(configuration);

        // Add local stream tracks to the peer connection
        localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));

        // Set up ICE candidate event handling
        peerConnection.onicecandidate = event => {
            if (event.candidate) {
                // Send the ICE candidate to the remote peer
                sendMessage({ type: 'candidate', candidate: event.candidate });
            }
        };

        // Handle remote stream
        peerConnection.ontrack = event => {
            remoteVideo.srcObject = event.streams[0];
        };

        // Create and send offer
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

// Mock function to send messages to the remote peer
function sendMessage(message) {
    // Implement your signaling mechanism here
    console.log("Send message:", message);
}

// Mock function to handle messages from the remote peer
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
