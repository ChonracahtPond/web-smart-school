<?php 

    $student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0; // เปลี่ยนให้เป็น integer
?>

<div class="flex items-start max-md:flex-col gap-y-6 gap-x-3 max-w-screen-lg mx-auto px-4 font-[sans-serif] mt-5">

 <?php include "step/step1.php";?>
 <?php include "step/step2.php";?> 
 <?php include "step/step3.php";?> 
 <?php 
//  include "step/step4.php";
 ?> 
 <?php include "step/step5.php";?> 

  


 

    

</div>