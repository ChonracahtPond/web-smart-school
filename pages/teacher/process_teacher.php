<?php

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $fname = $_POST['fname'];
//     $lname = $_POST['lname'];
//     $rank = $_POST['rank'];
//     $position = $_POST['position'];
//     $address = $_POST['address'];
//     $email = $_POST['email'];
//     $username = $_POST['username'];
//     $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // การเข้ารหัสรหัสผ่าน
//     $phone = $_POST['phone'];
//     $gender = $_POST['gender'];
//     $teacher_name = $_POST['teacher_name'];
//     $images = $_POST['images'];

//     $sql = "INSERT INTO teachers (Fname, Lname, Rank, position, address, email, username, password, phone, gender, teacher_name, images)
//             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param('ssssssssssss', $fname, $lname, $rank, $position, $address, $email, $username, $password, $phone, $gender, $teacher_name, $images);

//     if ($stmt->execute()) {
//         echo "Teacher added successfully!";
//     } else {
//         echo "Error: " . $stmt->error;
//     }
// }


// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $fname = $conn->real_escape_string($_POST['fname']);
    $lname = $conn->real_escape_string($_POST['lname']);
    $rank = $conn->real_escape_string($_POST['rank']);
    $position = $conn->real_escape_string($_POST['position']);
    $address = $conn->real_escape_string($_POST['address']);
    $email = $conn->real_escape_string($_POST['email']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password without escaping
    $images = $conn->real_escape_string($_POST['images']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $teacher_name = $conn->real_escape_string($_POST['teacher_name']);

    // Prepare SQL statement
    $sql = "INSERT INTO teachers (Fname, Lname, Rank, position, address, email, username, password, images, phone, gender, teacher_name) 
            VALUES ('$fname', '$lname', '$rank', '$position', '$address', '$email', '$username', '$password', '$images', '$phone', '$gender', '$teacher_name')";

    // Execute query
    if ($conn->query($sql) === TRUE) {
        // Redirect to the teacher management page with a success message
        echo "<script>window.location.href='?page=Teacher_Manage&status=1';</script>";
        exit();
    } else {
        // Redirect to the teacher management page with an error message
        echo "<script>window.location.href='?page=Teacher_Manage&status=0';</script>";
        exit();
    }
} else {
    // Redirect to the teacher management page if accessed directly
    echo "<script>window.location.href='?page=Teacher_Manage';</script>";
    exit();
}
