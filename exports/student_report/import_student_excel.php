<?php
require_once '../vendor/autoload.php';
include('../../includes/db_connect.php');
error_reporting(~E_NOTICE);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

// ตรวจสอบว่ามีการอัปโหลดไฟล์หรือไม่
if (isset($_FILES['excel_file'])) {
    $file = $_FILES['excel_file']['tmp_name'];
    $reader = new Xlsx();
    $spreadsheet = $reader->load($file);
    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray();

    // ประมวลผลข้อมูล (ข้ามแถวหัวข้อ)
    for ($i = 1; $i < count($data); $i++) {
        $row = $data[$i];

        // ดึงข้อมูลนักเรียนจากแถว
        $student_id = isset($row[0]) ? $row[0] : null;
        $grade_level = isset($row[1]) ? $row[1] : null;
        $section = isset($row[2]) ? $row[2] : null;
        $username = isset($row[3]) ? $row[3] : null;
        $password = isset($row[4]) ? $row[4] : null;
        $fullname = isset($row[5]) ? $row[5] : null;
        $nicknames = isset($row[6]) ? $row[6] : null;
        $email = isset($row[7]) ? $row[7] : null;
        $phone_number = isset($row[8]) ? $row[8] : null;
        $date_of_birth = isset($row[9]) ? $row[9] : null;
        $gender = isset($row[10]) ? $row[10] : null;
        $file_images = isset($row[11]) ? $row[11] : null;
        $status = isset($row[12]) ? $row[12] : null;
        $student_name = isset($row[13]) ? $row[13] : null;
        $national_id = isset($row[14]) ? $row[14] : null;
        $religion = isset($row[15]) ? $row[15] : null;
        $nationality = isset($row[16]) ? $row[16] : null;
        $occupation = isset($row[17]) ? $row[17] : null;
        $average_income = isset($row[18]) ? $row[18] : null;
        $father_name = isset($row[19]) ? $row[19] : null;
        $father_nationality = isset($row[20]) ? $row[20] : null;
        $father_occupation = isset($row[21]) ? $row[21] : null;
        $mother_name = isset($row[22]) ? $row[22] : null;
        $mother_nationality = isset($row[23]) ? $row[23] : null;
        $mother_occupation = isset($row[24]) ? $row[24] : null;
        $previous_education_level = isset($row[25]) ? $row[25] : null;
        $graduation_year = isset($row[26]) ? $row[26] : null;
        $graduation_school = isset($row[27]) ? $row[27] : null;
        $district = isset($row[28]) ? $row[28] : null;
        $province = isset($row[29]) ? $row[29] : null;
        $buddhist_qualification = isset($row[30]) ? $row[30] : null;
        $buddhist_qualification_year = isset($row[31]) ? $row[31] : null;
        $buddhist_qualification_school = isset($row[32]) ? $row[32] : null;
        $buddhist_district = isset($row[33]) ? $row[33] : null;
        $buddhist_province = isset($row[34]) ? $row[34] : null;
        $address = isset($row[35]) ? $row[35] : null;

        // คำสั่ง SQL INSERT หรือ UPDATE
        $sql = "INSERT INTO students (
            student_id, grade_level, section, username, password, fullname, nicknames, email, phone_number, date_of_birth, gender, file_images, status, student_name, national_id, religion, nationality, occupation, average_income, father_name, father_nationality, father_occupation, mother_name, mother_nationality, mother_occupation, previous_education_level, graduation_year, graduation_school, district, province, buddhist_qualification, buddhist_qualification_year, buddhist_qualification_school, buddhist_district, buddhist_province, address
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        ) ON DUPLICATE KEY UPDATE
            grade_level = VALUES(grade_level),
            section = VALUES(section),
            username = VALUES(username),
            password = VALUES(password),
            fullname = VALUES(fullname),
            nicknames = VALUES(nicknames),
            email = VALUES(email),
            phone_number = VALUES(phone_number),
            date_of_birth = VALUES(date_of_birth),
            gender = VALUES(gender),
            file_images = VALUES(file_images),
            status = VALUES(status),
            student_name = VALUES(student_name),
            national_id = VALUES(national_id),
            religion = VALUES(religion),
            nationality = VALUES(nationality),
            occupation = VALUES(occupation),
            average_income = VALUES(average_income),
            father_name = VALUES(father_name),
            father_nationality = VALUES(father_nationality),
            father_occupation = VALUES(father_occupation),
            mother_name = VALUES(mother_name),
            mother_nationality = VALUES(mother_nationality),
            mother_occupation = VALUES(mother_occupation),
            previous_education_level = VALUES(previous_education_level),
            graduation_year = VALUES(graduation_year),
            graduation_school = VALUES(graduation_school),
            district = VALUES(district),
            province = VALUES(province),
            buddhist_qualification = VALUES(buddhist_qualification),
            buddhist_qualification_year = VALUES(buddhist_qualification_year),
            buddhist_qualification_school = VALUES(buddhist_qualification_school),
            buddhist_district = VALUES(buddhist_district),
            buddhist_province = VALUES(buddhist_province),
            address = VALUES(address)";

        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }

        // กำหนดประเภทของพารามิเตอร์ใน bind_param
        $stmt->bind_param(
            'iisssssssssssssssssssssssssssssssss',
            $student_id,
            $grade_level,
            $section,
            $username,
            $password,
            $fullname,
            $nicknames,
            $email,
            $phone_number,
            $date_of_birth,
            $gender,
            $file_images,
            $status,
            $student_name,
            $national_id,
            $religion,
            $nationality,
            $occupation,
            $average_income,
            $father_name,
            $father_nationality,
            $father_occupation,
            $mother_name,
            $mother_nationality,
            $mother_occupation,
            $previous_education_level,
            $graduation_year,
            $graduation_school,
            $district,
            $province,
            $buddhist_qualification,
            $buddhist_qualification_year,
            $buddhist_qualification_school,
            $buddhist_district,
            $buddhist_province,
            $address
        );

        if (!$stmt->execute()) {
            die('Execute failed: ' . $stmt->error);
        }
    }

    echo "Data imported successfully!";
} else {
    echo "No file uploaded.";
}

$conn->close();
