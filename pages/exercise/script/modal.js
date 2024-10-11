// ฟังก์ชันสำหรับเปิด modal และแสดงข้อมูลคำตอบ
function openModal(answerId, answerText, answerScore, isCorrect) {
    document.getElementById("editAnswerId").value = answerId;
    document.getElementById("answerText").value = answerText;
    document.getElementById("answerScore").value = answerScore;
    document.getElementById("isCorrect").value = isCorrect;
  
    // เปิด modal
    document.getElementById("editAnswerModal").classList.remove("hidden");
  }
  
  // ฟังก์ชันสำหรับปิด modal
  function closeModal() {
    document.getElementById("editAnswerModal").classList.add("hidden");
  }