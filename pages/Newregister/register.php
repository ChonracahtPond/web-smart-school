<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบลงทะเบียนเรียน สกร.</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <link rel="stylesheet" href="https://horizon-tailwind-react-corporate-7s21b54hb-horizon-ui.vercel.app/static/css/main.d7f96858.css" />
    <style>
        /* Custom styles for dropdown */
        .dropdown-content {
            display: none;
        }

        .dropdown-content.show {
            display: block;
        }
    </style>
</head>

<?php include "components/modal.php" ?>

<header class="bg-[#6e4db0] text-white p-4 sticky top-0 flex flex-col sm:flex-row justify-between items-center shadow-md">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <img src="../../assets/images/LOGO@3x.png" alt="" class="container w-[60px] h-[60px] ms-20">
    <div class="w-full text-white dark-mode:text-gray-200 dark-mode:bg-white">
        <div x-data="{ open: false }" class="flex flex-col max-w-screen-xl px-4 mx-auto md:items-center md:justify-between md:flex-row md:px-6 lg:px-8">
            <div class="p-4 flex flex-row items-center justify-between">
                <a href="#" class="text-lg font-semibold tracking-widest text-white uppercase rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline">สกร อำเภอ ...</a>
                <button class="md:hidden rounded-lg focus:outline-none focus:shadow-outline" @click="open = !open">
                    <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                        <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <nav :class="{'flex': open, 'hidden': !open}" class="flex-col flex-grow pb-4 md:pb-0 hidden md:flex md:justify-end md:flex-row">
                <a class="px-4 py-2 mt-2 text-sm font-semibold text-gray-900 bg-white rounded-lg dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">ลงทะเบียน</a>
                <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">ข้อมูลทั่วไป</a>
                <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">เกี่ยวกับ สกร.</a>
                <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">ติดต่อ</a>
                <!-- <div @click.away="open = false" class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex flex-row items-center w-full px-4 py-2 mt-2 text-sm font-semibold text-left bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:focus:bg-gray-600 dark-mode:hover:bg-gray-600 md:w-auto md:inline md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                        <span>Dropdown</span>
                        <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg md:w-48">
                        <div class="px-2 py-2 bg-white rounded-md shadow dark-mode:bg-gray-800">
                            <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">Link #1</a>
                            <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">Link #2</a>
                            <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">Link #3</a>
                        </div>
                    </div>
                </div> -->
            </nav>
        </div>
    </div>
</header>

<body class=" bg-gray-100">

    <div class="container mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">ใบสมัครขึ้นทะเบียนเป็นนักศึกษา ศกร.ตำบลป่าหุ่ง</h1>

        <!-- <form method="POST" action="new_student_registration_system.php?action=<?= $action ?>&id=<?= $id ?>" class="space-y-4"> -->
        <form method="POST" action="edit/insert.php" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block text-gray-700">ระดับชั้น :</label>
                <select name="grade_level" class="w-full px-4 py-2 border rounded-lg" required>
                    <option value="" <?= !isset($edit_data['grade_level']) ? 'selected' : '' ?>>-- กรุณาเลือกระดับชั้น --</option>
                    <option value="Primary" <?= isset($edit_data['grade_level']) && $edit_data['grade_level'] == 'Primary' ? 'selected' : '' ?>>ประถมศึกษา</option>
                    <option value="LowerSecondary" <?= isset($edit_data['grade_level']) && $edit_data['grade_level'] == 'LowerSecondary' ? 'selected' : '' ?>>ม.ต้น</option>
                    <option value="UpperSecondary" <?= isset($edit_data['grade_level']) && $edit_data['grade_level'] == 'UpperSecondary' ? 'selected' : '' ?>>ม.ปลาย</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700">ชื่อ-นามสกุล :</label>
                <input type="text" name="student_name" value="<?= $edit_data['student_name'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg" required>
            </div>
            <div>
                <label class="block text-gray-700">ชื่อเล่น :</label>
                <input type="text" name="nicknames" value="<?= $edit_data['nicknames'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">อีเมล :</label>
                <input type="email" name="email" value="<?= $edit_data['email'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg" required>
            </div>
            <div>
                <label class="block text-gray-700">เบอร์โทรติดต่อ :</label>
                <input type="text" name="phone_number" value="<?= $edit_data['phone_number'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">วันเกิด :</label>
                <input type="date" name="date_of_birth" value="<?= $edit_data['date_of_birth'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">เพศ :</label>
                <select name="gender" class="w-full px-4 py-2 border rounded-lg" required>
                    <option value="ชาย" <?= isset($edit_data['gender']) && $edit_data['gender'] == 'Male' ? 'selected' : '' ?>>ชาย</option>
                    <option value="หญิง" <?= isset($edit_data['gender']) && $edit_data['gender'] == 'Female' ? 'selected' : '' ?>>หญิง</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700">รูปถ่าย 1.5 นิ้ว:</label>
                <input type="file" name="file_images" class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div>
                <label class="block text-gray-700">สถานภาพ :</label>
                <select name="status" class="w-full px-4 py-2 border rounded-lg" required>
                    <option value="" <?= !isset($edit_data['status']) ? 'selected' : '' ?>>-- กรุณาเลือกสถานภาพ --</option>
                    <option value="Single" <?= isset($edit_data['status']) && $edit_data['status'] == 'Single' ? 'selected' : '' ?>>โสด</option>
                    <option value="Married" <?= isset($edit_data['status']) && $edit_data['status'] == 'Married' ? 'selected' : '' ?>>สมรส</option>
                    <option value="Widowed" <?= isset($edit_data['status']) && $edit_data['status'] == 'Widowed' ? 'selected' : '' ?>>เป็นหม้าย</option>
                    <option value="Divorced" <?= isset($edit_data['status']) && $edit_data['status'] == 'Divorced' ? 'selected' : '' ?>>หย่าร้าง</option>
                    <option value="Separated" <?= isset($edit_data['status']) && $edit_data['status'] == 'Separated' ? 'selected' : '' ?>>แยกกันอยู่</option>
                    <option value="CommonLaw" <?= isset($edit_data['status']) && $edit_data['status'] == 'CommonLaw' ? 'selected' : '' ?>>แต่งงานโดยไม่ได้จดทะเบียน</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700">เลขประจำตัวประชาชน :</label>
                <input type="text" name="national_id" value="<?= $edit_data['national_id'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">ศาสนา :</label>
                <input type="text" name="religion" value="<?= $edit_data['religion'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">สัญชาติ :</label>
                <input type="text" name="nationality" value="<?= $edit_data['nationality'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">อาชีพ:</label>
                <input type="text" name="occupation" value="<?= $edit_data['occupation'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">รายได้เฉลี่ยปีละ :</label>
                <input type="number" name="average_income" value="<?= $edit_data['average_income'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">ชื่อ-สกุล(บิดา) :</label>
                <input type="text" name="father_name" value="<?= $edit_data['father_name'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">สัญชาติ(บิดา) :</label>
                <input type="text" name="father_nationality" value="<?= $edit_data['father_nationality'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">อาชีพ(บิดา) :</label>
                <input type="text" name="father_occupation" value="<?= $edit_data['father_occupation'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">ชื่อ-สกุล(มารดา) :</label>
                <input type="text" name="mother_name" value="<?= $edit_data['mother_name'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">สัญชาติ(มารดา) :</label>
                <input type="text" name="mother_nationality" value="<?= $edit_data['mother_nationality'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">อาชีพ(มารดา) :</label>
                <input type="text" name="mother_occupation" value="<?= $edit_data['mother_occupation'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">ความรู้เดิมจบชั้น :</label>
                <input type="text" name="previous_education_level" value="<?= $edit_data['previous_education_level'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">ปี พ.ศ.ที่จบ :</label>
                <input type="number" name="graduation_year" value="<?= $edit_data['graduation_year'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">จบจากสถานศึกษา :</label>
                <input type="text" name="graduation_school" value="<?= $edit_data['graduation_school'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">อำเภอ/เขต :</label>
                <input type="text" name="district" value="<?= $edit_data['district'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">จังหวัดที่จบมา :</label>
                <input type="text" name="province" value="<?= $edit_data['province'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">วุฒิทางธรรม(ถ้ามี) :</label>
                <input type="text" name="buddhist_qualification" value="<?= $edit_data['buddhist_qualification'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">พ.ศ.ที่จบ :</label>
                <input type="number" name="buddhist_qualification_year" value="<?= $edit_data['buddhist_qualification_year'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">จบจาก :</label>
                <input type="text" name="buddhist_qualification_school" value="<?= $edit_data['buddhist_qualification_school'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">อำเภอที่จบ :</label>
                <input type="text" name="buddhist_district" value="<?= $edit_data['buddhist_district'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">จังหวัดที่จบ :</label>
                <input type="text" name="buddhist_province" value="<?= $edit_data['buddhist_province'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>

            <!-- --------------- -->
            <div>
                <label class="block text-gray-700">บ้านเลขที่ :</label>
                <input type="text" name="housenumber" value="<?= $edit_data['housenumber'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div>
                <label class="block text-gray-700">หมู่ที่ :</label>
                <input type="text" name="village" class="w-full px-4 py-2 border rounded-lg"><?= $edit_data['village'] ?? '' ?></input>
            </div>
            <div>
                <label class="block text-gray-700">ตำบล :</label>
                <input type="text" name="subdistrict" class="w-full px-4 py-2 border rounded-lg"><?= $edit_data['subdistrict'] ?? '' ?></input>
            </div>
            <div>
                <label class="block text-gray-700">อำเภอ :</label>
                <input type="text" name="ofdistrict" class="w-full px-4 py-2 border rounded-lg"><?= $edit_data['ofdistrict'] ?? '' ?></input>
            </div>
            <div>
                <label class="block text-gray-700">จังหวัด :</label>
                <input type="text" name="ofprovince" class="w-full px-4 py-2 border rounded-lg"><?= $edit_data['ofprovince'] ?? '' ?></input>
            </div>
            <div>
                <label class="block text-gray-700">รหัสไปรษณีย์ :</label>
                <input type="text" name="postcode" class="w-full px-4 py-2 border rounded-lg"><?= $edit_data['postcode'] ?? '' ?></input>
            </div>
            <div>
                <label class="block text-gray-700">แนบสำเนาทะเบียนบ้าน :</label>
                <label class="block text-gray-700"> กรุณาเซนต์ ชื่อ-สกุล และรับรองสำเนาถูกต้องให้ครบถ้วน </label>
                <input type="file" name="ofhouse" class="w-full px-4 py-2 border rounded-lg"><?= $edit_data['ofhouse'] ?? '' ?></input>
            </div>
            <div>
                <label class="block text-gray-700">แนบสำเนาบัตรประชาชน :</label>
                <label class="block text-gray-700"> กรุณาเซนต์ชื่อ-สกุล และรับรองสำเนาถูกต้องให้ครบถ้วน </label>
                <input type="file" name="ofIDcard" class="w-full px-4 py-2 border rounded-lg"><?= $edit_data['ofIDcard'] ?? '' ?></input>
            </div>
            <div>
                <label class="block text-gray-700">แนบสำเนาวุฒิการศึกษา :</label>
                <label class="block text-gray-700"> กรุณาเซนต์ชื่อ-สกุล และรับรองสำเนาถูกต้องให้ครบถ้วน </label>
                <input type="file" name="ofeducationalqualification" class="w-full px-4 py-2 border rounded-lg"><?= $edit_data['ofeducationalqualification'] ?? '' ?></input>
            </div>
            <div>
                <label class="block text-gray-700">แนบรูปถ่ายหน้าตรง :</label>
                <input type="file" name="photoofstudent" class="w-full px-4 py-2 border rounded-lg"><?= $edit_data['photoofstudent'] ?? '' ?></input>
            </div>
            <div>
                <label class="block text-gray-700">แนบสำเนาเอกสารอื่นๆถ้ามี :</label>
                <label class="block text-gray-700">กรุณาเซนต์ชื่อ-สกุล และรับรองสำเนาถูกต้องให้ครบถ้วน</label>
                <input type="file" name="ofotherdocuments" class="w-full px-4 py-2 border rounded-lg"><?= $edit_data['ofotherdocuments'] ?? '' ?></input>
            </div>
            <p class="text-red-500">* กรุณาอ่านก่อนยืนยันข้อมูลข้าพเจ้าของรับรองว่าข้อความข้างต้นเป็นความจริงทุกประการ และมีคุณสมบัติตามรายวิชาการศึกษานอกระบบ
                ระดับการศึกษาขั้นพื้นฐาน พุทธศักราช 2551 และไม่อยู่ระหว่างการศึกษาในระบบโรงเรียนทุกสังกัดตลอดระยะเวลาที่เรียนรายวิชาการศึกษานอกระบบ
                ระดับการศึกษาขั้นพื้นฐาน พุทธศักราช 2551 หากตรวจพบภายหลังว่าหลักบานของข้าพเจ้าไม่ถูกต้อง ไม่ตรงกับความจริง หรือมีคุณสมบัติไม่ครบถ้วน
                หรือไม่นำหลักฐานมาแสดงตามเวลาที่กำหนด ข้าพเจ้ายินยอมให้คัดชื่อออก และหากตรวจสอบพบภายหลังที่จบรายวิชาไปแล้ว
                ข้าพเจ้ายินยอมให้สถานสึกษาประกาศยกเลิกหลักฐานการศึกษาแล้วแต่กรณี รวมทั้งไม่เรียกร้องค่าเสียหาย หรือค่าใช้จ่ายใดๆ ทั้งสิ้น *</p>

            <div class="flex justify-between">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Save</button>
                <a href="new_student_registration_system.php" class="px-4 py-2 bg-gray-500 text-white rounded-lg">Cancel</a>
            </div>
        </form>
    </div>



</body>

</html>