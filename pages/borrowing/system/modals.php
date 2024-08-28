<?php
// // Fetch items for borrowing, including quantity
// $sql = "SELECT item_id, item_name, quantity FROM items WHERE quantity > 0";
// $items_result = $conn->query($sql);

// // Fetch borrowings for returning
// $sql = "SELECT b.borrowing_id, i.item_name, b.quantity
//         FROM borrowings b
//         JOIN items i ON b.item_id = i.item_id
//         WHERE b.returned_at IS NULL";
// $borrowings_result = $conn->query($sql);


// Fetch items for borrowing, including quantity
$sql = "SELECT item_id, item_name, quantity FROM items WHERE quantity > 0";
$items_result = $conn->query($sql);

// Fetch users for borrower dropdown
$sql_users = "SELECT * FROM users";
$users_result = $conn->query($sql_users);

// Fetch borrowings for returning including the borrower's name
$sql_borrowings = "SELECT b.borrowing_id, i.item_name, b.quantity, u.first_name AS borrower_name
        FROM borrowings b
        JOIN items i ON b.item_id = i.item_id
        JOIN users u ON b.user_id = u.user_id
        WHERE b.returned_at IS NULL";
$borrowings_result = $conn->query($sql_borrowings);
$conn->close(); {
?>

    <!-- Borrowing Modal -->
    <div id="borrowingModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full md:w-3/4 lg:w-2/3 flex flex-col md:flex-row">
            <!-- Left Section: Items List -->
            <div class="md:w-1/3 p-4 border-r border-gray-300 flex flex-col">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800">เลือกวัสดุ</h2>
                <input type="text" id="searchItems" placeholder="ค้นหาวัสดุ" class="form-input w-full border-gray-300 rounded-lg mb-4 px-4 py-2 bg-gray-100 focus:bg-white focus:border-blue-500 transition-all" oninput="filterItems()">
                <ul id="itemsList" class="list-disc pl-5 space-y-2 overflow-y-auto max-h-72 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                    <?php while ($row = $items_result->fetch_assoc()) { ?>
                        <li class="flex items-center justify-between p-2 hover:bg-gray-100 rounded-lg transition-all">
                            <div class="flex-1">
                                <button type="button" onclick="selectItem('<?php echo $row['item_id']; ?>', '<?php echo $row['item_name']; ?>')" class="text-blue-600 hover:underline">
                                    <?php echo htmlspecialchars($row['item_name'], ENT_QUOTES, 'UTF-8'); ?>
                                </button>
                                <p class="text-gray-600 text-sm">จำนวน: <?php echo htmlspecialchars($row['quantity'], ENT_QUOTES, 'UTF-8'); ?></p>
                            </div>
                            <button type="button" onclick="addItemToBorrowList('<?php echo $row['item_id']; ?>', '<?php echo $row['item_name']; ?>')" class="bg-green-600 text-white px-3 py-1 rounded-lg hover:bg-green-700 transition-all">
                                เบิก
                            </button>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- Center Section: Borrowed Items List -->
            <div class="md:w-1/3 p-4 border-r border-gray-300 flex flex-col">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800">รายการวัสดุที่เบิก</h2>
                <div id="borrowedItemsList" class="flex-1 overflow-y-auto max-h-72 bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <!-- Borrowed items will be listed here -->
                    <p class="text-gray-600">ยังไม่มีวัสดุที่เบิก</p>
                </div>
            </div>

            <!-- Right Section: Borrower's Info and Form -->
            <div class="md:w-1/3 p-4 flex flex-col">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800">ข้อมูลการยืม</h2>
                <form id="borrowForm" action="?page=Borrow_equipment" method="POST" class="flex flex-col flex-1">
                    <div id="borrowedItemsInputs" class="mb-4">
                        <!-- Dynamically added inputs will go here -->
                    </div>
                    <div class="mb-4">
                        <label for="borrower_name" class="block text-gray-700 font-medium">ชื่อผู้ยืม:</label>
                        <select id="borrower_name" name="borrower_name" class="form-input w-full border-gray-300 rounded-lg mt-1 px-4 py-2 bg-gray-100 focus:bg-white focus:border-blue-500 transition-all" required>
                            <option value="">เลือกชื่อผู้ยืม</option>
                            <?php while ($user = $users_result->fetch_assoc()) { ?>
                                <option value="<?php echo htmlspecialchars($user['user_id'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php echo htmlspecialchars($user['first_name'], ENT_QUOTES, 'UTF-8'); ?>
                                </option>+ 'last_name'
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="return_due_date" class="block text-gray-700 font-medium">วันที่ยืม:</label>
                        <input type="date" id="return_due_date" name="return_due_date" class="form-input w-full border-gray-300 rounded-lg mt-1 px-4 py-2 bg-gray-100 focus:bg-white focus:border-blue-500 transition-all" required>
                    </div>
                    <!-- Hidden input to store items data -->
                    <input type="hidden" id="borrowedItemsData" name="borrowed_items_data">
                    <!-- Buttons -->
                    <div class="flex justify-end space-x-2 mt-auto">
                        <button type="submit" name="borrow" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all focus:outline-none focus:ring-2 focus:ring-blue-500">Borrow</button>
                        <button type="button" id="closeBorrowingModal" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-all focus:outline-none focus:ring-2 focus:ring-gray-500">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function openModal(modalId) {
                document.getElementById(modalId).classList.remove('hidden');
            }

            function closeModal(modalId) {
                document.getElementById(modalId).classList.add('hidden');
            }

            document.getElementById('openBorrowingModal').addEventListener('click', function() {
                openModal('borrowingModal');
            });

            document.getElementById('closeBorrowingModal').addEventListener('click', function() {
                closeModal('borrowingModal');
            });

            function filterItems() {
                const searchInput = document.getElementById('searchItems').value.toLowerCase();
                const itemsList = document.getElementById('itemsList');
                const items = itemsList.getElementsByTagName('li');

                for (let i = 0; i < items.length; i++) {
                    const itemName = items[i].getElementsByTagName('button')[0].textContent.toLowerCase();
                    if (itemName.includes(searchInput)) {
                        items[i].style.display = '';
                    } else {
                        items[i].style.display = 'none';
                    }
                }
            }

            document.getElementById('searchItems').addEventListener('input', filterItems);

            window.selectItem = function(itemId, itemName) {
                // Add the selected item to the list for borrowing
                addItemToBorrowList(itemId, itemName);
            }

            window.addItemToBorrowList = function(itemId, itemName) {
                const borrowedItemsList = document.getElementById('borrowedItemsList');
                const existingItem = document.getElementById(`item-${itemId}`);

                if (!existingItem) {
                    const itemDetails = `
                <div id="item-${itemId}" class="flex items-center justify-between border-b border-gray-300 pb-2 mb-2">
                    <p class="text-gray-700">วัสดุ: ${itemName}</p>
                    <input type="number" name="quantity_${itemId}" class="form-input w-24 border-gray-300 rounded-lg" min="1" placeholder="จำนวน" required>
                    <button type="button" onclick="removeItem('${itemId}')" class="bg-red-500 text-white px-4 py-1 rounded-lg hover:bg-red-600">ลบ</button>
                </div>
            `;
                    borrowedItemsList.insertAdjacentHTML('beforeend', itemDetails);
                    updateHiddenInput();
                }
            }

            window.removeItem = function(itemId) {
                const itemElement = document.getElementById(`item-${itemId}`);
                if (itemElement) {
                    itemElement.remove();
                    updateHiddenInput();
                }
            }

            function updateHiddenInput() {
                const borrowedItemsList = document.getElementById('borrowedItemsList');
                const items = borrowedItemsList.querySelectorAll('div[id^="item-"]');
                const itemsData = [];
                items.forEach(item => {
                    const itemId = item.id.replace('item-', '');
                    const quantityInput = item.querySelector('input[name="quantity_' + itemId + '"]');
                    const quantity = quantityInput ? quantityInput.value : 0;
                    itemsData.push({
                        id: itemId,
                        quantity: quantity
                    });
                });
                document.getElementById('borrowedItemsData').value = JSON.stringify(itemsData);
            }
        });
    </script>


<?php

}
// $conn->close();
?>








<?php
// $sql = "SELECT b.borrowing_id, i.item_name, b.quantity, b.borrower_name
//         FROM borrowings b
//         JOIN items i ON b.item_id = i.item_id
//         WHERE b.returned_at IS NULL";
// $borrowings_result = $conn->query($sql);
?>

<!-- <div id="returningModal" class="fixed inset-0 bg-gray-800 bg-opacity-60 flex items-center justify-center hidden">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">คืนอุปกรณ์</h2>

        <form action="?page=Return_equipment" method="post" class="space-y-6">

          
            <div>
                <label for="search_borrower" class="block text-sm font-medium text-gray-700">ค้นหาผู้ยืม:</label>
                <input type="text" id="search_borrower" name="search_borrower" class="form-input mt-1 block w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="ค้นหาชื่อผู้ยืม...">
            </div>

            <div>
                <label for="borrowing_id" class="block text-sm font-medium text-gray-700">เลือกข้อมูลการยืม:</label>
                <select id="borrowing_id" name="borrowing_id" class="form-select mt-1 block w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <?php while ($row = $borrowings_result->fetch_assoc()) { ?>
                        <option value="<?php echo $row['borrowing_id']; ?>">
                            <?php echo $row['borrower_name'] . " - " . $row['item_name'] . " - " . $row['quantity'] . " pcs"; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

           
            <div>
                <label for="return_quantity" class="block text-sm font-medium text-gray-700">จำนวนที่คืน:</label>
                <input type="number" id="quantity" name="quantity" class="form-input mt-1 block w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="1" required>
            </div>

           
            <div>
                <label for="condition" class="block text-sm font-medium text-gray-700">สภาพของอุปกรณ์:</label>
                <select id="condition" name="condition" class="form-select mt-1 block w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="good">ดี</option>
                    <option value="damaged">เสียหาย</option>
                </select>
            </div>

            
            <div class="flex justify-end space-x-4">
                <button type="submit" name="return" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">ยืนยันการคืน</button>
                <button type="button" id="closeReturningModal" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">ปิด</button>
            </div>
        </form>
    </div>
</div> -->

<!-- <script>
    // ฟังก์ชันค้นหาผู้ยืม
    document.getElementById('search_borrower').addEventListener('input', function() {
        var searchValue = this.value.toLowerCase();
        var options = document.getElementById('borrowing_id').options;

        for (var i = 0; i < options.length; i++) {
            var optionText = options[i].text.toLowerCase();
            if (optionText.includes(searchValue)) {
                options[i].style.display = '';
            } else {
                options[i].style.display = 'none';
            }
        }
    });
</script> -->