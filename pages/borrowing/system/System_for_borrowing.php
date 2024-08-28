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
    <h1 class="text-2xl font-bold mb-4">ระบบยืม-คืนครุภัณฑ์ และ ระบบเบิกจ่ายวัสดุสำนักงาน</h1>
    <div>
        <!-- Button to open Borrowing Modal -->
        <button id="openBorrowingModal" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">ยืมอุปกรณ์</button>


        <!-- Button to open Returning Modal -->
        <button id="openReturningModal" class="bg-green-500 text-white px-4 py-2 rounded">คืนอุปกรณ์</button>


        <?php
        include "modals.php";
        // include "Remaining_quantity.php"
        ?>
    </div>
    <?php
    include "Remaining_quantity.php"
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