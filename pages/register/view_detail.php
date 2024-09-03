<?php
include "fetch_student.php"; // Include to fetch student data

?>

<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">รายละเอียดนักเรียน</h1>
    <div class="mt-6 flex space-x-4">
        <!-- Confirm Registration Form -->
        <form action="?page=insert_student" method="POST" class="flex-1">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($student['id']); ?>">
            <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">ยืนยันการสมัคร</button>
        </form>

        <!-- Cancel Registration Form -->
        <form action="?page=cancel_registration" method="POST" class="flex-1">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($student['id']); ?>">
            <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">ยกเลิกการสมัคร</button>
        </form>
    </div>




    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md mt-10">
        <tbody>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">ชื่อเล่น</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['nicknames']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">อีเมล</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['email']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">หมายเลขโทรศัพท์</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['phone_number']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">วันเกิด</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['date_of_birth']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">เพศ</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['gender']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">เอกสารภาพ</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['file_images']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">สถานะ</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['status']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">ชื่อ-นามสกุล</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['student_name']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">เลขบัตรประชาชน</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['national_id']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">ศาสนา</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['religion']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">สัญชาติ</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['nationality']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">อาชีพ</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['occupation']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">รายได้เฉลี่ย</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['average_income']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">ชื่อบิดา</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['father_name']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">สัญชาติของบิดา</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['father_nationality']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">อาชีพของบิดา</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['father_occupation']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">ชื่อมารดา</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['mother_name']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">สัญชาติของมารดา</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['mother_nationality']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">อาชีพของมารดา</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['mother_occupation']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">ระดับการศึกษาเดิม</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['previous_education_level']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">ปีที่จบการศึกษา</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['graduation_year']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">โรงเรียนที่จบการศึกษา</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['graduation_school']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">เขตการศึกษาบุญ</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['buddhist_district']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">จังหวัดการศึกษาบุญ</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['buddhist_province']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">บ้านเลขที่</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['housenumber']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">หมู่บ้าน</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['village']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">ตำบล</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['subdistrict']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">อำเภอ</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['ofdistrict']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">จังหวัด</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['ofprovince']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">รหัสไปรษณีย์</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['postcode']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">เอกสารบ้าน</td>
                <td class="py-3 px-6 text-sm text-gray-700">
                    <?php if (!empty($student['ofhouse'])): ?>
                        <img src="../uploads/register/<?php echo htmlspecialchars($student['ofhouse']); ?>" alt="เอกสารบ้าน" class="h-32 w-auto pointer-events-none" />
                    <?php else: ?>
                        ไม่มีเอกสาร
                    <?php endif; ?>
                </td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">บัตรประชาชน</td>
                <td class="py-3 px-6 text-sm text-gray-700">
                    <?php if (!empty($student['ofIDcard'])): ?>
                        <img src="../uploads/register/<?php echo htmlspecialchars($student['ofIDcard']); ?>" alt="บัตรประชาชน" class="h-32 w-auto pointer-events-none" />
                    <?php else: ?>
                        ไม่มีเอกสาร
                    <?php endif; ?>
                </td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">คุณวุฒิการศึกษา</td>
                <td class="py-3 px-6 text-sm text-gray-700">
                    <?php if (!empty($student['ofeducationalqualification'])): ?>
                        <img src="../uploads/register/<?php echo htmlspecialchars($student['ofeducationalqualification']); ?>" alt="คุณวุฒิการศึกษา" class="h-32 w-auto pointer-events-none" />
                    <?php else: ?>
                        ไม่มีเอกสาร
                    <?php endif; ?>
                </td>
            </tr>

            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">รูปถ่ายนักเรียน</td>
                <td class="py-3 px-6 text-sm text-gray-700">
                    <?php if (!empty($student['photoofstudent'])): ?>
                        <img src="../uploads/register/<?php echo htmlspecialchars($student['photoofstudent']); ?>" alt="รูปถ่ายนักเรียน" class="h-32 w-auto pointer-events-none" />
                    <?php else: ?>
                        ไม่มีรูปถ่าย
                    <?php endif; ?>
                </td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">เอกสารอื่นๆ</td>
                <td class="py-3 px-6 text-sm text-gray-700">
                    <?php if (!empty($student['ofotherdocuments'])): ?>
                        <img src="../uploads/register/<?php echo htmlspecialchars($student['ofotherdocuments']); ?>" alt="เอกสารอื่นๆ" class="h-32 w-auto pointer-events-none" />
                    <?php else: ?>
                        ไม่มีเอกสาร
                    <?php endif; ?>
                </td>
            </tr>

            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">ระดับชั้น</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['grade_level']); ?></td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-3 px-6 text-sm font-semibold text-gray-700">สถานะการสมัคร</td>
                <td class="py-3 px-6 text-sm text-gray-700"><?php echo htmlspecialchars($student['status_register']); ?></td>
            </tr>
        </tbody>
    </table>

</div>