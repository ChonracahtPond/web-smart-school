<?php
// SQL query to fetch borrowing records and related user/item data
$sql = "SELECT p.*, u.first_name, u.last_name, i.item_name 
        FROM permanent_borrowings p
        JOIN users u ON p.user_id = u.user_id
        JOIN items i ON p.item_id = i.item_id";

$result = $conn->query($sql);

// SQL query to fetch items
$items_sql = "SELECT item_id, item_name FROM items";
$items_result = $conn->query($items_sql);
?>

<link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<!-- Regular Datatables CSS -->
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<!-- Responsive Extension Datatables CSS -->
<link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
<style>
    /* Overrides for Tailwind CSS */
    .dataTables_wrapper select,
    .dataTables_wrapper input {
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
        width: 100px;
    }



    .dataTables_filter input {
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
        width: 500px;
    }




    table.dataTable.hover tbody tr:hover,
    table.dataTable.display tbody tr:hover {
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
        /* width: 500px; */
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        color: #fff !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
        font-weight: 700;
        border-radius: .25rem;
        background: #667eea !important;
        border: 1px solid transparent;
        /* width: 500px; */
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

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-4">ระบบเบิกวัสดุ-อุปกรณ์ ไม่ต้องคืน</h1>

    <!-- Add Borrowing Button -->
    <button id="addBorrowingBtn" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4">
        + เพิ่มรายการเบิก
    </button>

    <!-- Borrowing Records Table -->
    <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
        <table id="example" class="stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
            <thead>
                <tr>
                    <th>No</th> <!-- Added No column -->
                    <th>ชื่อวัสดุ-อุปกรณ์</th>
                    <th>ชื่อผู้เบิก</th>
                    <th>จำนวนที่เบิก</th>
                    <th>เบิกวันที่</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) :
                    $counter = 1; // Initialize counter
                ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td class="text-center"><?php echo $counter; ?></td> <!-- Display counter value -->
                            <td class="text-center"><?php echo htmlspecialchars($row['item_name']); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($row['borrowed_at']); ?></td>
                            <td class="text-center">
                                <a href="?page=edit_borrowing&permanent_borrowing_id=<?php echo htmlspecialchars($row['permanent_borrowing_id']); ?>" class="text-blue-500 hover:underline">แก้ไข</a> |
                                <a href="?page=delete_borrowing&permanent_borrowing_id=<?php echo htmlspecialchars($row['permanent_borrowing_id']); ?>" class="text-red-500 hover:underline" onclick="return confirm('Are you sure you want to delete this borrowing record?')">ลบ</a>
                            </td>
                        </tr>
                        <?php $counter++; // Increment counter 
                        ?>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center">ไม่มีข้อมูลการเบิกวัสดุ</td> <!-- Updated colspan to match the new column count -->
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>

<!-- jQuery and Datatables -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            responsive: true
        });
    });
</script>



<?php include "modal.php"; ?>