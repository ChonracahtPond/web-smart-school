<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Toast Notifications Example</title>
    <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        /* Toast animations */
        .toast-enter {
            -webkit-transform: translateX(1000px);
            transform: translateX(1000px);
            opacity: 0;
        }

        .toast-enter-active {
            -webkit-transform: translateX(0);
            transform: translateX(0);
            opacity: 1;
            transition: opacity 300ms ease-out, transform 300ms ease-out;
        }

        .toast-exit {
            -webkit-transform: translateX(0);
            transform: translateX(0);
            opacity: 1;
        }

        .toast-exit-active {
            -webkit-transform: translateX(1000px);
            transform: translateX(1000px);
            opacity: 0;
            transition: opacity 300ms ease-in, transform 300ms ease-in;
        }

        /* Loader Styles */
        .horizontal-loader {
            width: 100%;
            height: 4px;
            background-color: rgba(0, 0, 0, 0.1);
            position: absolute;
            bottom: 0;
            left: 0;
            overflow: hidden;
            border-radius: 2px;
        }

        .horizontal-loader span {
            display: block;
            height: 100%;
            background-color: #FFF;
            position: absolute;
            left: -100%;
            width: 100%;
            animation: load 3s linear forwards;
        }

        @keyframes load {
            to {
                left: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Success Toast -->
    <div id="successToast" class="fixed bottom-0 right-0 m-8 w-5/6 md:w-full max-w-sm hidden toast-enter toast-enter-active">
        <div class="bg-green-500 text-white p-4 rounded-lg shadow-lg flex items-center justify-between relative">
            <span>ออกจากระบบสำเร็จ</span>
            <button id="closeSuccessToast" class="text-white ml-4">
                <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </button>
            <div class="horizontal-loader">
                <span></span>
            </div>
        </div>
    </div>

    <!-- Error Toast -->
    <div id="errorToast" class="fixed bottom-0 right-0 m-8 w-5/6 md:w-full max-w-sm hidden toast-enter toast-enter-active">
        <div class="bg-red-500 text-white p-4 rounded-lg shadow-lg flex items-center justify-between relative">
            <span>เกิดข้อผิดพลาด</span>
            <button id="closeErrorToast" class="text-white ml-4">
                <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </button>
            <div class="horizontal-loader">
                <span></span>
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

        // Show the appropriate toast based on the URL parameter
        function showToast() {
            const status = getUrlParameter('status');
            const successToast = document.getElementById('successToast');
            const errorToast = document.getElementById('errorToast');

            if (status === 'success') {
                successToast.classList.remove('hidden');
                setTimeout(() => {
                    successToast.classList.add('toast-exit');
                    successToast.classList.remove('toast-enter-active');
                    successToast.classList.add('toast-exit-active');
                    setTimeout(() => {
                        successToast.classList.add('hidden');
                        successToast.classList.remove('toast-exit');
                        successToast.classList.remove('toast-exit-active');
                        successToast.classList.add('toast-enter');
                    }, 300);
                }, 3000); // Toast visible for 3 seconds
            } else if (status === 'error') {
                errorToast.classList.remove('hidden');
                setTimeout(() => {
                    errorToast.classList.add('toast-exit');
                    errorToast.classList.remove('toast-enter-active');
                    errorToast.classList.add('toast-exit-active');
                    setTimeout(() => {
                        errorToast.classList.add('hidden');
                        errorToast.classList.remove('toast-exit');
                        errorToast.classList.remove('toast-exit-active');
                        errorToast.classList.add('toast-enter');
                    }, 300);
                }, 3000); // Toast visible for 3 seconds
            }
        }

        // Close toast functions
        function closeToast(toastId) {
            const toast = document.getElementById(toastId);
            toast.classList.add('toast-exit');
            toast.classList.remove('toast-enter-active');
            toast.classList.add('toast-exit-active');
            setTimeout(() => {
                toast.classList.add('hidden');
                toast.classList.remove('toast-exit');
                toast.classList.remove('toast-exit-active');
                toast.classList.add('toast-enter');
            }, 300);
        }

        document.getElementById('closeSuccessToast').onclick = function() {
            closeToast('successToast');
        };
        document.getElementById('closeErrorToast').onclick = function() {
            closeToast('errorToast');
        };

        // Show the toast when the page loads
        window.onload = function() {
            showToast();
        };
    </script>
</body>

</html>
