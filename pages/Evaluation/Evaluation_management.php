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
                            <a href="?page=Evaluation_management&edit=<?php echo $row['evaluation_id']; ?>" class="text-blue-500 hover:text-blue-700">Edit</a>
                            <a href="?page=Evaluation_management&delete=<?php echo $row['evaluation_id']; ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this evaluation?');">Delete</a>
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
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var openModalBtn = document.getElementById('openModal');
        var closeModalBtn = document.getElementById('closeModal');
        var modal = document.getElementById('evaluationModal');

        openModalBtn.addEventListener('click', function() {
            modal.classList.remove('hidden');
        });

        closeModalBtn.addEventListener('click', function() {
            modal.classList.add('hidden');
        });

        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });
</script>