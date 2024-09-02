<?php
include 'upload.php'; // Include the file for database connection

// Fetch all eBooks from the database
$sql = "SELECT * FROM ebooks ORDER BY upload_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show eBooks</title>
    <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 text-gray-900 tracking-wider leading-normal">

    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4 text-indigo-600">eBook List</h1>

        <!-- Display eBooks as cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <h2 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($row['title']); ?></h2>
                    <p class="text-gray-500 mb-4">Uploaded on: <?php echo htmlspecialchars($row['upload_date']); ?></p>
                    <a href="../uploads/ebooks/<?php echo htmlspecialchars($row['file_name']); ?>" target="_blank" class="text-blue-500 hover:text-blue-700 font-medium">View</a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <?php $conn->close(); ?>

</body>

</html>