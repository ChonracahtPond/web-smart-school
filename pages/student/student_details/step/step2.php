<?php
// db_connection.php

// ฟังก์ชันสำหรับตรวจสอบการลงทะเบียนนักเรียน
function checkStudentEnrollment($conn, $student_id) {
    // สร้าง SQL Query เพื่อตรวจสอบการลงทะเบียน
    $sql = "SELECT 
            enrollment_id, 
            course_id, 
            semester, 
            academic_year, 
            grade, 
            status, 
            teacher_id, 
            class, 
            credits 
        FROM 
            enrollments 
        WHERE 
            student_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id); // "i" ระบุว่าค่าที่ส่งไปเป็น integer
    $stmt->execute();
    return $stmt->get_result();
}
?>

<!-- ส่วนการศึกษา -->
<div class="w-full">
    <?php
    // ตรวจสอบการลงทะเบียนนักเรียน
    $result = checkStudentEnrollment($conn, $student_id);

    // ตรวจสอบผลลัพธ์
    if ($result->num_rows > 0) {
        // ถ้านักเรียนมีการลงทะเบียนเรียน
        echo '
            <div class="w-full h-1 rounded-xl bg-green-500"></div>
            <div class="mt-2 mr-4 flex"> 
                <div class="ml-2">
                    <div class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="shrink-0 fill-green-500" viewBox="0 0 24 24">
                            <g>
                                <path d="M9.7 11.3c-.4-.4-1-.4-1.4 0s-.4 1 0 1.4l3 3c.2.2.4.3.7.3s.5-.1.7-.3l7-8c.3-.5.3-1.1-.2-1.4-.4-.3-1-.3-1.3.1L12 13.5z" />
                                <path d="M21 11c-.6 0-1 .4-1 1 0 4.4-3.6 8-8 8s-8-3.6-8-8c0-2.1.8-4.1 2.3-5.6C7.8 4.8 9.8 4 12 4c.6 0 1.3.1 1.9.2.5.2 1.1-.1 1.3-.7s-.2-1-.7-1.2h-.1c-.8-.2-1.6-.3-2.4-.3C6.5 2 2 6.5 2 12.1c0 2.6 1.1 5.2 2.9 7 1.9 1.9 4.4 2.9 7 2.9 5.5 0 10-4.5 10-10 .1-.6-.4-1-.9-1z" />
                            </g>
                        </svg>
                        <h6 class="text-base font-bold text-green-500">ลงทะเบียนเรียน</h6>
                    </div>
                    <p class="text-xs text-green-500">ลงทะเบียนเรียนเสร็จสิ้น</p>
                </div>
            </div>';
        
        // ส่งค่าผลลัพธ์เป็น 1
        // $enrollment_status = 1;
        $step2 = 1;
    } else {
        // ถ้านักเรียนยังไม่ได้ลงทะเบียนเรียน
        echo '
            <div class="w-full h-1 rounded-xl bg-yellow-500"></div>
            <div class="mt-2 mr-4 flex"> 
                <div class="ml-2">
                    <div class="flex">
                        <h6 class="text-base font-bold text-yellow-500 mr-4">รอลงทะเบียนเรียน</h6>
                    </div>
                    <p class="text-xs text-yellow-500">รอดำเนินการ ...</p>
                </div>
            </div>';
        
        // ส่งค่าผลลัพธ์เป็น 0 หากยังไม่ได้ลงทะเบียน
        // $enrollment_status = 0;
        $step2 = 0;
    }

    // ใช้ค่า $enrollment_status ในส่วนอื่นตามที่คุณต้องการ
    ?>
</div>
