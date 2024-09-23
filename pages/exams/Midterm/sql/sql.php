<?php
// ดึงข้อมูลจากตาราง courses
$sql = "SELECT course_id, course_name FROM courses WHERE status = 0";
$result = $conn->query($sql);

// ฟังก์ชันสำหรับดึงข้อมูล enrollments ถ้าเลือก course
$enrollmentData = '';
$course_id = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course'])) {
    $course_id = $_POST['course'];

    // ใช้ JOIN เพื่อดึงข้อมูล student_name จากตาราง students
    $sql1 = "SELECT e.enrollment_id, e.student_id, s.student_name 
              FROM enrollments e
              JOIN students s ON e.student_id = s.student_id
              WHERE e.course_id = ? AND e.status = 1";
    $stmt = $conn->prepare($sql1);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $resultEnrollments = $stmt->get_result();

    // แสดงข้อมูล enrollment ในตัวแปร $enrollmentData
    while ($row = $resultEnrollments->fetch_assoc()) {
        $enrollmentData .= "<tr>";
        $enrollmentData .= "<td class='py-2 px-4 border'>" . htmlspecialchars($course_id) . "</td>"; // Course ID
        $enrollmentData .= "<td class='py-2 px-4 border'>" . htmlspecialchars($row['student_id']) . "</td>"; // Student ID
        $enrollmentData .= "<td class='py-2 px-4 border'>" . htmlspecialchars($row['student_name']) . "</td>"; // Student Name
        $enrollmentData .= "<td class='py-2 px-4 border'>";
        $enrollmentData .= "<input type='hidden' name='enrollment_id[]' value='" . htmlspecialchars($row['enrollment_id']) . "' />"; // Hidden field for enrollment_id
        $enrollmentData .= "<input type='text' name='exam_score[]' class='border border-gray-300 rounded-lg p-1' placeholder='คะแนนจากการสอบ' required>"; // Input field
        $enrollmentData .= "</td>";
        $enrollmentData .= "</tr>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['exam_score'])) {
    // รับค่าจากฟอร์ม
    $enrollment_ids = $_POST['enrollment_id'] ?? [];
    $exam_scores = $_POST['exam_score'] ?? [];
    $totalMarks = $_POST['totalMarks'] ?? ''; // ตรวจสอบการส่ง totalMarks
    $exam_date = $_POST['exam_date'] ?? ''; // ตรวจสอบการส่ง totalMarks
    $term = $_POST['term'] ?? ''; // ตรวจสอบการส่ง totalMarks
    $year = $_POST['year'] ?? ''; // ตรวจสอบการส่ง totalMarks

    // ตรวจสอบว่า enrollment_id มีค่าหรือไม่
    if (empty($enrollment_ids)) {
        // echo "<p class='text-red-500'>Error: No enrollment IDs provided.</p>";
    } else if (empty($totalMarks)) {
        // echo "<p class='text-red-500'>Error: Total marks cannot be null.</p>"; // เพิ่มการตรวจสอบ totalMarks
    } else {
        $exam_type = 'กลางภาค'; // สามารถเปลี่ยนตามความต้องการ

        $duration =  $_POST['duration'] ?? ''; // สามารถเปลี่ยนตามความต้องการ duration


        // Prepare statement สำหรับการบันทึกข้อมูลลงในฐานข้อมูล
        $insertSQL = "INSERT INTO exams (enrollment_id, exam_type, exam_date, duration, total_marks, student_id, score, exams_status , criterion , term , year) VALUES (?, ?, ?, ?, ?, ?, ?, ? , ?, ? , ?)";
        $stmt = $conn->prepare($insertSQL);

        // ตรวจสอบว่าการเตรียม statement สำเร็จหรือไม่
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        foreach ($exam_scores as $index => $score) {
            $enrollment_id = $enrollment_ids[$index]; // ดึง enrollment_id ที่ถูกต้อง

            // ดึง student_id ตาม enrollment_id
            $sqlStudent = "SELECT student_id FROM enrollments WHERE enrollment_id = ?";
            $stmtStudent = $conn->prepare($sqlStudent);
            $stmtStudent->bind_param("i", $enrollment_id);
            $stmtStudent->execute();
            $resultStudent = $stmtStudent->get_result();
            $student_data = $resultStudent->fetch_assoc();
            $student_id = $student_data['student_id'] ?? null;



            if ($student_id !== null) {
                // เริ่มต้นตัวแปร $isPassing
                $isPassing =  "ไม่ผ่าน"; // สมมุติว่าไม่ผ่าน

                // ตั้งค่าพื้นฐานให้กับ $passingCriteria และ $passingPercentage
                $passingCriteria = isset($_POST['passingCriteria']) ? $_POST['passingCriteria'] : 0;
                $passingPercentage = isset($_POST['passingPercentage']) ? $_POST['passingPercentage'] : 0;

                if ($passingCriteria >= 1) {
                    if ($score >= $passingCriteria) {
                        $isPassing = "ผ่าน"; // ผ่าน
                    }
                    $type = $passingCriteria;
                } else if ($passingPercentage >= 1) {
                    $totalPassingCriteria = $totalMarks * ($passingPercentage / 100);
                    if ($score >= $totalPassingCriteria) {
                        $isPassing = "ผ่าน"; // ผ่าน

                    }
                    $type = $passingPercentage . "%";
                }

                // กำหนดสถานะการสอบ
                $exams_status = $isPassing; // ใช้ค่า $isPassing โดยตรง

                $criterion = $type;
                // $criterion = $_POST['criterion'] ?? '';


                // Binding parameters
                $stmt->bind_param("ississsssii", $enrollment_id, $exam_type, $exam_date, $duration, $totalMarks, $student_id, $score, $exams_status, $criterion ,$term, $year);

                // Execute statement
                // Execute statement
                if ($stmt->execute()) {
                    echo "<script>window.location.href='?page=Manage_exam_Midterm&status=1';</script>";
                } else {
                    echo "Error: " . $stmt->error;
                    echo "<script>window.location.href='?page=Manage_exam_Midterm&status=0';</script>";
                }
            }
        }

        // Echo ข้อมูลที่ได้รับจากฟอร์ม
        echo "<div class='mt-4'>";
        echo "<h3 class='text-lg font-semibold'>ข้อมูลการสอบ:</h3>";
        // แสดงคะแนนของนักเรียน
        foreach ($exam_scores as $index => $score) {
            echo "<p>คะแนนนักเรียน " . ($index + 1) . ": " . htmlspecialchars($score) . "</p>";
        }
        echo "</div>";

        // ปิด statement หลังใช้งาน
        $stmt->close();
    }
}
