<?php
// เชื่อมต่อฐานข้อมูล

// ฟังก์ชันสำหรับการเพิ่มหนังสือ
if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $published_date = $_POST['published_date'];

    $sql = "INSERT INTO books (title, author, published_date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $author, $published_date);
    if ($stmt->execute()) {
        echo "<script>alert('Book added successfully');</script>";
    } else {
        echo "<script>alert('Error adding book: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// ฟังก์ชันสำหรับการลบหนังสือ
if (isset($_GET['delete'])) {
    $book_id = $_GET['delete'];

    $sql = "DELETE FROM books WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);
    if ($stmt->execute()) {
        echo "<script>alert('Book deleted successfully');</script>";
    } else {
        echo "<script>alert('Error deleting book: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// ฟังก์ชันสำหรับการแก้ไขหนังสือ
if (isset($_POST['update'])) {
    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $published_date = $_POST['published_date'];

    $sql = "UPDATE books SET title = ?, author = ?, published_date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $title, $author, $published_date, $book_id);
    if ($stmt->execute()) {
        echo "<script>alert('Book updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating book: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// ค้นหาหนังสือ
$search = isset($_POST['search']) ? $_POST['search'] : '';
$date_from = isset($_POST['date_from']) ? $_POST['date_from'] : '';
$date_to = isset($_POST['date_to']) ? $_POST['date_to'] : '';

$sql = "SELECT * FROM books WHERE title LIKE ? AND (published_date BETWEEN ? AND ?)";
$stmt = $conn->prepare($sql);
$search_term = "%$search%";
$stmt->bind_param("sss", $search_term, $date_from, $date_to);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Manage Books</h1>

        <!-- Form for Adding Books -->
        <div class="bg-white p-4 rounded shadow-md mb-4">
            <h2 class="text-xl font-semibold mb-2">Add New Book</h2>
            <form action="ManageBook.php" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700">Title:</label>
                    <input type="text" name="title" class="mt-1 p-2 border border-gray-300 rounded w-full" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Author:</label>
                    <input type="text" name="author" class="mt-1 p-2 border border-gray-300 rounded w-full" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Published Date:</label>
                    <input type="date" name="published_date" class="mt-1 p-2 border border-gray-300 rounded w-full" required>
                </div>
                <button type="submit" name="add" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">Add Book</button>
            </form>
        </div>

        <!-- Form for Searching and Filtering -->
        <div class="bg-white p-4 rounded shadow-md mb-4">
            <h2 class="text-xl font-semibold mb-2">Search and Filter Books</h2>
            <form action="ManageBook.php" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700">Search Title:</label>
                    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" class="mt-1 p-2 border border-gray-300 rounded w-full">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Published Date From:</label>
                    <input type="date" name="date_from" value="<?php echo htmlspecialchars($date_from); ?>" class="mt-1 p-2 border border-gray-300 rounded w-full">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Published Date To:</label>
                    <input type="date" name="date_to" value="<?php echo htmlspecialchars($date_to); ?>" class="mt-1 p-2 border border-gray-300 rounded w-full">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">Search</button>
            </form>
        </div>

        <!-- Display Books -->
        <div class="bg-white p-4 rounded shadow-md">
            <h2 class="text-xl font-semibold mb-2">Book List</h2>
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['title']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['author']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['published_date']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="javascript:void(0)" onclick="editBook(<?php echo $row['id']; ?>, '<?php echo addslashes($row['title']); ?>', '<?php echo addslashes($row['author']); ?>', '<?php echo $row['published_date']; ?>')" class="text-blue-500 hover:text-blue-700">Edit</a>
                                <a href="?delete=<?php echo $row['id']; ?>" class="text-red-500 hover:text-red-700 ml-2">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Edit Modal -->
        <div id="edit-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white p-4 rounded shadow-lg">
                <h2 class="text-xl font-semibold mb-2">Edit Book</h2>
                <form id="edit-form" action="ManageBook.php" method="POST">
                    <input type="hidden" name="book_id" id="edit-book-id">
                    <div class="mb-4">
                        <label class="block text-gray-700">Title:</label>
                        <input type="text" name="title" id="edit-title" class="mt-1 p-2 border border-gray-300 rounded w-full" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Author:</label>
                        <input type="text" name="author" id="edit-author" class="mt-1 p-2 border border-gray-300 rounded w-full" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Published Date:</label>
                        <input type="date" name="published_date" id="edit-published_date" class="mt-1 p-2 border border-gray-300 rounded w-full" required>
                    </div>
                    <button type="submit" name="update" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">Update Book</button>
                    <button type="button" onclick="closeEditModal()" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 ml-2">Cancel</button>
                </form>
            </div>
        </div>

    </div>

    <script>
        function editBook(id, title, author, published_date) {
            document.getElementById('edit-book-id').value = id;
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-author').value = author;
            document.getElementById('edit-published_date').value = published_date;
            document.getElementById('edit-modal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }
    </script>
</body>
</html>
