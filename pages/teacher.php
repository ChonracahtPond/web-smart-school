<?php include '../includes/header.php'; ?>

<div class=" w-full ml-2">
    <!-- Main Content -->
    <main class="flex-1 p-4">
        <section class="content">
            <?php
            // รับค่าพารามิเตอร์ URL
            $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

            // ใช้ switch-case ในการแสดงเนื้อหาต่างๆ
            switch ($page) {
                case 'dashboard':
                    include "../pages/dashboard/dashboard.php";
                    break;
                case 'HomeRoom':
                    include "../pages/HomeRoom";
                    break;
                case 'Home_Room':
                    include "../pages/HomeRoom/Home_Room.php";
                    break;
                case 'Room':
                    include "../pages/HomeRoom/Room.php";
                    break;
                case 'app.js':
                    include "../pages/HomeRoom/app.js";
                    break;
                case 'meeting_room':
                    include "../pages/HomeRoom/meeting_room.php";
                    break;



                case 'your_classroom':
                    include "../pages/Classroom/your_classroom/your_classroom.php";
                    break;
                case 'detali_classroom':
                    include "../pages/Classroom/your_classroom/detali_classroom.php";
                    break;
                case 'lesson_detail':
                    include "../pages/Classroom/your_classroom/lesson_detail.php";
                    break;

                case 'add_lesson':
                    include "../pages/Classroom/your_classroom/sql/add_lesson.php";
                    break;
                case 'delete_lesson':
                    include "../pages/Classroom/your_classroom/sql/delete_lesson.php";
                    break;

                case 'add_onlinemeeting':
                    include "../pages/Classroom/your_classroom/sql/add_onlinemeeting.php";
                    break;
                case 'delete_meeting':
                    include "../pages/Classroom/your_classroom/sql/delete_meeting.php";
                    break;
                    
                case 'add_assignments':
                    include "../pages/Classroom/your_classroom/sql/add_assignments.php";
                    break;
                case 'delete_assignment':
                    include "../pages/Classroom/your_classroom/sql/delete_assignment.php";
                    break;

                case 'add_documents':
                    include "../pages/Classroom/your_classroom/sql/add_documents.php";
                    break;
                case 'delete_document':
                    include "../pages/Classroom/your_classroom/sql/delete_document.php";
                    break;














                case 'Teacher_Manage':
                    include "../pages/teacher/Management/Teacher_Manage.php";
                    break;
                case 'process_teacher':
                    include "../pages/teacher/Management/process_teacher.php";
                    break;
                case 'update_teacher':
                    include "../pages/teacher/Management/update_teacher.php";
                    break;
                case 'delete_teacher':
                    include "../pages/teacher/Management/delete_teacher.php";
                    break;

                case 'reset_password':
                    include "../pages/teacher/resetpassword/reset_password.php";
                    break;
                case 'update_password':
                    include "../pages/teacher/resetpassword/update_password.php";
                    break;



                case 'Lesson_plan':
                    include "../pages/Lesson/Lesson_plan/Lesson_plan.php";
                    break;






                    // -------------------------

                    // add_questions

                case 'add_exercise':
                    include "../pages/exercise/add_exercise.php";
                    break;
                case 'show_exam':
                    include "../pages/exercise/show_exam.php";
                    break;
                case 'get_question_details':
                    include "../pages/exercise/sql/get_question_details.php";
                    break;
                case 'update_answer':
                    include "../pages/exercise/sql/update_answer.php";
                    break;


                case 'exercise':
                    include "../pages/exercise/";
                    break;
            }
            ?>
        </section>
    </main>
</div>

<?php include '../includes/footer.php'; ?>