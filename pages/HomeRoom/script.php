<script>
    // scripts.js
    let localStream;
    let remoteStream;
    let peerConnection;
    const servers = {
        iceServers: [{
            urls: 'stun:stun.l.google.com:19302'
        }]
    };

    document.getElementById('start-call').addEventListener('click', async () => {
        localStream = await navigator.mediaDevices.getUserMedia({
            video: true,
            audio: true
        });
        document.getElementById('local-video').srcObject = localStream;

        peerConnection = new RTCPeerConnection(servers);

        localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));

        peerConnection.ontrack = (event) => {
            remoteStream = event.streams[0];
            document.getElementById('remote-video').srcObject = remoteStream;
        };

        const offer = await peerConnection.createOffer();
        await peerConnection.setLocalDescription(offer);

        // Send offer to the signaling server
        // Example: signalingServer.send(JSON.stringify({ offer }));

        // Receive answer from the signaling server
        // Example: signalingServer.onmessage = async (message) => {
        //     const { answer } = JSON.parse(message.data);
        //     await peerConnection.setRemoteDescription(new RTCSessionDescription(answer));
        // };
    });

    document.getElementById('end-call').addEventListener('click', () => {
        peerConnection.close();
        document.getElementById('local-video').srcObject = null;
        document.getElementById('remote-video').srcObject = null;
    });

    document.getElementById('toggle-microphone').addEventListener('click', () => {
        const audioTrack = localStream.getAudioTracks()[0];
        audioTrack.enabled = !audioTrack.enabled;
        document.getElementById('toggle-microphone').textContent = audioTrack.enabled ? 'ปิดไมค์' : 'เปิดไมค์';
    });

    document.getElementById('toggle-camera').addEventListener('click', () => {
        const videoTrack = localStream.getVideoTracks()[0];
        videoTrack.enabled = !videoTrack.enabled;
        document.getElementById('toggle-camera').textContent = videoTrack.enabled ? 'ปิดกล้อง' : 'เปิดกล้อง';
    });

    document.getElementById('toggle-live').addEventListener('click', () => {
        // Implement live streaming functionality if needed
        document.getElementById('toggle-live').textContent = document.getElementById('toggle-live').textContent === 'เปิดการถ่ายทอดสด' ? 'ปิดการถ่ายทอดสด' : 'เปิดการถ่ายทอดสด';
    });

    document.getElementById('increase-volume').addEventListener('click', () => {
        const audioTracks = localStream.getAudioTracks();
        if (audioTracks.length > 0) {
            let audioTrack = audioTracks[0];
            audioTrack.enabled = true; // Enable if it was disabled
            let audioContext = new AudioContext();
            let gainNode = audioContext.createGain();
            gainNode.gain.value += 0.1; // Increase volume
            let source = audioContext.createMediaStreamSource(localStream);
            source.connect(gainNode);
            gainNode.connect(audioContext.destination);
        }
    });

    document.getElementById('decrease-volume').addEventListener('click', () => {
        const audioTracks = localStream.getAudioTracks();
        if (audioTracks.length > 0) {
            let audioTrack = audioTracks[0];
            audioTrack.enabled = true; // Enable if it was disabled
            let audioContext = new AudioContext();
            let gainNode = audioContext.createGain();
            gainNode.gain.value -= 0.1; // Decrease volume
            let source = audioContext.createMediaStreamSource(localStream);
            source.connect(gainNode);
            gainNode.connect(audioContext.destination);
        }
    });

    document.getElementById('send-message').addEventListener('click', () => {
        const message = document.getElementById('chat-input').value;
        if (message) {
            const chatBox = document.getElementById('chat-box');
            const messageElement = document.createElement('div');
            messageElement.textContent = message;
            chatBox.appendChild(messageElement);
            document.getElementById('chat-input').value = '';

            // Send message to the signaling server
            // Example: signalingServer.send(JSON.stringify({ message }));
        }
    });
</script>