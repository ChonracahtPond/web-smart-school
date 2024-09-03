<?php
// Include your database connection
// include "../../../includes/db_connect.php";

// Fetch all student data from the database
$sql = "SELECT * FROM register";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $students = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $students = [];
}

$conn->close();
?>

<h1 class="text-2xl font-bold mb-4 text-gray-800">ผู้ลงทะเบียนสมัครเรียน</h1>

<table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
    <thead>
        <tr class="border-b border-gray-300">
            <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">ID</th>
            <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Student Name</th>
            <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Email</th>
            <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Phone Number</th>
            <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($students)): ?>
            <?php foreach ($students as $student): ?>
                <tr class="border-b border-gray-300">
                    <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['id']); ?></td>
                    <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['student_name']); ?></td>
                    <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['email']); ?></td>
                    <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['phone_number']); ?></td>
                    <td class="py-3 px-6 text-sm text-gray-700 flex space-x-4">
                        <a href="?page=view_detail&id=<?php echo $student['id']; ?>" class="text-blue-500 hover:text-blue-700 flex items-center">
                            <svg class="h-5 w-5 " viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            <span class="ml-2">View</span>
                        </a>
                        <a href="edit.php?id=<?php echo $student['id']; ?>" class="text-green-500 hover:text-green-700 flex items-center">
                            <svg class="h-5 w-5 " viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                                <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
                                <line x1="16" y1="5" x2="19" y2="8" />
                            </svg>
                            <span class="ml-2">Edit</span>
                        </a>
                        <a href="delete.php?id=<?php echo $student['id']; ?>" class="text-red-500 hover:text-red-700 flex items-center">
                            <svg class="h-5 w-5 " viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6" />
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                <line x1="10" y1="11" x2="10" y2="17" />
                                <line x1="14" y1="11" x2="14" y2="17" />
                            </svg>
                            <span class="ml-2">Delete</span>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="py-3 px-6 text-sm text-gray-700 text-center">No records found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>