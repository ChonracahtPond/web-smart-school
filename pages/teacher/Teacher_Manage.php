<div class="flex h-screen">
    <!-- Sidebar code here -->

    <main class="flex-1 p-6">
        <h1 class="text-2xl font-semibold mb-4">Teacher Management</h1>

        <!-- Add New Teacher Form -->
        <section class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Add New Teacher</h2>
            <form id="add-teacher-form" method="POST" action="process_teacher.php">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="fname" class="block mb-2 text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" id="fname" name="fname" class="form-input" required>
                    </div>
                    <div>
                        <label for="lname" class="block mb-2 text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" id="lname" name="lname" class="form-input" required>
                    </div>
                    <div>
                        <label for="rank" class="block mb-2 text-sm font-medium text-gray-700">Rank</label>
                        <input type="text" id="rank" name="rank" class="form-input">
                    </div>
                    <div>
                        <label for="position" class="block mb-2 text-sm font-medium text-gray-700">Position</label>
                        <input type="text" id="position" name="position" class="form-input">
                    </div>
                    <div>
                        <label for="address" class="block mb-2 text-sm font-medium text-gray-700">Address</label>
                        <input type="text" id="address" name="address" class="form-input">
                    </div>
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" class="form-input">
                    </div>
                    <div>
                        <label for="username" class="block mb-2 text-sm font-medium text-gray-700">Username</label>
                        <input type="text" id="username" name="username" class="form-input">
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password" class="form-input">
                    </div>
                    <div>
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" id="phone" name="phone" class="form-input">
                    </div>
                    <div>
                        <label for="gender" class="block mb-2 text-sm font-medium text-gray-700">Gender</label>
                        <select id="gender" name="gender" class="form-select">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label for="teacher_name" class="block mb-2 text-sm font-medium text-gray-700">Teacher Name</label>
                        <input type="text" id="teacher_name" name="teacher_name" class="form-input">
                    </div>
                    <div>
                        <label for="images" class="block mb-2 text-sm font-medium text-gray-700">Images URL</label>
                        <input type="text" id="images" name="images" class="form-input">
                    </div>
                </div>
                <button type="submit" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded">Add Teacher</button>
            </form>
        </section>
        <!-- Search Form -->
        <form method="GET" action="Teacher_Manage.php" class="mb-4">
            <div class="flex items-center">
                <input type="text" name="search" class="form-input" placeholder="Search by name...">
                <button type="submit" class="ml-2 bg-blue-500 text-white py-2 px-4 rounded">Search</button>
            </div>
        </form>

        <!-- Teacher List -->
        <section>
            <h2 class="text-xl font-semibold mb-2">Teacher List</h2>
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">First Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- This part should be generated by PHP dynamically -->
                    <!-- Example of a single row -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">John</td>
                        <td class="px-6 py-4 whitespace-nowrap">Doe</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="edit_teacher.php?id=1" class="text-blue-600 hover:text-blue-900">Edit</a>
                            <a href="delete_teacher.php?id=1" class="text-red-600 hover:text-red-900 ml-4">Delete</a>
                        </td>
                    </tr>
                    <!-- End of single row example -->
                </tbody>
            </table>
        </section>
    </main>
</div>

<script src="https://unpkg.com/alpinejs@3.10.5" defer></script>