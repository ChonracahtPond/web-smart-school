<?php
include "fetch_student.php"; // Include to fetch student data

// Format the password as the date of birth
$dateOfBirth = new DateTime($student['date_of_birth']);
$formattedPassword = $dateOfBirth->format('d-m-Y');

// Construct the address from multiple fields
$address = implode(' ', array_filter([
    $student['housenumber'],
    $student['village'],
    $student['subdistrict'],
    $student['ofdistrict'],
    $student['ofprovince'],
    $student['postcode']
]));

// Ensure all required fields have valid values
$username = !empty($student['username']) ? $student['username'] : 'default_username'; // Provide a default value if missing
$section = !empty($student['section']) ? $student['section'] : 'default_section'; // Provide a default value if missing
$fullname = !empty($student['student_name']) ? $student['student_name'] : 'default_fullname'; // Provide a default value if missing

// Insert data into the students table
$insertSql = "INSERT INTO students (grade_level, section, username, password, fullname, nicknames, email, phone_number, date_of_birth, gender, file_images, status, student_name, national_id, religion, nationality, occupation, average_income, father_name, father_nationality, father_occupation, mother_name, mother_nationality, mother_occupation, previous_education_level, graduation_year, graduation_school, district, province, buddhist_qualification, buddhist_qualification_year, buddhist_qualification_school, buddhist_district, buddhist_province, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$insertStmt = $conn->prepare($insertSql);
if (!$insertStmt) {
    die("Error preparing insert statement: " . $conn->error);
}
$insertStmt->bind_param(
    'sssssssssssssssssssssssssssssssssss',
    $student['grade_level'],
    $section, // Use the default value if section is missing
    $username, // Use the default value if username is missing
    $formattedPassword, // Use formatted date_of_birth as password
    $fullname, // Use student_name as fullname
    $student['nicknames'],
    $student['email'],
    $student['phone_number'],
    $student['date_of_birth'],
    $student['gender'],
    $student['file_images'],
    $student['status'],
    $student['student_name'], // Use student_name as it is for this field
    $student['national_id'],
    $student['religion'],
    $student['nationality'],
    $student['occupation'],
    $student['average_income'],
    $student['father_name'],
    $student['father_nationality'],
    $student['father_occupation'],
    $student['mother_name'],
    $student['mother_nationality'],
    $student['mother_occupation'],
    $student['previous_education_level'],
    $student['graduation_year'],
    $student['graduation_school'],
    $student['district'],
    $student['province'],
    $student['buddhist_qualification'],
    $student['buddhist_qualification_year'],
    $student['buddhist_qualification_school'],
    $student['buddhist_district'],
    $student['buddhist_province'],
    $address // Use the concatenated address
);

if ($insertStmt->execute()) {
    // Update the register table status_register
    $updateSql = "UPDATE register SET status_register = 4 WHERE id = ?";
    $updateStmt = $conn->prepare($updateSql);
    if (!$updateStmt) {
        die("Error preparing update statement: " . $conn->error);
    }
    $updateStmt->bind_param('i', $id);

    if ($updateStmt->execute()) {
        // echo "Registration confirmed successfully.";
        echo "<script>window.location.href='?page=New_student_registration_system&status=1';</script>";
    } else {
        // echo "Error updating registration status: " . $updateStmt->error;
        echo "<script>window.location.href='?page=New_student_registration_system&status=0';</script>";
    }

    $updateStmt->close();
} else {
    // echo "Error inserting student data: " . $insertStmt->error;
    echo "<script>window.location.href='?page=New_student_registration_system&status=0';</script>";
}

$insertStmt->close();
$conn->close();
// New_student_registration_system