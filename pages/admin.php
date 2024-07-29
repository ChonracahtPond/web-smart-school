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
                    include "../pages/dashboard.php";
                    break;

                case 'ManageUsers':
                    include "../pages/Users/ManageUsers.php";
                    break;

                case 'add_user':
                    include "../pages/Users/add_user.php";
                    break;

                case 'edit_user':
                    include "../pages/Users/edit_user.php";
                    break;

                case 'delete_user':
                    include "../pages/Users/delete_user.php";
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
                    include "../pages/Activities/Manage_Credits.php";
                    break;
                case 'update_credits':
                    include "../pages/Activities/update_credits.php";
                    break;
                case 'delete_participant':
                    include "../pages/Activities/delete_participant.php";
                    break;




                case 'products':
                    include "../pages/products.php";
                    break;

                case 'orders':
                    include "../pages/orders.php";
                    break;

                case 'recent-activities':
                    include "../pages/recent-activities.php";
                    break;

                default:
                    include "../pages/dashboard.php";
                    break;
            }
            ?>
        </section>
    </main>
</div>

<?php include '../includes/footer.php'; ?>