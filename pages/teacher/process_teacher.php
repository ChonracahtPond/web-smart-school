<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $rank = $_POST['rank'];
    $position = $_POST['position'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // การเข้ารหัสรหัสผ่าน
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $teacher_name = $_POST['teacher_name'];
    $images = $_POST['images'];

    $sql = "INSERT INTO teachers (Fname, Lname, Rank, position, address, email, username, password, phone, gender, teacher_name, images)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssssssss', $fname, $lname, $rank, $position, $address, $email, $username, $password, $phone, $gender, $teacher_name, $images);

    if ($stmt->execute()) {
        echo "Teacher added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
