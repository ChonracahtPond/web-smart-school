<div class="flex h-screen">
    <!-- <aside class="w-64 h-full bg-[#6e4db0] text-white p-4 overflow-y-auto " aria-label="Sidebar"> -->
    <aside class="w-64 h-full text-white p-4 overflow-y-auto" style="background-color: <?php echo htmlspecialchars($tool_color); ?>;" aria-label="Sidebar">
        <div class="space-y-4">
            <ul class="space-y-4">
                <li class="group">
                    <a href="?page=courses_dashboard" id="courses_dashboard-link" class="flex items-center p-2 text-base font-normal text-white rounded-lg hover:bg-white hover:text-gray-800 dark:hover:bg-gray-700">
                        <!-- <div class="w-10 h-10 border-white border-w-1 border-2 border-indigo-500/100 static "></div> -->
                        <svg class="w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-gray-800 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                        </svg>
                        <span class="ml-3">การจัดการรายวิชา</span>
                    </a>
                </li>
                <div class="bg-white w-full h-0.5"></div>
                <!----------------------------------- จัดการรายวิชาและเนื้อหา ----------------------------------->
                <li>
                    <button type="button" id="manage-activity-button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg hover:bg-white hover:text-gray-800 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-Manage-courses" data-collapse-toggle="dropdown-Manage-courses">
                        <svg class="h-6 w-6 " viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                        </svg>

                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>จัดการรายวิชาและเนื้อหา</span>
                        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul id="dropdown-Manage-courses" class="hidden py-2 space-y-2">
                        <!-- <li>
                            <a href="?page=Manage_courses" id="Manage-courses-link" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:text-white dark:hover:bg-gray-700 pl-11">เพิ่ม/ลบ/อัพเดต</a>
                        </li> -->
                        <li>
                            <a href="?page=Manage_courses" id="Manage-courses-link" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:text-white dark:hover:bg-gray-700 pl-11">ระบบจัดการรายวิชา</a>
                        </li>
                        <!-- <li>
                            <a href="?page=" id="Manage-enrollments-link" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:text-white dark:hover:bg-gray-700 pl-11">การจัดการการลงทะเบียนเรียน</a>
                        </li> -->
                    </ul>
                </li>
                <!----------------------------------- end จัดการรายวิชาและเนื้อหา ----------------------------------->
                <!----------------------------------- จัดการรายวิชาและเนื้อหา ----------------------------------->
                <li>
                    <a href="?page=Manage_enrollments" id="Manage-enrollments-link" class="flex items-center p-2 text-base font-normal text-white rounded-lg hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 14 14">
                            <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                            <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5" />
                        </svg>
                        <span class="ml-3 flex-1 whitespace-nowrap">ลงทะเบียนเรียน</span>
                    </a>
                </li>
                <!----------------------------------- end จัดการรายวิชาและเนื้อหา ----------------------------------->
                <!----------------------------------- จัดการรายวิชาและเนื้อหา ----------------------------------->
                <li>
                    <a href="?page=Student_registration_results" id="Student_registration_results-link" class="flex items-center p-2 text-base font-normal text-white rounded-lg hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700">
                        <svg class="h-6 w-6 " width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" />
                            <rect x="4" y="3" width="8" height="14" rx="4" />
                            <rect x="12" y="7" width="8" height="10" rx="3" />
                            <line x1="8" y1="21" x2="8" y2="13" />
                            <line x1="16" y1="21" x2="16" y2="14" />
                        </svg>
                        <span class="ml-3 flex-1 whitespace-nowrap">ผลการลงทะเบียนเรียน</span>
                    </a>
                </li>
                <!----------------------------------- end จัดการรายวิชาและเนื้อหา ----------------------------------->
                <!----------------------------------- user ----------------------------------->
                <li>
                    <a href="?page=eligible_students_nnet" id="eligible_students_nnet-link" class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700">
                        <svg class="h-6 w-6 " width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" />
                            <line x1="9" y1="14" x2="15" y2="8" />
                            <circle cx="9.5" cy="8.5" r=".5" fill="currentColor" />
                            <circle cx="14.5" cy="13.5" r=".5" fill="currentColor" />
                            <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16l-3 -2l-2 2l-2 -2l-2 2l-2 -2l-3 2" />
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">ผู้ที่มีสิทธิ์สอบ N-NET</span>
                    </a>
                </li>
                <li>
                    <a href="?page=scores_management" id="scores_management-link" class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700">
                        <svg class="h-6 w-6 " width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" />
                            <line x1="9" y1="14" x2="15" y2="8" />
                            <circle cx="9.5" cy="8.5" r=".5" fill="currentColor" />
                            <circle cx="14.5" cy="13.5" r=".5" fill="currentColor" />
                            <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16l-3 -2l-2 2l-2 -2l-2 2l-2 -2l-3 2" />
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">จัดการคะแนน N-NET</span>
                    </a>
                </li>
                <!----------------------------------- end user ----------------------------------->
                <!----------------------------------- จัดการรายวิชาและเนื้อหา ----------------------------------->
                <li>
                    <button type="button" id="manage-activity-button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg hover:bg-white hover:text-gray-800 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-Manage-exam" data-collapse-toggle="dropdown-Manage-exam">
                        <svg class="h-6 w-6 " width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" />
                            <path d="M6 4h11a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-11a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1m3 0v18" />
                            <line x1="13" y1="8" x2="15" y2="8" />
                            <line x1="13" y1="12" x2="15" y2="12" />
                        </svg>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>ระบบจัดการสอบ</span>
                        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul id="dropdown-Manage-exam" class="hidden py-2 space-y-2">
                        <li>
                            <a href="?page=eligible_students" id="eligible_students-link" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:text-white dark:hover:bg-gray-700 pl-11">ผู้ที่มีสิทธิ์สอบ</a>
                        </li>
                        <li>
                            <a href="?page=Manage_exam_Midterm" id="Manage_exam_Midterm" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:text-white dark:hover:bg-gray-700 pl-11">ระบบจัดสอบกลางภาค</a>
                        </li>

                        <li>
                            <a href="?page=Manage_exam_Final" id="Manage_exam_Final" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:text-white dark:hover:bg-gray-700 pl-11">ระบบจัดสอบปลายภาค</a>
                        </li>
                    </ul>
                </li>
                <!----------------------------------- end จัดการรายวิชาและเนื้อหา ----------------------------------->
                <!----------------------------------- จัดการรายวิชาและเนื้อหา ----------------------------------->
                <li>
                    <button type="button" id="manage-activity-button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg hover:bg-white hover:text-gray-800 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-Manage-Graduation" data-collapse-toggle="dropdown-Manage-Graduation">
                        <svg class="h-6 w-6 " width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" />
                            <path d="M6 4h11a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-11a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1m3 0v18" />
                            <line x1="13" y1="8" x2="15" y2="8" />
                            <line x1="13" y1="12" x2="15" y2="12" />
                        </svg>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>จัดการจบการศึกษา</span>
                        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul id="dropdown-Manage-Graduation" class="hidden py-2 space-y-2">
                        <li>
                            <a href="?page=Graduation_system" id="Graduation-system-link" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:text-white dark:hover:bg-gray-700 pl-11">คาดว่าจะจบการศึกษา</a>
                        </li>
                        <li>
                            <a href="?page=Graduation_history" id="Graduation_history-link" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:text-white dark:hover:bg-gray-700 pl-11">ประวัติการจบการศึกษา</a>
                        </li>

                        <!-- <li>
                            <a href="?page=Manage_exam_Final" id="Manage_exam_Final" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:text-white dark:hover:bg-gray-700 pl-11">ระบบจัดสอบปลายภาค</a>
                        </li> -->

                    </ul>
                </li>
                <!----------------------------------- end จัดการรายวิชาและเนื้อหา ----------------------------------->
                <!----------------------------------- จัดการรายวิชาและเนื้อหา ----------------------------------->
                <!-- <li>
                    <a href="?page=Graduation_system" id="Graduation-system-link" class="flex items-center p-2 text-base font-normal text-white rounded-lg hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-mortarboard-fill" viewBox="0 0 16 16">
                            <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917z" />
                            <path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466z" />
                        </svg>
                        <span class="ml-3 flex-1 whitespace-nowrap">ระบบจบการศึกษา</span>
                    </a>
                </li> -->
                <!----------------------------------- end จัดการรายวิชาและเนื้อหา ----------------------------------->
                <!----------------------------------- จัดการรายวิชาและเนื้อหา ----------------------------------->
                <li>
                    <a href="?page=Evaluation_management" id="Evaluation-management-link" class="flex items-center p-2 text-base font-normal text-white rounded-lg hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-data-fill" viewBox="0 0 16 16">
                            <path d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5z" />
                            <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5zM10 8a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0zm-6 4a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0zm4-3a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1" />
                        </svg>
                        <span class="ml-3 flex-1 whitespace-nowrap">การจัดการประเมินผล</span>
                    </a>
                </li>
                <!----------------------------------- end จัดการรายวิชาและเนื้อหา ----------------------------------->

                <!-- <li>
                    <a href="../logout.php" id="logout-link" class="flex items-center p-2 text-base font-normal text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="w-6 h-6 text-white transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-3 flex-1 whitespace-nowrap">Logout</span>
                    </a>
                </li> -->
            </ul>
        </div>
    </aside>
</div>

<script src="https://unpkg.com/flowbite@1.3.4/dist/flowbite.js"></script>
<script src="../scripts/select.js"></script>