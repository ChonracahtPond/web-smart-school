<?php
// คำสั่ง SQL เพื่อดึงข้อมูลบุคลากร
$sql = "SELECT teacher_id, Fname, Lname, Rank, position, address, email, username, password, images, phone, gender, teacher_name FROM teachers";
$result = $conn->query($sql);
?>

<link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
<style>
    /*Overrides for Tailwind CSS */
    /*Form fields*/
    .dataTables_wrapper select,
    .dataTables_wrapper .dataTables_filter input {
        color: #4a5568;
        /*text-gray-700*/
        padding-left: 1rem;
        /*pl-4*/
        padding-right: 1rem;
        /*pl-4*/
        padding-top: .5rem;
        /*pl-2*/
        padding-bottom: .5rem;
        /*pl-2*/
        line-height: 1.25;
        /*leading-tight*/
        border-width: 2px;
        /*border-2*/
        border-radius: .25rem;
        /*rounded*/
        border-color: #edf2f7;
        /*border-gray-200*/
        background-color: #edf2f7;
        /*bg-gray-200*/
    }

    /*Row Hover*/
    table.dataTable.hover tbody tr:hover,
    table.dataTable.display tbody tr:hover {
        background-color: #ebf4ff;
        /*bg-indigo-100*/
    }

    /*Pagination Buttons*/
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        font-weight: 700;
        /*font-bold*/
        border-radius: .25rem;
        /*rounded*/
        border: 1px solid transparent;
        /*border border-transparent*/
    }

    /*Pagination Buttons - Current selected */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        color: #fff !important;
        /*text-white*/
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
        /*shadow*/
        font-weight: 700;
        /*font-bold*/
        border-radius: .25rem;
        /*rounded*/
        background: #667eea !important;
        /*bg-indigo-500*/
        border: 1px solid transparent;
        /*border border-transparent*/
    }

    /*Pagination Buttons - Hover */
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        color: #fff !important;
        /*text-white*/
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
        /*shadow*/
        font-weight: 700;
        /*font-bold*/
        border-radius: .25rem;
        /*rounded*/
        background: #667eea !important;
        /*bg-indigo-500*/
        border: 1px solid transparent;
        /*border border-transparent*/
    }

    /*Add padding to bottom border */
    table.dataTable.no-footer {
        border-bottom: 1px solid #e2e8f0;
        /*border-b-1 border-gray-300*/
        margin-top: 0.75em;
        margin-bottom: 0.75em;
    }

    /*Change colour of responsive icon*/
    table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before,
    table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before {
        background-color: #667eea !important;
        /*bg-indigo-500*/
    }
</style>

<div class="container mx-auto px-2">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-10">รีเซ็ตรหัสผ่าน</h1>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 my-4">
        <table id="teacher-table" class="stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
            <thead>
                <tr>
                    <th>ชื่อ</th>
                    <th>นามสกุล</th>
                    <th>ตำแหน่ง</th>
                    <th>ตำแหน่งงาน</th>
                    <th>ที่อยู่</th>
                    <th>อีเมล</th>
                    <th>โทรศัพท์</th>
                    <th>เพศ</th>
                    <th>ชื่อบุคลากร</th>
                    <th>การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Fname']); ?></td>
                            <td><?php echo htmlspecialchars($row['Lname']); ?></td>
                            <td><?php echo htmlspecialchars($row['Rank']); ?></td>
                            <td><?php echo htmlspecialchars($row['position']); ?></td>
                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><?php echo htmlspecialchars($row['gender']); ?></td>
                            <td><?php echo htmlspecialchars($row['teacher_name']); ?></td>
                            <td>
                                <button onclick='openChangePasswordModal(<?php echo json_encode($row); ?>)' class='text-red-500 hover:underline'>เปลี่ยนรหัสผ่าน</button>

                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="10" class="px-4 py-2 text-center">ไม่พบข้อมูล</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal HTML -->
<div id="change-password-modal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-lg w-full">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">เปลี่ยนรหัสผ่าน</h2>
        <form id="change-password-form" action="?page=update_password" method="POST">
            <input type="hidden" name="teacher_id" id="modal-teacher-id">
            <div id="modal-teacher-name" class="mb-4 text-gray-700 text-lg font-medium"></div>
            <div class="mb-6 relative">
                <label for="new-password" class="block text-gray-700 font-medium mb-1">รหัสผ่านใหม่</label>
                <input type="password" id="new-password" name="new_password" class="block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 pr-12 text-gray-800" required>
                <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 flex items-center px-3 mt-6 mx-auto text-gray-600 focus:outline-none">
                    <svg class="h-7 w-7 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                </button>
            </div>
            <div class="flex justify-end gap-3">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">อัปเดต</button>
                <button type="button" id="close-modal" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">ปิด</button>
            </div>
        </form>
    </div>
</div>








<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        $('#teacher-table').DataTable({
            responsive: true
        });
    });

    function openChangePasswordModal(teacher) {
        document.getElementById('modal-teacher-id').value = teacher.teacher_id;
        document.getElementById('change-password-modal').classList.remove('hidden');
    }

    function openChangePasswordModal(teacher) {
        document.getElementById('modal-teacher-id').value = teacher.teacher_id;
        document.getElementById('modal-teacher-name').innerText = `ชื่อ: ${teacher.Fname} ${teacher.Lname}`;
        document.getElementById('change-password-modal').classList.remove('hidden');
    }

    document.getElementById('close-modal').addEventListener('click', function() {
        document.getElementById('change-password-modal').classList.add('hidden');
    });

    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('new-password');
        const togglePasswordIcon = document.getElementById('toggle-password-icon');

        togglePassword.addEventListener('click', function() {
            // Toggle the type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle the icon
            togglePasswordIcon.setAttribute('d', type === 'password' ?
                'M3 12l9-9 9 9-9 9-9-9zm0 0l9 9 9-9M3 12h18' :
                'M12 5c4.418 0 8 3.582 8 8s-3.582 8-8 8-8-3.582-8-8 3.582-8 8-8zm0 11c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3z');
        });
    });
</script>