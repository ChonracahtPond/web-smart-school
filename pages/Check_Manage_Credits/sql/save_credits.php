<?php
// ตรวจสอบว่าฟอร์มถูกส่งมาหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    // รับข้อมูลจากฟอร์ม
    $activity_id = $_POST['activity_id'];
    $student_id = $_POST['student_id'];
    $registration_date = $_POST['registration_date'];
    $credits = $_POST['credits'];
    $status = 'กำลังทำ'; // ตั้งค่า status ตามที่คุณต้องการ

    // ตรวจสอบข้อมูลที่รับมา
    if (empty($activity_id) || empty($student_id) || empty($registration_date) || empty($credits)) {
        echo "<script>
                alert('กรุณากรอกข้อมูลให้ครบถ้วน');
                setTimeout(function() {
                    window.location.href = window.location.href; // ค้างอยู่ที่หน้านี้
                }, 2000);
              </script>";
        exit; // หยุดการทำงานของสคริปต์
    }

    // รับข้อมูลสำหรับอัพโหลดภาพ
    $image = $_FILES['image']['name']; // ชื่อไฟล์ภาพ
    $target_dir = "../../../uploads/activity/"; // โฟลเดอร์สำหรับเก็บภาพ
    $target_file = $target_dir . basename($image); // เส้นทางไฟล์ภาพ

    // ตรวจสอบว่ามีการอัพโหลดไฟล์หรือไม่
    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        echo "<script>
                alert('เกิดข้อผิดพลาดในการอัพโหลดไฟล์: " . $_FILES['image']['error'] . "');
                setTimeout(function() {
                    window.location.href = window.location.href; // ค้างอยู่ที่หน้านี้
                }, 2000);
              </script>";
        exit; // หยุดการทำงานของสคริปต์
    }

    // อัพโหลดไฟล์ภาพ
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // เตรียมคำสั่ง SQL สำหรับบันทึกข้อมูล
        $stmt = $conn->prepare("INSERT INTO activity_participants (activity_id, student_id, registration_date, credits, status, images) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iidiss", $activity_id, $student_id, $registration_date, $credits, $status, $target_file);

        // ทำการบันทึกข้อมูล
        if ($stmt->execute()) {
            echo "<script>
                    alert('บันทึกข้อมูลสำเร็จ');
                    setTimeout(function() {
                        window.location.href = window.location.href; // ค้างอยู่ที่หน้านี้
                    }, 2000);
                  </script>";
        } else {
            echo "<script>
                    alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $stmt->error . "');
                    setTimeout(function() {
                        window.location.href = window.location.href; // ค้างอยู่ที่หน้านี้
                    }, 2000);
                  </script>";
        }

        // ปิดการเตรียมและการเชื่อมต่อ
        $stmt->close();
    } else {
        echo "<script>
                alert('เกิดข้อผิดพลาดในการอัพโหลดภาพ');
                setTimeout(function() {
                    window.location.href = window.location.href; // ค้างอยู่ที่หน้านี้
                }, 2000);
              </script>";
    }
}
