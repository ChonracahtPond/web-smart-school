<?php
// ฟังก์ชันสำหรับตรวจสอบการจบการศึกษา
function getGraduationStatus($conn, $student_id)
{
    // สร้าง SQL Query เพื่อตรวจสอบการจบการศึกษา
    $sql = "SELECT 
        g.id, 
        g.student_id, 
        g.graduation_year, 
        g.education_level, 
        g.institution, 
        g.status AS graduation_status, 
        s.status AS student_status,
        g.honors
    FROM 
        graduation_history g
    JOIN 
        students s ON g.student_id = s.student_id
    WHERE 
        g.student_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id); // "i" ระบุว่าค่าที่ส่งไปเป็น integer
    $stmt->execute();
    return $stmt->get_result(); // ส่งผลลัพธ์กลับ
}

// เรียกใช้ฟังก์ชันเพื่อดึงข้อมูลการจบการศึกษา
$result = getGraduationStatus($conn, $student_id);
?>

<!-- ส่วนการตรวจสอบ -->
<div class="w-full">
    <?php
    if ($step3 == 0) {
        echo '
            <div class="w-full h-1 rounded-xl bg-gray-300"></div>
            <div class="mt-2 mr-4 flex"> 
                <div class="ml-2">
                    <div class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="shrink-0 fill-gray-400" viewBox="0 0 24 24">
                            <g>
                                <path d="M9.7 11.3c-.4-.4-1-.4-1.4 0s-.4 1 0 1.4l3 3c.2.2.4.3.7.3s.5-.1.7-.3l7-8c.3-.5.3-1.1-.2-1.4-.4-.3-1-.3-1.3.1L12 13.5z" />
                                <path d="M21 11c-.6 0-1 .4-1 1 0 4.4-3.6 8-8 8s-8-3.6-8-8c0-2.1.8-4.1 2.3-5.6C7.8 4.8 9.8 4 12 4c.6 0 1.3.1 1.9.2.5.2 1.1-.1 1.3-.7s-.2-1-.7-1.2h-.1c-.8-.2-1.6-.3-2.4-.3C6.5 2 2 6.5 2 12.1c0 2.6 1.1 5.2 2.9 7 1.9 1.9 4.4 2.9 7 2.9 5.5 0 10-4.5 10-10 .1-.6-.4-1-.9-1z" />
                            </g>
                        </svg>
                        <h6 class="text-base font-bold text-gray-400">จบการศึกษา</h6>
                    </div>
                    <p class="text-xs text-gray-400">รอดำเนินการ...</p>
                </div>
            </div>';
    } else {
        // ตรวจสอบผลลัพธ์
        if ($result->num_rows > 0) {
            // ถ้านักเรียนมีการลงทะเบียนเรียน
            $row = $result->fetch_assoc();
            $student_status = $row['student_status'];

            if ($student_status == '2') {
                echo '
            <div class="w-full h-1 rounded-xl bg-yellow-500"></div>
            <div class="mt-2 mr-4 flex"> 
                <div class="ml-2">
                    <div class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="shrink-0 fill-yellow-500" viewBox="0 0 24 24">
                            <g>
                                <path d="M9.7 11.3c-.4-.4-1-.4-1.4 0s-.4 1 0 1.4l3 3c.2.2.4.3.7.3s.5-.1.7-.3l7-8c.3-.5.3-1.1-.2-1.4-.4-.3-1-.3-1.3.1L12 13.5z" />
                                <path d="M21 11c-.6 0-1 .4-1 1 0 4.4-3.6 8-8 8s-8-3.6-8-8c0-2.1.8-4.1 2.3-5.6C7.8 4.8 9.8 4 12 4c.6 0 1.3.1 1.9.2.5.2 1.1-.1 1.3-.7s-.2-1-.7-1.2h-.1c-.8-.2-1.6-.3-2.4-.3C6.5 2 2 6.5 2 12.1c0 2.6 1.1 5.2 2.9 7 1.9 1.9 4.4 2.9 7 2.9 5.5 0 10-4.5 10-10 .1-.6-.4-1-.9-1z" />
                            </g>
                        </svg>
                        <h6 class="text-base font-bold text-yellow-500">คากว่าจะจบ</h6>
                    </div>
                    <p class="text-xs text-yellow-500">รอดำเนินการ...</p>
                </div>
            </div>';
            } else if ($student_status == '5') {
                // ถ้านักเรียนจบการศึกษา
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
                        <h6 class="text-base font-bold text-green-500">จบการศึกษา</h6>
                    </div>
                    <p class="text-xs text-green-500">จบการศึกษา</p>
                </div>
            </div>';
            }
        } else {
            echo '
        <div class="w-full h-1 rounded-xl bg-yellow-500"></div>
        <div class="mt-2 mr-4 flex"> 
            <div class="ml-2">
                <div class="flex">
                    <h6 class="text-base font-bold text-yellow-500">รอจบการศึกษา</h6>
                </div>
                <p class="text-xs text-yellow-500">รอดำเนินการ ...</p>
            </div>
        </div>';
        }
    }
    ?>
</div>