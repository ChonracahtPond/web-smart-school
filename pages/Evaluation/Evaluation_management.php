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

<meta name="description" content="">
<meta name="keywords" content="">
<link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
<style>
    /* Tailwind CSS overrides for DataTables */
    .dataTables_wrapper select,
    .dataTables_wrapper .dataTables_filter input {
        color: #4a5568;
        padding-left: 1rem;
        padding-right: 1rem;
        padding-top: .5rem;
        padding-bottom: .5rem;
        line-height: 1.25;
        border-width: 2px;
        border-radius: .25rem;
        border-color: #edf2f7;
        background-color: #edf2f7;
    }

    table.dataTable.hover tbody tr:hover {
        background-color: #ebf4ff;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        font-weight: 700;
        border-radius: .25rem;
        border: 1px solid transparent;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        color: #fff !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
        font-weight: 700;
        border-radius: .25rem;
        background: #667eea !important;
        border: 1px solid transparent;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        color: #fff !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
        font-weight: 700;
        border-radius: .25rem;
        background: #667eea !important;
        border: 1px solid transparent;
    }

    table.dataTable.no-footer {
        border-bottom: 1px solid #e2e8f0;
        margin-top: 0.75em;
        margin-bottom: 0.75em;
    }

    table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before,
    table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before {
        background-color: #667eea !important;
    }
</style>
</head>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">การจัดการประเมินผล</h1>
    <button id="openModal" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600"> + เพิ่มการประเมินผล</button>

    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-8">การประเมินที่มีอยู่</h2>
    <div class="overflow-x-auto">
        <table id="evaluationsTable" class="stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
            <thead>
                <tr>
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
                    <tr>
                        <td><?php echo htmlspecialchars($row['evaluation_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['evaluation_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['evaluation_score']); ?></td>
                        <td><?php echo htmlspecialchars($row['comments']); ?></td>
                        <td>
                            <?php if (!empty($row['google_form_link'])): ?>
                                <a href="<?php echo htmlspecialchars($row['google_form_link']); ?>" target="_blank" class="text-blue-500 hover:text-blue-700">View Form</a>
                            <?php else: ?>
                                <span class="text-gray-500">No link</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button class="text-blue-500 hover:text-blue-700 edit-btn" data-id="<?php echo $row['evaluation_id']; ?>" data-name="<?php echo htmlspecialchars($row['evaluation_name']); ?>" data-date="<?php echo htmlspecialchars($row['evaluation_date']); ?>" data-score="<?php echo htmlspecialchars($row['evaluation_score']); ?>" data-comments="<?php echo htmlspecialchars($row['comments']); ?>" data-link="<?php echo htmlspecialchars($row['google_form_link']); ?>">แก้ไข</button>
                            |
                            <a href="?page=Evaluation_management&delete=<?php echo $row['evaluation_id']; ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this evaluation?');">ลบ</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Structure -->
<div id="evaluationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 w-full max-w-lg">
        <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-2">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">เพิ่ม/แก้ไขการประเมินผล</h2>
            <button id="closeModal" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">&times;</button>
        </div>
        <form id="evaluationForm" method="post" action="" class="mt-4">
            <div class="mb-4">
                <label for="evaluation_name" class="block text-gray-700 dark:text-gray-400">ชื่อการประเมินผล</label>
                <input type="text" name="evaluation_name" id="evaluation_name" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="evaluation_date" class="block text-gray-700 dark:text-gray-400">วันที่ประเมิน</label>
                <input type="date" name="evaluation_date" id="evaluation_date" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="evaluation_score" class="block text-gray-700 dark:text-gray-400">คะแนนการประเมินผล</label>
                <input type="number" step="0.01" name="evaluation_score" id="evaluation_score" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="comments" class="block text-gray-700 dark:text-gray-400">ความคิดเห็น</label>
                <textarea name="comments" id="comments" class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"></textarea>
            </div>
            <div class="mb-4">
                <label for="google_form_link" class="block text-gray-700 dark:text-gray-400">Google Form Link</label>
                <input type="url" name="google_form_link" id="google_form_link" class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <input type="hidden" name="evaluation_id" id="evaluation_id">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">บันทึกการประเมินผล</button>
        </form>
    </div>
</div>

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