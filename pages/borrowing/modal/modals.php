<!-- Add Item Modal -->
<div id="addItemModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-md w-1/3">
        <h2 class="text-xl font-semibold mb-4">Add New Item</h2>
        <form action="?page=add_item" method="POST">
            <div class="mb-4">
                <label for="item_name" class="block text-sm font-medium text-gray-700">Item Name</label>
                <input type="text" name="item_name" id="item_name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="item_description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="item_description" id="item_description" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm"></textarea>
            </div>
            <div class="mb-4">
                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                    <option value="available">มีอยู่</option>
                    <option value="unavailable">ไม่พร้อมใช้งาน</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="submit" name="add_item" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Add Item</button>
                <button type="button" id="closeAddItemModal" class="ml-4 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Close</button>
            </div>
        </form>
    </div>
</div>

<!-- Filter Modal -->
<div id="filterModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-800 w-full max-w-md">
            <div class="flex justify-between items-center p-5 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">กรองรายการ</h3>
                <button id="closeFilterModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <span class="sr-only">Close modal</span>
                    &times;
                </button>
            </div>
            <div class="p-6">
                <form>
                    <div class="mb-4">
                        <label for="filterSelect" class="block text-sm font-medium text-gray-700 dark:text-gray-200">เลือกตัวกรอง</label>
                        <select id="filterSelect" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-gray-700 dark:text-gray-300">
                            <option value="all">ทั้งหมด</option>
                            <option value="low_quantity">ปริมาณน้อยกว่า 10</option>
                            <option value="medium_quantity">ปริมาณระหว่าง 10-20</option>
                            <option value="high_quantity">ปริมาณมากกว่า 20</option>
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500">กรอง</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>





<!-- Select PDF Modal -->
<div id="selectPdfModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg p-6 w-full max-w-lg">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">เลือกรายการเพื่อออกรายงาน</h2>
        <input type="text" id="searchItem" placeholder="ค้นหา..." class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
        <div id="itemList" class="max-h-64 overflow-y-auto">
            <!-- Items will be inserted here by JavaScript -->
        </div>
        <div class="mt-6 flex justify-end space-x-4">
            <button id="closeSelectPdfModal" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 transition duration-150 ease-in-out focus:outline-none">ยกเลิก</button>
            <button id="confirmSelection" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow-lg hover:bg-blue-700 transition duration-150 ease-in-out focus:outline-none">ยืนยัน</button>
        </div>
    </div>
</div>