<?php
include "sql.php";

// Set default dates to today's date
$start_date = date('d/m/Y');
$end_date = date('d/m/Y');
$year = date('Y');

// If form is submitted, override the default dates with user input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : $start_date;
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : $end_date;
    $year = isset($_POST['year']) ? $_POST['year'] : $year;
}

?>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.4/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/th.js"></script> -->


<div class="container mx-auto my-6 px-4 mb-5">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">สถิติและรายงาน</h1>

    <!-- ฟอร์มเลือกวันที่เริ่มต้น, สิ้นสุด และปี -->
    <form method="POST" action="" class="mb-6 space-y-3" id="filterForm">
        <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-3">
            <div class="flex-1">
                <label for="start_date" class="block text-sm font-medium text-gray-700">วันที่เริ่มต้น</label>
                <input type="text" name="start_date" id="start_date" class="mt-1 p-2 border border-gray-300 rounded-md shadow-sm w-full" value="<?php echo htmlspecialchars($start_date); ?>">
            </div>
            <div class="flex-1">
                <label for="end_date" class="block text-sm font-medium text-gray-700">วันที่สิ้นสุด</label>
                <input type="text" name="end_date" id="end_date" class="mt-1 p-2 border border-gray-300 rounded-md shadow-sm w-full" value="<?php echo htmlspecialchars($end_date); ?>">
            </div>
        </div>
    </form>

    <a href="">
        <!-- <button class="mt-5 p-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600 transition w-[150px] h-[45px]">ข้อมูลปัจจุบัน</button> -->
    </a>

    <!-- ฟอร์มสำหรับออกรายงาน -->
    <form method="POST" class="mb-6 space-y-3" id="reportForm">
        <label for="year" class="block text-sm font-medium text-gray-700">เลือกปี</label>
        <select name="year" id="year" class="mt-1 p-2 border border-gray-300 rounded-md shadow-sm w-[70%]">
            <option value="">เลือกปี</option>
            <?php foreach ($years as $yr): ?>
                <option value="<?php echo htmlspecialchars($yr['year']); ?>" <?php echo $year == $yr['year'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($yr['year']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="button" class="p-2 bg-yellow-500 text-white rounded-md shadow hover:bg-yellow-600 transition w-[150px]" onclick="redirectToReport()">ออกรายงาน</button>
    </form>

    <!-- การ์ดแสดงสถิติ -->
    <?php include "Statistics_Cards.php"; ?>

    <!-- แสดงกราฟ -->
    <?php include "Statistics_Chart.php"; ?>

    <!-- ตารางแสดงข้อมูล -->
    <?php include "Statistics_Table.php"; ?>

</div>

<script>
    function redirectToReport() {
        var form = document.getElementById('reportForm');
        var formData = new FormData(form);
        var params = new URLSearchParams(formData).toString();
        var reportUrl = "../mpdf/Statistics/Statistics_report.php?" + params;

        // Open the report URL in a new tab
        window.open(reportUrl, '_blank');
    }

    function autoSubmitForm() {
        document.getElementById('filterForm').submit();
    }

    // Initialize Flatpickr with today's date as the default
    flatpickr("#start_date", {
        dateFormat: "d/m/Y",
        defaultDate: "<?php echo isset($start_date) ? htmlspecialchars($start_date) : ''; ?>",
        onChange: autoSubmitForm
    });

    flatpickr("#end_date", {
        dateFormat: "d/m/Y",
        defaultDate: "<?php echo isset($end_date) ? htmlspecialchars($end_date) : ''; ?>",
        onChange: autoSubmitForm
    });
</script>