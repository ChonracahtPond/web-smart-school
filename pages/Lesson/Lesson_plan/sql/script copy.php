<script>
    function showNoContentModal() {
        document.getElementById('noContentModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('noContentModal').classList.add('hidden');
    }

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
                qAndAContainer.appendChild(qAElement);
            });

            // แสดงหมายเหตุและการอ้างอิง
            document.getElementById("note").innerText = `Note: ${data.note}`;
            document.getElementById("refer").innerText = `Refer: ${data.refer}`;
        } else {
            const errorData = await response.json();
            if (errorData.error === 'no_content') {
                showNoContentModal(); // แสดง modal ถ้าไม่มีข้อมูล
            } else {
                alert(errorData.error); // แสดงข้อความผิดพลาดถ้ามี
            }
        }
    }
</script>
