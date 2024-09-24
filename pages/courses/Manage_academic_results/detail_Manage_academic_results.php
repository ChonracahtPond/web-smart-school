<?php
include "sql/sql.php";
?>

<div class="mx-auto px-2 mt-5 ">

    <h1 class="flex items-center font-sans font-bold break-normal text-indigo-500 px-2 text-xl md:text-2xl">
        จัดการผลการเรียน (รหัสนักศึกษา: <?php echo htmlspecialchars($student_id); ?> )
    </h1>
    <h1 class="flex items-center font-sans font-bold break-normal text-indigo-500 px-2 text-xl md:text-2xl">
        ชื่อ: <?php echo htmlspecialchars($student_name); ?>
    </h1>

    <?php
    // แสดงชื่อของนักเรียน
    if ($row = $result->fetch_assoc()) {
        echo "<h1 class='flex items-center font-sans font-bold break-normal text-indigo-500 px-2 py-4 text-xl md:text-2xl'>
                ชื่อ: " . htmlspecialchars($row['student_name']) . "
              </h1>";
    }

    // Reset pointer ของผลลัพธ์เพื่อแสดงข้อมูลในตาราง
    $result->data_seek(0);
    ?>

    <div class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
        <table class="stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
            <thead class="text-white" style="background-color: <?php echo htmlspecialchars($tool_color); ?>;">
                <tr>
                    <th>รหัสการลงทะเบียน</th>
                    <th>รหัสหลักสูตร</th>
                    <th>ชื่อหลักสูตร</th>
                    <th>เทอม</th>
                    <th>ปีการศึกษา</th>
                    <th>เกรด</th>
                    <th>สถานะ</th>
                    <th>รหัสครู</th>
                    <th>หน่วยกิต</th>
                    <th>ประเภท</th>
                    <th>การกระทำ</th> <!-- เพิ่มหัวข้อใหม่สำหรับปุ่มแก้ไข -->
                </tr>
            </thead>
            <tbody>
                <?php
                // แสดงข้อมูล
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['enrollment_id']}</td>";
                    echo "<td>{$row['course_id']}</td>";
                    echo "<td>" . htmlspecialchars($row['course_name']) . "</td>";
                    echo "<td>{$row['semester']}</td>";
                    echo "<td>{$row['academic_year']}</td>";
                    echo "<td>{$row['grade']}</td>";
                    echo "<td>{$row['status']}</td>";
                    echo "<td>{$row['teacher_id']}</td>";
                    echo "<td>{$row['credits']}</td>";
                    echo "<td>" . htmlspecialchars($row['course_type']) . "</td>";

                    // ปุ่มแก้ไข เพื่อแสดง modal
                    echo "<td>
                            <button class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded edit-btn' 
                                    data-enrollment-id='{$row['enrollment_id']}'
                                    data-course-id='{$row['course_id']}'
                                    data-course-name='" . htmlspecialchars($row['course_name']) . "'
                                    data-semester='{$row['semester']}'
                                    data-academic-year='{$row['academic_year']}'
                                    data-grade='{$row['grade']}'
                                    data-status='{$row['status']}'
                                    data-credits='{$row['credits']}'>
                                แก้ไข
                            </button>
                          </td>";

                    echo "</tr>";
                }
                ?>
            </tbody>
            <tfoot class="text-white" style="background-color: <?php echo htmlspecialchars($tool_color); ?>;">
                <tr>
                    <th>รหัสการลงทะเบียน</th>
                    <th>รหัสหลักสูตร</th>
                    <th>ชื่อหลักสูตร</th>
                    <th>เทอม</th>
                    <th>ปีการศึกษา</th>
                    <th>เกรด</th>
                    <th>สถานะ</th>
                    <th>รหัสครู</th>
                    <th>หน่วยกิต</th>
                    <th>ประเภท</th>
                    <th>การกระทำ</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?php include "modal/modal.php"; ?>

<!-- jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        // DataTable setup
        $('.stripe').DataTable({
            responsive: true
        });

        // เปิด modal และแสดงข้อมูลเมื่อคลิกปุ่มแก้ไข
        $('.edit-btn').on('click', function() {
            $('#enrollment_id').val($(this).data('enrollment-id'));
            $('#course_id').val($(this).data('course-id'));
            $('#course_name').val($(this).data('course-name'));
            $('#semester').val($(this).data('semester'));
            $('#academic_year').val($(this).data('academic-year'));
            $('#grade').val($(this).data('grade'));
            $('#status').val($(this).data('status'));
            $('#credits').val($(this).data('credits'));
            $('#editModal').removeClass('hidden');
        });

        // ปิด modal เมื่อคลิกปุ่มยกเลิก
        $('#closeModal').on('click', function() {
            $('#editModal').addClass('hidden');
        });
    });
</script>

<?php
// ปิดการเชื่อมต่อ
$stmt->close();
$conn->close();
?>