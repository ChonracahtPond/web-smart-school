<?php
// กำหนดค่า default สำหรับการเรียงลำดับ
$orderBy = isset($_GET['order_by']) ? $_GET['order_by'] : 'item_name';
$orderDirection = isset($_GET['order_dir']) && $_GET['order_dir'] === 'desc' ? 'desc' : 'asc';

// ดึงข้อมูลครุภัณฑ์ทั้งหมดพร้อมเรียงลำดับ
$sql = "SELECT * FROM items ORDER BY $orderBy $orderDirection";
$result = $conn->query($sql);

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}
?>


<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">จัดการ ครุภัณฑ์-วัสดุอุปกรณ์</h1>

    <!-- Button to open Add Item Modal -->
    <button id="addItemBtn" class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow-lg hover:bg-blue-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500">+ เพิ่มรายการใหม่</button>
    <!-- Button to open Filter Modal -->
    <button id="filterBtn" class="px-6 py-3 bg-green-600 text-white rounded-lg shadow-lg hover:bg-green-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500">กรองรายการ</button>
    <!-- Button to open Select PDF Modal -->
    <button id="openselectpdf" class="px-6 py-3 bg-green-600 text-white rounded-lg shadow-lg hover:bg-green-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500">เลือกรายการเพื่อออกรายงาน</button>

    <!-- Table of equipment -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg mt-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 px-6 py-4 border-b border-gray-200 dark:border-gray-700">อุปกรณ์ที่มีอยู่</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-800">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            <a href="?order_by=item_name&order_dir=<?php echo $orderDirection === 'asc' ? 'desc' : 'asc'; ?>" class="hover:underline">ชื่อรายการ</a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            <a href="?order_by=item_description&order_dir=<?php echo $orderDirection === 'asc' ? 'desc' : 'asc'; ?>" class="hover:underline">คำอธิบาย</a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            <a href="?order_by=quantity&order_dir=<?php echo $orderDirection === 'asc' ? 'desc' : 'asc'; ?>" class="hover:underline">ปริมาณ</a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            <a href="?order_by=status&order_dir=<?php echo $orderDirection === 'asc' ? 'desc' : 'asc'; ?>" class="hover:underline">สถานะ</a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    <?php foreach ($items as $item): ?>
                        <?php
                        // กำหนดคลาสตามค่า quantity
                        $quantity = (int)$item['quantity'];
                        $quantityClass = 'text-green-600';
                        if ($quantity < 10) {
                            $quantityClass = 'text-red-600';
                        } elseif ($quantity >= 10 && $quantity < 20) {
                            $quantityClass = 'text-yellow-600';
                        }
                        ?>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($item['item_name']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($item['item_description']); ?></td>
                            <td class="px-6 py-4 text-sm <?php echo $quantityClass; ?> dark:text-gray-100"><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($item['status']); ?></td>
                            <td class="px-6 py-4 text-sm font-medium flex space-x-4">
                                <a href="?page=edit_item&item_id=<?php echo htmlspecialchars($item['item_id']); ?>" class="text-blue-600 hover:text-blue-900 transition duration-150 ease-in-out">แก้ไข</a>
                                <a href="?page=delete_item&delete_item=<?php echo htmlspecialchars($item['item_id']); ?>" class="text-red-600 hover:text-red-900 transition duration-150 ease-in-out" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบรายการนี้?')">ลบ</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "modal/modals.php" ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const items = <?php echo json_encode($items); ?>;

        // เปิด modal สำหรับเพิ่มไอเท็ม
        document.getElementById('addItemBtn').addEventListener('click', function() {
            document.getElementById('addItemModal').classList.remove('hidden');
        });

        // ปิด modal สำหรับเพิ่มไอเท็ม
        document.getElementById('closeAddItemModal').addEventListener('click', function() {
            document.getElementById('addItemModal').classList.add('hidden');
        });

        // เปิด modal สำหรับการกรองรายการ
        document.getElementById('filterBtn').addEventListener('click', function() {
            document.getElementById('filterModal').classList.remove('hidden');
        });

        // ปิด modal สำหรับการกรองรายการ
        document.getElementById('closeFilterModal').addEventListener('click', function() {
            document.getElementById('filterModal').classList.add('hidden');
        });

    });

    document.addEventListener('DOMContentLoaded', function() {
        const items = <?php echo json_encode($items); ?>;

        // เปิด modal สำหรับการเลือกรายการเพื่อออกรายงาน
        document.getElementById('openselectpdf').addEventListener('click', function() {
            document.getElementById('selectPdfModal').classList.remove('hidden');
            loadItems();
        });

        // ปิด modal สำหรับการเลือกรายการเพื่อออกรายงาน
        document.getElementById('closeSelectPdfModal').addEventListener('click', function() {
            document.getElementById('selectPdfModal').classList.add('hidden');
        });

        // ปิด modal เมื่อคลิกปุ่ม ยืนยัน
        document.getElementById('confirmSelection').addEventListener('click', function() {
            const selectedItems = Array.from(document.querySelectorAll('#itemList input[type="checkbox"]:checked'))
                .map(checkbox => checkbox.nextElementSibling.textContent);

            if (selectedItems.length > 0) {
                // ส่งข้อมูลที่เลือกไปยังเซิร์ฟเวอร์เพื่อสร้าง PDF
                fetch('../../mpdf/equipment/equipment_pdf.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            items: selectedItems
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.blob();
                    })
                    .then(blob => {
                        const url = URL.createObjectURL(blob);
                        window.open(url, '_blank');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('เกิดข้อผิดพลาดในการสร้าง PDF');
                    });

            } else {
                alert('กรุณาเลือกอย่างน้อยหนึ่งรายการ');
            }
        });

        // ฟังก์ชันค้นหา
        document.getElementById('searchItem').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            document.querySelectorAll('#itemList .item').forEach(item => {
                const itemName = item.querySelector('.item-name').textContent.toLowerCase();
                item.style.display = itemName.includes(searchTerm) ? 'block' : 'none';
            });
        });

        // ฟังก์ชันในการโหลดรายการ
        function loadItems() {
            const itemList = document.getElementById('itemList');
            itemList.innerHTML = ''; // Clear previous items

            items.forEach(item => {
                const itemDiv = document.createElement('label');
                itemDiv.className = 'inline-flex items-center mb-2 item';
                itemDiv.innerHTML = `
                <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" />
                <span class="ml-2 text-gray-700 item-name">${item.item_name}</span>
            `;
                itemList.appendChild(itemDiv);
            });
        }
    });
</script>