<?php
require 'connection.php';

$query = "SELECT * FROM Student_Evaluations";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Student Evaluations</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <link rel="stylesheet" href="https://horizon-tailwind-react-corporate-7s21b54hb-horizon-ui.vercel.app/static/css/main.d7f96858.css" />
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Manage Student Evaluations</h1>
        <a href="add_edit.php" class="bg-green-500 text-white py-2 px-4 rounded mb-4 inline-block">Add New Evaluation</a>
        <table class="w-full bg-white border border-gray-300 rounded shadow-md">
            <thead>
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Student ID</th>
                    <th class="px-4 py-2">Evaluation ID</th>
                    <th class="px-4 py-2">Score</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td class="px-4 py-2"><?php echo $row['id']; ?></td>
                        <td class="px-4 py-2"><?php echo $row['student_id']; ?></td>
                        <td class="px-4 py-2"><?php echo $row['evaluation_id']; ?></td>
                        <td class="px-4 py-2"><?php echo $row['score']; ?></td>
                        <td class="px-4 py-2">
                            <a href="edit_student_evaluation.php?id=<?php echo $row['id']; ?>" class="text-blue-500 hover:underline">Edit</a>
                            <a href="delete_student_evaluation.php?id=<?php echo $row['id']; ?>" class="text-red-500 hover:underline ml-4">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
