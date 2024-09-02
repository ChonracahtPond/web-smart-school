<?php
// รับค่า student_id จากพารามิเตอร์ URL
$student_id = $_GET['id'];

// คำสั่ง SQL สำหรับดึงข้อมูลของผู้ใช้ที่ต้องการแก้ไข
$sql = "SELECT * FROM students WHERE student_id = $student_id";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    echo "No record found";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $new_student_id = $_POST['student_id'];
    $grade_level = $_POST['grade_level'];
    $section = $_POST['section'];
    $username = $_POST['username'];
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
    $upload_dir = '../../../uploads/images_student/';
    $file_images = '';
    if (isset($_FILES['file_images']) && $_FILES['file_images']['error'] == UPLOAD_ERR_OK) {
        $file_tmp_name = $_FILES['file_images']['tmp_name'];
        $file_name = basename($_FILES['file_images']['name']);
        $file_path = $upload_dir . $file_name;

        if (move_uploaded_file($file_tmp_name, $file_path)) {
            $file_images = $file_name;
        } else {
            echo "<script>alert('Failed to upload image.');</script>";
        }
    } else {
        // If no file was uploaded, keep the old file path
        $file_images = $_POST['old_file_images'];
    }

    // ตรวจสอบว่า ID ใหม่ซ้ำกับข้อมูลอื่นหรือไม่
    $id_check_sql = "SELECT * FROM students WHERE student_id = '$new_student_id' AND student_id != '$student_id'";
    $id_check_result = $conn->query($id_check_sql);

    if ($id_check_result->num_rows > 0) {
        echo "<script>alert('ID already exists. Please choose a different ID.');</script>";
    } else {
        // คำสั่ง SQL สำหรับอัพเดตข้อมูล
        $sql = "UPDATE students SET student_id='$new_student_id', grade_level='$grade_level', section='$section', username='$username', fullname='$fullname', nicknames='$nicknames', email='$email', phone_number='$phone_number', date_of_birth='$date_of_birth', gender='$gender', file_images='$file_images', status='$status', student_name='$student_name', national_id='$national_id', religion='$religion', nationality='$nationality', occupation='$occupation', average_income='$average_income', father_name='$father_name', father_nationality='$father_nationality', father_occupation='$father_occupation', mother_name='$mother_name', mother_nationality='$mother_nationality', mother_occupation='$mother_occupation', previous_education_level='$previous_education_level', graduation_year='$graduation_year', graduation_school='$graduation_school', district='$district', province='$province', buddhist_qualification='$buddhist_qualification', buddhist_qualification_year='$buddhist_qualification_year', buddhist_qualification_school='$buddhist_qualification_school', buddhist_district='$buddhist_district', buddhist_province='$buddhist_province', address='$address' WHERE student_id='$student_id'";

        if ($conn->query($sql) === TRUE) {
            echo "<script>window.location.href='?page=Manage_student&status=1';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            echo "<script> window.location.href='?page=Manage_student&status=1';</script>";
        }
    }
}
?>


<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-4">แก้ไขข้อมูลนักเรียน</h1>
    <form action="" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Student ID:</label>
            <input type="text" name="student_id" value="<?php echo htmlspecialchars($row['student_id']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Grade Level:</label>
            <input type="text" name="grade_level" value="<?php echo htmlspecialchars($row['grade_level']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Section:</label>
            <input type="text" name="section" value="<?php echo htmlspecialchars($row['section']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Username:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($row['username']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Full Name:</label>
            <input type="text" name="fullname" value="<?php echo htmlspecialchars($row['fullname']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Nicknames:</label>
            <input type="text" name="nicknames" value="<?php echo htmlspecialchars($row['nicknames']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Phone Number:</label>
            <input type="text" name="phone_number" value="<?php echo htmlspecialchars($row['phone_number']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Date of Birth:</label>
            <input type="date" name="date_of_birth" value="<?php echo htmlspecialchars($row['date_of_birth']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Gender:</label>
            <select name="gender" class="mt-1 p-2 w-full border border-gray-300 rounded">
                <option value="Male" <?php if ($row['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if ($row['gender'] == 'Female') echo 'selected'; ?>>Female</option>
            </select>
        </div>

        <!-- Add additional fields as needed -->
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">File Images:</label>
            <input type="file" name="file_images" value="<?php echo htmlspecialchars($row['file_images']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Status:</label>
            <input type="text" name="status" value="<?php echo htmlspecialchars($row['status']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Student Name:</label>
            <input type="text" name="student_name" value="<?php echo htmlspecialchars($row['student_name']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">National ID:</label>
            <input type="text" name="national_id" value="<?php echo htmlspecialchars($row['national_id']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Religion:</label>
            <input type="text" name="religion" value="<?php echo htmlspecialchars($row['religion']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Nationality:</label>
            <input type="text" name="nationality" value="<?php echo htmlspecialchars($row['nationality']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Occupation:</label>
            <input type="text" name="occupation" value="<?php echo htmlspecialchars($row['occupation']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Average Income:</label>
            <input type="text" name="average_income" value="<?php echo htmlspecialchars($row['average_income']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Father's Name:</label>
            <input type="text" name="father_name" value="<?php echo htmlspecialchars($row['father_name']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Father's Nationality:</label>
            <input type="text" name="father_nationality" value="<?php echo htmlspecialchars($row['father_nationality']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Father's Occupation:</label>
            <input type="text" name="father_occupation" value="<?php echo htmlspecialchars($row['father_occupation']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Mother's Name:</label>
            <input type="text" name="mother_name" value="<?php echo htmlspecialchars($row['mother_name']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Mother's Nationality:</label>
            <input type="text" name="mother_nationality" value="<?php echo htmlspecialchars($row['mother_nationality']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Mother's Occupation:</label>
            <input type="text" name="mother_occupation" value="<?php echo htmlspecialchars($row['mother_occupation']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Previous Education Level:</label>
            <input type="text" name="previous_education_level" value="<?php echo htmlspecialchars($row['previous_education_level']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Graduation Year:</label>
            <input type="text" name="graduation_year" value="<?php echo htmlspecialchars($row['graduation_year']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Graduation School:</label>
            <input type="text" name="graduation_school" value="<?php echo htmlspecialchars($row['graduation_school']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">District:</label>
            <input type="text" name="district" value="<?php echo htmlspecialchars($row['district']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Province:</label>
            <input type="text" name="province" value="<?php echo htmlspecialchars($row['province']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Buddhist Qualification:</label>
            <input type="text" name="buddhist_qualification" value="<?php echo htmlspecialchars($row['buddhist_qualification']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Buddhist Qualification Year:</label>
            <input type="text" name="buddhist_qualification_year" value="<?php echo htmlspecialchars($row['buddhist_qualification_year']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Buddhist Qualification School:</label>
            <input type="text" name="buddhist_qualification_school" value="<?php echo htmlspecialchars($row['buddhist_qualification_school']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Buddhist District:</label>
            <input type="text" name="buddhist_district" value="<?php echo htmlspecialchars($row['buddhist_district']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Buddhist Province:</label>
            <input type="text" name="buddhist_province" value="<?php echo htmlspecialchars($row['buddhist_province']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Address:</label>
            <textarea name="address" class="mt-1 p-2 w-full border border-gray-300 rounded"><?php echo htmlspecialchars($row['address']); ?></textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">Update User</button>
    </form>
</div>