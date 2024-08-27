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
                // สร้าง query string สำหรับข้อมูลที่เลือก
                const queryString = new URLSearchParams({
                    items: JSON.stringify(selectedItems)
                }).toString();

                // เปลี่ยนเส้นทางไปยัง URL ที่สร้าง PDF
                window.location.href = `../mpdf/equipment/equipment_pdf.php?${queryString}`;
                document.getElementById('selectPdfModal').classList.add('hidden');
            } else {
                alert('กรุณาเลือกอย่างน้อยหนึ่งรายการ');
            }
        });

        // ฟังก์ชันในการโหลดรายการ
        function loadItems() {
            let itemList = document.getElementById('itemList');
            itemList.innerHTML = ''; // Clear previous items

            items.forEach(item => {
                let itemDiv = document.createElement('label');
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