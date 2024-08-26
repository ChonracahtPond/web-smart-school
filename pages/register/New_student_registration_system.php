<?php
// include "../../../includes/db_connect.php"; // Include your database connection

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

<h1 class="text-2xl font-bold mb-4">ผู้ลงทะเบียนสมัครเรียน</h1>

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
                    <td class="py-3 px-6 text-sm text-gray-700">
                        <a href="view_register.php?id=<?php echo $student['id']; ?>" class="text-blue-500 hover:underline">View</a> |
                        <a href="edit.php?id=<?php echo $student['id']; ?>" class="text-blue-500 hover:underline">Edit</a> |
                        <a href="delete.php?id=<?php echo $student['id']; ?>" class="text-red-500 hover:underline">Delete</a>
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
