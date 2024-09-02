<aside class="w-64 h-full" aria-label="Sidebar">
    <div class="px-3 py-4 overflow-y-auto rounded bg-[#6e4db0] text-white dark:bg-gray-800">
        <ul class="space-y-4">
            <li>
                <a href="?page=dashboard" class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-white dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                    </svg>
                    <span class="ml-3">ระบบจัดการข้อมูลนักเรียน</span>
                </a>
            </li>
            <div class="bg-white w-full h-0.5">

            </div>
            <!----------------------------------- user ----------------------------------->
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-Manage-users" data-collapse-toggle="dropdown-Manage-users">
                    <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-white dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>จัดการข้อมูลนักเรียน</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul id="dropdown-Manage-users" class="hidden py-2 space-y-2">
                    <li>
                        <a href="?page=Manage_student" id="Manage-student-link" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">ข้อมูลผู้เรียน</a>
                    </li>
                    <li>
                        <a href="?page=reset_password" id="reset_password-link" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">รีเซ็ตรหัสผ่าน</a>
                    </li>
                    <li>
                        <a href="?page=StudentGrade" id="StudentGrade-link" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">เกรดนักเรียน-นักศึกษา</a>
                    </li>
                    <li>
                        <a href="?page=Studentcredit" id="Studentcredit-link" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">หน่วยกิตนักเรียน-นักศึกษา</a>
                    </li>
                    <li>
                        <a href="?page=manage_access_rights" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">นักศึกษาที่จบการศึกษา</a>
                    </li>
                    <li>
                        <a href="?page=manage_attendance" id="manage_attendance" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">ขาด/ลา/มาสาย</a>
                    </li>
                </ul>
            </li>
            <!----------------------------------- end user ----------------------------------->
            <!----------------------------------- กพช ----------------------------------->
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-Manage-activity" data-collapse-toggle="dropdown-Manage-activity">
                    <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-white dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 2a1 1 0 011-1h1V0h8v1h1a1 1 0 011 1v1h1a2 2 0 012 2v14a2 2 0 01-2 2H3a2 2 0 01-2-2V5a2 2 0 012-2h1V1a1 1 0 011-1zM4 3v1h12V3H4zm12 2H4v14h12V5zm-5 8v-2h-2v2H7v-4h6v4h-2z" />
                    </svg>

                    <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>กิจกรรม กพช</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul id="dropdown-Manage-activity" class="hidden py-2 space-y-2">
                    <li>
                        <a href="?page=Manage_Activity" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">เพิ่ม/ลบ/อัพเดต</a>
                    </li>
                    <li>
                        <a href="?page=Manage_Credits" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">จัดการข้อมูลหน่วยกิจ</a>
                    </li>
                    <li>
                        <a href="?page=Reports_and_statistics" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">รายงานและสถิติ</a>
                    </li>
                </ul>
            </li>
            <!----------------------------------- end กพช ----------------------------------->
            <!----------------------------------- เกี่ยวกับแอพพลิเคชั่น ----------------------------------->
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-ManageBook" data-collapse-toggle="dropdown-ManageBook">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#FFF" height="20px" width="20px" version="1.1" id="Capa_1" viewBox="0 0 487.5 487.5" xml:space="preserve">
                        <g>
                            <g>
                                <path d="M437,12.3C437,5.5,431.5,0,424.7,0H126.3C84.4,0,50.4,34.1,50.4,75.9v335.7c0,41.9,34.1,75.9,75.9,75.9h298.5    c6.8,0,12.3-5.5,12.3-12.3V139.6c0-6.8-5.5-12.3-12.3-12.3H126.3c-28.3,0-51.4-23.1-51.4-51.4S98,24.5,126.3,24.5h298.5    C431.5,24.5,437,19,437,12.3z M126.3,151.8h286.2V463H126.3c-28.3,0-51.4-23.1-51.4-51.4V131.7    C88.4,144.2,106.5,151.8,126.3,151.8z" />
                                <path d="M130.5,64.8c-6.8,0-12.3,5.5-12.3,12.3s5.5,12.3,12.3,12.3h280.1c6.8,0,12.3-5.5,12.3-12.3s-5.5-12.3-12.3-12.3H130.5z" />
                                <path d="M178,397.7c6.3,2.4,13.4-0.7,15.8-7.1l17.9-46.8h62.7c0.5,0,0.9-0.1,1.3-0.1l17.9,46.9c1.9,4.9,6.5,7.9,11.4,7.9    c1.5,0,2.9-0.3,4.4-0.8c6.3-2.4,9.5-9.5,7.1-15.8l-54-141.2c-3-7.9-10.4-13-18.8-13c-8.4,0-15.8,5.1-18.8,13l-54,141.2    C168.5,388.2,171.7,395.2,178,397.7z M243.7,260l22.7,59.3h-45.3L243.7,260z" />
                            </g>
                        </g>
                    </svg>

                    <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>หนังสือเรียน</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul id="dropdown-ManageBook" class="hidden py-2 space-y-2">
                    <li>
                        <a href="?page=ManageBook" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">เพิ่ม/ลบ/แก้ไข</a>
                    </li>
                    <!-- <li>
                            <a href="?page=" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">ข่าวสารและกิจกรรม</a>
                        </li>
                        <li>
                            <a href="?page=" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">ข่าวสารและกิจกรรม</a>
                        </li> -->
                    <li>
                        <a href="#" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">ข้อมูลหนังสือทั้งหมด</a>
                    </li>

                </ul>
            </li>
            <!----------------------------------- end เกี่ยวกับแอพพลิเคชั่น ----------------------------------->


            <li>
                <a href="../logout.php" class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-white dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
<script src="https://unpkg.com/flowbite@1.3.4/dist/flowbite.js"></script>
<script src="../scripts/select.js"></script>