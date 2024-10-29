<?php

// $exercise_id = isset($_GET['exercise_id']) ? intval($_GET['exercise_id']) : 0;

// // ตัวแปรสำหรับแสดงผล
// $message = "";

// // ตรวจสอบว่าแบบฟอร์มถูกส่งมา
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     if (isset($_POST['question_text'])) {
//         // รับค่าและจัดเตรียมข้อมูลสำหรับคำถาม
//         $question_text = $_POST['question_text'];
//         $question_type = $_POST['question_type'];
//         $media_url = $_POST['media_url'];
//         $score = $_POST['score'];
//         $created_at = date('Y-m-d H:i:s');
//         $updated_at = date('Y-m-d H:i:s');

//         // สร้างคำสั่ง SQL เพื่อเพิ่มข้อมูลคำถาม
//         $sql = "INSERT INTO questions (exercise_id, question_text, created_at, updated_at, question_type, media_url, score) 
//                 VALUES (?, ?, ?, ?, ?, ?, ?)";

//         // เตรียมและ bind parameters
//         if ($stmt = $conn->prepare($sql)) {
//             $stmt->bind_param("isssssi", $exercise_id, $question_text, $created_at, $updated_at, $question_type, $media_url, $score);

//             // Execute the statement
//             if ($stmt->execute()) {
//                 // รับค่า question_id ที่เพิ่งเพิ่ม
//                 $question_id = $stmt->insert_id;
//                 $message = "<div class='bg-green-200 text-green-800 p-4 rounded'>Question added successfully!</div>";

//                 // แสดงฟอร์มสำหรับเพิ่มคำตอบ
//                 if ($question_type == 'multiple_choice') {
//                     if (isset($_POST['answer_text']) && is_array($_POST['answer_text'])) {
//                         foreach ($_POST['answer_text'] as $index => $answer_text) {
//                             $is_correct = isset($_POST['is_correct'][$index]) ? 1 : 0; // กำหนดค่า is_correct

//                             // สร้างคำสั่ง SQL เพื่อเพิ่มข้อมูลคำตอบ
//                             $sql_answer = "INSERT INTO answers (question_id, answer_text, is_correct, created_at, updated_at, answer_type, score) 
//                                            VALUES (?, ?, ?, ?, ?, ?, ?)";

//                             if ($stmt_answer = $conn->prepare($sql_answer)) {
//                                 $stmt_answer->bind_param("issssis", $question_id, $answer_text, $is_correct, $created_at, $updated_at, $question_type, $score);
//                                 if ($stmt_answer->execute()) {
//                                     $message .= "<div class='bg-green-200 text-green-800 p-4 rounded'>Answer added successfully!</div>";
//                                 } else {
//                                     $message .= "<div class='bg-red-200 text-red-800 p-4 rounded'>Error adding answer: " . $stmt_answer->error . "</div>";
//                                 }
//                                 $stmt_answer->close();
//                             }
//                         }
//                     }
//                 } elseif (!empty($_POST['answer_text'])) { // สำหรับ single choice และคำถามประเภทอื่น
//                     $answer_text = $_POST['answer_text'];
//                     $is_correct = isset($_POST['is_correct']) ? 1 : 0; // กำหนดค่า is_correct

//                     // สร้างคำสั่ง SQL เพื่อเพิ่มข้อมูลคำตอบ
//                     $sql_answer = "INSERT INTO answers (question_id, answer_text, is_correct, created_at, updated_at, answer_type, score) 
//                                    VALUES (?, ?, ?, ?, ?, ?, ?)";

//                     if ($stmt_answer = $conn->prepare($sql_answer)) {
//                         $stmt_answer->bind_param("issssis", $question_id, $answer_text, $is_correct, $created_at, $updated_at, $question_type, $score);
//                         if ($stmt_answer->execute()) {
//                             $message .= "<div class='bg-green-200 text-green-800 p-4 rounded'>Answer added successfully!</div>";
//                         } else {
//                             $message .= "<div class='bg-red-200 text-red-800 p-4 rounded'>Error adding answer: " . $stmt_answer->error . "</div>";
//                         }
//                         $stmt_answer->close();
//                     }
//                 }
//                 $stmt->close();
//             } else {
//                 $message = "<div class='bg-red-200 text-red-800 p-4 rounded'>Error adding question: " . $stmt->error . "</div>";
//             }
//         }
//     }
// }

?>