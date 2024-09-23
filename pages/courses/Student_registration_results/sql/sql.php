<?php

// รับค่า student_id จาก URL
$student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// ดึงข้อมูลจากตาราง enrollments, students และ courses
$sql = "
SELECT e.enrollment_id, e.student_id, c.course_id, c.course_name, e.semester, e.academic_year, e.grade, e.status, 
e.teacher_id, e.class, e.credits, s.student_name, c.course_type, c.credits , c.course_description , c.course_content
FROM enrollments e
JOIN students s ON e.student_id = s.student_id
JOIN courses c ON e.course_id = c.course_id
WHERE e.student_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();


// ตรวจสอบว่ามีผลลัพธ์หรือไม่
if (!$result) {
    echo "เกิดข้อผิดพลาดในการดึงข้อมูล: " . $conn->error;
    exit;
}
// // ดึงข้อมูลจากผลลัพธ์
// $data = $result->fetch_assoc();
// $student_name = $data['student_name']; // กำหนดตัวแปร $student_name


// ----------- ประมวลผล -----------
// เริ่มต้นคำนวณ
include "unit.php";

while ($row = $result->fetch_assoc()) {
    $course_type = $row['course_type'];
    $credits = $row['credits'];
    $course_content = $row['course_content'];
    $course_description = $row['course_description']; // สมมติว่ามีคอลัมน์ 'course_description' ที่บอกระดับการศึกษา


    // ตรวจสอบระดับการศึกษา
    switch ($course_content) {
        case "ทักษะการเรียนรู้":
            switch ($course_description) {
                case "ระดับประถมศึกษา":
                    // คำนวณหน่วยกิตสำหรับระดับประถมศึกษา
                    if ($course_type == "mandatory") {
                        $mandatory_credits_pathom += $credits;
                    } else if ($course_type == "elective") {
                        $elective_credits_pathom += $credits;
                    }
                    break;

                case "ระดับมัธยมศึกษาตอนต้น":
                    // คำนวณหน่วยกิตสำหรับระดับมัธยมศึกษาตอนต้น
                    if ($course_type == "mandatory") {
                        $mandatory_credits_morton += $credits;
                    } else if ($course_type == "elective") {
                        $elective_credits_morton += $credits;
                    }
                    break;

                case "ระดับมัธยมศึกษาตอนปลาย":
                    // คำนวณหน่วยกิตสำหรับระดับมัธยมศึกษาตอนปลาย
                    if ($course_type == "mandatory") {
                        $mandatory_credits_morpai += $credits;
                    } else if ($course_type == "elective") {
                        $elective_credits_morpai += $credits;
                    }
                    break;
            }
            break;

        case "ความรู้พื้นฐาน":
            // // คำนวณหน่วยกิตสำหรับระดับประถมศึกษา
            // if ($course_type == "mandatory") {
            //     $mandatory_credits_pathom1 += $credits;
            // } else if ($course_type == "elective") {
            //     $elective_credits_pathom1 += $credits;
            // }

            switch ($course_description) {
                case "ระดับประถมศึกษา":
                    // คำนวณหน่วยกิตสำหรับระดับประถมศึกษา
                    if ($course_type == "mandatory") {
                        $mandatory_credits_pathom1 += $credits;
                    } else if ($course_type == "elective") {
                        $elective_credits_pathom1 += $credits;
                    }
                    break;

                case "ระดับมัธยมศึกษาตอนต้น":
                    // คำนวณหน่วยกิตสำหรับระดับมัธยมศึกษาตอนต้น
                    if ($course_type == "mandatory") {
                        $mandatory_credits_morton1 += $credits;
                    } else if ($course_type == "elective") {
                        $elective_credits_morton1 += $credits;
                    }
                    break;

                case "ระดับมัธยมศึกษาตอนปลาย":
                    // คำนวณหน่วยกิตสำหรับระดับมัธยมศึกษาตอนปลาย
                    if ($course_type == "mandatory") {
                        $mandatory_credits_morpai1 += $credits;
                    } else if ($course_type == "elective") {
                        $elective_credits_morpai1 += $credits;
                    }
                    break;
            }
            break;

        case "การประกอบอาชีพ":
            // // คำนวณหน่วยกิตสำหรับระดับประถมศึกษา
            // if ($course_type == "mandatory") {
            //     $mandatory_credits_pathom2 += $credits;
            // } else if ($course_type == "elective") {
            //     $elective_credits_pathom2 += $credits;
            // }

            switch ($course_description) {
                case "ระดับประถมศึกษา":
                    // คำนวณหน่วยกิตสำหรับระดับประถมศึกษา
                    if ($course_type == "mandatory") {
                        $mandatory_credits_pathom2 += $credits;
                    } else if ($course_type == "elective") {
                        $elective_credits_pathom2 += $credits;
                    }
                    break;

                case "ระดับมัธยมศึกษาตอนต้น":
                    // คำนวณหน่วยกิตสำหรับระดับมัธยมศึกษาตอนต้น
                    if ($course_type == "mandatory") {
                        $mandatory_credits_morton2 += $credits;
                    } else if ($course_type == "elective") {
                        $elective_credits_morton2 += $credits;
                    }
                    break;

                case "ระดับมัธยมศึกษาตอนปลาย":
                    // คำนวณหน่วยกิตสำหรับระดับมัธยมศึกษาตอนปลาย
                    if ($course_type == "mandatory") {
                        $mandatory_credits_morpai2 += $credits;
                    } else if ($course_type == "elective") {
                        $elective_credits_morpai2 += $credits;
                    }
                    break;
            }
            break;
        case "ทักษะการดำเนินชีวิต":
            // // คำนวณหน่วยกิตสำหรับระดับมัธยมศึกษาตอนปลาย
            // if ($course_type == "mandatory") {
            //     $mandatory_credits_content3 += $credits;
            // } else if ($course_type == "elective") {
            //     $elective_credits_content3 += $credits;
            // }


            switch ($course_description) {
                case "ระดับประถมศึกษา":
                    // คำนวณหน่วยกิตสำหรับระดับประถมศึกษา
                    if ($course_type == "mandatory") {
                        $mandatory_credits_pathom3 += $credits;
                    } else if ($course_type == "elective") {
                        $elective_credits_pathom3 += $credits;
                    }
                    break;

                case "ระดับมัธยมศึกษาตอนต้น":
                    // คำนวณหน่วยกิตสำหรับระดับมัธยมศึกษาตอนต้น
                    if ($course_type == "mandatory") {
                        $mandatory_credits_morton3 += $credits;
                    } else if ($course_type == "elective") {
                        $elective_credits_morton3 += $credits;
                    }
                    break;

                case "ระดับมัธยมศึกษาตอนปลาย":
                    // คำนวณหน่วยกิตสำหรับระดับมัธยมศึกษาตอนปลาย
                    if ($course_type == "mandatory") {
                        $mandatory_credits_morpai3 += $credits;
                    } else if ($course_type == "elective") {
                        $elective_credits_morpai3 += $credits;
                    }
                    break;
            }
            break;

        case "การพัฒนาสังคม":
            // // คำนวณหน่วยกิตสำหรับระดับมัธยมศึกษาตอนปลาย
            // if ($course_type == "mandatory") {
            //     $mandatory_credits_content4 += $credits;
            // } else if ($course_type == "elective") {
            //     $elective_credits_content4 += $credits;
            // }

            switch ($course_description) {
                case "ระดับประถมศึกษา":
                    // คำนวณหน่วยกิตสำหรับระดับประถมศึกษา
                    if ($course_type == "mandatory") {
                        $mandatory_credits_pathom4 += $credits;
                    } else if ($course_type == "elective") {
                        $elective_credits_pathom4 += $credits;
                    }
                    break;

                case "ระดับมัธยมศึกษาตอนต้น":
                    // คำนวณหน่วยกิตสำหรับระดับมัธยมศึกษาตอนต้น
                    if ($course_type == "mandatory") {
                        $mandatory_credits_morton4 += $credits;
                    } else if ($course_type == "elective") {
                        $elective_credits_morton4 += $credits;
                    }
                    break;

                case "ระดับมัธยมศึกษาตอนปลาย":
                    // คำนวณหน่วยกิตสำหรับระดับมัธยมศึกษาตอนปลาย
                    if ($course_type == "mandatory") {
                        $mandatory_credits_morpai4 += $credits;
                    } else if ($course_type == "elective") {
                        $elective_credits_morpai4 += $credits;
                    }
                    break;
            }
            break;

        default:
            // ถ้าไม่ตรงกับกรณีใดๆ
            // echo "ระดับการศึกษาไม่ถูกต้อง";
            break;
    }
};








// ----------- ช่องรวม -----------
// เริ่มต้นคำนวณ
$mandatory_credits = $mandatory_credits_pathom + $mandatory_credits_pathom1 + $mandatory_credits_pathom2 + $mandatory_credits_pathom3 + $mandatory_credits_pathom4;
$elective_credits = $elective_credits_pathom + $elective_credits_pathom1 + $elective_credits_pathom2 + $elective_credits_pathom3 + $elective_credits_pathom4;

$mandatory_credits1 = $mandatory_credits_morton + $mandatory_credits_morton1 + $mandatory_credits_morton2 + $mandatory_credits_morton3 + $mandatory_credits_morton4; // สำหรับมัธยมศึกษาตอนต้น
$elective_credits1 =  $elective_credits_morton + $elective_credits_morton1 + $elective_credits_morton2 + $elective_credits_morton3 + $elective_credits_morton4;

$mandatory_credits2 = $mandatory_credits_morpai + $mandatory_credits_morpai1 + $mandatory_credits_morpai2 + $mandatory_credits_morpai3 + $mandatory_credits_morpai4;
$elective_credits2 = $elective_credits_morpai + $elective_credits_morpai1 + $elective_credits_morpai2 + $elective_credits_morpai3 + $elective_credits_morpai4;


include "class_style.php";


