function updateAnswer() {
    const answerId = document.getElementById("answer-id").value;
    const answerText = document.getElementById("answer-text").value;
    const answerScore = document.getElementById("answer-score").value;

    const payload = {
        answer_text: answerText,
        score: answerScore,
    };

    fetch(`sql/update_answer.php?answer_id=${answerId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload),
    })
    .then((response) => {
        if (response.ok) {
            alert("อัปเดตคำตอบเรียบร้อยแล้ว");
            closeModal();
            location.reload(); // ทำการรีเฟรชหน้าเพื่อดูการเปลี่ยนแปลง
        } else {
            alert("เกิดข้อผิดพลาดในการอัปเดตคำตอบ");
        }
    })
    .catch((error) => {
        console.error("Error updating answer:", error);
    });
}


