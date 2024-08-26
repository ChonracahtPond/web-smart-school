<?php
require_once("../vendor/autoload.php");
include('../../includes/db_connect.php');
error_reporting(~E_NOTICE);

// ปิดการแสดงข้อผิดพลาดชั่วคราว
ini_set('display_errors', 0);

// mPDF configuration
$defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];
$defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];
ini_set("pcre.backtrack_limit", "5000000");

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/tmp',
    ]),
    'fontdata' => $fontData + [
        'sarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
            'BI' => 'THSarabunNew BoldItalic.ttf'
        ]
    ],
    'default_font' => 'sarabun' // เลือกฟอนต์ที่ต้องการใช้
]);

// Get student ID from the query parameter
$student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($student_id > 0) {
    // Fetch student data from the database
    $sql = "SELECT * FROM register WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "No record found";
        exit();
    }
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid student ID";
    exit();
}

$data = [
    'กล่อง 1' => 'ข้อมูล 1',
    'กล่อง 2' => 'ข้อมูล 2',
    'กล่อง 3' => 'ข้อมูล 3',
    // เพิ่มข้อมูลตามที่คุณต้องการ
    'กล่อง 13' => 'ข้อมูล 13'
];




// Create HTML content for the PDF
$html = '
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>ใบสมัครขึ้นทะเบียนเป็นนักศึกษา</title>
    <style type="text/css">
        * { margin: 0; padding: 0; text-indent: 0; }
        h1, p { font-family: sarabun, sans-serif; }
        h1 { color: black; font-weight: bold; font-size: 16pt; margin: 0; }
        p { color: black; font-size: 16pt; margin: 0; }
        .s1 { font-family: sarabun, serif; font-size: 16pt; }
        .s2 { font-family: sarabun, serif; font-size: 10pt; }
        .textbox { background: #FFFFFF; display: block; margin-bottom: 10px; padding: 10px; }
        table { border-collapse: collapse; margin: 5px 0; }
          td { border: 1px solid black; padding: 10px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .full-width { width: 100%; }
        .spacer {
            width: 30px; /* Define the width of the space */
            background-color: #fff; /* Optional: add a background color to make the space visible */
        }
        .hidden {
            display: none; /* Hide the cell */
        }
        .container {
            display: flex;
            flex-direction: row; /* Align children in a row */
            align-items: flex-start; /* Align items to the top */
            gap: 10px; /* Optional: add space between children */
        }
        .ex1 {
            flex: 1; /* Allow the <h1> to take up available space */
        }
        .table-wrapper {
            flex: 3; /* Allow the table to take up more space than <h1> */
        }



   .container {
        display: flex;
        flex-wrap: wrap;
    }
    .box {
        width: 60px; /* ปรับขนาดกล่องตามต้องการ */
        height: 60px; /* ปรับขนาดกล่องตามต้องการ */
        margin: 5px; /* ระยะห่างระหว่างกล่อง */
        border: 1px solid #000;
        text-align: center;
        line-height: 60px; /* จัดตำแหน่งข้อความให้อยู่กลาง */
        box-sizing: border-box;
    }


    </style>
</head>
<body>
    <h1 style="padding-top: 2pt; padding-left: 60pt; text-indent: 115pt; line-height: 94%; text-align: left;">
        ใบสมัครขึ้นทะเบียนเป็นนักศึกษา หลักสูตรการศึกษานอกระบบระดับการศึกษาขั้นพื้นฐาน
        พุทธศักราช 2551 เลขที่ ใบสมัคร........
    </h1>

  <h1 style="padding-left: 173pt; text-indent: 0pt; line-height: 18pt; text-align: left;">
        ศูนย์ส่งเสริมการเรียนรู้อำเภอเมืองอุดรธานี
    </h1>
  
    


      <div class="ex1 container">
            <h1 style="padding-top: 5pt; padding-left: 5pt; text-indent: 0pt; line-height: 19pt; text-align: left;">
                ระดับ<span class="s1">.................................</span>รหัสสถานศึกษา
            </h1>
            <h1 style="padding-top: 5pt; padding-left: 5pt; text-indent: 0pt; line-height: 19pt; text-align: left;">
                ระดับ<span class="s1">.................................</span>รหัสสถานศึกษา
            </h1>
        </div>







 <div class="row1">
        <div class="box"></div>
        <div class="box"></div>
        <div class="box"></div>
        <div class="box"></div>

        <div class="box"></div>
        <div class="box"></div>
        <div class="box"></div>
        <div class="box"></div>
        
        <div class="box"></div>
        <div class="box"></div>
        <div class="box"></div>
        <div class="box"></div>
        
        <div class="box"></div>
    </div>




    <h1 style="padding-left: 114pt; text-indent: 0pt; line-height: 19pt; text-align: left;">
        รหัสประจำตัวนักศึกษา
    </h1>



    


    <div class="textbox">
        <p>รูปถ่าย</p>
        <p>1.5 นิ้ว</p>
    </div>

  









    


    <h1 style="padding-left: 5pt; text-indent: 216pt; line-height: 94%; text-align: left;">
        ประวัตินักศึกษา สถานศึกษา ศูนย์ส่งเสริมการเรียนรู้อำเภอเมืองอุดรธานี จังหวัดอุดรธานี
    </h1>

    <h1 style="padding-left: 5pt; text-indent: 0pt; line-height: 18pt; text-align: left;">
        ศกร.ตำบล............................................................................................................................................................
    </h1>

    <h1 style="padding-left: 5pt; text-indent: 0pt; line-height: 18pt;">
        ชื่อ....................................................................................นามสกุล.........................................................................
    </h1>

    <p style="padding-left: 5pt; text-indent: 0pt; line-height: 18pt;">
        วัน/เดือน/ปีเกิด......................................................................อายุ.....................ปี<span class="s1"></span>เดือน (นับถึงวันขึ้นทะเบียน)
    </p>

    <p style="padding-left: 5pt; text-indent: 0pt; line-height: 18pt;">
        เลขประจำตัวประชาชน ..................................................................................................................................................
    </p>

    <p style="padding-left: 5pt; text-indent: 0pt; line-height: 18pt;">
        ศาสนา.................................สัญชาติ.................... อาชีพ.....................................รายได้เฉลี่ยต่อปี…………………………….. ชื่อ – สกุล บิดา..............................................................สัญชาติ................................................อาชีพ............................
    </p>

    <p style="padding-left: 5pt; text-indent: 0pt; line-height: 18pt;">
        ชื่อ – สกุล มารดา..........................................................สัญชาติ.................................................อาชีพ............................
    </p>

    <p style="padding-left: 5pt; text-indent: 0pt; line-height: 18pt;">
        ความรู้เดิม (จบชั้น)...................................ปี พ.ศ.ที่จบ.............................จากโรงเรียน....................................................
    </p>

    <p style="padding-left: 5pt; text-indent: 0pt; line-height: 18pt;">
        อำเภอ/เขต...............................................................................จังหวัด............................................................................
    </p>

    <p style="padding-left: 5pt; text-indent: 0pt; line-height: 18pt;">
        วุฒิทางธรรม (ถ้ามี)..................................................ปี พ.ศ. ที่จบ...................จากสถานศึกษา........................................
    </p>

    <p style="padding-left: 5pt; text-indent: 0pt; line-height: 18pt;">
        อำเภอ/เขต...............................................................................จังหวัด............................................................................
    </p>

    <p style="padding-left: 5pt; text-indent: 0pt; line-height: 18pt;">
        ที่อยู่ปัจจุบัน (สามารถติดต่อได้สะดวก) บ้านเลขที่..............หมู่ที่..............ซอย........................ถนน................................. ตำบล/แขวง...................................อำเภอ/เขต....................................จังหวัด.................................................................
    </p>

    <p style="padding-left: 10pt; text-indent: 0pt; text-align: right;">
        รหัสไปรษณีย์.............................................................โทรศัพท์ (มือถือ)............................………..………………………………. ข้าพเจ้าขอรับรองว่าข้อความข้างต้นเป็นความจริงทุกประการ และมีคุณสมบัติตามหลักสูตรการศึกษานอกระบบระดับการศึกษาขั้นพื้นฐานพุทธศักราช 2551 และไม่อยู่ในระหว่างการศึกษาในระบบโรงเรียนทุกสังกัดตลอดระยะเวลาที่เรียนหลักสูตรการศึกษานอกระบบระดับการศึกษาขั้นพื้นฐานพุทธศักราช 2551 หากตรวจสอบภายหลัง พบว่าหลักฐานการสมัครไม่ถูกต้องไม่ตรงกับความเป็นจริง หรือคุณสมบัติไม่ครบถ้วน หรือไม่นำหลักฐานมาแสดงตามเวลาที่กำหนด ข้าพเจ้ายินยอมให้คัดชื่อออก และหากตรวจสอบพบภายหลังที่จบหลักสูตรไปแล้ว ข้าพเจ้ายินยอมให้สถานศึกษาประกาศยกเลิกหลักฐานการศึกษาแล้วแต่กรณีรวมทั้งไม่เรียกร้องค่าเสียหายหรือค่าใช้จ่ายใด ๆ ทั้งสิ้น
    </p>

    <p style="text-align: center;">
        ลงชื่อ...............................................ผู้สมัคร<br>
        (....................................................)<br>
        วันที่...........................................................
    </p>

    <p style="text-align: center;">
        ………………………………………………………………………………………………<br>
        หลักฐาน/เอกสารที่ยื่นในวันสมัคร
    </p>

    <p style="padding-left: 7pt; text-indent: 0pt;">
        <span><table border="0" cellspacing="0" cellpadding="0">
            <tr><td><img width="19" height="11" src="data:image/png;base64,..."/></td></tr>
        </table></span>
        วุฒิเดิม
    </p>

    <p style="padding-left: 7pt; text-indent: 0pt;">
        <span><table border="0" cellspacing="0" cellpadding="0">
            <tr><td><img width="19" height="12" src="data:image/png;base64,..."/></td></tr>
        </table></span>
        ทะเบียนบ้าน
    </p>

    <p style="padding-left: 7pt; text-indent: 0pt;">
        <span><table border="0" cellspacing="0" cellpadding="0">
            <tr><td><img width="19" height="12" src="data:image/png;base64,..."/></td></tr>
        </table></span>
        รูปถ่าย
    </p>

    <p style="padding-left: 7pt; text-indent: 0pt;">
        <span><table border="0" cellspacing="0" cellpadding="0">
            <tr><td><img width="19" height="12" src="data:image/png;base64,..."/></td></tr>
        </table></span>
        บัตรประชาชน
    </p>
';






$html .= '</body></html>';
// Write the HTML content into the PDF
$mpdf->WriteHTML($html);

// Output the PDF to the browser
$mpdf->Output('student_details.pdf', 'I');
