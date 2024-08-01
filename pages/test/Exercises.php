<?php

// Query เพื่อดึงข้อมูลแบบฝึกหัดทั้งหมด
$query = "SELECT * FROM Exercises";
$result = mysqli_query($conn, $query);
?>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Manage Exercises</h1>
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Title</th>
                    <th class="py-2 px-4 border-b">Description</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td class="py-2 px-4 border-b"><?php echo $row['exercise_id']; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo $row['title']; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo $row['description']; ?></td>
                        <td class="py-2 px-4 border-b">
                            <a href="?page=edit_exercise&id=<?php echo $row['exercise_id']; ?>" class="text-blue-500">Edit</a> | 
                            <a href="?page=delete_exercise&id=<?php echo $row['exercise_id']; ?>" class="text-red-500">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="?page=add_exercise" class="mt-4 inline-block bg-blue-500 text-white py-2 px-4 rounded">Add New Exercise</a>
    </div>

