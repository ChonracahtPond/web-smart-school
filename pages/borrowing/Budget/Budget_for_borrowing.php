<?php
// Default sorting order
$orderBy = isset($_GET['order_by']) ? $_GET['order_by'] : 'purchase_date';
$orderDirection = isset($_GET['order_dir']) && $_GET['order_dir'] === 'desc' ? 'desc' : 'asc';

// Default search term
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// SQL query to get total purchase price by year
$sql = "
    SELECT 
        YEAR(purchase_date) AS purchase_year,
        SUM(purchase_price) AS total_price
    FROM 
        items
    WHERE 
        item_name LIKE '%$search%' 
        OR item_description LIKE '%$search%' 
        OR status LIKE '%$search%'
    GROUP BY 
        YEAR(purchase_date)
    ORDER BY 
        purchase_year $orderDirection
";
$result = $conn->query($sql);

$annualBudgets = [];
while ($row = $result->fetch_assoc()) {
    // Add 543 to the purchase year
    $row['purchase_year'] += 543;
    $annualBudgets[] = $row;
}
?>

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">งบประมาณครุภัณฑ์ และ วัสดุสำนักงาน</h1>
    <!-- Table of annual budgets -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg mt-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 px-6 py-4 border-b border-gray-200 dark:border-gray-700">งบประมาณตามปี</h2>
        <div class="overflow-x-auto">
            <table class="border-collapse w-full">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            ปี
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            จำนวนงบประมาณ
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            รายงาน PDF
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    <?php foreach ($annualBudgets as $budget): ?>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($budget['purchase_year']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo number_format($budget['total_price'], 2); ?> บาท</td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                <button data-year="<?php echo htmlspecialchars($budget['purchase_year']); ?>" class="generate-pdf-btn px-4 py-2 bg-blue-600 text-white rounded-lg shadow-lg hover:bg-blue-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500">สร้างรายงาน PDF</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Confirmation Modal for PDF Report -->
    <div id="pdfModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">
            <h2 id="pdfModalLabel" class="text-2xl font-bold text-gray-900 dark:text-white mb-4">สร้างรายงาน PDF</h2>
            <p id="pdfModalMessage" class="mb-4">คุณแน่ใจหรือไม่ว่าต้องการสร้างรายงาน PDF สำหรับปี <span id="selectedYear"></span>?</p>
            <div class="flex justify-end mt-4">
                <button id="confirmGeneratePdfBtn" class="px-4 py-2 bg-green-600 text-white rounded-lg shadow-lg hover:bg-green-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500">ใช่, สร้างรายงาน PDF</button>
                <button id="cancelGeneratePdfBtn" class="ml-4 px-4 py-2 bg-gray-600 text-white rounded-lg shadow-lg hover:bg-gray-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-500">ยกเลิก</button>
            </div>
        </div>
    </div>

    <!-- JavaScript to handle modals and PDF generation -->
    <script>
        let selectedYear = '';

        document.querySelectorAll('.generate-pdf-btn').forEach(button => {
            button.addEventListener('click', (event) => {
                selectedYear = event.target.getAttribute('data-year');
                document.getElementById('selectedYear').textContent = selectedYear;
                document.getElementById('pdfModal').classList.remove('hidden');
            });
        });

        document.getElementById('confirmGeneratePdfBtn').addEventListener('click', () => {
            // สร้างลิงก์ใหม่และตั้งค่า URL ของ PDF
            const url = `../mpdf/equipment/Budget_for_pdf.php?year=${selectedYear}`;

            // สร้างเอลิเมนต์ anchor และกำหนดค่า
            const link = document.createElement('a');
            link.href = url;
            link.target = '_blank'; // เปิดในแท็บใหม่
            link.rel = 'noopener noreferrer'; // ความปลอดภัย

            // จำเป็นต้องเพิ่มเอลิเมนต์ลงในเอกสารเพื่อให้สามารถคลิกได้
            document.body.appendChild(link);

            // คลิกลิงก์เพื่อเปิดในแท็บใหม่
            link.click();

            // ลบลิงก์ออกหลังจากเปิดแล้ว
            document.body.removeChild(link);
        });


        document.getElementById('cancelGeneratePdfBtn').addEventListener('click', () => {
            document.getElementById('pdfModal').classList.add('hidden');
        });
    </script>
</div>