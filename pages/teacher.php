<?php include '../includes/header.php'; ?>

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




        
            }
            ?>
        </section>
    </main>
</div>

<?php include '../includes/footer.php'; ?>