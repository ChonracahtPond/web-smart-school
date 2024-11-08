<div class="flex h-screen">
    <!-- <aside class="w-64 h-full bg-[#6e4db0] text-white p-4 overflow-y-auto sticky top-0" aria-label="Sidebar"> -->
    <aside class="w-64 h-full text-white p-4 overflow-y-auto" style="background-color: <?php echo htmlspecialchars($tool_color); ?>;" aria-label="Sidebar">
        <ul class="space-y-4">
            <li>
                <a href="?page=dashboard" class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700">
                    <svg class="w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-white dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                    </svg>
                    <span class="ml-3">ระบบจัดการข้อมูลครู</span>
                </a>
            </li>
            <div class="bg-white w-full h-0.5">

            </div>
            <!----------------------------------- user ----------------------------------->
            <li>
                <a href="?page=Home_Room" id="Home-Room-link" class="flex items-center p-2 text-base font-normal text-white rounded-lg hover:bg-white hover:text-gray-800 dark:hover:bg-gray-700">
                    <svg class="flex-shrink-0 w-6 h-6  transition duration-75 dark:text-white group-hover:text-white dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">ระบบจัดการพบนักเรียน</span>
                </a>
            </li>
            <!----------------------------------- user ----------------------------------->
            <!----------------------------------- user ----------------------------------->
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-white rounded-lg hover:bg-gray-100 hover:text-gray-800 dark:text-white dark:hover:bg-gray-700" data-collapse-toggle="dropdown-class-room">
                    <svg class="h-6 w-6 " viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" />
                        <path d="M4 8v-2a2 2 0 0 1 2 -2h2" />
                        <path d="M4 16v2a2 2 0 0 0 2 2h2" />
                        <path d="M16 4h2a2 2 0 0 1 2 2v2" />
                        <path d="M16 20h2a2 2 0 0 0 2 -2v-2" />
                        <line x1="9" y1="12" x2="15" y2="12" />
                        <line x1="12" y1="9" x2="12" y2="15" />
                    </svg>
                    <span class="flex-1 ml-3">ระบบจัดการห้องเรียนออนไลน์</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul id="dropdown-class-room" class="hidden py-2 space-y-2">
                    <li>
                        <a href="?page=your_classroom" id="your_classroom_link" class="flex items-center w-full p-2 text-base font-normal text-white rounded-lg hover:bg-gray-100 hover:text-gray-800 dark:text-white dark:hover:bg-gray-700 pl-11">ห้องเรียนของคุณ</a>
                    </li>
                    <!-- <li>
                        <a href="?page=" class="flex items-center w-full p-2 text-base font-normal text-white rounded-lg hover:bg-gray-100 hover:text-gray-800 dark:text-white dark:hover:bg-gray-700 pl-11">รีเซ็ตรหัสผ่าน</a>
                    </li> -->
                </ul>
            </li>

            <!----------------------------------- user ----------------------------------->
            <!----------------------------------- user ----------------------------------->
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-Lesson-plan" data-collapse-toggle="dropdown-Lesson-plan">
                    <svg class="h-6 w-6" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" />
                        <path d="M15 7v-4h-12v12.01h4" stroke-dasharray=".001 4" />
                        <path d="M19 11v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" />
                        <path d="M13 13l9 3l-4 2l-2 4l-3 -9" />
                    </svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>ระบบช่วยวางแผนการสอน</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul id="dropdown-Lesson-plan" class="hidden py-2 space-y-2">
                    <li>
                        <a href="?page=Lesson_plan" id="Lesson_plan_link" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:text-white dark:hover:bg-gray-700 pl-11">ช่วยวางแผนการสอน</a>
                    </li>

                </ul>
            </li>
            <!----------------------------------- user ----------------------------------->
            <!-- <li>
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-Manage-Teacher" data-collapse-toggle="dropdown-Manage-Teacher">
                    <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-white dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>จัดการข้อมูลครู</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul id="dropdown-Manage-Teacher" class="hidden py-2 space-y-2">
                    <li>
                        <a href="?page=Teacher_Manage" id="Teacher-Manage-link" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">เพิ่ม/ลบ/อัพเดต</a>
                    </li>
                    <li>
                        <a href="?page=reset_password" id="reset-password-link" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">รีเซ็ตรหัสผ่าน</a>
                    </li>
                </ul>
            </li> -->

            <li>
                <a href="?page=add_exercise" class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-white dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">test</span>
                </a>
            </li>
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