<?php
include 'upload.php'; // นำเข้าไฟล์อัปโหลด

// ตรวจสอบว่ามีการร้องขอให้ลบ eBook หรือไม่
if (isset($_GET['delete'])) {
    $ebook_id = intval($_GET['delete']); // ตรวจสอบและทำให้เป็นจำนวนเต็ม
    include 'delete.php'; // นำเข้าไฟล์ลบ
}

// ดึงข้อมูล eBook ทั้งหมดจากฐานข้อมูล
$sql = "SELECT * FROM ebooks ORDER BY upload_date DESC";
$result = $conn->query($sql);
?>


<link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
<style>
    /* Overrides for Tailwind CSS */
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

<!-- Container -->
<div class="container w-ful mx-auto px-2">

    <!-- Title -->
    <h1 class="flex items-center font-sans font-bold break-normal text-indigo-500 px-2 py-8 text-xl md:text-2xl">
        จัดการ eBook
    </h1>

    <!-- Card -->
    <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
        <!-- Form for uploading eBook -->
        <div class="bg-white p-4 rounded shadow-md mb-4">
            <h2 class="text-xl font-semibold mb-2">อัปโหลด eBook ใหม่</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label class="block text-gray-700">ชื่อเรื่อง:</label>
                    <input type="text" name="title" class="mt-1 p-2 border border-gray-300 rounded w-full" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">ไฟล์ eBook (PDF):</label>
                    <input type="file" name="ebook_file" class="mt-1 p-2 border border-gray-300 rounded w-full" accept="application/pdf" required>
                </div>
                <button type="submit" name="upload" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">อัปโหลด eBook</button>
            </form>
        </div>

        <!-- Display eBook list -->
        <table id="ebookTable" class="stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
            <thead>
                <tr>
                    <th>ชื่อเรื่อง</th>
                    <th>วันที่อัปโหลด</th>
                    <th>การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['upload_date']); ?></td>
                        <td>
                            <a href="../uploads/ebooks/<?php echo $row['file_name']; ?>" target="_blank" class="text-blue-500 hover:text-blue-700">ดู</a>
                            <a href="?page=ManageBook&delete=<?php echo $row['id']; ?>" class="text-red-500 hover:text-red-700 ml-2">ลบ</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <!-- /Card -->

</div>
<!-- /Container -->

<!-- jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        $('#ebookTable').DataTable({
            responsive: true
        }).columns.adjust().responsive.recalc();
    });
</script>