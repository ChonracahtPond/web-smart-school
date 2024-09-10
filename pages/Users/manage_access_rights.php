<?php
// Check if the connection is established
if (!$conn) {
    die("<div class='container mx-auto p-4 text-red-600 font-bold'>Connection failed: " . mysqli_connect_error() . "</div>");
}

// SQL query to fetch data from the access_rights table along with student full names
$sql = "SELECT ar.status, ar.student_id, ar.role, s.fullname 
        FROM access_rights ar
        JOIN students s ON ar.student_id = s.student_id";

// Execute the query
$result = $conn->query($sql);

// Check for query errors
if (!$result) {
    die("<div class='container mx-auto p-4 text-red-600 font-bold'>Query failed: " . $conn->error . "</div>");
}

// Fetch all students for the dropdown
$studentsSql = "SELECT student_id, fullname FROM students";
$studentsResult = $conn->query($studentsSql);
$students = [];

if ($studentsResult) {
    while ($row = $studentsResult->fetch_assoc()) {
        $students[] = $row;
    }
} else {
    die("<div class='container mx-auto p-4 text-red-600 font-bold'>Error fetching students: " . $conn->error . "</div>");
}
?>


<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-4">นักศึกษาที่จบการศึกษา</h1>

    <!-- Add Button -->
    <button id="openAddAccessRightModal" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300 flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        <span>เพิ่ม นักศึกษาที่จบการศึกษา</span>
    </button>

    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-6">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <th class="px-4 py-2 border-b">Access ID</th>
                    <th class="px-4 py-2 border-b">Student ID</th>
                    <th class="px-4 py-2 border-b">Full Name</th>
                    <th class="px-4 py-2 border-b">Role</th>
                    <th class="px-4 py-2 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['status']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['student_id']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['fullname']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['role']); ?></td>
                            <td class="px-4 py-2 border-b flex space-x-2">
                                <!-- Edit Button -->
                                <a href="edit_access_right.php?id=<?php echo htmlspecialchars($row['status']); ?>" class="text-blue-600 hover:underline transition duration-300 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 9.172a4 4 0 01-5.656 5.656L3 21h3l5.172-5.172a4 4 0 015.656-5.656L21 3h-3l-3.172 3.172z"></path>
                                    </svg>
                                    <span>Edit</span>
                                </a>
                                |
                                <!-- Delete Button -->
                                <a href="delete_access_right.php?id=<?php echo htmlspecialchars($row['status']); ?>" class="text-red-600 hover:underline transition duration-300 flex items-center space-x-1" onclick="return confirm('Are you sure you want to delete this access right?')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 2L6 4H18L18 2M4 6L20 6L20 18C20 19.1 19.1 20 18 20L6 20C4.9 20 4 19.1 4 18L4 6ZM14 11L10 11L10 17L14 17L14 11ZM15 4L15 5H9L9 4H15Z"></path>
                                    </svg>
                                    <span>Delete</span>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-600 dark:text-gray-400">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>





    <!-- Modal Structure -->
    <div id="addAccessRightModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 max-w-lg mx-auto">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">เพิ่มการเข้าถึงสิทธิ์</h2>

            <form action="?page=process_add_access_right" method="POST">
                <!-- Student ID Field -->
                <div class="mb-4">
                    <label for="student_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Student ID</label>
                    <select id="student_id" name="student_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        <option value="" disabled selected>Select Student</option>
                        <?php foreach ($students as $student) : ?>
                            <option value="<?php echo htmlspecialchars($student['student_id']); ?>">
                                <?php echo htmlspecialchars($student['student_id']) . ' - ' . htmlspecialchars($student['fullname']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Role Field -->
                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Role</label>
                    <select id="role" name="role" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        <option value="admin">Admin</option>
                        <option value="editor">Editor</option>
                        <option value="viewer">Viewer</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4">
                    <button type="button" id="closeAddAccessRightModal" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span>Cancel</span>
                    </button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12h16M12 4v16"></path>
                        </svg>
                        <span>Add Access Right</span>
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to open the Add Access Right modal
            function openAddAccessRightModal() {
                const modal = document.getElementById('addAccessRightModal');
                modal.classList.remove('hidden');
                setTimeout(() => modal.classList.add('fade-in'), 10); // Add fade-in animation
            }

            // Function to close the Add Access Right modal
            function closeAddAccessRightModal() {
                const modal = document.getElementById('addAccessRightModal');
                modal.classList.remove('fade-in');
                setTimeout(() => modal.classList.add('hidden'), 300); // Remove modal after fade-out
            }

            // Event listeners for opening the modal
            document.getElementById('openAddAccessRightModal').addEventListener('click', openAddAccessRightModal);

            // Event listeners for closing the modal
            document.getElementById('closeAddAccessRightModal').addEventListener('click', closeAddAccessRightModal);
        });
    </script>