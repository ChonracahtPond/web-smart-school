<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Example</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.1/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Modal Animation Styles */
        .modal-enter {
            opacity: 0;
            transform: scale(0.9);
        }

        .modal-enter-active {
            opacity: 1;
            transform: scale(1);
            transition: opacity 300ms ease-out, transform 300ms ease-out;
        }

        .modal-exit {
            opacity: 1;
            transform: scale(1);
        }

        .modal-exit-active {
            opacity: 0;
            transform: scale(0.9);
            transition: opacity 300ms ease-in, transform 300ms ease-in;
        }

        /* Horizontal Loader Animation Styles */
        .horizontal-loader {
            width: 200px;
            height: 6px;
            background-color: rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            border-radius: 3px;
            margin: 16px 0;
            /* Space between content and loader */
        }

        .horizontal-loader::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100px;
            width: 100px;
            height: 100%;
            background-color: #3498db;
            animation: load 1.5s infinite;
        }

        @keyframes load {
            0% {
                left: -100px;
            }

            50% {
                left: calc(100% - 100px);
            }

            100% {
                left: -100px;
            }
        }
    </style>
</head>

<body>
    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden modal-enter modal-enter-active">
        <div class="bg-white p-6 rounded-lg w-11/12 max-w-md mx-auto relative flex flex-col">
            <div class="relative z-20 flex flex-col flex-grow">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold text-green-600">สำเร็จ</h2>
                    <button id="closeSuccessModal" class="text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
                </div>
                <p class="mb-4">บันทึกข้อมูลสำเร็จ</p>
                <div class="flex justify-end">
                    <button id="closeSuccessModalBtn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">ปิด</button>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 flex items-center justify-center pb-4">
                <div class="horizontal-loader"></div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div id="errorModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden modal-enter modal-enter-active">
        <div class="bg-white p-6 rounded-lg w-11/12 max-w-md mx-auto relative flex flex-col">
            <div class="relative z-20 flex flex-col flex-grow">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold text-red-600">เกิดข้อผิดพลาด</h2>
                    <button id="closeErrorModal" class="text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
                </div>
                <p class="mb-4">เกิดปัญหาบางอย่างเกี่ยวกับระบบ</p>
                <div class="flex justify-end">
                    <button id="closeErrorModalBtn" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">ปิด</button>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 flex items-center justify-center pb-4">
                <div class="horizontal-loader"></div>
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
                setTimeout(() => {
                    successModal.classList.add('modal-exit');
                    successModal.classList.remove('modal-enter-active');
                    successModal.classList.add('modal-exit-active');
                    setTimeout(() => {
                        successModal.classList.add('hidden');
                        successModal.classList.remove('modal-exit');
                        successModal.classList.remove('modal-exit-active');
                        successModal.classList.add('modal-enter');
                    }, 300);
                }, 1000);
            } else if (status === '0') {
                errorModal.classList.remove('hidden');
                setTimeout(() => {
                    errorModal.classList.add('modal-exit');
                    errorModal.classList.remove('modal-enter-active');
                    errorModal.classList.add('modal-exit-active');
                    setTimeout(() => {
                        errorModal.classList.add('hidden');
                        errorModal.classList.remove('modal-exit');
                        errorModal.classList.remove('modal-exit-active');
                        errorModal.classList.add('modal-enter');
                    }, 300);
                }, 1000);
            }
        }

        // Close modal functions
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('modal-exit');
            modal.classList.remove('modal-enter-active');
            modal.classList.add('modal-exit-active');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('modal-exit');
                modal.classList.remove('modal-exit-active');
                modal.classList.add('modal-enter');
            }, 300);
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