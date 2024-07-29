<?php include '../includes/header.php'; ?>

<div class="container ml-5">
    <!-- Main Content -->
    <main class="flex-1 p-4 ">
        <section class="content">
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">ผู้ดูแลระบบ</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">เนื้อหาสำหรับผู้ดูแลระบบจะอยู่ที่นี่</p>

            <!-- Dashboard Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                <!-- Card 1 -->
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Users</h2>
                    <p class="text-gray-600 dark:text-gray-400">Manage and view all users in the system.</p>
                    <a href="#" class="mt-2 inline-flex items-center text-blue-600 dark:text-blue-400 hover:underline">View Users</a>
                </div>

                <!-- Card 2 -->
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Products</h2>
                    <p class="text-gray-600 dark:text-gray-400">Manage and view all products in the system.</p>
                    <a href="#" class="mt-2 inline-flex items-center text-blue-600 dark:text-blue-400 hover:underline">View Products</a>
                </div>

                <!-- Card 3 -->
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Orders</h2>
                    <p class="text-gray-600 dark:text-gray-400">Manage and view all orders in the system.</p>
                    <a href="#" class="mt-2 inline-flex items-center text-blue-600 dark:text-blue-400 hover:underline">View Orders</a>
                </div>
            </div>

            <!-- Recent Activities Table -->
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Recent Activities</h2>
                <table class="w-full mt-4 border-collapse">
                    <thead>
                        <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                            <th class="px-4 py-2 border-b">Activity</th>
                            <th class="px-4 py-2 border-b">Date</th>
                            <th class="px-4 py-2 border-b">User</th>
                            <th class="px-4 py-2 border-b">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="px-4 py-2 border-b">User signed in</td>
                            <td class="px-4 py-2 border-b">2024-07-29</td>
                            <td class="px-4 py-2 border-b">John Doe</td>
                            <td class="px-4 py-2 border-b text-green-600 dark:text-green-400">Completed</td>
                        </tr>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="px-4 py-2 border-b">New product added</td>
                            <td class="px-4 py-2 border-b">2024-07-28</td>
                            <td class="px-4 py-2 border-b">Jane Smith</td>
                            <td class="px-4 py-2 border-b text-blue-600 dark:text-blue-400">Pending</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>


<?php include '../includes/footer.php'; ?>