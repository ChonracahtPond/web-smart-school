function loadQuestionDetails(questionId) {
  // ส่ง AJAX request ไปยัง server เพื่อดึงข้อมูลของคำถามที่ถูกเลือก
  fetch(`../pages/exercise/sql/get_question_details.php?question_id=${questionId}`)
    .then((response) => response.json())
    .then((data) => {
      // แสดงข้อมูลในพื้นที่ว่างทางด้านขวา
      const detailsDiv = document.getElementById("question-details");
      detailsDiv.innerHTML = `
          <div class="p-5 bg-white shadow-md rounded-lg">
            <h2 class='text-xl font-semibold text-gray-800'>${data.question.question_text}</h2>
            <p class='text-gray-600'>ประเภทคำถาม: <span class="font-medium">${data.question.question_type}</span></p>
            <p class='text-gray-600'>คะแนน: <span class="font-medium">${data.question.score}</span></p>
            <p class='text-gray-600'>สร้างเมื่อ: <span class="font-medium">${data.question.created_at}</span></p>
            <p class='text-gray-600'>อัปเดตเมื่อ: <span class="font-medium">${data.question.updated_at}</span></p>
  
            <div class="mt-4">
              <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="editQuestion(${data.question.question_id})">แก้ไขคำถาม</button>
              <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 ml-2" onclick="deleteQuestion(${data.question.question_id})">ลบคำถาม</button>
            </div>
  
            <h3 class='text-lg font-semibold mt-4 text-gray-800'>คำตอบ:</h3>
            <ul class='list-disc ml-5'>
        `;

      // แสดงคำตอบ
      data.answers.forEach((answer) => {
        detailsDiv.innerHTML += `
            <li class="text-gray-700 mt-1">
              ${answer.answer_text} - <span class="${
          answer.is_correct
            ? "text-green-600 font-bold"
            : "text-red-600 font-bold"
        }">${answer.is_correct ? "ถูกต้อง" : "ไม่ถูกต้อง"}</span>
              (คะแนน: <span class="font-medium">${answer.score}</span>)
              <button class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600 ml-2" 
                onclick="openModal(${answer.answer_id}, '${
          answer.answer_text
        }', ${answer.score}, ${answer.is_correct})">แก้ไขคำตอบ</button>
              <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 ml-2" 
                onclick="deleteAnswer(${answer.answer_id})">ลบ</button>
            </li>
          `;
      });
      detailsDiv.innerHTML += "</ul>"; // ปิด tag <ul>
      detailsDiv.innerHTML += "</div>"; // ปิด div สำหรับรายละเอียด
    })
    .catch((error) => {
      console.error("Error fetching question details:", error);
    });
}



