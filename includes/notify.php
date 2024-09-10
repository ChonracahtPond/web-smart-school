<?php

$notifications = [];
// Updated query to get all new registrations (not limited to today)
$query = "SELECT COUNT(*) as new_registrations FROM register WHERE status_register = 0";
$result = $conn->query($query);

if ($result) {
    $row = $result->fetch_assoc();
    if ($row['new_registrations'] > 0) {
        $notifications[] = [
            'title' => 'การลงทะเบียนใหม่',
            'description' => 'มีนักเรียนลงทะเบียนใหม่ ' . $row['new_registrations'] . ' คน',
            // 'date' => date('Y-m-d') // Uncomment if you want to include the date
        ];
    }
    $result->free();
} else {
    die("Query failed: " . $conn->error);
}

// Default message when no notifications are found
$no_notifications_message = "ไม่มีการแจ้งเตือนใหม่";
?>

<style>
    /* Dropdown for notifications */
    .notification-dropdown {
        display: none;
        position: absolute;
        right: 0;
        z-index: 10;
        background-color: white;
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .notification-dropdown.active {
        display: block;
    }

    .notification-item:hover {
        background-color: #f9fafb;
    }

    /* Add cursor pointer to notification button */
    #notification-button {
        cursor: pointer;
    }
</style>

<div class="mx-auto py-10 px-4">
    <div class="relative inline-block text-left">
        <!-- Notification Bell Icon -->
        <button id="notification-button" class="flex items-center space-x-2">
            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <!-- Notification Count Badge -->
            <?php if (!empty($notifications)): ?>
                <span class="absolute top-0 left-1 -mt-3 -mr-3 w-5 h-5 bg-red-600 text-white text-xs font-bold rounded-full flex items-center justify-center">
                    <?php echo count($notifications); ?>
                </span>
                <span class="hover:underline ml-2">แจ้งเตือน</span>
            <?php endif; ?>
        </button>

        <!-- Notification Dropdown -->
        <div id="notification-dropdown" class="notification-dropdown w-64 mt-2 rounded-md shadow-lg">

            <div class="bg-white p-5 rounded-md">
                <h1 class="text-1xl font-semibold text-gray-600 text-right mb-1 p-2">รายการแจ้งเตือน</h1>
                <?php if (!empty($notifications)): ?>
                    <ul class="space-y-4">
                        <?php foreach ($notifications as $notification): ?>
                            <li class="notification-item border-b border-gray-300 pb-2">
                                <a href="system.php?page=New_student_registration_system" class="block">
                                    <h2 class="text-md font-semibold text-gray-800"><?php echo htmlspecialchars($notification['title']); ?></h2>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($notification['description']); ?></p>
                                    <!-- <span class="text-xs text-gray-500"><?php echo htmlspecialchars($notification['date']); ?></span> -->
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-center text-gray-500"><?php echo $no_notifications_message; ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle the notification dropdown
    const notificationButton = document.getElementById('notification-button');
    const notificationDropdown = document.getElementById('notification-dropdown');

    notificationButton.addEventListener('click', () => {
        notificationDropdown.classList.toggle('active');
    });

    // Close the dropdown if clicked outside
    document.addEventListener('click', (event) => {
        if (!notificationButton.contains(event.target) && !notificationDropdown.contains(event.target)) {
            notificationDropdown.classList.remove('active');
        }
    });
</script>