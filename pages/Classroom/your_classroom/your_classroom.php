<?php

// ตรวจสอบว่า teacher_id ถูกตั้งค่าในเซสชันหรือไม่
if (!isset($_SESSION['teacher_id'])) {
    header('Location: login.php'); // เปลี่ยนเส้นทางไปที่หน้าเข้าสู่ระบบ
    exit(); // ออกจากสคริปต์
}

$teacher_id = $_SESSION['teacher_id']; // กำหนด teacher_id จากเซสชัน

// คำสั่ง SQL เพื่อดึงข้อมูลจากตาราง courses โดยใช้ teacher_id
$sql = "SELECT course_id, course_name, course_description, course_type, course_code, credits, semester, academic_year, status, course_content, midterm_score, final_score, assignment_score, participation_score 
        FROM courses 
        WHERE teacher_id = ?";

$stmt = $conn->prepare($sql); // เตรียมคำสั่ง SQL
$stmt->bind_param("i", $teacher_id); // ผูกตัวแปร teacher_id เข้ากับคำสั่ง SQL
$stmt->execute(); // รันคำสั่ง SQL
$result = $stmt->get_result(); // รับผลลัพธ์
?>

<div class=" mx-auto p-6">
    <h1 class="text-4xl font-semibold text-center text-purple-900 mb-8">หลักสูตรของคุณในห้องเรียน</h1>
    
    <!-- ฟอร์มสำหรับเลือกคำอธิบายหลักสูตร -->
    <label for="course_description" class="text-lg font-semibold">เลือกคำอธิบายหลักสูตร:</label>
    <select name="course_description" id="course_description" class="bg-white border border-gray-300 rounded-lg px-4 py-2">
        <option value="">-- กรุณาเลือก --</option>
        <?php
        // รีเซ็ตรูปแบบคำสั่ง SQL เพื่อดึงข้อมูล course_description
        $description_sql = "SELECT DISTINCT course_description FROM courses WHERE teacher_id = ?";
        $description_stmt = $conn->prepare($description_sql);
        $description_stmt->bind_param("i", $teacher_id);
        $description_stmt->execute();
        $description_result = $description_stmt->get_result();

        // แสดงคำอธิบายหลักสูตรใน select option
        while ($description_row = $description_result->fetch_assoc()) {
            echo '<option value="' . htmlspecialchars($description_row['course_description']) . '">' . htmlspecialchars($description_row['course_description']) . '</option>';
        }
        ?>
    </select>

    <!-- div สำหรับแสดงข้อมูลหลักสูตร -->
    <div id="course_details" class="mt-4">
    </div>

    <h2 class="text-2xl font-semibold  mt-8">รายวิชาทั้งหมด</h2>


    <div class="grid gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mt-6">
        <?php
        if ($result->num_rows > 0) { // ถ้ามีข้อมูลในผลลัพธ์
            while ($row = $result->fetch_assoc()) { // วนลูปผ่านข้อมูลแต่ละแถว
        ?>
    

                <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-200 course-item" data-description="<?php echo htmlspecialchars($row['course_description']); ?>">
                    <h2 class="text-2xl font-bold text-purple-800 mb-2"><?php echo htmlspecialchars($row['course_name']); ?></h2> <!-- ชื่อหลักสูตร -->
                    <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($row['course_description']); ?></p> <!-- คำอธิบายหลักสูตร -->
                    <div class="text-gray-700">
                        <p><strong>ประเภท:</strong> <?php echo htmlspecialchars($row['course_type']); ?></p> <!-- ประเภท -->
                        <p><strong>รหัส:</strong> <?php echo htmlspecialchars($row['course_code']); ?></p> <!-- รหัส -->
                        <p><strong>หน่วยกิต:</strong> <?php echo htmlspecialchars($row['credits']); ?></p> <!-- หน่วยกิต -->
                        <p><strong>เทอม:</strong> <?php echo htmlspecialchars($row['semester']); ?> / <?php echo htmlspecialchars($row['academic_year']); ?></p> <!-- เทอม -->
                        <span><strong>คะแนนกลางภาค:</strong> <?php echo htmlspecialchars($row['midterm_score']); ?></span> <!-- คะแนนกลางภาค -->
                        <span>/</span>
                        <span><strong>คะแนนปลายภาค:</strong> <?php echo htmlspecialchars($row['final_score']); ?></span> <!-- คะแนนปลายภาค -->
                        <span>/</span>
                        <span><strong>คะแนนงาน:</strong> <?php echo htmlspecialchars($row['assignment_score']); ?></span> <!-- คะแนนงาน -->
                        <span>/</span>
                        <span><strong>คะแนนการเข้าร่วม:</strong> <?php echo htmlspecialchars($row['participation_score']); ?></span> <!-- คะแนนการเข้าร่วม -->
                        <p><strong>เนื้อหา:</strong> <?php echo htmlspecialchars($row['course_content']); ?></p> <!-- เนื้อหา -->
                        <div class="mt-4 flex flex-wrap gap-2">
                            <a href="?page=detali_classroom&id=<?php echo urlencode($row['course_id']); ?>" class="bg-indigo-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-600 flex items-center space-x-2 transition-transform transform hover:scale-105 duration-300">
                                <svg class="h-5 w-5" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <circle cx="12" cy="12" r="2" />
                                    <path d="M2 12l1.5 2a11 11 0 0 0 17 0l1.5 -2" />
                                    <path d="M2 12l1.5 -2a11 11 0 0 1 17 0l1.5 2" />
                                </svg>
                                <span>ดูรายละเอียด</span>
                            </a>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<p class='text-center text-purple-600 text-lg'>ไม่มีหลักสูตรที่สามารถใช้ได้</p>"; // ข้อความถ้าไม่มีหลักสูตร
        }
        ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#course_description').change(function() {
        var selectedDescription = $(this).val();
        $('#course_details').empty(); // ล้างข้อมูลที่แสดงอยู่

        if (selectedDescription) {
            $('.course-item').each(function() {
                if ($(this).data('description') === selectedDescription) {
                    var courseHTML = $(this).clone(); // คัดลอก HTML ของหลักสูตรที่ตรงกับคำอธิบาย
                    $('#course_details').append(courseHTML); // เพิ่มข้อมูลหลักสูตรลงใน div
                }
            });
        }
    });
});
</script>
