<?php
include '../includes/header.php';



?>

<div class="container w-full ml-10">
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
                case 'ai_analysis':
                    include "../pages/AI/ai_analysis/ai_analysis.php";
                    break;




                case 'add_event':
                    include "../pages/dashboard/calendar/add_event.php";
                    break;
                case 'get_event':
                    include "../pages/dashboard/calendar/get_event.php";
                    break;
                case 'fetch_data':
                    include "../pages/dashboard/calendar/fetch_data.php";
                    break;


                case 'modals.php':
                    include "../pages/borrowing/modal/modals.php";
                    break;
                case 'borrowing':
                    include "../pages/borrowing";
                    break;

                    // ระบบสมัครเรียนใหม่
                case 'New_student_registration_system':
                    include "../pages/register/New_student_registration_system.php";
                    break;
                case 'view_register.php':
                    include "../mpdf/pdf_register/view_register.php";
                    break;
                case 'view_detail':
                    include "../pages/register/view_detail.php";
                    break;
                case 'insert_student':
                    include "../pages/register/insert_student.php";
                    break;
                case 'Canceled_registration':
                    include "../pages/register/Canceled_registration.php";
                    break;
                case 'cancel_registration':
                    include "../pages/register/cancel_registration.php";
                    break;
                case 'equipment_pdf.php':
                    include "../mpdf/equipment/equipment_pdf.php";
                    break;

                case 'Budget_for_borrowing':
                    include "../pages/borrowing/Budget/Budget_for_borrowing.php";
                    break;
                case 'Budget_for_pdf.php':
                    include "../mpdf/equipment/Budget_for_pdf.php";
                    break;


                case 'add_item':
                    include "../pages/borrowing/Equipment/add_item.php";
                    break;
                case 'edit_item':
                    include "../pages/borrowing/Equipment/edit_item.php";
                    break;
                case 'update_item':
                    include "../pages/borrowing/Equipment/sql/update_item.php";
                    break;
                case 'delete_item':
                    include "../pages/borrowing/Equipment/delete_item.php";
                    break;



                case 'System_for_borrowing':
                    include "../pages/borrowing/system/System_for_borrowing.php";
                    break;
                case 'BorrowingDetails':
                    include "../pages/borrowing/system/BorrowingDetails.php";
                    break;
                case 'Borrow_equipment':
                    include "../pages/borrowing/system/Borrow_equipment.php";
                    break;
                case 'Return_equipment':
                    include "../pages/borrowing/Return_equipment.php";
                    break;
                case 'Remaining_quantity':
                    include "../pages/borrowing/Remaining_quantity.php";
                    break;

                case 'Borrow_Office_Supplies':
                    include "../pages/borrowing/OfficeSupplies/Borrow_Office_Supplies.php";
                    break;
                case 'borrow_action':
                    include "../pages/borrowing/OfficeSupplies/borrow_action.php";
                    break;
                case 'edit_borrowing':
                    include "../pages/borrowing/OfficeSupplies/edit_borrowing.php";
                    break;
                case 'delete_borrowing':
                    include "../pages/borrowing/OfficeSupplies/delete_borrowing.php";
                    break;
                case 'add_borrowing':
                    include "../pages/borrowing/OfficeSupplies/add_borrowing.php";
                    break;


                case 'borrowing_Borrow_history':
                    include "../pages/borrowing/History/borrowing_Borrow_history.php";
                    break;
                case 'History_Report.php':
                    include "../mpdf/History/History_Report.php";
                    break;




                case 'equipment_management':
                    include "../pages/borrowing/equipment_management.php";
                    break;
                case 'export_items.php':
                    include "../exports/export_items.php";
                    break;



                case 'Statistics_and_reports':
                    include "../pages/Statistics/Statistics_and_reports.php";
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


                case 'ManageBook':
                    include "../pages/Book/ManageBook.php";
                    break;
                case 'delete':
                    include "../pages/Book/delete.php";
                    break;


                case 'ShowBook':
                    include "../pages/Book/ShowBook.php";
                    break;
            }
            ?>
        </section>
    </main>
</div>

<?php include '../includes/footer.php'; ?>