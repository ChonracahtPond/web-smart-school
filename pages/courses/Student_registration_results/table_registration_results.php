<?php
// ไม่มีการเรียกใช้ PEAR
?>

<div class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">

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