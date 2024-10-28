<script src="../pages/exercise/script/show_exam.js"></script>
<script src="../pages/exercise/script/modal.js"></script>
<script src="../pages/exercise/script/update_answer.js"></script>
<script src="../pages/exercise/script/update_exam.js"></script>


<script>
    function toggleAddQuestionForm() {
        const form = document.getElementById('add-question-form');
        form.classList.toggle('hidden'); // ซ่อน/แสดงฟอร์มเพิ่มคำถาม
        // ทำให้พื้นที่แสดงรายละเอียดคำถามมีความกว้างเต็มที่เมื่อต้องการแสดงฟอร์ม
        const detailsDiv = document.getElementById('question-details');
        detailsDiv.classList.toggle('w-full', form.classList.contains('hidden'));
        detailsDiv.classList.toggle('w-2/3', !form.classList.contains('hidden'));
    }

    document.addEventListener("DOMContentLoaded", function() {
        // ตรวจสอบการทำงานของปุ่มเพิ่มคำถาม
        const addQuestionButton = document.querySelector('.add-question-button');
        addQuestionButton.addEventListener('click', toggleAddQuestionForm);
    });
</script>

<?php include "sql/modal_exam.php"; ?>


<div class="flex space-x-4">
    <div class="bg-white shadow-md rounded-lg h-screen p-4 w-[350px] ">
        <!-- <h1 class="text-2xl font-bold mb-4">รายละเอียดการสอบ</h1> -->

        <?php
        // include "../../includes/db_connect.php";
        $exercise_id = isset($_GET['exercise_id']) ? intval($_GET['exercise_id']) : 0;

        if ($exercise_id <= 0) {
            echo '<form method="GET" action="" class="mb-4">';
            echo '<label for="exercise_id" class="block mb-2">กรุณากรอก exercise_id:</label>';
            echo '<input type="number" id="exercise_id" name="exercise_id" required class="border border-gray-300 p-2 w-full rounded" />';
            echo '<button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 mt-2">แสดงรายละเอียด</button>';
            echo '</form>';
        } else {
            $sql = "SELECT * FROM exercises WHERE exercise_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $exercise_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<h2 class='text-xl font-semibold mb-2'>" . htmlspecialchars($row['title']) . "</h2>";
                    echo "<p class='text-gray-700 mb-4'>คำอธิบาย: " . htmlspecialchars($row['description']) . "</p>";
                }
            } else {
                echo "<p class='text-red-500'>ไม่พบข้อมูลที่เกี่ยวข้องกับ exercise_id นี้.</p>";
            }

            echo "<div class='w-full h-0.5 bg-gray-300 mb-2'></div>";

            // ปุ่มเพิ่มคำถาม
            // echo '<button class="add-question-button bg-green-500 text-white p-2 rounded hover:bg-green-600">เพิ่มคำถาม</button>';
            echo '<button class="add-question-button bg-green-500 text-white p-2 rounded hover:bg-green-600 flex " onclick="location.reload();">
            <svg class="h-5 w-5 my-auto mr-1"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="12" y1="5" x2="12" y2="19" />  <line x1="5" y1="12" x2="19" y2="12" /></svg>
            เพิ่มคำถาม
            </button>';


            // คิวรีข้อมูลจากตาราง questions
            $sqlQuestions = "SELECT * FROM questions WHERE exercise_id = ? ORDER BY question_id ASC";
            $stmtQuestions = $conn->prepare($sqlQuestions);
            $stmtQuestions->bind_param("i", $exercise_id);
            $stmtQuestions->execute();
            $resultQuestions = $stmtQuestions->get_result();

            if ($resultQuestions->num_rows > 0) {
                echo "<h2 class='text-xl font-semibold mt-6'>คำถาม</h2>";
                echo "<ul class='list-decimal pl-5 space-y-2'>";

                while ($questionRow = $resultQuestions->fetch_assoc()) {
                    echo "<li class='bg-gray-50 border border-gray-300 rounded-lg p-3 hover:bg-blue-100 transition cursor-pointer' onclick=\"loadQuestionDetails(" . htmlspecialchars($questionRow['question_id']) . ")\">";
                    echo "<span class='font-semibold'>" . htmlspecialchars($questionRow['question_text']) . "</span>";
                    echo "<span class='text-gray-500 text-sm ml-2'> (คะแนน: " . htmlspecialchars($questionRow['score']) . ")</span>";
                    echo "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p class='text-gray-500 mt-2'>ยังไม่มีคำถามสำหรับแบบทดสอบนี้.</p>";
            }

            // ปิดการเชื่อมต่อ
            $stmtQuestions->close();
            $stmt->close();
        }

        $conn->close();
        ?>
    </div>

    <!-- พื้นที่แสดงรายละเอียดคำถาม -->
    <div id="question-details" class="bg-white shadow-md rounded-lg p-4 flex-1 w-2/3">
        <?php include "add_questions.php"; ?>
    </div>
</div>