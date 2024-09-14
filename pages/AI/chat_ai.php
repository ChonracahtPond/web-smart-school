<!-- <!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ระบบถามตอบ</title> -->
<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
<!-- FontAwesome CDN for Icons -->
<link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    rel="stylesheet" />
<style>
    /* Custom animation for buttons */
    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }

        100% {
            transform: scale(1);
        }
    }

    .animate-pulse {
        animation: pulse 1s infinite;
    }
</style>
<!-- </head> -->

<!-- <body class="w-screen flex items-center justify-center p-4"> -->
<!-- <body
    class="bg-gradient-to-r from-violet-500 to-fuchsia-500 min-h-screen flex items-center justify-center p-4"
  > -->
<div class="w-full mt-5 p-8 rounded-lg shadow-lg border border-gray-200 bg-opacity-90">
    <h1 class="text-3xl font-extrabold mb-8 text-center text-gray-900">
        ระบบถามตอบ
    </h1>
    <form id="questionForm" class="space-y-6">
        <div>
            <label
                for="question"
                class="block text-lg font-medium text-gray-700 flex items-center space-x-3">
                <i class="fas fa-question-circle text-indigo-600 text-xl"></i>
                <span>กรุณาถามคำถาม:</span>
            </label>
            <input
                type="text"
                id="question"
                name="question"
                required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-lg p-4" />
        </div>
        <button
            type="submit"
            class="w-full px-5 py-3 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 animate-pulse text-lg flex items-center justify-center">
            <i class="fas fa-paper-plane mr-2"></i> ส่งคำถาม
        </button>
    </form>

    <div
        id="answer"
        class="mt-8 p-5 bg-gray-50 border border-gray-300 rounded-md text-gray-900 text-lg">
        <p>คำตอบ</p>
    </div>
</div>
<script>
    document
        .getElementById("questionForm")
        .addEventListener("submit", async function(event) {
            event.preventDefault();
            const question = document.getElementById("question").value.trim();

            // ล้างคำตอบก่อนหน้า
            document.getElementById("answer").textContent = "";

            if (!question) {
                document.getElementById("answer").textContent = "กรุณากรอกคำถาม";
                return;
            }

            try {
                const response = await fetch("http://localhost:5000/ask", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        question
                    }),
                });

                if (!response.ok) {
                    throw new Error("การตอบสนองจากเครือข่ายไม่เป็นไปตามที่คาด");
                }

                const data = await response.json();
                document.getElementById("answer").textContent =
                    "คำตอบ: " + data.answer || "ไม่พบคำตอบ";
            } catch (error) {
                document.getElementById("answer").textContent =
                    "ข้อผิดพลาด: " + error.message;
            }
        });
</script>
<!-- </body> -->

<!-- </html> -->