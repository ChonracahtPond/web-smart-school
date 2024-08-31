<?php
// ตรวจสอบว่าการร้องขอเป็น POST หรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $student_id = $_POST['student_id'];
    $grade_level = $_POST['grade_level'];
    $section = $_POST['section'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];
    $nicknames = $_POST['nicknames'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $status = $_POST['status'];
    $student_name = $_POST['student_name'];
    $national_id = $_POST['national_id'];
    $religion = $_POST['religion'];
    $nationality = $_POST['nationality'];
    $occupation = $_POST['occupation'];
    $average_income = $_POST['average_income'];
    $father_name = $_POST['father_name'];
    $father_nationality = $_POST['father_nationality'];
    $father_occupation = $_POST['father_occupation'];
    $mother_name = $_POST['mother_name'];
    $mother_nationality = $_POST['mother_nationality'];
    $mother_occupation = $_POST['mother_occupation'];
    $previous_education_level = $_POST['previous_education_level'];
    $graduation_year = $_POST['graduation_year'];
    $graduation_school = $_POST['graduation_school'];
    $district = $_POST['district'];
    $province = $_POST['province'];
    $buddhist_qualification = $_POST['buddhist_qualification'];
    $buddhist_qualification_year = $_POST['buddhist_qualification_year'];
    $buddhist_qualification_school = $_POST['buddhist_qualification_school'];
    $buddhist_district = $_POST['buddhist_district'];
    $buddhist_province = $_POST['buddhist_province'];
    $address = $_POST['address'];

    // Handle file upload
    $file_image = ''; // Default to an empty string
    if (isset($_FILES['student_image']) && $_FILES['student_image']['error'] == 0) {
        // กำหนดไดเร็กทอรีสำหรับอัพโหลด
        $uploadDir = '../uploads/';

        // ตรวจสอบว่าไดเร็กทอรีสำหรับอัพโหลดมีอยู่แล้วหรือไม่
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // กำหนดชื่อไฟล์ที่อัพโหลด
        $fileName = basename($_FILES['student_image']['name']);
        $uploadFile = $uploadDir . $fileName;

        // ตรวจสอบประเภทไฟล์ (ให้แน่ใจว่าเป็นไฟล์ภาพ)
        $fileType = mime_content_type($_FILES['student_image']['tmp_name']);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if (in_array($fileType, $allowedTypes)) {
            // ย้ายไฟล์จากชั่วคราวไปยังไดเร็กทอรีที่ต้องการ
            if (move_uploaded_file($_FILES['student_image']['tmp_name'], $uploadFile)) {
                $file_image = $fileName; // Set the file name to the database field
            } else {
                echo "เกิดข้อผิดพลาดในการอัพโหลดไฟล์.";
            }
        } else {
            echo "ประเภทไฟล์ไม่อนุญาต.";
        }
    }

    // คำสั่ง SQL สำหรับเพิ่มข้อมูลใหม่
    $sql = "INSERT INTO students (student_id, grade_level, section, username, password, fullname, nicknames, email, phone_number, date_of_birth, gender, file_images, status, student_name, national_id, religion, nationality, occupation, average_income, father_name, father_nationality, father_occupation, mother_name, mother_nationality, mother_occupation, previous_education_level, graduation_year, graduation_school, district, province, buddhist_qualification, buddhist_qualification_year, buddhist_qualification_school, buddhist_district, buddhist_province, address)
    VALUES ('$student_id', '$grade_level', '$section', '$username', '$password', '$fullname', '$nicknames', '$email', '$phone_number', '$date_of_birth', '$gender', '$file_image', '$status', '$student_name', '$national_id', '$religion', '$nationality', '$occupation', '$average_income', '$father_name', '$father_nationality', '$father_occupation', '$mother_name', '$mother_nationality', '$mother_occupation', '$previous_education_level', '$graduation_year', '$graduation_school', '$district', '$province', '$buddhist_qualification', '$buddhist_qualification_year', '$buddhist_qualification_school', '$buddhist_district', '$buddhist_province', '$address')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New record created successfully'); window.location.href='system.php?page=ManageUsers';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">เพิ่มข้อมูลนักเรียน</h1>
    <form action="" method="POST" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4" enctype="multipart/form-data" onsubmit="return confirmUpload();">
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">รหัสนักเรียน/รหัสนักศึกษา:</label>
            <input type="text" name="student_id" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">ระดับชั้น:</label>
            <input type="text" name="grade_level" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">ห้อง:</label>
            <input type="text" name="section" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">ชื่อผู้ใช้:</label>
            <input type="text" name="username" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">รหัสผ่าน:</label>
            <input type="password" name="password" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">ชื่อจริง:</label>
            <input type="text" name="fullname" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">ชื่อเล่น:</label>
            <input type="text" name="nicknames" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">อีเมล:</label>
            <input type="email" name="email" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">หมายเลขโทรศัพท์:</label>
            <input type="text" name="phone_number" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">วันเกิด:</label>
            <input type="date" name="date_of_birth" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">เพศ:</label>
            <select name="gender" class="mt-1 p-2 w-full border border-gray-300 rounded">
                <option value="Male">ชาย</option>
                <option value="Female">หญิง</option>
            </select>
        </div>
        <!-- Add new fields here -->
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">รูปภาพนักเรียน 2 นิ้ว:</label>
            <input type="file" name="student_image" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">สถานะ:</label>
            <input type="number" name="status" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">ชื่อนักเรียน:</label>
            <input type="text" name="student_name" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">บัตรประจำตัวประชาชน:</label>
            <input type="number" name="national_id" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">ศาสนา:</label>
            <input type="text" name="religion" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">สัญชาติ:</label>
            <input type="text" name="nationality" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">อาชีพ:</label>
            <input type="text" name="occupation" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">รายได้เฉลี่ย:</label>
            <input type="number" step="0.01" name="average_income" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">ชื่อบิดา:</label>
            <input type="text" name="father_name" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">สัญชาติบิดา:</label>
            <input type="text" name="father_nationality" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">อาชีพบิดา:</label>
            <input type="text" name="father_occupation" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">ชื่อมารดา:</label>
            <input type="text" name="mother_name" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">สัญชาติของมารดา:</label>
            <input type="text" name="mother_nationality" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">อาชีพมารดา:</label>
            <input type="text" name="mother_occupation" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">ระดับการศึกษาก่อนหน้า:</label>
            <input type="text" name="previous_education_level" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">ปีที่สำเร็จการศึกษา:</label>
            <input type="number" name="graduation_year" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">โรงเรียนที่สำเร็จการศึกษา:</label>
            <input type="text" name="graduation_school" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">เขต/อำเภอ:</label>
            <input type="text" name="district" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">จังหวัด:</label>
            <input type="text" name="province" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">วุฒิการศึกษาทางพระพุทธศาสนา:</label>
            <input type="text" name="buddhist_qualification" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">ที่อยู่โรงเรียน:</label>
            <input type="text" name="school_address" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">ชื่อผู้ติดต่อในกรณีฉุกเฉิน:</label>
            <input type="text" name="emergency_contact_name" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">โทรศัพท์ติดต่อฉุกเฉิน:</label>
            <input type="text" name="emergency_contact_phone" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">โปรไฟล์โซเชียลมีเดีย:</label>
            <input type="text" name="social_media_profile" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">หมายเหตุเพิ่มเติม:</label>
            <textarea name="additional_notes" class="mt-1 p-2 w-full border border-gray-300 rounded"></textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">บันทึก</button>
        </div>
    </form>
</div>