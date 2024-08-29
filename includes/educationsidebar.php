<div class="flex h-screen">
    <aside class="w-64 h-full bg-[#6e4db0] text-white p-4 overflow-y-auto" aria-label="Sidebar">
        <div class="space-y-4">
            <ul class="space-y-4">
                <li class="group">
                    <a href="?page=dashboard" id="dashboard-link" class="flex items-center p-2 text-base font-normal text-white rounded-lg hover:bg-white hover:text-gray-800 dark:hover:bg-gray-700">
                        <svg class="w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-gray-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
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
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#FFF" height="20px" width="20px" version="1.1" id="Capa_1" viewBox="0 0 490.1 490.1" xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M32.1,141.15h76.7c17.7,0,32.1-14.4,32.1-32.1v-76.7c0-17.7-14.4-32.1-32.1-32.1H32.1C14.4,0.25,0,14.65,0,32.35v76.7    C0,126.75,14.4,141.15,32.1,141.15z M24.5,32.35c0-4.2,3.4-7.6,7.6-7.6h76.7c4.2,0,7.6,3.4,7.6,7.6v76.7c0,4.2-3.4,7.6-7.6,7.6    H32.1c-4.2,0-7.6-3.4-7.6-7.6V32.35z" />
                                    <path d="M0,283.45c0,17.7,14.4,32.1,32.1,32.1h76.7c17.7,0,32.1-14.4,32.1-32.1v-76.7c0-17.7-14.4-32.1-32.1-32.1H32.1    c-17.7,0-32.1,14.4-32.1,32.1V283.45z M24.5,206.65c0-4.2,3.4-7.6,7.6-7.6h76.7c4.2,0,7.6,3.4,7.6,7.6v76.7c0,4.2-3.4,7.6-7.6,7.6    H32.1c-4.2,0-7.6-3.4-7.6-7.6V206.65z" />
                                    <path d="M0,457.75c0,17.7,14.4,32.1,32.1,32.1h76.7c17.7,0,32.1-14.4,32.1-32.1v-76.7c0-17.7-14.4-32.1-32.1-32.1H32.1    c-17.7,0-32.1,14.4-32.1,32.1V457.75z M24.5,381.05c0-4.2,3.4-7.6,7.6-7.6h76.7c4.2,0,7.6,3.4,7.6,7.6v76.7c0,4.2-3.4,7.6-7.6,7.6    H32.1c-4.2,0-7.6-3.4-7.6-7.6V381.05z" />
                                    <path d="M477.8,31.75H202.3c-6.8,0-12.3,5.5-12.3,12.3c0,6.8,5.5,12.3,12.3,12.3h275.5c6.8,0,12.3-5.5,12.3-12.3    C490.1,37.25,484.6,31.75,477.8,31.75z" />
                                    <path d="M477.8,85.15H202.3c-6.8,0-12.3,5.5-12.3,12.3s5.5,12.3,12.3,12.3h275.5c6.8,0,12.3-5.5,12.3-12.3    C490,90.65,484.6,85.15,477.8,85.15z" />
                                    <path d="M477.8,206.05H202.3c-6.8,0-12.3,5.5-12.3,12.3s5.5,12.3,12.3,12.3h275.5c6.8,0,12.3-5.5,12.3-12.3    C490,211.55,484.6,206.05,477.8,206.05z" />
                                    <path d="M477.8,259.55H202.3c-6.8,0-12.3,5.5-12.3,12.3s5.5,12.3,12.3,12.3h275.5c6.8,0,12.3-5.5,12.3-12.3    C490,265.05,484.6,259.55,477.8,259.55z" />
                                    <path d="M477.8,380.45H202.3c-6.8,0-12.3,5.5-12.3,12.3s5.5,12.3,12.3,12.3h275.5c6.8,0,12.3-5.5,12.3-12.3    C490,385.95,484.6,380.45,477.8,380.45z" />
                                    <path d="M490,446.15c0-6.8-5.5-12.3-12.3-12.3H202.3c-6.8,0-12.3,5.5-12.3,12.3s5.5,12.3,12.3,12.3h275.5    C484.6,458.35,490,452.85,490,446.15z" />
                                </g>
                            </g>
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
                    <a href="?page=Manage_enrollments" id="Manage-enrollments-link" class="flex items-center p-2 text-base font-normal text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 14 14">
                            <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                            <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5" />
                        </svg>
                        <span class="ml-3 flex-1 whitespace-nowrap">การจัดการการลงทะเบียนเรียน</span>
                    </a>
                </li>
                <!----------------------------------- end จัดการรายวิชาและเนื้อหา ----------------------------------->
                <!----------------------------------- จัดการรายวิชาและเนื้อหา ----------------------------------->
                <li>
                    <a href="?page=Manage_enrollments" id="Manage-enrollments-link" class="flex items-center p-2 text-base font-normal text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 14 14">
                            <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                            <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5" />
                        </svg>
                        <span class="ml-3 flex-1 whitespace-nowrap">การจัดการการประเมินผล</span>
                    </a>
                </li>
                <!----------------------------------- end จัดการรายวิชาและเนื้อหา ----------------------------------->
                <!----------------------------------- จัดการรายวิชาและเนื้อหา ----------------------------------->
                <li>
                    <a href="?page=Manage_enrollments" id="Manage-enrollments-link" class="flex items-center p-2 text-base font-normal text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 14 14">
                            <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                            <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5" />
                        </svg>
                        <span class="ml-3 flex-1 whitespace-nowrap">ระบบจบการศึกษา</span>
                    </a>
                </li>
                <!----------------------------------- end จัดการรายวิชาและเนื้อหา ----------------------------------->
                <!----------------------------------- กพช ----------------------------------->
                <li>
                    <button type="button" id="manage-activity-button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg hover:bg-white hover:text-gray-800 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-Manage-activity" data-collapse-toggle="dropdown-Manage-activity">
                        <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-gray-800 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 2a1 1 0 011-1h1V0h8v1h1a1 1 0 011 1v1h1a2 2 0 012 2v14a2 2 0 01-2 2H3a2 2 0 01-2-2V5a2 2 0 012-2h1V1a1 1 0 011-1zM4 3v1h12V3H4zm12 2H4v14h12V5zm-5 8v-2h-2v2H7v-4h6v4h-2z" />
                        </svg>

                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>รายวิชา</span>
                        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul id="dropdown-Manage-activity" class="hidden py-2 space-y-2">
                        <li>
                            <a href="?page=Manage_Activity" id="manage-activity-link" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:text-white dark:hover:bg-gray-700 pl-11">เพิ่ม/ลบ/อัพเดต</a>
                        </li>
                        <li>
                            <a href="?page=Manage_Credits" id="manage-credits-link" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:text-white dark:hover:bg-gray-700 pl-11">จัดการข้อมูลรายวิชา</a>
                        </li>
                        <li>
                            <a href="?page=Reports_and_statistics" id="reports-statistics-link" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:text-white dark:hover:bg-gray-700 pl-11">รายงานและสถิติ</a>
                        </li>
                    </ul>
                </li>
                <!----------------------------------- end กพช ----------------------------------->
                <li>
                    <a href="?page=Questions" id="questions-link" class="flex items-center p-2 text-base font-normal text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="w-6 h-6 text-white transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-3 flex-1 whitespace-nowrap">test2</span>
                    </a>
                </li>
                <li>
                    <a href="../logout.php" id="logout-link" class="flex items-center p-2 text-base font-normal text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="w-6 h-6 text-white transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-3 flex-1 whitespace-nowrap">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
</div>

<script src="https://unpkg.com/flowbite@1.3.4/dist/flowbite.js"></script>
<script src="../scripts/select.js"></script>