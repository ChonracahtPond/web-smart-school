<?php
// ไม่มีการเรียกใช้ PEAR
?>
<div class="flex ">
    <div class="p-8 mt-2 lg:mt-0 ">

        <span class="text-red-500">
            ** สีแดง คือ ยังไม่ถึงที่กำหนด
        </span>
        <span class="text-green-500 ml-2">
            ** สีเขียว คือ ครบกำหนด
        </span>
        <table class="min-w-full border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="border border-gray-500 px-4 py-2" rowspan="3">ที่</th>
                    <th class="border border-gray-500 px-4 py-2" rowspan="3">สาระการเรียนรู้</th>
                    <th class="border border-gray-500 px-4 py-2" colspan="6">จำนวนหน่วยกิต</th>
                </tr>
                <tr>
                    <th class="border border-gray-500 px-4 py-2" colspan="2">ประถมศึกษา</th>
                    <th class="border border-gray-500 px-4 py-2" colspan="2">มัธยมศึกษาตอนต้น</th>
                    <th class="border border-gray-500 px-4 py-2" colspan="2">มัธยมศึกษาตอนปลาย</th>
                </tr>
                <tr>
                    <th class="border border-gray-500 px-4 py-2">วิชาบังคับ</th>
                    <th class="border border-gray-500 px-4 py-2">วิชาเลือก</th>
                    <th class="border border-gray-500 px-4 py-2">วิชาบังคับ</th>
                    <th class="border border-gray-500 px-4 py-2">วิชาเลือก</th>
                    <th class="border border-gray-500 px-4 py-2">วิชาบังคับ</th>
                    <th class="border border-gray-500 px-4 py-2">วิชาเลือก</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-gray-300 px-4 py-2">1</td>
                    <td class="border border-gray-300 px-4 py-2">ทักษะการเรียนรู้</td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $mandatory_credits_pathom_style; ?>"><?php echo $mandatory_credits_pathom ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $elective_credits_pathom_style; ?>"><?php echo $elective_credits_pathom ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $mandatory_credits_morton_style; ?>"><?php echo $mandatory_credits_morton ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $elective_credits_morton_style; ?>"><?php echo $elective_credits_morton ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $mandatory_credits_morpai_style; ?>"><?php echo $mandatory_credits_morpai ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $elective_credits_morpai_style; ?>"><?php echo $elective_credits_morpai ?></td>
                    <!-- <td class="border border-gray-300 px-4 py-2 text-green-500"><?php echo $elective_credits_pathom ?></td> -->
                    <!-- <td class="border border-gray-300 px-4 py-2 text-green-500"><?php echo $mandatory_credits_morton ?></td> -->
                    <!-- <td class="border border-gray-300 px-4 py-2 text-green-500"><?php echo $elective_credits_morton ?></td> -->
                    <!-- <td class="border border-gray-300 px-4 py-2 text-green-500"><?php echo $mandatory_credits_morpai ?></td> -->
                    <!-- <td class="border border-gray-300 px-4 py-2 text-green-500"><?php echo $elective_credits_morpai ?></td> -->
                </tr>
                <tr>
                    <td class="border border-gray-300 px-4 py-2">2</td>
                    <td class="border border-gray-300 px-4 py-2">ความรู้พื้นฐาน</td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $mandatory_credits_pathom_style1; ?>"><?php echo $mandatory_credits_pathom1 ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $elective_credits_pathom_style1; ?>"><?php echo $elective_credits_pathom1 ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $mandatory_credits_morton_style1; ?>"><?php echo $mandatory_credits_morton1 ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $elective_credits_morton_style1; ?>"><?php echo $elective_credits_morton1 ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $mandatory_credits_morpai_style1; ?>"><?php echo $mandatory_credits_morpai1 ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $elective_credits_morpai_style1; ?>"><?php echo $elective_credits_morpai1 ?></td>

                    <!-- <td class="border border-gray-300 px-4 py-2 text-green-500"><?php echo $elective_credits_pathom1 ?></td> -->
                    <!-- <td class="border border-gray-300 px-4 py-2 text-green-500"><?php echo $mandatory_credits_morton1 ?></td> -->
                    <!-- <td class="border border-gray-300 px-4 py-2 text-green-500"><?php echo $elective_credits_morton1 ?></td> -->
                    <!-- <td class="border border-gray-300 px-4 py-2 text-green-500"><?php echo $mandatory_credits_morpai1 ?></td> -->
                    <!-- <td class="border border-gray-300 px-4 py-2 text-green-500"><?php echo $elective_credits_morpai1 ?></td> -->
                </tr>
                <tr>
                    <td class="border border-gray-300 px-4 py-2">3</td>
                    <td class="border border-gray-300 px-4 py-2">การประกอบอาชีพ</td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $mandatory_credits_pathom_style2; ?>"><?php echo $mandatory_credits_pathom2 ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $elective_credits_pathom_style2; ?>"><?php echo $elective_credits_pathom2 ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $mandatory_credits_morton_style2; ?>"><?php echo $mandatory_credits_morton2 ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $elective_credits_morton_style2; ?>"><?php echo $elective_credits_morton2 ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $mandatory_credits_morpai_style2; ?>"><?php echo $mandatory_credits_morpai2 ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $elective_credits_morpai_style2; ?>"><?php echo $elective_credits_morpai2 ?></td>

                    <!-- <td class="border border-gray-300 px-4 py-2  text-green-500"> <?php echo $elective_credits_pathom2 ?></td> -->
                    <!-- <td class="border border-gray-300 px-4 py-2 text-green-500"><?php echo $mandatory_credits_morton2 ?></td> -->
                    <!-- <td class="border border-gray-300 px-4 py-2 text-green-500"><?php echo $elective_credits_morton2 ?></td> -->
                    <!-- <td class="border border-gray-300 px-4 py-2 text-green-500"><?php echo $mandatory_credits_morpai2 ?></td> -->
                    <!-- <td class="border border-gray-300 px-4 py-2 text-green-500"><?php echo $elective_credits_morpai2 ?></td> -->
                </tr>
                <tr>
                    <td class="border border-gray-300 px-4 py-2">4</td>
                    <td class="border border-gray-300 px-4 py-2">ทักษะการดำเนินชีวิต</td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $mandatory_credits_pathom_style3; ?>"><?php echo $mandatory_credits_pathom3 ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $elective_credits_pathom_style3; ?>"><?php echo $elective_credits_pathom3 ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $mandatory_credits_morton_style3; ?>"><?php echo $mandatory_credits_morton3 ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $elective_credits_morton_style3; ?>"><?php echo $elective_credits_morton3 ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $mandatory_credits_morpai_style3; ?>"><?php echo $mandatory_credits_morpai3 ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $elective_credits_morpai_style3; ?>"><?php echo $elective_credits_morpai3 ?></td>

                    <!-- <td class="border border-gray-300 px-4 py-2  text-green-500"> <?php echo $elective_credits_pathom3 ?></td> -->
                    <!-- <td class="border border-gray-300 px-4 py-2 text-green-500"><?php echo $mandatory_credits_morton3 ?></td> -->
                    <!-- <td class="border border-gray-300 px-4 py-2 text-green-500"><?php echo $elective_credits_morton3 ?></td> -->
                    <!-- <td class="border border-gray-300 px-4 py-2 text-green-500"><?php echo $mandatory_credits_morpai3 ?></td> -->
                    <!-- <td class="border border-gray-300 px-4 py-2 text-green-500"><?php echo $elective_credits_morpai3 ?></td> -->
                </tr>
                <tr>
                    <td class="border border-gray-300 px-4 py-2">5</td>
                    <td class="border border-gray-300 px-4 py-2">การพัฒนาสังคม</td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $mandatory_credits_pathom_style4; ?>"><?php echo $mandatory_credits_pathom4 ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $elective_credits_pathom_style4; ?>"><?php echo $elective_credits_pathom4 ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $mandatory_credits_morton_style4; ?>"><?php echo $mandatory_credits_morton4 ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $elective_credits_morton_style4; ?>"><?php echo $elective_credits_morton4 ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $mandatory_credits_morpai_style4; ?>"><?php echo $mandatory_credits_morpai4 ?></td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $elective_credits_morpai_style4; ?>"><?php echo $elective_credits_morpai4 ?></td>

                    <!-- <td class="border border-gray-300 px-4 py-2  text-green-500"> <?php echo $elective_credits_pathom4 ?></td> -->
                    <!-- <td class="border border-gray-300 px-4 py-2 text-green-500"><?php echo $mandatory_credits_morton4 ?></td> -->
                    <!-- <td class="border border-gray-300 px-4 py-2 text-green-500"><?php echo $elective_credits_morton4 ?></td> -->
                    <!-- <td class="border border-gray-300 px-4 py-2 text-green-500"><?php echo $mandatory_credits_morpai4 ?></td> -->
                    <!-- <td class="border border-gray-300 px-4 py-2 text-green-500"><?php echo $elective_credits_morpai4 ?></td> -->
                </tr>

                <tr>
                    <td class="text-center mt-5" colspan="2" rowspan="2">รวม</td>

                    <!-- ระดับประถมศึกษา -->
                    <td class="border border-gray-300 px-4 py-2 <?php echo $mandatory_class_style; ?>">
                        <?php echo $mandatory_credits; ?>
                    </td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $elective_class_style; ?>">
                        <?php echo $elective_credits; ?>
                    </td>

                    <!-- ระดับมัธยมศึกษาตอนต้น -->
                    <td class="border border-gray-300 px-4 py-2 <?php echo $mandatory_class_style1; ?>">
                        <?php echo $mandatory_credits1; ?>
                    </td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $elective_class_style1; ?>">
                        <?php echo $elective_credits1; ?>
                    </td>

                    <!-- ระดับมัธยมศึกษาตอนปลาย -->
                    <td class="border border-gray-300 px-4 py-2 <?php echo $mandatory_class_style2; ?>">
                        <?php echo $mandatory_credits2; ?>
                    </td>
                    <td class="border border-gray-300 px-4 py-2 <?php echo $elective_class_style2; ?>">
                        <?php echo $elective_credits2; ?>
                    </td>
                </tr>


                <tr>
                    <td class="border border-gray-300 px-4 py-2 text-center" colspan="2">48 หน่วยกิต</td>
                    <td class="border border-gray-300 px-4 py-2 text-center" colspan="2">56 หน่วยกิต</td>
                    <td class="border border-gray-300 px-4 py-2 text-center" colspan="2">76 หน่วยกิต</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-4 py-2 text-center" colspan="2">กิจกรรมพัฒนาคุณภาพชีวิต</td>
                    <td class="border border-gray-300 px-4 py-2 text-center" colspan="2">200 ชั่วโมง</td>
                    <td class="border border-gray-300 px-4 py-2 text-center" colspan="2">200 ชั่วโมง</td>
                    <td class="border border-gray-300 px-4 py-2 text-center" colspan="2">200 ชั่วโมง</td>
                </tr>
            </tbody>
        </table>


    </div>
    <div class="p-8 mt-2 lg:mt-0 ">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">เกณฑ์การให้คะแนน</h2>
        <div class="space-y-2">
            <p class="text-gray-700">🎖️ ได้คะแนนร้อยละ 80 - 100 ให้ระดับ <strong class="text-green-600">4</strong> หมายถึง <strong class="text-green-600">ดีเยี่ยม</strong></p>
            <p class="text-gray-700">🌟 ได้คะแนนร้อยละ 75 - 79 ให้ระดับ <strong class="text-green-500">3.5</strong> หมายถึง <strong class="text-green-500">ดีมาก</strong></p>
            <p class="text-gray-700">🏆 ได้คะแนนร้อยละ 70 - 74 ให้ระดับ <strong class="text-yellow-500">3</strong> หมายถึง <strong class="text-yellow-500">ดี</strong></p>
            <p class="text-gray-700">📈 ได้คะแนนร้อยละ 65 - 69 ให้ระดับ <strong class="text-yellow-400">2.5</strong> หมายถึง <strong class="text-yellow-400">ค่อนข้างดี</strong></p>
            <p class="text-gray-700">⚖️ ได้คะแนนร้อยละ 60 - 64 ให้ระดับ <strong class="text-orange-500">2</strong> หมายถึง <strong class="text-orange-500">ปานกลาง</strong></p>
            <p class="text-gray-700">📉 ได้คะแนนร้อยละ 55 - 59 ให้ระดับ <strong class="text-red-500">1.5</strong> หมายถึง <strong class="text-red-500">พอใช้</strong></p>
            <p class="text-gray-700">✅ ได้คะแนนร้อยละ 50 - 54 ให้ระดับ <strong class="text-red-600">1</strong> หมายถึง <strong class="text-red-600">ผ่านเกณฑ์ขั้นต่ำที่กำหนด</strong></p>
            <p class="text-gray-700">❌ ได้คะแนนร้อยละ 0 - 49 ให้ระดับ <strong class="text-red-700">0</strong> หมายถึง <strong class="text-red-700">ต่ำกว่าเกณฑ์ต่ำที่กำหนด</strong></p>
        </div>
    </div>


</div>