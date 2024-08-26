<?php
include "../../../includes/db_connect.php"; // Include your database connection

// Retrieve form data
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

// Handle file uploads
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

// Check if email exists
$check_sql = "SELECT * FROM register WHERE email = '$email'";
$result = $conn->query($check_sql);

if ($result->num_rows > 0) {
    // Redirect to register.php with a parameter indicating modal should be shown
    header("Location: ../register.php?showModal=true");
    exit();
} else {
    $sql = "INSERT INTO register (grade_level, student_name, nicknames, email, phone_number, date_of_birth, gender, file_images, status, national_id, religion, nationality, occupation, average_income, father_name, father_nationality, father_occupation, mother_name, mother_nationality, mother_occupation, previous_education_level, graduation_year, graduation_school, district, province, buddhist_qualification, buddhist_qualification_year, buddhist_qualification_school, buddhist_district, buddhist_province, housenumber, village, subdistrict, ofdistrict, ofprovince, postcode, ofhouse, ofIDcard, ofeducationalqualification, photoofstudent, ofotherdocuments)
    VALUES ('$grade_level', '$student_name', '$nicknames', '$email', '$phone_number', '$date_of_birth', '$gender', '$file_images', '$status', '$national_id', '$religion', '$nationality', '$occupation', '$average_income', '$father_name', '$father_nationality', '$father_occupation', '$mother_name', '$mother_nationality', '$mother_occupation', '$previous_education_level', '$graduation_year', '$graduation_school', '$district', '$province', '$buddhist_qualification', '$buddhist_qualification_year', '$buddhist_qualification_school', '$buddhist_district', '$buddhist_province', '$housenumber', '$village', '$subdistrict', '$ofdistrict', '$ofprovince', '$postcode', '$ofhouse', '$ofIDcard', '$ofeducationalqualification', '$photoofstudent', '$ofotherdocuments')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to register.php with a parameter indicating success
        header("Location: ../register.php?success=true");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
