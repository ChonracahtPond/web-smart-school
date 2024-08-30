<?php
// Assume you have a database connection already established in $conn

// Handle graduation approval
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_graduation'])) {
    $student_id = $_POST['student_id'];
    $sql = "UPDATE students SET graduation_status = 'Approved' WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $student_id);
    if ($stmt->execute()) {
        echo "<script>alert('Graduation approved successfully'); window.location.href='Graduation_system.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Handle student status change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_status'])) {
    $student_id = $_POST['student_id'];
    $new_status = $_POST['new_status'];
    $sql = "UPDATE students SET class_level = ? WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $new_status, $student_id);
    if ($stmt->execute()) {
        echo "<script>alert('Student status updated successfully'); window.location.href='Graduation_system.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Handle ConGraduation file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['congraduation_file'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["congraduation_file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is a valid image or video
    if ($fileType != "gif" && $fileType != "mp4" && $fileType != "avi" && $fileType != "mov") {
        echo "Sorry, only GIF, MP4, AVI & MOV files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["congraduation_file"]["tmp_name"], $target_file)) {
            echo "<script>alert('File uploaded successfully'); window.location.href='Graduation_system.php';</script>";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Retrieve students for displaying
$sql = "SELECT student_id, name, class_level, graduation_status FROM students";
$result = $conn->query($sql);

if ($result === false) {
    die("Error executing query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Graduation System</title>
    <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Graduation System</h1>

        <!-- Graduation Approval Section -->
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-8">Approve Graduation</h2>
        <form method="post">
            <div class="mb-4">
                <label for="student_id" class="block text-gray-700 dark:text-gray-400">Student ID</label>
                <input type="text" name="student_id" id="student_id" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <button type="submit" name="approve_graduation" class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-green-600">Approve Graduation</button>
        </form>

        <!-- Change Student Status Section -->
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-8">Change Student Status</h2>
        <form method="post">
            <div class="mb-4">
                <label for="student_id" class="block text-gray-700 dark:text-gray-400">Student ID</label>
                <input type="text" name="student_id" id="student_id" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="new_status" class="block text-gray-700 dark:text-gray-400">New Status</label>
                <input type="text" name="new_status" id="new_status" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <button type="submit" name="change_status" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">Change Status</button>
        </form>

        <!-- ConGraduation File Upload Section -->
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-8">ConGraduation</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="congraduation_file" class="block text-gray-700 dark:text-gray-400">Upload GIF or Video</label>
                <input type="file" name="congraduation_file" id="congraduation_file" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">Upload File</button>
        </form>

        <!-- Students Table -->
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-8">Students List</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class Level</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Graduation Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['student_id']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['name']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['class_level']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['graduation_status']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($row['graduation_status'] !== 'Approved') : ?>
                                    <form method="post" style="display:inline;">
                                        <input type="hidden" name="student_id" value="<?php echo $row['student_id']; ?>">
                                        <button type="submit" name="approve_graduation" class="text-green-500 hover:text-green-700">Approve</button>
                                    </form>
                                <?php else: ?>
                                    Approved
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>