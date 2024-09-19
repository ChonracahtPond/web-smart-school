'use strict';

const joinButton = document.getElementById('joinButton');
const startButton = document.getElementById('startButton');
const hangupButton = document.getElementById('hangupButton');
const videoContainer = document.getElementById('videoContainer');
const room_keyInput = document.getElementById('room_key');
const inviteLinkInput = document.getElementById('inviteLink');
const copyLinkButton = document.getElementById('copyLinkButton');

hangupButton.disabled = true;
startButton.disabled = true;

let localStream;
const peers = {};
const signaling = new BroadcastChannel('webrtc');
let room_key = ''; // Store the room key

// Check if there is a room key in the URL
const urlParams = new URLSearchParams(window.location.search);
const urlroom_key = urlParams.get('room_key');
if (urlroom_key) {
  room_keyInput.value = urlroom_key;
  room_key = urlroom_key;
  startButton.disabled = false;
  joinButton.disabled = true;
  // Automatically join the room with the room key from the URL
  autoJoinRoom(urlroom_key);
}

signaling.onmessage = async e => {
  if (!localStream) {
    console.log('not ready yet');
    return;
  }

  // Check if the room_key in the message matches the current room_key
  if (e.data.room_key !== room_key) {
    console.log('Room key mismatch. Access denied.');
    return;
  }

  switch (e.data.type) {
    case 'offer':
      await handleOffer(e.data);
      break;
    case 'answer':
      await handleAnswer(e.data);
      break;
    case 'candidate':
      await handleCandidate(e.data);
      break;
    case 'ready':
      // A new peer joined. Create a new connection and make a call.
      await makeCall();
      break;
    case 'bye':
      const peerId = e.data.peerId;
      if (peers[peerId]) {
        await hangup(peerId);
      }
      break;
    default:
      console.log('unhandled', e);
      break;
  }
};

joinButton.onclick = async () => {
  const inputKey = room_keyInput.value.trim();
  if (inputKey === '') {
    alert('กรุณากรอกคีย์ห้อง');
    return;
  }

  room_key = inputKey;
  startButton.disabled = false;
  joinButton.disabled = true;

  // Generate the invite link
  generateInviteLink();
  updateInviteLink(); // Update the invite link input
};

startButton.onclick = async () => {
  if (room_key === '') {
    alert('กรุณากรอกคีย์ห้องก่อน');
    return;
  }

  localStream = await navigator.mediaDevices.getUserMedia({ audio: true, video: true });
  document.getElementById('localVideo').srcObject = localStream;

  startButton.disabled = true;
  hangupButton.disabled = false;

  signaling.postMessage({ type: 'ready', room_key }); // Include room_key in the message
};

hangupButton.onclick = async () => {
  await hangup();
  signaling.postMessage({ type: 'bye', peerId: 'local', room_key }); // Include room_key in the message
};

copyLinkButton.onclick = () => {
  if (inviteLinkInput.value !== '') {
    inviteLinkInput.select();
    document.execCommand('copy');
    alert('ลิงค์เชิญถูกคัดลอกแล้ว');
  }
};

async function autoJoinRoom(key) {
  room_key = key;
  startButton.disabled = false;
  joinButton.disabled = true;
  // Automatically trigger startButton's onclick to start the media stream
  await startButton.onclick();
}

function generateInviteLink() {
  const inviteLink = `${window.location.origin}${window.location.pathname}?room_key=${encodeURIComponent(room_key)}`;
  inviteLinkInput.value = inviteLink;
}

function updateInviteLink() {
  inviteLinkInput.value = `${window.location.origin}${window.location.pathname}?room_key=${encodeURIComponent(room_key)}`;
}

async function hangup(peerId = 'local') {
  if (peerId === 'local') {
    // Hang up local connection
    for (const id in peers) {
      peers[id].close();
      delete peers[id];
      const remoteVideo = document.getElementById(`remoteVideo-${id}`);
      if (remoteVideo) {
        videoContainer.removeChild(remoteVideo);
      }
    }
    localStream.getTracks().forEach(track => track.stop());
    localStream = null;
    startButton.disabled = false;
    hangupButton.disabled = true;
  } else {
    // Hang up remote connection
    if (peers[peerId]) {
      peers[peerId].close();
      delete peers[peerId];
      const remoteVideo = document.getElementById(`remoteVideo-${peerId}`);
      if (remoteVideo) {
        videoContainer.removeChild(remoteVideo);
      }
    }
  }

  // Redirect to index.html after hangup
  window.location.href = 'index.html';
}


async function createPeerConnection(peerId) {
  const pc = new RTCPeerConnection();
  
  pc.onicecandidate = e => {
    const message = {
      type: 'candidate',
      candidate: e.candidate ? e.candidate.candidate : null,
      sdpMid: e.candidate ? e.candidate.sdpMid : null,
      sdpMLineIndex: e.candidate ? e.candidate.sdpMLineIndex : null,
      peerId: peerId,
      room_key: room_key // Include room_key in the message
    };
    signaling.postMessage(message);
  };

  pc.ontrack = e => {
    let remoteVideo = document.getElementById(`remoteVideo-${peerId}`);
    if (!remoteVideo) {
      remoteVideo = document.createElement('video');
      remoteVideo.id = `remoteVideo-${peerId}`;
      remoteVideo.className = 'w-full h-auto rounded-lg border border-gray-300';
      remoteVideo.autoplay = true;
      videoContainer.appendChild(remoteVideo);
    }
    remoteVideo.srcObject = e.streams[0];
  };

  localStream.getTracks().forEach(track => pc.addTrack(track, localStream));
  peers[peerId] = pc;
}

async function makeCall() {
  const peerId = Date.now().toString(); // Unique ID for each peer
  await createPeerConnection(peerId);

  const offer = await peers[peerId].createOffer();
  signaling.postMessage({ type: 'offer', sdp: offer.sdp, peerId: peerId, room_key }); // Include room_key in the message
  await peers[peerId].setLocalDescription(offer);
}

async function handleOffer(offer) {
  const peerId = offer.peerId;
  if (peers[peerId]) {
    console.error('existing peerconnection', peerId);
    return;
  }
  await createPeerConnection(peerId);
  await peers[peerId].setRemoteDescription(offer);

  const answer = await peers[peerId].createAnswer();
  signaling.postMessage({ type: 'answer', sdp: answer.sdp, peerId: peerId, room_key }); // Include room_key in the message
  await peers[peerId].setLocalDescription(answer);
}

async function handleAnswer(answer) {
  const peerId = answer.peerId;
  if (!peers[peerId]) {
    console.error('no peerconnection', peerId);
    return;
  }
  await peers[peerId].setRemoteDescription(answer);
}

async function handleCandidate(candidate) {
  const peerId = candidate.peerId;
  if (!peers[peerId]) {
    console.error('no peerconnection', peerId);
    return;
  }
  if (candidate.candidate) {
    await peers[peerId].addIceCandidate(new RTCIceCandidate({
      candidate: candidate.candidate,
      sdpMid: candidate.sdpMid,
      sdpMLineIndex: candidate.sdpMLineIndex
    }));
  }
}
