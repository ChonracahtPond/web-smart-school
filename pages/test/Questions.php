<?php
$exercise_id = $_GET['id'];
$query = "SELECT * FROM Questions WHERE exercise_id = $exercise_id";
$result = mysqli_query($conn, $query);
?>

    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Manage Questions</h1>
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Question</th>
                    <th class="py-2 px-4 border-b">Type</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td class="py-2 px-4 border-b"><?php echo $row['question_id']; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo $row['question_text']; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo ucfirst($row['question_type']); ?></td>
                        <td class="py-2 px-4 border-b">
                            <a href="edit_question.php?id=<?php echo $row['question_id']; ?>" class="text-blue-500">Edit</a> | 
                            <a href="delete_question.php?id=<?php echo $row['question_id']; ?>" class="text-red-500">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="add_question.php?exercise_id=<?php echo $exercise_id; ?>" class="mt-4 inline-block bg-blue-500 text-white py-2 px-4 rounded">Add New Question</a>
    </div>

