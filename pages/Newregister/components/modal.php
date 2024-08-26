
<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


<!-- Modal Structure for Error -->
<div id="errorModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 z-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-80 relative">
        <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl" onclick="document.getElementById('errorModal').classList.add('hidden')">
            <i class="fas fa-times"></i>
        </button>
        <div class="flex items-center mb-4">
            <i class="fas fa-exclamation-triangle text-red-600 text-3xl mr-3"></i>
            <p class="text-lg font-semibold text-red-600">มีข้อมูลนี้อยู่แล้ว</p>
        </div>
    </div>
</div>

<!-- Modal Structure for Success -->
<div id="successModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 z-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-80 relative">
        <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl" onclick="document.getElementById('successModal').classList.add('hidden')">
            <i class="fas fa-times"></i>
        </button>
        <div class="flex items-center mb-4">
            <i class="fas fa-check-circle text-green-600 text-3xl mr-3"></i>
            <p class="text-lg font-semibold text-green-600">สมัครสำเร็จเสร็จสิ้น</p>
        </div>
    </div>
</div>

<!-- JavaScript for modal display -->
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        var errorModal = document.getElementById('errorModal');
        var successModal = document.getElementById('successModal');

        // Check if the query parameters are present
        var urlParams = new URLSearchParams(window.location.search);

        if (urlParams.get('showModal') === 'true') {
            errorModal.classList.remove('hidden');
        }

        if (urlParams.get('success') === 'true') {
            successModal.classList.remove('hidden');
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target === errorModal || event.target === successModal) {
                errorModal.classList.add('hidden');
                successModal.classList.add('hidden');
            }
        }
    });
</script>