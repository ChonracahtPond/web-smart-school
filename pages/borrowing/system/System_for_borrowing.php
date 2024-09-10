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

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">ระบบยืม-คืนครุภัณฑ์ และ ระบบเบิกจ่ายวัสดุสำนักงาน</h1>

    <!-- Action Buttons -->
    <div class="flex gap-4 mb-6">
        <!-- Button to open Borrowing Modal -->
        <button id="openBorrowingModal" class="bg-blue-600 text-white px-6 py-3 rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-300">ยืมอุปกรณ์</button>

        <!-- Button to open Returning Modal -->
        <!-- Uncomment the following line if you have a returning modal -->
        <!-- <button id="openReturningModal" class="bg-green-600 text-white px-6 py-3 rounded-md shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-300">คืนอุปกรณ์</button> -->
    </div>

    <?php
    include "modals.php";
    include "Remaining_quantity.php";
    ?>
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
        document.getElementById('openBorrowingModal').addEventListener('click', function() {
            openModal('borrowingModal');
        });

        document.getElementById('openReturningModal').addEventListener('click', function() {
            openModal('returningModal');
        });

        document.getElementById('closeBorrowingModal').addEventListener('click', function() {
            closeModal('borrowingModal');
        });

        document.getElementById('closeReturningModal').addEventListener('click', function() {
            closeModal('returningModal');
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