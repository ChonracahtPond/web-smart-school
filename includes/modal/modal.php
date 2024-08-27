<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Example</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.1/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg w-11/12 max-w-md mx-auto">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-green-600">Success</h2>
                <button id="closeSuccessModal" class="text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
            </div>
            <p class="mb-4">Operation was successful!</p>
            <div class="flex justify-end">
                <button id="closeSuccessModalBtn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Close</button>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div id="errorModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg w-11/12 max-w-md mx-auto">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-red-600">Error</h2>
                <button id="closeErrorModal" class="text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
            </div>
            <p class="mb-4">Operation failed. Please try again.</p>
            <div class="flex justify-end">
                <button id="closeErrorModalBtn" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Close</button>
            </div>
        </div>
    </div>

    <script>
        // Function to get URL parameter by name
        function getUrlParameter(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            const regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            const results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        }

        // Show the appropriate modal based on the URL parameter
        function showModal() {
            const status = getUrlParameter('status');
            const successModal = document.getElementById('successModal');
            const errorModal = document.getElementById('errorModal');

            if (status === '1') {
                successModal.classList.remove('hidden');
            } else if (status === '0') {
                errorModal.classList.remove('hidden');
            }
        }

        // Close modal functions
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        document.getElementById('closeSuccessModal').onclick = function() {
            closeModal('successModal');
        };
        document.getElementById('closeSuccessModalBtn').onclick = function() {
            closeModal('successModal');
        };
        document.getElementById('closeErrorModal').onclick = function() {
            closeModal('errorModal');
        };
        document.getElementById('closeErrorModalBtn').onclick = function() {
            closeModal('errorModal');
        };

        // Show the modal when the page loads
        window.onload = function() {
            showModal();
        };
    </script>
</body>

</html>