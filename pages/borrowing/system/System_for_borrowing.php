<?php
// Fetch items for borrowing, including quantity
$sql = "SELECT item_id, item_name, quantity FROM items WHERE quantity > 0";
$items_result = $conn->query($sql);

// Fetch borrowings for returning
$sql = "SELECT b.borrowing_id, i.item_name, b.quantity
        FROM borrowings b
        JOIN items i ON b.item_id = i.item_id
        WHERE b.returned_at IS NULL";
$borrowings_result = $conn->query($sql);
?>

<div class=" mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">ระบบยืม-คืนครุภัณฑ์ และ ระบบเบิกจ่ายวัสดุสำนักงาน</h1>

    <div class="flex gap-4 mb-6">
        <!-- Button to open Borrowing Modal -->
        <button id="openBorrowingModal" class="bg-blue-600 text-white px-6 py-3 rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-300">ยืมอุปกรณ์</button>

        <!-- Button to open Returning Modal -->
        <!-- Uncomment the following line if you have a returning modal -->
        <!-- <button id="openReturningModal" class="bg-green-600 text-white px-6 py-3 rounded-md shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-300">คืนอุปกรณ์</button> -->

        <!-- Generate Report Button -->
        <button id="openReportModal" class="bg-purple-600 text-white px-6 py-3 rounded-md shadow-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 transition duration-300">ออกรายงาน</button>
    </div>

    <?php
    include "modals.php";
    include "Remaining_quantity.php";
    ?>
</div>




<!-- Report Modal -->
<div id="reportModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">ออกรายงาน</h2>
        <form action="../mpdf/borrowing/borrowing_report.php" target="_blank" method="get">
            <div class="mb-4">
                <label for="startDate" class="block text-gray-700 font-bold mb-2">วันที่เริ่มต้น:</label>
                <input type="date" id="startDate" name="startDate" class="border border-gray-300 rounded p-2 w-full" required>
            </div>
            <div class="mb-4">
                <label for="endDate" class="block text-gray-700 font-bold mb-2">วันที่สิ้นสุด:</label>
                <input type="date" id="endDate" name="endDate" class="border border-gray-300 rounded p-2 w-full" required>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-300">สร้างรายงาน</button>
                <button type="button" id="closeReportModal" class="ml-4 bg-gray-300 text-gray-800 px-4 py-2 rounded shadow-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50 transition duration-300">ปิด</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to open modals
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        // Function to close modals
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Event listeners for modal buttons
        document.getElementById('openReportModal').addEventListener('click', function() {
            openModal('reportModal');
        });

        document.getElementById('closeReportModal').addEventListener('click', function() {
            closeModal('reportModal');
        });


        // Function to filter items in the borrowing modal
        function filterItems() {
            const searchInput = document.getElementById('searchItems').value.toLowerCase();
            const itemsList = document.getElementById('itemsList');
            const items = itemsList.getElementsByTagName('li');

            for (let i = 0; i < items.length; i++) {
                const itemName = items[i].textContent.toLowerCase();
                if (itemName.includes(searchInput)) {
                    items[i].style.display = '';
                } else {
                    items[i].style.display = 'none';
                }
            }
        }

        // Attach filter function to search input
        document.getElementById('searchItems').addEventListener('input', filterItems);
    });
</script>