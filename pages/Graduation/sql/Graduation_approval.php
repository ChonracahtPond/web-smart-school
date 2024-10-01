<?php

// // Handle graduation approval
// if (isset($_GET['id'])) {
//     $student_id = $_GET['id'];
//     $graduation_year = date("Y"); // Current year
//     $education_level = "Bachelor"; // Example, you can modify as needed
//     $institution = "Your Institution Name"; // Replace with actual institution name
//     $honors = ""; // Add any honors if applicable
//     $status = "Approved"; // Set the status to approved

//     // Insert into graduation_history table
//     $stmt = $conn->prepare("INSERT INTO graduation_history (student_id, graduation_year, education_level, institution, honors, status) VALUES (?, ?, ?, ?, ?, ?)");
//     $stmt->bind_param("isssss", $student_id, $graduation_year, $education_level, $institution, $honors, $status);




//     if ($stmt->execute()) {
//         // echo "Graduation approved for student ID: " . htmlspecialchars($student_id);
//         echo "<script>window.location.href='?page=Graduation_system&status=1';</script>";
//     } else {
//         echo "Error approving graduation: " . $stmt->error;
//         echo "<script>window.location.href='?page=Graduation_system&status=0';</script>";

//     }

//     $stmt->close();
// }

// // Handle graduation approval
// if (isset($_GET['id'])) {
//     $student_id = $_GET['id'];
//     $graduation_year = date("Y"); // Current year
//     $education_level = "Bachelor"; // Example, you can modify as needed
//     $institution = "Your Institution Name"; // Replace with actual institution name
//     $honors = ""; // Add any honors if applicable
//     $status = "Approved"; // Set the status to approved

//     // Insert into graduation_history table
//     $stmt = $conn->prepare("INSERT INTO graduation_history (student_id, graduation_year, education_level, institution, honors, status) VALUES (?, ?, ?, ?, ?, ?)");
//     $stmt->bind_param("isssss", $student_id, $graduation_year, $education_level, $institution, $honors, $status);

//     if ($stmt->execute()) {
//         // Update student's status to 5
//         $update_stmt = $conn->prepare("UPDATE students SET status = 5 WHERE student_id = ?");
//         $update_stmt->bind_param("i", $student_id);

//         if ($update_stmt->execute()) {
//             // Redirect on success
//             echo "<script>window.location.href='?page=Graduation_system&status=1';</script>";
//         } else {
//             echo "Error updating student status: " . $update_stmt->error;
//             echo "<script>window.location.href='?page=Graduation_system&status=0';</script>";
//         }

//         $update_stmt->close();
//     } else {
//         echo "Error approving graduation: " . $stmt->error;
//         echo "<script>window.location.href='?page=Graduation_system&status=0';</script>";
//     }

//     $stmt->close();
// }


if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // แปลงปีเป็นพุทธศักราช (พ.ศ.)
    $graduation_year = (int)date("Y") + 543;

    // Fetch education level from students table
    $sql = "SELECT grade_level, status FROM students WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();

    // Bind both columns (grade_level and status) to variables
    $stmt->bind_result($education_level, $student_status);
    $stmt->fetch();
    $stmt->close();

    // Define other details
    $institution = "สกร ...."; // Replace with actual institution name
    $honors = ""; // Add any honors if applicable
    $status = "จบการศึกษา"; // Set the status to approved

    // Insert into graduation_history table
    $stmt = $conn->prepare("INSERT INTO graduation_history (student_id, graduation_year, education_level, institution, honors, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $student_id, $graduation_year, $education_level, $institution, $honors, $status);

    if ($stmt->execute()) {
        // Update student's status to 5
        $update_stmt = $conn->prepare("UPDATE students SET status = 5 WHERE student_id = ?");
        $update_stmt->bind_param("i", $student_id);

        if ($update_stmt->execute()) {
            // Redirect on success
            echo "<script>window.location.href='?page=Graduation_system&status=1';</script>";
        } else {
            echo "Error updating student status: " . $update_stmt->error;
            echo "<script>window.location.href='?page=Graduation_system&status=0';</script>";
        }

        $update_stmt->close();
    } else {
        echo "Error approving graduation: " . $stmt->error;
        echo "<script>window.location.href='?page=Graduation_system&status=0';</script>";
    }

    $stmt->close();
}
