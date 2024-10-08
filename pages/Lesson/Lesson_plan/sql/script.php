<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

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

            // แสดงข้อมูลในตาราง
            document.getElementById("chapter_display").innerText = data.Chapter;
            document.getElementById("indicators").innerText = data.Indicators.join(", ");
            document.getElementById("expected_learning_outcomes").innerText = data.Expected_learning_outcomes.join(", ");
            document.getElementById("content").innerText = data.content.join(", ");
            document.getElementById("study_time").innerText = data.Study_time;

            // แสดงข้อมูลอื่นๆ
            document.getElementById("no_display").innerText = data.No;
            document.getElementById("activity").innerText = data.activity.join(", ");
            document.getElementById("learning_resources").innerText = data.Learning_resources.join(", ");
            document.getElementById("note").innerText = data.note;
            document.getElementById("refer").innerText = data.refer;

            // แสดงคำถามและคำตอบ
            const qAndAContainer = document.getElementById("questions_and_answers");
            qAndAContainer.innerHTML = ""; // Clear previous Q&A
            data.Questions_and_answers.forEach((qAndA) => {
                const qAElement = document.createElement("div");
                qAElement.innerHTML = `<strong>คำถาม:</strong> ${qAndA.question}<br/><strong>คำตอบ:</strong> ${qAndA.answer}<br/><br/>`;
                qAndAContainer.appendChild(qAElement);
            });

            // แสดงปุ่ม PDF และตาราง
            document.getElementById("pdfPreviewButton").classList.remove('hidden');
            document.getElementById("dataTable").classList.remove('hidden');

            // แสดงเนื้อหาที่ค้นพบ
            document.getElementById("searchResultsHeader").classList.remove('hidden');
            document.getElementById("no_display").classList.remove('hidden');
            document.getElementById("activity").classList.remove('hidden');
            document.getElementById("learning_resources").classList.remove('hidden');
            document.getElementById("questionsHeader").classList.remove('hidden');
            document.getElementById("questions_and_answers").classList.remove('hidden');
            document.getElementById("noteHeader").classList.remove('hidden');
            document.getElementById("note").classList.remove('hidden');
            document.getElementById("referHeader").classList.remove('hidden');
            document.getElementById("refer").classList.remove('hidden');

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