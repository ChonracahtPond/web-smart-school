<?php
// Assume you have a database connection already established in $conn

// Handle form submission for adding or updating an evaluation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $evaluation_name = $_POST['evaluation_name'];
    $evaluation_date = $_POST['evaluation_date'];
    $evaluation_score = $_POST['evaluation_score'];
    $comments = $_POST['comments'];
    $google_form_link = $_POST['google_form_link']; // New field for Google Form link

    if (isset($_POST['evaluation_id']) && !empty($_POST['evaluation_id'])) {
        // Update an existing evaluation
        $evaluation_id = $_POST['evaluation_id'];
        $sql = "UPDATE evaluations SET evaluation_name = ?, evaluation_date = ?, evaluation_score = ?, comments = ?, google_form_link = ? WHERE evaluation_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssddsi', $evaluation_name, $evaluation_date, $evaluation_score, $comments, $google_form_link, $evaluation_id);
    } else {
        // Add a new evaluation
        $sql = "INSERT INTO evaluations (evaluation_name, evaluation_date, evaluation_score, comments, google_form_link) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssdds', $evaluation_name, $evaluation_date, $evaluation_score, $comments, $google_form_link);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Evaluation saved successfully'); window.location.href='?page=Evaluation_management';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Retrieve evaluations
$sql = "SELECT evaluation_id, evaluation_name, evaluation_date, evaluation_score, comments, google_form_link FROM evaluations";
$result = $conn->query($sql);

if ($result === false) {
    die("Error executing query: " . $conn->error);
}
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">การจัดการประเมินผล</h1>

    <div id='recipients' class="p-8 mt-6 mb-10 lg:mt-0 rounded shadow bg-white mt-8">
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-3">การประเมินที่มีอยู่</h2>

        <button id="openModal" class="flex items-center bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-green-600 mt-4 mb-5">
            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M3 7l9 6 9-6" />
            </svg>
            <span class="font-bold">+ เพิ่มการประเมินผล</span>
        </button>

        <table id="evaluationsTable" class="stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
            <thead>
                <tr class="bg-gray-100">
                    <th>ชื่อการประเมินผล</th>
                    <th>วันที่ประเมิน</th>
                    <th>คะแนน</th>
                    <th>ความคิดเห็น</th>
                    <th>Google Form Link</th>
                    <th>การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr class="text-center hover:bg-gray-50">
                        <td><?php echo htmlspecialchars($row['evaluation_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['evaluation_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['evaluation_score']); ?></td>
                        <td><?php echo htmlspecialchars($row['comments']); ?></td>
                        <td>
                            <?php if (!empty($row['google_form_link'])): ?>
                                <a href="<?php echo htmlspecialchars($row['google_form_link']); ?>" target="_blank" class="text-blue-500 hover:text-blue-700">
                                    <svg class="w-4 h-4 inline-block mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M3 7l9 6 9-6" />
                                    </svg>
                                    View Form
                                </a>
                            <?php else: ?>
                                <span class="text-gray-500">No link</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="?page=edit_Evaluation&id=<?php echo $row['evaluation_id']; ?>" class="text-blue-500 hover:text-blue-700">แก้ไข</a> |
                            <a href="?page=delete_Evaluation&id=<?php echo $row['evaluation_id']; ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('คุณแน่ใจหรือไม่ว่าจะลบการลงทะเบียนนี้?')">ลบ</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include "modal.php"; ?>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        $('#evaluationsTable').DataTable({
            responsive: true
        });

        // Open the modal
        $('#openModal').on('click', function() {
            $('#evaluationModal').removeClass('hidden');
            $('#evaluationForm').trigger('reset');
            $('#evaluation_id').val('');
        });

        // Handle Edit button click
        $(document).on('click', '.edit-btn', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var date = $(this).data('date');
            var score = $(this).data('score');
            var comments = $(this).data('comments');
            var link = $(this).data('link');

            $('#evaluation_id').val(id);
            $('#evaluation_name').val(name);
            $('#evaluation_date').val(date);
            $('#evaluation_score').val(score);
            $('#comments').val(comments);
            $('#google_form_link').val(link);

            $('#evaluationModal').removeClass('hidden');
        });

        // Close the modal
        $('#closeModal').on('click', function() {
            $('#evaluationModal').addClass('hidden');
        });

        // Close the modal if clicked outside
        $(window).on('click', function(event) {
            if ($(event.target).is('#evaluationModal')) {
                $('#evaluationModal').addClass('hidden');
            }
        });
    });
</script>