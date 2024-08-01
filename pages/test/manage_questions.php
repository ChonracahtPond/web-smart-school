<?php

$exercise_id = $_GET['id'];

$query = "SELECT * FROM Questions WHERE exercise_id = $exercise_id";
$result = mysqli_query($conn, $query);
?>


    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Manage Questions</h1>
        <a href="add_question.php?exercise_id=<?php echo $exercise_id; ?>" class="bg-green-500 text-white py-2 px-4 rounded mb-4 inline-block">Add New Question</a>
        <table class="w-full bg-white border border-gray-300 rounded shadow-md">
            <thead>
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Question Text</th>
                    <th class="px-4 py-2">Type</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td class="px-4 py-2"><?php echo $row['question_id']; ?></td>
                        <td class="px-4 py-2"><?php echo $row['question_text']; ?></td>
                        <td class="px-4 py-2"><?php echo $row['question_type']; ?></td>
                        <td class="px-4 py-2">
                            <a href="?page=edit_question&id=<?php echo $row['question_id']; ?>&exercise_id=<?php echo $exercise_id; ?>" class="text-blue-500 hover:underline">Edit</a>
                            <a href="?page=delete_question&id=<?php echo $row['question_id']; ?>&exercise_id=<?php echo $exercise_id; ?>" class="text-red-500 hover:underline ml-4">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

