<?php
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root"; // กรอก username ของคุณ
$password = ""; // กรอก password ของคุณ
$dbname = "datatest";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับข้อมูลจากฟอร์ม
$grade_level = $_POST['grade_level'];
$student_name = $_POST['student_name'];
$nicknames = $_POST['nicknames'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$date_of_birth = $_POST['date_of_birth'];
$gender = $_POST['gender'];
$status = $_POST['status'];
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
$housenumber = $_POST['housenumber'];
$village = $_POST['village'];
$subdistrict = $_POST['subdistrict'];
$ofdistrict = $_POST['ofdistrict'];
$ofprovince = $_POST['ofprovince'];
$postcode = $_POST['postcode'];

// จัดการการอัปโหลดไฟล์
$target_dir = "../uploads/";
$file_images = $target_dir . basename($_FILES["file_images"]["name"]);
$ofhouse = $target_dir . basename($_FILES["ofhouse"]["name"]);
$ofIDcard = $target_dir . basename($_FILES["ofIDcard"]["name"]);
$ofeducationalqualification = $target_dir . basename($_FILES["ofeducationalqualification"]["name"]);
$photoofstudent = $target_dir . basename($_FILES["photoofstudent"]["name"]);
$ofotherdocuments = $target_dir . basename($_FILES["ofotherdocuments"]["name"]);

move_uploaded_file($_FILES["file_images"]["tmp_name"], $file_images);
move_uploaded_file($_FILES["ofhouse"]["tmp_name"], $ofhouse);
move_uploaded_file($_FILES["ofIDcard"]["tmp_name"], $ofIDcard);
move_uploaded_file($_FILES["ofeducationalqualification"]["tmp_name"], $ofeducationalqualification);
move_uploaded_file($_FILES["photoofstudent"]["tmp_name"], $photoofstudent);
move_uploaded_file($_FILES["ofotherdocuments"]["tmp_name"], $ofotherdocuments);

// เตรียมคำสั่ง SQL เพื่อเพิ่มข้อมูลลงในฐานข้อมูล
$sql = "INSERT INTO register (grade_level, student_name, nicknames, email, phone_number, date_of_birth, gender, file_images, status, national_id, religion, nationality, occupation, average_income, father_name, father_nationality, father_occupation, mother_name, mother_nationality, mother_occupation, previous_education_level, graduation_year, graduation_school, district, province, buddhist_qualification, buddhist_qualification_year, buddhist_qualification_school, buddhist_district, buddhist_province, housenumber, village, subdistrict, ofdistrict, ofprovince, postcode, ofhouse, ofIDcard, ofeducationalqualification, photoofstudent, ofotherdocuments)
VALUES ('$grade_level', '$student_name', '$nicknames', '$email', '$phone_number', '$date_of_birth', '$gender', '$file_images', '$status', '$national_id', '$religion', '$nationality', '$occupation', '$average_income', '$father_name', '$father_nationality', '$father_occupation', '$mother_name', '$mother_nationality', '$mother_occupation', '$previous_education_level', '$graduation_year', '$graduation_school', '$district', '$province', '$buddhist_qualification', '$buddhist_qualification_year', '$buddhist_qualification_school', '$buddhist_district', '$buddhist_province', '$housenumber', '$village', '$subdistrict', '$ofdistrict', '$ofprovince', '$postcode', '$ofhouse', '$ofIDcard', '$ofeducationalqualification', '$photoofstudent', '$ofotherdocuments')";

// ตรวจสอบการเพิ่มข้อมูล
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// ปิดการเชื่อมต่อ
$conn->close();
