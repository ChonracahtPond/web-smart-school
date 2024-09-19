'use strict';

export let localStream;
export const peers = {};
export const signaling = new BroadcastChannel('webrtc');
export let room_key = ''; // Store the room key

export async function autoJoinRoom(key) {
  room_key = key;
  startButton.disabled = false;
  joinButton.disabled = true;
  // Automatically trigger startButton's onclick to start the media stream
  await startButton.onclick();
}

export function generateInviteLink() {
  const inviteLink = `${window.location.origin}${window.location.pathname}?room_key=${encodeURIComponent(room_key)}`;
  inviteLinkInput.value = inviteLink;
}

export async function hangup(peerId = 'local') {
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
}

export async function createPeerConnection(peerId) {
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

export async function makeCall() {
  const peerId = Date.now().toString(); // Unique ID for each peer
  await createPeerConnection(peerId);

  const offer = await peers[peerId].createOffer();
  signaling.postMessage({ type: 'offer', sdp: offer.sdp, peerId: peerId, room_key }); // Include room_key in the message
  await peers[peerId].setLocalDescription(offer);
}

export async function handleOffer(offer) {
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

export async function handleAnswer(answer) {
  const peerId = answer.peerId;
  if (!peers[peerId]) {
    console.error('no peerconnection', peerId);
    return;
  }
  await peers[peerId].setRemoteDescription(answer);
}

export async function handleCandidate(candidate) {
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
