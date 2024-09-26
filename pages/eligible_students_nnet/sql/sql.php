<?php
// ดึงข้อมูลระดับชั้นที่ไม่ซ้ำจากฐานข้อมูล
$grade_levels_result = $conn->query("SELECT DISTINCT grade_level FROM students");
if ($grade_levels_result === false) {
    die('Query failed: ' . $conn->error); // ตรวจสอบการทำงานของ query
}
$grade_levels = [];
while ($row = $grade_levels_result->fetch_assoc()) {
    $grade_levels[] = $row['grade_level'];
}

// ตรวจสอบว่ามีการเลือกระดับชั้นหรือไม่
$selected_grade_level = isset($_POST['grade_level']) ? $_POST['grade_level'] : '';

// ฟังก์ชันสำหรับดึงข้อมูลนักเรียนตามระดับชั้นที่เลือก
function fetchStudents($conn, $grade_level = null)
{
    // SQL สำหรับดึงข้อมูลนักเรียนที่มีสถานะเป็น 0
    $sql_students = "SELECT student_id, fullname, grade_level FROM students WHERE status = '0'";

    if ($grade_level) {
        $sql_students .= " AND grade_level = '" . $conn->real_escape_string($grade_level) . "'"; // เพิ่มเงื่อนไขตามระดับชั้นที่เลือก
    }

    $result = $conn->query($sql_students);
    if ($result === false) {
        die('Query failed: ' . $conn->error); // ตรวจสอบการทำงานของ query
    }

    // สร้าง array สำหรับ student_ids ที่มีอยู่ใน eligible_students
    $eligible_students = [];
    $sql_check_eligible = "SELECT student_id FROM eligible_students WHERE eligible_type = 'nnet'";
    $eligible_result = $conn->query($sql_check_eligible);

    if ($eligible_result && $eligible_result->num_rows > 0) {
        while ($row = $eligible_result->fetch_assoc()) {
            $eligible_students[] = $row['student_id']; // เพิ่ม student_id ลงใน array
        }
    }

    // สร้าง array สำหรับนักเรียนที่ดึงมาจากฐานข้อมูล
    $students = [];
    while ($row = $result->fetch_assoc()) {
        // ตรวจสอบว่ามีนักเรียนที่มีสิทธิใน eligible_students หรือไม่
        $row['is_eligible'] = in_array($row['student_id'], $eligible_students); // จะให้ true ถ้ามีใน eligible_students
        $students[] = $row; // เก็บนักเรียนทั้งหมดลงใน array
    }

    return $students; // คืนค่ารายการนักเรียนทั้งหมดรวมถึงสถานะ eligible
}

// ดึงข้อมูลนักเรียนตามระดับชั้นที่เลือก
$students = fetchStudents($conn, $selected_grade_level); // แก้ไขเพื่อให้ตัวแปร $students มีค่าเริ่มต้น

// ฟังก์ชันเพื่อตรวจสอบว่านักเรียนมีอยู่ใน eligible_students หรือไม่
function isStudentAlreadyEligible($conn, $student_id)
{
    $sql_check = "SELECT COUNT(*) as count FROM eligible_students WHERE student_id = '" . $conn->real_escape_string($student_id) . "' AND eligible_type = 'nnet'";
    $result = $conn->query($sql_check);
    if ($result === false) {
        die('Query failed: ' . $conn->error);
    }

    $row = $result->fetch_assoc();
    return $row['count'] > 0; // ถ้ามีข้อมูลมากกว่าศูนย์ จะส่งกลับ true
}

// การเพิ่มข้อมูลใน eligible_students
if (isset($_POST['confirm'])) {
    // ตรวจสอบว่ามีนักเรียนที่เลือกหรือไม่
    if (isset($_POST['selected_students']) && !empty($_POST['selected_students'])) {
        // ดึงข้อมูล enrollmentId และ dateTime
        $enrollment_id = $_POST['enrollmentId'];
        $date_time = $_POST['dateTime'];

        // เตรียมการสำหรับการเพิ่มข้อมูลในฐานข้อมูล
        $selected_students = $_POST['selected_students'];
        foreach ($selected_students as $student_id) {
            // ตรวจสอบว่ามีนักเรียนใน eligible_students หรือไม่
            if (!isStudentAlreadyEligible($conn, $student_id)) {
                // สร้าง query สำหรับการเพิ่มข้อมูล
                $sql_insert = "INSERT INTO eligible_students (student_id, enrollment_id, exam_id, created_at, date_time, eligible_type, status) 
                               VALUES ('" . $conn->real_escape_string($student_id) . "', 
                                       '" . $conn->real_escape_string($enrollment_id) . "', 
                                       'exam_id_value', 
                                       NOW(), 
                                       '" . $conn->real_escape_string($date_time) . "', 
                                       'nnet', 
                                       '1')"; // กำหนดค่า status เป็น 1

                // ดำเนินการ query
                if ($conn->query($sql_insert) === false) {
                    die('Error: ' . $conn->error); // ตรวจสอบการทำงานของ query
                }
            }
        }
        echo "<script>window.location.href='?page=eligible_students_nnet&status=1';</script>";
    } else {
        echo "กรุณาเลือกนักเรียนก่อนทำการยืนยัน.";
    }
}
