<?php include '../includes/header.php'; ?>

<div class="container w-full ml-10 ">
    <!-- Main Content -->
    <main class="flex-1 p-4">
        <section class="content">
            <?php
            // รับค่าพารามิเตอร์ URL
            $page = isset($_GET['page']) ? $_GET['page'] : 'student_dashboard';

            // ใช้ switch-case ในการแสดงเนื้อหาต่างๆ
            switch ($page) {
                case 'student_dashboard':
                    include "../pages/student/dashboard/student_dashboard.php";
                    break;

                case 'students_courses':
                    include "../pages/student/students_courses/students_courses.php";
                    break;



                    // จัดการกับข้อมูลนักเรียน
                case 'Manage_student':
                    include "../pages/student/Management/Manage_student.php";
                    break;
                case 'view_student':
                    include "../pages/student/Management/view_student.php";
                    break;
                case 'add_student':
                    include "../pages/student/Management/add_student.php";
                    break;
                case 'edit_user':
                    include "../pages/student/Management/edit_student.php";
                    break;
                case 'delete_user':
                    include "../pages/student/Management/delete_student.php";
                    break;
                case 'view_register.php':
                    include "../mpdf/pdf_register/view_register.php";
                    break;

                    // จัดการเกรด
                case 'StudentGrade':
                    include "../pages/Users/Grade/StudentGrade.php";
                    break;
                case 'GradeList':
                    include "../pages/Users/Grade/GradeList.php";
                    break;

                    // จัดการหน่วยกิจ
                case 'Studentcredit':
                    include "../pages/Users/credit/Studentcredit.php";
                    break;
                case 'creditList':
                    include "../pages/Users/credit/creditList.php";
                    break;

                    // ขาดลามาสาย
                case 'manage_attendance':
                    include "../pages/Users/attendance/manage_attendance.php";
                    break;
                    // ขาดลามาสาย pdf
                case 'attendance_pdf':
                    include "../mpdf/attendance_pdf.php";
                    break;










                case 'manage_access_rights':
                    include "../pages/Users/manage_access_rights.php";
                    break;
                case 'add_access_right':
                    include "../pages/Users/add_access_right.php";
                    break;
                case 'reset_password':
                    include "../pages/Users/reset_password.php";
                    break;

                case 'Manage_Activity':
                    include "../pages/Activities/Manage_Activity.php";
                    break;
                case 'add_activity':
                    include "../pages/Activities/add_activity.php";
                    break;
                case 'edit_activity':
                    include "../pages/Activities/edit_activity.php";
                    break;
                case 'delete_activity':
                    include "../pages/Activities/delete_activity.php";
                    break;

                case 'Manage_Credits':
                    include "../pages/Activities/Credits/Manage_Credits.php";
                    break;
                case 'update_credits':
                    include "../pages/Activities/Credits/update_credits.php";
                    break;
                case 'add_participant':
                    include "../pages/Activities/add_participant.php";
                    break;
                case 'delete_participant':
                    include "../pages/Activities/delete_participant.php";
                    break;


                 // เช็คกิจกรรม
                 case 'Check_Manage_Credits':
                 include "../pages/Check_Manage_Credits/Check_Manage_Credits.php";
                 break;



                case 'Reports_and_statistics':
                    include "../pages/Activities/Reports_and_statistics.php";
                    break;


                case 'Manage_courses':
                    include "../pages/courses/Manage_courses.php";
                    break;
                case 'add_course':
                    include "../pages/courses/add_course.php";
                    break;
                case 'edit_course':
                    include "../pages/courses/edit_course.php";
                    break;
                case 'delete_course':
                    include "../pages/courses/delete_course.php";
                    break;

                case 'Manage_enrollments':
                    include "../pages/courses/Manage_enrollments.php";
                    break;
                case 'add_enrollment':
                    include "../pages/courses/add_enrollment.php";
                    break;
                case 'edit_enrollment':
                    include "../pages/courses/edit_enrollment.php";
                    break;
                case 'delete_enrollment':
                    include "../pages/courses/delete_enrollment.php";
                    break;




                case 'equipment_management':
                    include "../pages/borrowing/equipment_management.php";
                    break;

                case 'add_item':
                    include "../pages/borrowing/add_item.php";
                    break;
                case 'edit_item':
                    include "../pages/borrowing/edit_item.php";
                    break;
                case 'delete_item':
                    include "../pages/borrowing/delete_item.php";
                    break;

                case 'System_for_borrowing':
                    include "../pages/borrowing/System_for_borrowing.php";
                    break;
                case 'Borrow_equipment':
                    include "../pages/borrowing/Borrow_equipment.php";
                    break;
                case 'Return_equipment':
                    include "../pages/borrowing/Return_equipment.php";
                    break;
                case 'Remaining_quantity':
                    include "../pages/borrowing/Remaining_quantity.php";
                    break;

                case 'Borrow_Office_Supplies':
                    include "../pages/borrowing/Borrow_Office_Supplies.php";
                    break;
                case 'borrow_action':
                    include "../pages/borrowing/borrow_action.php";
                    break;
                case 'edit_borrowing':
                    include "../pages/borrowing/edit_borrowing.php";
                    break;
                case 'delete_borrowing':
                    include "../pages/borrowing/delete_borrowing.php";
                    break;
                case 'add_borrowing':
                    include "../pages/borrowing/add_borrowing.php";
                    break;

                case 'teacher':
                    include "teacher.php";
                    break;
                case 'student':
                    include "student.php";
                    break;

                case 'Manage_evaluations':
                    include "../pages/evaluations/Manage_evaluations.php";
                    break;

                case 'student_details':
                    include "../pages/student/student_details/student_details.php";
                    break;

                case 'students_eligible_for_exam':
                    include "../pages/student/students_eligible/students_eligible_for_exam.php";
                    break;
                case 'add_students_eligible_for_exam':
                    include "../pages/student/students_eligible/add_students_eligible_for_exam.php";
                    break;
                case 'edit_students_eligible_for_exam':
                    include "../pages/student/students_eligible/edit_students_eligible_for_exam.php";
                    break;
                case 'update_students_eligible_for_exam':
                    include "../pages/student/students_eligible/update_students_eligible_for_exam.php";
                    break;
                case 'delete_students_eligible_for_exam':
                    include "../pages/student/students_eligible/delete_students_eligible_for_exam.php";
                    break;







                case 'generate_pdf':
                    include "../mpdf/generate_pdf.php";
                    break;




                case 'Exercises':
                    include "test/Exercises.php";
                    break;
                case 'add_exercise':
                    include "test/add_exercise.php";
                    break;
                case 'edit_exercise':
                    include "test/edit_exercise.php";
                    break;
                case 'add_questions':
                    include "test/add_questions.php";
                    break;
                case 'manage_questions':
                    include "test/manage_questions.php";
                    break;

                case 'Questions':
                    include "test/Questions.php";
                    break;
                case 'add_question':
                    include "test/add_question.php";
                    break;
                case 'edit_question':
                    include "test/edit_question.php";
                    break;
                case 'delete_question':
                    include "test/delete_question.php";
                    break;

                case 'manage_answers':
                    include "test/manage_answers.php";
                    break;
                case 'add_answer':
                    include "test/add_answer.php";
                    break;


                case 'ManageBook':
                    include "../pages/Book/ManageBook.php";
                    break;
            }
            ?>
        </section>
    </main>
</div>

<?php include '../includes/footer.php'; ?>