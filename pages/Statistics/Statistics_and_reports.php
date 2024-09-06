<?php
// Initialize variables
$start_date = null;
$end_date = null;
$year = null;

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่า start_date, end_date และ year จากฟอร์ม
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : null;
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : null;
    $year = isset($_POST['year']) ? $_POST['year'] : null;
}

// Prepare SQL query
$query = "SELECT * FROM register WHERE status_register IN (0, 1, 3)";

if ($start_date && $end_date) {
    $query .= " AND registration_date BETWEEN ? AND ?";
} elseif ($year) {
    $query .= " AND YEAR(registration_date) = ?";
}

$stmt = $conn->prepare($query);

if ($start_date && $end_date) {
    $stmt->bind_param('ss', $start_date, $end_date);
} elseif ($year) {
    $stmt->bind_param('i', $year);
}

$stmt->execute();
$result = $stmt->get_result();
$students = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];

// Calculate student counts
$total_students = count($students);
$accepted_students = array_filter($students, fn($s) => $s['status_register'] == 1);
$rejected_students = array_filter($students, fn($s) => $s['status_register'] == 3);
$accepted_count = count($accepted_students);
$rejected_count = count($rejected_students);

// Get distinct years for dropdown
$year_stmt = $conn->prepare("SELECT DISTINCT YEAR(registration_date) AS year FROM register ORDER BY year DESC");
$year_stmt->execute();
$year_result = $year_stmt->get_result();
$years = $year_result->num_rows > 0 ? $year_result->fetch_all(MYSQLI_ASSOC) : [];
?>

<!DOCTYPE html>
<html lang="th" data-theme="mytheme">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สถิติและรายงาน</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.4/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</head>

<body>
    <div class="container mx-auto my-6 px-4">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">สถิติและรายงาน</h1>

        <!-- ฟอร์มเลือกวันที่เริ่มต้น, สิ้นสุด และปี -->
        <form method="POST" action="" class="mb-6 space-y-4">
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                <div class="flex-1">
                    <label for="start_date" class="block text-sm font-medium text-gray-700">วันที่เริ่มต้น</label>
                    <input type="text" name="start_date" id="start_date" class="mt-1 p-2 border border-gray-300 rounded-md shadow-sm w-full" value="<?php echo htmlspecialchars($start_date); ?>">
                </div>
                <div class="flex-1">
                    <label for="end_date" class="block text-sm font-medium text-gray-700">วันที่สิ้นสุด</label>
                    <input type="text" name="end_date" id="end_date" class="mt-1 p-2 border border-gray-300 rounded-md shadow-sm w-full" value="<?php echo htmlspecialchars($end_date); ?>">
                </div>
                <div class="flex-1">
                    <label for="year" class="block text-sm font-medium text-gray-700">เลือกปี</label>
                    <select name="year" id="year" class="mt-1 p-2 border border-gray-300 rounded-md shadow-sm w-full">
                        <option value="">เลือกปี</option>
                        <?php foreach ($years as $yr): ?>
                            <option value="<?php echo htmlspecialchars($yr['year']); ?>" <?php echo $year == $yr['year'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($yr['year']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="flex space-x-4 mt-4">
                <button type="submit" class="p-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600 transition">กรองข้อมูล</button>
                <button type="button" class="p-2 bg-yellow-500 text-white rounded-md shadow hover:bg-yellow-600 transition" onclick="redirectToReport()">ออกรายงาน</button>
            </div>
        </form>

        <!-- การ์ดแสดงสถิติ -->
        <?php include "Statistics_Cards.php"; ?>

        <!-- แสดงกราฟ -->
        <?php include "Statistics_Chart.php"; ?>

        <div class="bg-white shadow-lg rounded-lg p-6 flex-1 mt-10">
            <!-- ตารางแสดงข้อมูลนักเรียน -->
            <div class="overflow-x-auto">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800">ตารางแสดงข้อมูล</h2>
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                    <thead>
                        <tr class="border-b border-gray-300">
                            <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">No</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">ชื่อของนักเรียน</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">เพศ</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">อีเมล</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">หมายเลขโทรศัพท์</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($students)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($students as $student): ?>
                                <tr class="border-b border-gray-300">
                                    <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($no++); ?></td>
                                    <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['student_name']); ?></td>
                                    <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['gender']); ?></td>
                                    <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['email']); ?></td>
                                    <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['phone_number']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="py-3 px-6 text-sm text-gray-700 text-center">ไม่พบข้อมูล</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function redirectToReport() {
            var startDate = document.getElementById('start_date').value;
            var endDate = document.getElementById('end_date').value;
            var year = document.getElementById('year').value;

            var reportUrl = "../mpdf/Statistics/Statistics_report.php";
            var params = [];

            if (startDate) params.push('start_date=' + encodeURIComponent(startDate));
            if (endDate) params.push('end_date=' + encodeURIComponent(endDate));
            if (year) params.push('year=' + encodeURIComponent(year));

            if (params.length) {
                reportUrl += '?' + params.join('&');
            }

            window.location.href = reportUrl;
        }
    </script>
    <script>
        flatpickr("#start_date", {
            dateFormat: "d/m",
            onChange: function(selectedDates, dateStr, instance) {
                document.getElementById('start_date').value = dateStr;
            }
        });

        flatpickr("#end_date", {
            dateFormat: "d/m",
            onChange: function(selectedDates, dateStr, instance) {
                document.getElementById('end_date').value = dateStr;
            }
        });
    </script>
</body>

</html>