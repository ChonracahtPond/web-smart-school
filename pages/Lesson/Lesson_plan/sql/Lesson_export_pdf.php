<script>
    function showPDFPreview() {
        const chapterDisplay = document.getElementById("chapter_display").innerText;
        const noDisplay = document.getElementById("no_display").innerText;
        const studyTime = document.getElementById("study_time").innerText;
        const indicators = document.getElementById("indicators").innerText;
        const expectedLearningOutcomes = document.getElementById("expected_learning_outcomes").innerText;
        const content = document.getElementById("content").innerText;
        const activity = document.getElementById("activity").innerText;
        const learningResources = document.getElementById("learning_resources").innerText;

        // Get Q&A and reformat it for the preview
        const questionsAndAnswers = Array.from(document.getElementById("questions_and_answers").children)
            .map(qA => qA.innerText.replace(/\n/g, ' ')).join('\n');

        const note = document.getElementById("note").innerText;
        const refer = document.getElementById("refer").innerText;

        // ข้อมูลที่จะนำไปใส่ใน PDF
        const pdfContent = `
        ข้อมูลที่ค้นหาได้:
        Chapter: ${chapterDisplay}
        No: ${noDisplay}
        Study Time: ${studyTime}
        Indicators: ${indicators}
        Expected Learning Outcomes: ${expectedLearningOutcomes}
        Content: ${content}
        Activity: ${activity}
        Learning Resources: ${learningResources}
        Questions and Answers: ${questionsAndAnswers}
        Note: ${note}
        Refer: ${refer}
        `;

        // สร้างหน้าต่างใหม่สำหรับแสดงตัวอย่าง PDF
        const pdfWindow = window.open("", "_blank");
        pdfWindow.document.write(`
            <html>
            <head>
                <title>ตัวอย่าง PDF</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; background-color: #f8f9fa; color: #343a40; }
                    h1 { color: #007bff; text-align: center; }
                    pre { white-space: pre-wrap; background-color: #e9ecef; padding: 15px; border-radius: 5px; border: 1px solid #ced4da; }
                    button {
                        background-color: #007bff;
                        color: white;
                        border: none;
                        border-radius: 5px;
                        padding: 10px 15px;
                        cursor: pointer;
                        margin: 10px;
                        transition: background-color 0.3s;
                    }
                    button:hover {
                        background-color: #0056b3;
                    }
                </style>
            </head>
            <body>
                <h1>ตัวอย่าง PDF</h1>
                <pre>${pdfContent}</pre>
                <div style="text-align: center;">
                    <button onclick="window.print();">พิมพ์ PDF</button>
                    <button onclick="downloadPDF();">ดาวน์โหลด PDF</button>
                    <button onclick="window.close();">ปิด</button>
                </div>
            </body>
            </html>
        `);
        pdfWindow.document.close();
    }
</script>