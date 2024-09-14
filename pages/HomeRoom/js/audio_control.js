document.addEventListener('DOMContentLoaded', () => {
    const muteButton = document.getElementById('muteButton');
    const unmuteButton = document.getElementById('unmuteButton');
    const volumeDownButton = document.getElementById('volumeDownButton');
    const volumeUpButton = document.getElementById('volumeUpButton');
    
    let isMuted = false;
    let currentVolume = 1.0;

    // Get video elements (Assuming you are streaming video)
    const videoElements = document.querySelectorAll('video');

    function setVolume(volume) {
        videoElements.forEach(video => {
            video.volume = volume;
        });
        currentVolume = volume;
    }

    muteButton.addEventListener('click', () => {
        if (!isMuted) {
            setVolume(0);
            isMuted = true;
            muteButton.classList.add('hidden');
            unmuteButton.classList.remove('hidden');
        }
    });

    unmuteButton.addEventListener('click', () => {
        if (isMuted) {
            setVolume(currentVolume);
            isMuted = false;
            muteButton.classList.remove('hidden');
            unmuteButton.classList.add('hidden');
        }
    });

    volumeDownButton.addEventListener('click', () => {
        if (currentVolume > 0.1) {
            setVolume(Math.max(currentVolume - 0.1, 0));
        }
    });

    volumeUpButton.addEventListener('click', () => {
        if (currentVolume < 1.0) {
            setVolume(Math.min(currentVolume + 0.1, 1.0));
        }
    });
});
