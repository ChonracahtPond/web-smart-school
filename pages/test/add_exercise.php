<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $lesson_id = 8; // กำหนดค่า lesson_id เป็น 8

    $query = "INSERT INTO Exercises (title, description, lesson_id) VALUES ('$title', '$description', '$lesson_id')";
    if (mysqli_query($conn, $query)) {
        // header("Location: manage_exercises.php");
        // exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>



    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Add Exercise</h1>
        <form action="" method="POST" class="bg-white p-6 rounded shadow-md">
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Title</label>
                <input type="text" id="title" name="title" class="mt-1 block w-full border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Description</label>
                <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded"></textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Add Exercise</button>
        </form>
    </div>
