<?php
// ตรวจสอบระดับการศึกษาและตั้งค่าสี
$mandatory_credits_pathom_style = '';
$mandatory_credits_pathom_style1 = '';
$mandatory_credits_pathom_style2 = '';
$mandatory_credits_pathom_style3 = '';
$mandatory_credits_pathom_style4 = '';

$elective_credits_pathom_style = '';
$elective_credits_pathom_style1 = '';
$elective_credits_pathom_style2 = '';
$elective_credits_pathom_style3 = '';
$elective_credits_pathom_style4 = '';


$mandatory_credits_morton_style = '';
$mandatory_credits_morton_style1 = '';
$mandatory_credits_morton_style2 = '';
$mandatory_credits_morton_style3 = '';
$mandatory_credits_morton_style4 = '';

$elective_credits_morton_style = '';
$elective_credits_morton_style1 = '';
$elective_credits_morton_style2 = '';
$elective_credits_morton_style3 = '';
$elective_credits_morton_style4 = '';


$mandatory_credits_morpai_style = '';
$mandatory_credits_morpai_style1 = '';
$mandatory_credits_morpai_style2 = '';
$mandatory_credits_morpai_style3 = '';
$mandatory_credits_morpai_style4 = '';

$elective_credits_morpai_style = '';
$elective_credits_morpai_style1 = '';
$elective_credits_morpai_style2 = '';
$elective_credits_morpai_style3 = '';
$elective_credits_morpai_style4 = '';


$mandatory_class_style = '';
$elective_class_style = '';
$mandatory_class_style1 = '';
$elective_class_style1 = '';
$mandatory_class_style2 = '';
$elective_class2_style2 = '';


$mandatory_credits_pathom_style = ($mandatory_credits_pathom >= 5) ? 'text-green-500' : 'text-red-500';
$mandatory_credits_pathom_style1 = ($mandatory_credits_pathom1 >= 12) ? 'text-green-500' : 'text-red-500';
$mandatory_credits_pathom_style2 = ($mandatory_credits_pathom2 >= 8) ? 'text-green-500' : 'text-red-500';
$mandatory_credits_pathom_style3 = ($mandatory_credits_pathom3 >= 5) ? 'text-green-500' : 'text-red-500';
$mandatory_credits_pathom_style4 = ($mandatory_credits_pathom4 >= 6) ? 'text-green-500' : 'text-red-500';

$elective_credits_pathom_style = ($elective_credits_pathom >= 0) ? 'text-green-500' : 'text-red-500';
$elective_credits_pathom_style1 = ($elective_credits_pathom >= 0) ? 'text-green-500' : 'text-red-500';
$elective_credits_pathom_style2 = ($elective_credits_pathom >= 0) ? 'text-green-500' : 'text-red-500';
$elective_credits_pathom_style3 = ($elective_credits_pathom >= 0) ? 'text-green-500' : 'text-red-500';
$elective_credits_pathom_style4 = ($elective_credits_pathom >= 0) ? 'text-green-500' : 'text-red-500';


$mandatory_credits_morton_style = ($mandatory_credits_morton >= 5) ? 'text-green-500' : 'text-red-500';
$mandatory_credits_morton_style1 = ($mandatory_credits_morton1 >= 16) ? 'text-green-500' : 'text-red-500';
$mandatory_credits_morton_style2 = ($mandatory_credits_morton2 >= 8) ? 'text-green-500' : 'text-red-500';
$mandatory_credits_morton_style3 = ($mandatory_credits_morton3 >= 5) ? 'text-green-500' : 'text-red-500';
$mandatory_credits_morton_style4 = ($mandatory_credits_morton4 >= 6) ? 'text-green-500' : 'text-red-500';

$elective_credits_morton_style = ($elective_credits_morton >= 0) ? 'text-green-500' : 'text-red-500';
$elective_credits_morton_style1 = ($elective_credits_morton >= 0) ? 'text-green-500' : 'text-red-500';
$elective_credits_morton_style2 = ($elective_credits_morton >= 0) ? 'text-green-500' : 'text-red-500';
$elective_credits_morton_style3 = ($elective_credits_morton >= 0) ? 'text-green-500' : 'text-red-500';
$elective_credits_morton_style4 = ($elective_credits_morton >= 0) ? 'text-green-500' : 'text-red-500';


$mandatory_credits_morpai_style = ($mandatory_credits_morpai >= 5) ? 'text-green-500' : 'text-red-500';
$mandatory_credits_morpai_style1 = ($mandatory_credits_morpai1 >= 20) ? 'text-green-500' : 'text-red-500';
$mandatory_credits_morpai_style2 = ($mandatory_credits_morpai2 >= 8) ? 'text-green-500' : 'text-red-500';
$mandatory_credits_morpai_style3 = ($mandatory_credits_morpai3 >= 5) ? 'text-green-500' : 'text-red-500';
$mandatory_credits_morpai_style4 = ($mandatory_credits_morpai4 >= 6) ? 'text-green-500' : 'text-red-500';

$elective_credits_morpai_style = ($elective_credits_morpai >= 0) ? 'text-green-500' : 'text-red-500';
$elective_credits_morpai_style1 = ($elective_credits_morpai >= 0) ? 'text-green-500' : 'text-red-500';
$elective_credits_morpai_style2 = ($elective_credits_morpai >= 0) ? 'text-green-500' : 'text-red-500';
$elective_credits_morpai_style3 = ($elective_credits_morpai >= 0) ? 'text-green-500' : 'text-red-500';
$elective_credits_morpai_style4 = ($elective_credits_morpai >= 0) ? 'text-green-500' : 'text-red-500';



$mandatory_class_style = ($mandatory_credits >= 36) ? 'text-green-500' : 'text-red-500';
$elective_class_style = ($elective_credits >= 12) ? 'text-green-500' : 'text-red-500';

$mandatory_class_style1 = ($mandatory_credits1 >= 40) ? 'text-green-500' : 'text-red-500';
$elective_class_style1 = ($elective_credits1 >= 16) ? 'text-green-500' : 'text-red-500';

$mandatory_class_style2 = ($mandatory_credits2 >= 44) ? 'text-green-500' : 'text-red-500';
$elective_class_style2 = ($elective_credits2 >= 32) ? 'text-green-500' : 'text-red-500';
