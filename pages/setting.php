<?php include '../includes/header.php'; ?>

<div class="container w-full ml-10">
    <!-- Main Content -->
    <main class="flex-1 p-4">
        <section class="content">
            <?php
            // รับค่าพารามิเตอร์ URL
            $page = isset($_GET['page']) ? $_GET['page'] : 'edit_profile';

            // ใช้ switch-case ในการแสดงเนื้อหาต่างๆ
            switch ($page) {
                case 'edit_profile':
                    include "../pages/profile/edit/edit_profile.php";
                    break;

                case 'Manage_Toolbar_setting':
                    include "../pages/setting/Manage_screen_setting/Manage_Toolbar_setting.php";
                    break;
                case 'Manage_screen_setting':
                    include "../pages/setting/Manage_screen_setting/Manage_screen_setting.php";
                    break;
                case 'Manage_Tap_setting':
                    include "../pages/setting/Manage_screen_setting/Manage_Tap_setting.php";
                    break;

                case 'edit_Notification':
                    include "../pages/setting/Notification/edit_Notification.php";
                    break;
            }
            ?>
        </section>
    </main>
</div>

<?php include '../includes/footer.php'; ?>