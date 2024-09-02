<?php


// Fetch all news from the database
$sql_news = "SELECT New_id, News_name, News_detail, News_images FROM news";
$result_news = $conn->query($sql_news);
?>

<link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
<style>
    /* Custom styles for DataTables */
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

<!--Container-->
<div class="container w-full mx-auto px-2">
    <!--Title-->
    <h1 class="flex items-center font-sans font-bold break-normal text-indigo-500 px-2 py-8 text-xl md:text-2xl">
        จัดการข่าวสาร
    </h1>

    <!--Card-->
    <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
        <button id="openModal" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 mb-4">+ เพิ่มข่าวสารใหม่</button>

        <!-- ฟอร์มค้นหา -->
        <form method="GET" action="" class="mb-4">
            <div class="flex items-center">
                <input type="text" name="search" class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="ค้นหาด้วยชื่อข่าวสาร">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 ml-2">ค้นหา</button>
            </div>
        </form>

        <!-- DataTable -->
        <table id="example" class="stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
            <thead>
                <tr>
                    <th data-priority="1">รหัสข่าวสาร</th>
                    <th data-priority="2">ชื่อข่าวสาร</th>
                    <th data-priority="3">รายละเอียดข่าวสาร</th>
                    <th data-priority="4">รูปภาพข่าวสาร</th>
                    <th data-priority="5">การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_news->num_rows > 0) : ?>
                    <?php while ($row = $result_news->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['New_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['News_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['News_detail']); ?></td>
                            <td>
                                <?php if (!empty($row['News_images'])) : ?>
                                    <img src="<?php echo htmlspecialchars($row['News_images']); ?>" alt="รูปภาพข่าวสาร" class="w-32 h-auto">
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="system.php?page=edit_news&id=<?php echo htmlspecialchars($row['New_id']); ?>" class="text-blue-500 hover:text-blue-700">แก้ไข</a>
                                |
                                <a href="system.php?page=delete_news&id=<?php echo htmlspecialchars($row['New_id']); ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข่าวสารนี้?')">ลบ</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center">ไม่พบข่าวสาร</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!--/Card-->
</div>
<!--/container-->

<?php include "add_news.php"; ?>
<!-- jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<!--Datatables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            responsive: true
        }).columns.adjust().responsive.recalc();

        // Open modal
        $('#openModal').click(function() {
            $('#newsModal').removeClass('hidden');
        });

        // Close modal
        $('#closeModal').click(function() {
            $('#newsModal').addClass('hidden');
        });

        // Close modal when clicking outside of it
        $(window).click(function(event) {
            if ($(event.target).is('#newsModal')) {
                $('#newsModal').addClass('hidden');
            }
        });
    });
</script>