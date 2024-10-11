// // ฟังก์ชันสำหรับการบันทึกข้อมูลที่แก้ไข
// document
//   .getElementById("editAnswerForm")
//   .addEventListener("submit", function (e) {
//     e.preventDefault();

//     const answerId = document.getElementById("editAnswerId").value;
//     const answerText = document.getElementById("answerText").value;
//     const answerScore = document.getElementById("answerScore").value;
//     const isCorrect = document.getElementById("isCorrect").value;

//     // ส่งข้อมูลไปยัง server เพื่อบันทึกการแก้ไข
//     fetch("../sql/update_answer.php", {
//       method: "POST",
//       headers: {
//         "Content-Type": "application/json",
//       },
//       body: JSON.stringify({
//         answer_id: answerId,
//         answer_text: answerText,
//         score: answerScore,
//         is_correct: isCorrect,
//       }),
//     })
//       .then((response) => response.json())
//       .then((data) => {
//         if (data.success) {
//           // ปิด modal และรีเฟรชข้อมูล
//           closeModal();
//           loadQuestionDetails(data.question_id); // โหลดข้อมูลคำถามใหม่
//         } else {
//           console.error("Error updating answer:", data.error);
//         }
//       })
//       .catch((error) => {
//         console.error("Error:", error);
//       });
//   });
