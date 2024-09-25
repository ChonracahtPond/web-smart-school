<?php include '../includes/header.php'; ?>

<div class=" w-full ml-2">
    <!-- Main Content -->
    <main class="flex-1 p-5">
        <section class="content ">
            <?php
            // รับค่าพารามิเตอร์ URL
            $page = isset($_GET['page']) ? $_GET['page'] : 'courses_dashboard';

            // ใช้ switch-case ในการแสดงเนื้อหาต่างๆ
            switch ($page) {
                case 'courses_dashboard':
                    include "../pages/courses/dashboard/courses_dashboard.php";
                    break;


                    // -- หน้า ระบบจัดการรายวิชา --//
                case 'Manage_courses':
                    include "../pages/courses/Manage_courses/Manage_courses.php";
                    break;
                case 'course_details_approve':
                    include "../pages/courses/Manage_courses/course_details_approve.php";
                    break;
                case 'course_details':
                    include "../pages/courses/Manage_courses/course_details.php";
                    break;
                case 'add_course':
                    include "../pages/courses/Manage_courses/add_course.php";
                    break;
                case 'edit_course':
                    include "../pages/courses/Manage_courses/edit_course.php";
                    break;
                case 'delete_course':
                    include "../pages/courses/Manage_courses/delete_course.php";
                    break;



                    //     // จัดการหน่วยกิจ
                    // case 'Studentcredit':
                    //     include "../pages/Users/credit/Studentcredit.php";
                    //     break;
                    // case 'creditList':
                    //     include "../pages/Users/credit/creditList.php";
                    //     break;

                    //     // ขาดลามาสาย
                    // case 'manage_attendance':
                    //     include "../pages/Users/attendance/manage_attendance.php";
                    //     break;
                    //     // ขาดลามาสาย pdf
                    // case 'attendance_pdf':
                    //     include "../mpdf/attendance_pdf.php";
                    //     break;



                    // case 'Manage_Activity':
                    //     include "../pages/Activities/Manage_Activity.php";
                    //     break;
                    // case 'add_activity':
                    //     include "../pages/Activities/add_activity.php";
                    //     break;
                    // case 'edit_activity':
                    //     include "../pages/Activities/edit_activity.php";
                    //     break;
                    // case 'delete_activity':
                    //     include "../pages/Activities/delete_activity.php";
                    //     break;

                case 'Manage_Credits':
                    include "../pages/Activities/Manage_Credits.php";
                    break;
                case 'update_credits':
                    include "../pages/Activities/update_credits.php";
                    break;
                case 'add_participant':
                    include "../pages/Activities/add_participant.php";
                    break;
                case 'delete_participant':
                    include "../pages/Activities/delete_participant.php";
                    break;

                case 'Reports_and_statistics':
                    include "../pages/Activities/Reports_and_statistics.php";
                    break;

                    // -- หน้า การจัดการประเมินผล --//
                case 'Evaluation_management':
                    include "../pages/Evaluation/Evaluation_management.php";
                    break;
                case 'edit_Evaluation':
                    include "../pages/Evaluation/edit_Evaluation.php";
                    break;
                case 'delete_Evaluation':
                    include "../pages/Evaluation/delete_Evaluation.php";
                    break;

                    // -- หน้า นักเรียนที่มาสิทธิสอบ --//
                case 'eligible_students':
                    include "../pages/eligible_students/eligible_students.php";
                    break;
                case 'insert_eligible_students':
                    include "../pages/eligible_students/insert_eligible_students.php";
                    break;
                case 'edit_eligible_students':
                    include "../pages/eligible_students/edit_eligible_students.php";
                    break;
                case 'delete_eligible_students':
                    include "../pages/eligible_students/delete_eligible_students.php";
                    break;



                    // -- หน้า จัดการการสอบกลางภาค --//
                case 'Manage_exam_Midterm':
                    include "../pages/exams/Midterm/Manage_exam_Midterm.php";
                    break;
                case 'add_exams_Midterm':
                    include "../pages/exams/Midterm/add_exams_Midterm.php";
                    break;
                case 'delete_exam_Midterm':
                    include "../pages/exams/Midterm/delete_exam_Midterm.php";
                    break;
                case 'edit_exam_Midterm':
                    include "../pages/exams/Midterm/edit_exam_Midterm.php";
                    break;


                    // -- หน้า จัดการการสอบปลายภาค --//
                case 'Manage_exam_Final':
                    include "../pages/exams/Final/Manage_exam_Final.php";
                    break;
                case 'add_exams_Final':
                    include "../pages/exams/Final/add_exams_Final.php";
                    break;
                case 'delete_exam_Final':
                    include "../pages/exams/Final/delete_exam_Final.php";
                    break;
                case 'edit_exam_Final':
                    include "../pages/exams/Final/edit_exam_Final.php";
                    break;
                    // -- หน้า จัดการจบการศึกษา --//
                case 'Graduation_system':
                    include "../pages/Graduation/Graduation_system.php";
                    break;
                case 'add_Graduation_system':
                    include "../pages/Graduation/add_Graduation_system.php";
                    break;
                case 'enrollment_details':
                    include "../pages/courses/Manage_courses/enrollment_details.php";
                    break;

                    // -- หน้า ผลการลงทะเบียน --//
                case 'Student_registration_results':
                    include "../pages/courses/Student_registration_results/Student_registration_results.php";
                    break;
                case 'detail_Student_registration_results':
                    include "../pages/courses/Student_registration_results/detail_Student_registration_results.php";
                    break;


                case 'Manage_academic_results':
                    include "../pages/courses/Manage_academic_results/Manage_academic_results.php";
                    break;
                case 'detail_Manage_academic_results':
                    include "../pages/courses/Manage_academic_results/detail_Manage_academic_results.php";
                    break;



                    // -- หน้า ระบบจัดการผลการเรียน --//
                case 'scores_management':
                    include "../pages/n-net/management/scores_management.php";
                    break;
                case 'add_score':
                    include "../pages/n-net/management/add_score.php";
                    break;
                case 'update_score':
                    include "../pages/n-net/management/update_score.php";
                    break;



















                case 'Manage_enrollments':
                    include "../pages/courses/register/Manage_enrollments.php";
                    break;
                case 'Add_enrollment':
                    include "../pages/courses/register/Add_enrollment.php";
                    break;
                case 'edit_enrollment':
                    include "../pages/courses/register/edit_enrollment.php";
                    break;
                case 'delete_enrollment':
                    include "../pages/courses/register/delete_enrollment.php";
                    break;











                case 'Manage_News':
                    include "../pages/News/Manage_News.php";
                    break;
                case 'add_news':
                    include "../pages/News/add_news.php";
                    break;
                case 'edit_news':
                    include "../pages/News/edit_news.php";
                    break;
                case 'delete_news':
                    include "../pages/News/delete_news.php";
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
                    include "../pages/student/student_details.php";
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



                    // case 'borrow_item':
                    //     include "../pages/borrowing/borrow_item.php";
                    //     break;
                    // case 'return_item':
                    //     include "../pages/borrowing/return_item.php";
                    //     break;


                    // case 'recent-activities':
                    //     include "../pages/recent-activities.php";
                    //     break;

                    // default:
                    //     include "../pages/dashboard.php";
                    //     break;
            }
            ?>
        </section>
    </main>
</div>

<?php include '../includes/footer.php'; ?>