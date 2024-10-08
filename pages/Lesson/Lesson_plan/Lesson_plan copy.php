<div class=" max-w-5xl bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold mb-4 text-center">ถามคำถาม</h1>

    <!-- ส่วนที่มีการเลือกข้อมูล -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700" for="grade_level">เลือก Grade Level:</label>
        <select
            id="grade_level"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            <option value="ประถม">ประถม</option>
            <option value="มัธยม">มัธยม</option>
        </select>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700" for="course">เลือก Course:</label>
        <select
            id="course"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            <option value="วิชาคณิตศาสตร์">วิชาคณิตศาสตร์</option>
            <option value="วิชาวิทยาศาสตร์">วิทยาศาสตร์</option>
        </select>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700" for="chapter">เลือก Chapter:</label>
        <select
            id="chapter"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            <option value="บทที่ 1">บทที่ 1</option>
            <option value="บทที่ 2">บทที่ 2</option>
        </select>
    </div>

    <button
        onclick="fetchLessonData()"
        class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 mb-5">
        ค้นหา
    </button>

    <!-- ปุ่มส่งออกเป็น PDF -->
    <button
        onclick="showPDFPreview()"
        class="w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700">
        แสดงตัวอย่าง PDF
    </button>

    <!-- --------------------------- -->
    <table class="border-collapse w-full">
        <thead>
            <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">ลำดับที่</th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">หัวเรื่อง</th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">ตัวชี้วัด</th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">เนื้อหา</th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">จำนวนชั่วโมง</th>
            </tr>
        </thead>
        <tbody>
            <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                <td class="w-full lg:w-auto p-3 text-gray-800 text-left border border-b block lg:table-cell relative lg:static">
                    <p id="chapter_display" class=""></p>
                </td>
                <td class="w-full lg:w-auto p-3 text-gray-800 text-left border border-b block lg:table-cell relative lg:static">
                    <p id="indicators" class=""></p>
                </td>
                <td class="w-full lg:w-auto p-3 text-gray-800 text-left border border-b block lg:table-cell relative lg:static">
                    <p id="expected_learning_outcomes" class=""></p>
                </td>
                <td class="w-full lg:w-auto p-3 text-gray-800 text-left border border-b block lg:table-cell relative lg:static">
                    <p id="content" class=""></p>
                </td>
                <td class="w-full lg:w-auto p-3 text-gray-800 text-left border border-b block lg:table-cell relative lg:static">
                    <p id="study_time" class=""></p>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- ---------------------------------------- -->
    <h2 class="text-xl font-semibold mt-6 mb-2">ข้อมูลที่ค้นหาได้</h2>
    <p id="no_display" class="border border-gray-300 p-2 rounded-md mb-2"></p>
    <p id="activity" class="border border-gray-300 p-2 rounded-md mb-2"></p>
    <p id="learning_resources" class="border border-gray-300 p-2 rounded-md mb-2"></p>

    <h2 class="text-xl font-semibold mt-6 mb-2">คำถามและคำตอบ</h2>
    <div id="questions_and_answers" class="border border-gray-300 p-2 rounded-md mb-2"></div>

    <h2 class="text-xl font-semibold mt-6 mb-2">หมายเหตุ</h2>
    <p id="note" class="border border-gray-300 p-2 rounded-md mb-2"></p>

    <h2 class="text-xl font-semibold mt-6 mb-2">การอ้างอิง</h2>
    <p id="refer" class="border border-gray-300 p-2 rounded-md mb-2"></p>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    async function fetchLessonData() {
        const gradeLevel = document.getElementById("grade_level").value;
        const course = document.getElementById("course").value;
        const chapter = document.getElementById("chapter").value;

        const response = await fetch("http://127.0.0.1:5000/ask", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                gradeLevel,
                course,
                chapter
            }),
        });

        if (response.ok) {
            const data = await response.json();

            // แสดงข้อมูลที่กรองได้
            document.getElementById("chapter_display").innerText = `Chapter: ${data.Chapter}`;
            document.getElementById("no_display").innerText = `No: ${data.No}`;
            document.getElementById("study_time").innerText = `Study Time: ${data.Study_time}`;

            // แสดง Indicators
            document.getElementById("indicators").innerText = `Indicators: ${data.Indicators.join(", ")}`;

            // แสดง Expected Learning Outcomes
            document.getElementById("expected_learning_outcomes").innerText = `Expected Learning Outcomes: ${data.Expected_learning_outcomes.join(", ")}`;

            // แสดง Content
            document.getElementById("content").innerText = `Content: ${data.content.join(", ")}`;

            // แสดง Activity
            document.getElementById("activity").innerText = `Activity: ${data.activity.join(", ")}`;

            // แสดง Learning Resources
            document.getElementById("learning_resources").innerText = `Learning Resources: ${data.Learning_resources.join(", ")}`;

            // แสดง Questions and Answers
            const qAndAContainer = document.getElementById("questions_and_answers");
            qAndAContainer.innerHTML = ""; // Clear previous Q&A
            data.Questions_and_answers.forEach((qAndA) => {
                const qAElement = document.createElement("div");
                qAElement.innerHTML = `<strong>คำถาม:</strong> ${qAndA.question}<br/><strong>คำตอบ:</strong> ${qAndA.answer}<br/><br/>`;
                qAContainer.appendChild(qAElement);
            });

            // แสดงหมายเหตุและการอ้างอิง
            document.getElementById("note").innerText = `Note: ${data.note}`;
            document.getElementById("refer").innerText = `Refer: ${data.refer}`;
        } else {
            const errorData = await response.json();
            alert(errorData.error); // แสดงข้อความผิดพลาด
        }
    }

    function showPDFPreview() {
        const pdfContent = `
        ข้อมูลที่ค้นหาได้:
        Chapter: ${document.getElementById("chapter_display").innerText}
        No: ${document.getElementById("no_display").innerText}
        Study Time: ${document.getElementById("study_time").innerText}
        Indicators: ${document.getElementById("indicators").innerText}
        Expected Learning Outcomes: ${document.getElementById("expected_learning_outcomes").innerText}
        Content: ${document.getElementById("content").innerText}
        Activity: ${document.getElementById("activity").innerText}
        Learning Resources: ${document.getElementById("learning_resources").innerText}
        Questions and Answers: 
        ${Array.from(document.getElementById("questions_and_answers").children)
            .map(qA => `${qA.querySelector('strong').innerText} ${qA.querySelector('strong + strong').innerText}`)
            .join('\n')}
        Note: ${document.getElementById("note").innerText}
        Refer: ${document.getElementById("refer").innerText}
        `;

        const pdfWindow = window.open("", "_blank");
        pdfWindow.document.write(`
            <html>
            <head>
                <title>ตัวอย่าง PDF</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                </style>
            </head>
            <body>
                <h1>ตัวอย่าง PDF</h1>
                <pre>${pdfContent}</pre>
                <button onclick="window.print();">พิมพ์ PDF</button>
                <button onclick="downloadPDF();">ดาวน์โหลด PDF</button>
                <button onclick="window.close();">ปิด</button>
            </body>
            </html>
        `);
        pdfWindow.document.close();
    }

    function downloadPDF() {
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF();

        // เพิ่มข้อมูลใน PDF
        doc.text("ข้อมูลที่ค้นหาได้", 10, 10);
        doc.text(`Chapter: ${document.getElementById("chapter_display").innerText}`, 10, 20);
        doc.text(`No: ${document.getElementById("no_display").innerText}`, 10, 30);
        doc.text(`Study Time: ${document.getElementById("study_time").innerText}`, 10, 40);
        doc.text(`Indicators: ${document.getElementById("indicators").innerText}`, 10, 50);
        doc.text(`Expected Learning Outcomes: ${document.getElementById("expected_learning_outcomes").innerText}`, 10, 60);
        doc.text(`Content: ${document.getElementById("content").innerText}`, 10, 70);
        doc.text(`Activity: ${document.getElementById("activity").innerText}`, 10, 80);
        doc.text(`Learning Resources: ${document.getElementById("learning_resources").innerText}`, 10, 90);

        // เพิ่ม Questions and Answers
        const qAndAContainer = document.getElementById("questions_and_answers");
        const qAndAElements = Array.from(qAndAContainer.children);
        let y = 100; // ตำแหน่ง Y เริ่มต้น

        qAndAElements.forEach((qA) => {
            doc.text(`คำถาม: ${qA.querySelector('strong').nextSibling.textContent.trim()}`, 10, y);
            doc.text(`คำตอบ: ${qA.querySelector('strong + strong').nextSibling.textContent.trim()}`, 10, y + 10);
            y += 20; // เพิ่มตำแหน่ง Y สำหรับ Q&A ถัดไป
        });

        // บันทึก PDF
        doc.save("ข้อมูล.pdf");
    }
</script>