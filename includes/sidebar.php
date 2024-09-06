<div class="flex h-screen">
    <!-- <aside class="w-64 h-full bg-[#6e4db0] text-white p-4 overflow-y-auto " aria-label="Sidebar"> -->
    <aside class="w-64 h-full text-white p-4 overflow-y-auto" style="background-color: <?php echo htmlspecialchars($tool_color); ?>;" aria-label="Sidebar">
        <ul class="space-y-4">
            <li class="group">
                <a href="?page=dashboard" id="dashboard-link" class="flex items-center p-2 text-base font-normal text-white rounded-lg hover:bg-white hover:text-gray-800 dark:hover:bg-gray-700">
                    <svg class="w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-gray-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                    </svg>
                    <span class="ml-3 group-hover:text-gray-800">ระบบจัดการข้อมูล สกร.</span>
                </a>
            </li>
            <div class="bg-white w-full h-0.5">
            </div>

            <!----------------------------------- ครุภัณฑ์และวัสดุสำนักงาน ----------------------------------->
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-white hover:text-gray-800 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-register" data-collapse-toggle="dropdown-register">
                    <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-gray-800" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 4H4v16h16V4zm-8 10H8v-2h4v2zm4-4H8V8h8v2z" />
                    </svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>ระบบรับสมัคร</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul id="dropdown-register" class="hidden py-2 space-y-2">
                    <li>
                        <a href="?page=New_student_registration_system" id="New-student-registration-system-link" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700 pl-11">ระบบลงทะเบียนนักเรียนใหม่</a>
                    </li>
                    <li>
                        <a href="?page=Canceled_registration" id="Canceled_registration-link" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700 pl-11">ลงทะเบียนที่ถูกยกเลิก</a>
                    </li>
                    <li>
                        <a href="../pages/Newregister/register.php" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700 pl-11">ระบบสมัครเรียน</a>
                    </li>
                </ul>
            </li>
            <!----------------------------------- end ครุภัณฑ์และวัสดุสำนักงาน ----------------------------------->
            <!----------------------------------- ครุภัณฑ์และวัสดุสำนักงาน ----------------------------------->
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-white hover:text-gray-800 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-System_for_borrowing" data-collapse-toggle="dropdown-System_for_borrowing">
                    <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-gray-800" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 4H4v16h16V4zm-8 10H8v-2h4v2zm4-4H8V8h8v2z" />
                    </svg>

                    <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>ครุภัณฑ์และวัสดุสำนักงาน</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul id="dropdown-System_for_borrowing" class="hidden py-2 space-y-2">
                    <li>
                        <a href="?page=equipment_management" id="equipment_management" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700 pl-11">เพิ่ม/ลบ/อัพเดต</a>
                    </li>

                    <li>
                        <a href="?page=System_for_borrowing" id="System_for_borrowing" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700 pl-11">ระบบยืม-คืน ครุภัณฑ์และวัสดุสำนักงาน</a>
                    </li>
                    <li>
                        <a href="?page=Borrow_Office_Supplies" id="Borrow_Office_Supplies" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700 pl-11">ระบบเบิกวัสดุ ไม่ต้องคืน</a>
                    </li>
                    <li>
                        <a href="?page=Budget_for_borrowing" id="Budget_for_borrowing" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700 pl-11">งบประมาณที่ใช้ (แยกตามปี)</a>
                    </li>
                    <li>
                        <a href="?page=borrowing_Borrow_history" id="borrowing_Borrow_history" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700 pl-11">ประวัติ</a>
                    </li>
                </ul>
            </li>
            <!----------------------------------- end ครุภัณฑ์และวัสดุสำนักงาน ----------------------------------->
            <!----------------------------------- ครุภัณฑ์และวัสดุสำนักงาน ----------------------------------->
            <!-- <li>
                    <button type="button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-white hover:text-gray-800 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-System_education" data-collapse-toggle="dropdown-System_education">
                        <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-gray-800" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 4H4v16h16V4zm-8 10H8v-2h4v2zm4-4H8V8h8v2z" />
                        </svg>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>การจัดการทรัพยากรการศึกษา</span>
                        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul id="dropdown-System_education" class="hidden py-2 space-y-2">
                        <li>
                            <a href="?page=equipment_management" id="equipment_management" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700 pl-11">เพิ่ม/ลบ/อัพเดต</a>
                        </li>
                        <li>
                            <a href="?page=System_for_borrowing" id="System_for_borrowing" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700 pl-11">ระบบยืม-คืน ครุภัณฑ์และวัสดุสำนักงาน</a>
                        </li>
                        <li>
                            <a href="?page=Borrow_Office_Supplies" id="Borrow_Office_Supplies" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700 pl-11">ระบบเบิกวัสดุ ไม่ต้องคืน</a>
                        </li>
                    </ul>
                </li> -->
            <!----------------------------------- end ครุภัณฑ์และวัสดุสำนักงาน ----------------------------------->
            <!----------------------------------- ครุภัณฑ์และวัสดุสำนักงาน ----------------------------------->
            <!-- <li>
                    <button type="button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-white hover:text-gray-800 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-System_buyandhire" data-collapse-toggle="dropdown-System_buyandhire">
                        <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-gray-800" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 4H4v16h16V4zm-8 10H8v-2h4v2zm4-4H8V8h8v2z" />
                        </svg>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>การจัดซื้อจัดจ้าง</span>
                        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul id="dropdown-System_buyandhire" class="hidden py-2 space-y-2">
                        <li>
                            <a href="?page=" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700 pl-11">การวางแผนจัดซื้อ</a>
                        </li>
                        <li>
                            <a href="?page=" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700 pl-11">การสร้างคำขอซื้อ</a>
                        </li>
                        <li>
                            <a href="?page=" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700 pl-11">การประเมินและคัดเลือกผู้ขาย</a>
                        </li>
                    </ul>
                </li> -->
            <!----------------------------------- end ครุภัณฑ์และวัสดุสำนักงาน ----------------------------------->
            <!----------------------------------- ครุภัณฑ์และวัสดุสำนักงาน ----------------------------------->
            <!-- <li>
                    <button type="button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-white hover:text-gray-800 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-System_payments" data-collapse-toggle="dropdown-System_payments">
                        <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-gray-800" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 4H4v16h16V4zm-8 10H8v-2h4v2zm4-4H8V8h8v2z" />
                        </svg>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>การจัดการงบประมาณและการเงิน:</span>
                        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul id="dropdown-System_payments" class="hidden py-2 space-y-2">
                        <li>
                            <a href="?page=equipment_management" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700 pl-11">เพิ่ม/ลบ/อัพเดต</a>
                        </li>
                        <li>
                            <a href="?page=System_for_borrowing" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700 pl-11">ระบบยืม-คืน ครุภัณฑ์และวัสดุสำนักงาน</a>
                        </li>
                        <li>
                            <a href="?page=Borrow_Office_Supplies" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700 pl-11">ระบบเบิกวัสดุ ไม่ต้องคืน</a>
                        </li>
                    </ul>
                </li> -->
            <!----------------------------------- end ครุภัณฑ์และวัสดุสำนักงาน ----------------------------------->
            <!----------------------------------- Meetingandevent ----------------------------------->
            <!-- <li>
                    <button type="button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-white hover:text-gray-800 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-System_Meetingandevent" data-collapse-toggle="dropdown-System_Meetingandevent">
                        <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-gray-800" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 4H4v16h16V4zm-8 10H8v-2h4v2zm4-4H8V8h8v2z" />
                        </svg>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>การจัดการข้อมูลการประชุม</span>
                        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul id="dropdown-System_Meetingandevent " class="hidden py-2 space-y-2">
                        <li>
                            <a href="?page=System_Meetingandevent" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700 pl-11">การจัดการการประชุมและกิจกรรม</a>
                        </li>
                        <li>
                            <a href="?page=" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700 pl-11">ระบบยืม-คืน ครุภัณฑ์และวัสดุสำนักงาน</a>
                        </li>
                        <li>
                            <a href="?page=" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700 pl-11">ระบบเบิกวัสดุ ไม่ต้องคืน</a>
                        </li>
                    </ul>
                </li> -->
            <!----------------------------------- end ครุภัณฑ์และวัสดุสำนักงาน ----------------------------------->
            <!----------------------------------- จัดการรายงานและสถิติ ----------------------------------->
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-Manage-reports" data-collapse-toggle="dropdown-Manage-reports">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>


                    <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>จัดการรายงานและสถิติ</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul id="dropdown-Manage-reports" class="hidden py-2 space-y-2">
                    <li>
                        <a href="?page=Statistics_and_reports" id="Statistics_and_reports" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:text-white dark:hover:bg-gray-700 pl-11">รายงานและสถิติการสมัครเรียน</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 hover:text-gray-800 dark:text-white dark:hover:bg-gray-700 pl-11">วิเคราะห์สถิติ</a>
                    </li>

                </ul>
            </li>
            <!----------------------------------- end จัดการรายงานและสถิติ ----------------------------------->
            <!----------------------------------- จัดการระบบการสนทนาและการสื่อสาร ----------------------------------->
            <!-- <li>
                    <button type="button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-Manage-conversation" data-collapse-toggle="dropdown-Manage-conversation">
                        <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-white dark:group-hover:text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 3h18v14H3V3zm0-2c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V3c0-1.1-.9-2-2-2H3zm3 4h10v2H6V5zm0 4h10v2H6V9zm0 4h10v2H6v-2z" />
                        </svg>

                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>จัดการระบบการสนทนา</span>
                        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul id="dropdown-Manage-conversation" class="hidden py-2 space-y-2">
                        <li>
                            <a href="#" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">ดูแลระบบการสนทนา</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">ส่งประกาศ</a>
                        </li>

                    </ul>
                </li> -->
            <!----------------------------------- end จัดการระบบการสนทนาและการสื่อสาร ----------------------------------->
            <!----------------------------------- เกี่ยวกับแอพพลิเคชั่น ----------------------------------->
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-white hover:text-gray-800 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-application" data-collapse-toggle="dropdown-application">
                    <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-gray-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 0H6C4.34 0 3 1.34 3 3v14c0 1.66 1.34 3 3 3h8c1.66 0 3-1.34 3-3V3c0-1.66-1.34-3-3-3zM6 1h8c.55 0 1 .45 1 1v14c0 .55-.45 1-1 1H6c-.55 0-1-.45-1-1V2c0-.55.45-1 1-1zm4 16c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z" />
                    </svg>

                    <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>เกี่ยวกับแอพพลิเคชั่น</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul id="dropdown-application" class="hidden py-2 space-y-2">
                    <li>
                        <a href="?page=Manage_News" id="Manage-News-link" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-white hover:text-gray-800 dark:text-white dark:hover:bg-gray-700 pl-11">ข่าวสารและกิจกรรม</a>
                    </li>
                    <!-- <li>
                            <a href="#" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">แบรนเนอร์</a>
                        </li> -->

                </ul>
            </li>
            <!----------------------------------- end เกี่ยวกับแอพพลิเคชั่น ----------------------------------->
            <!----------------------------------- เกี่ยวกับแอพพลิเคชั่น ----------------------------------->
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-white hover:text-gray-800 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-ManageBook" data-collapse-toggle="dropdown-ManageBook">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentColor" height="20px" width="20px" version="1.1" id="Capa_1" viewBox="0 0 487.5 487.5" xml:space="preserve" class="text-white transition duration-75 group-hover:text-gray-800 dark:group-hover:text-gray-800">
                        <g>
                            <g>
                                <path d="M437,12.3C437,5.5,431.5,0,424.7,0H126.3C84.4,0,50.4,34.1,50.4,75.9v335.7c0,41.9,34.1,75.9,75.9,75.9h298.5    c6.8,0,12.3-5.5,12.3-12.3V139.6c0-6.8-5.5-12.3-12.3-12.3H126.3c-28.3,0-51.4-23.1-51.4-51.4S98,24.5,126.3,24.5h298.5    C431.5,24.5,437,19,437,12.3z M126.3,151.8h286.2V463H126.3c-28.3,0-51.4-23.1-51.4-51.4V131.7    C88.4,144.2,106.5,151.8,126.3,151.8z" />
                                <path d="M130.5,64.8c-6.8,0-12.3,5.5-12.3,12.3s5.5,12.3,12.3,12.3h280.1c6.8,0,12.3-5.5,12.3-12.3s-5.5-12.3-12.3-12.3H130.5z" />
                                <path d="M178,397.7c6.3,2.4,13.4-0.7,15.8-7.1l17.9-46.8h62.7c0.5,0,0.9-0.1,1.3-0.1l17.9,46.9c1.9,4.9,6.5,7.9,11.4,7.9    c1.5,0,2.9-0.3,4.4-0.8c6.3-2.4,9.5-9.5,7.1-15.8l-54-141.2c-3-7.9-10.4-13-18.8-13c-8.4,0-15.8,5.1-18.8,13l-54,141.2    C168.5,388.2,171.7,395.2,178,397.7z M243.7,260l22.7,59.3h-45.3L243.7,260z" />
                            </g>

                    </svg>


                    <span class="flex-1 ml-3 text-left whitespace-nowrap group-hover:text-gray-800" sidebar-toggle-item>หนังสือเรียน</span>
                    <svg sidebar-toggle-item class="w-6 h-6 transition duration-75 group-hover:text-gray-800 dark:group-hover:text-gray-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>

                <ul id="dropdown-ManageBook" class="hidden py-2 space-y-2">
                    <li>
                        <a href="?page=ManageBook" id="ManageBook-link" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-white hover:text-gray-800 dark:text-white dark:hover:bg-gray-700 pl-11">เพิ่ม/ลบ/แก้ไข</a>
                    </li>
                    <!-- <li>
                            <a href="?page=" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">ข่าวสารและกิจกรรม</a>
                        </li>
                        <li>
                            <a href="?page=" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">ข่าวสารและกิจกรรม</a>
                        </li> -->
                    <li>
                        <a href="?page=ShowBook" id="ShowBook-link" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-white hover:text-gray-800 dark:hover:bg-gray-700 pl-11">ข้อมูลหนังสือทั้งหมด</a>
                    </li>

                </ul>
            </li>
            <!----------------------------------- end เกี่ยวกับแอพพลิเคชั่น ----------------------------------->
            <!----------------------------------- สนับสนุนและแก้ไขปัญหา ----------------------------------->
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-Support" data-collapse-toggle="dropdown-Support">
                    <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-white dark:group-hover:text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17h-2v-2h2v2zm0-4h-2V7h2v8z" />
                    </svg>

                    <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>สนับสนุนและแก้ไขปัญหา</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul id="dropdown-Support" class="hidden py-2 space-y-2">
                    <li>
                        <a href="#" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">ช่วยเหลือผู้ใช้</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">จัดการข้อผิดพลาดและปัญหา</a>
                    </li>

                </ul>
            </li>
            <!----------------------------------- end สนับสนุนและแก้ไขปัญหา ----------------------------------->
            <!----------------------------------- ดูแลและอัพเดตระบบ ----------------------------------->
            <!-- <li>
                    <button type="button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-Maintain" data-collapse-toggle="dropdown-Maintain">
                        <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-white dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                        <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-white dark:group-hover:text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.24 4.759a1.5 1.5 0 00-2.121 0l-1.414 1.415a1.5 1.5 0 000 2.121l1.414 1.415a1.5 1.5 0 002.121-2.121l-1.414-1.415a1.5 1.5 0 00-2.121 0l-1.414 1.415a1.5 1.5 0 00-2.121-2.121l1.414-1.415a1.5 1.5 0 00-2.121-2.121L5.757 4.758a1.5 1.5 0 00-2.121 2.121l1.414 1.415a1.5 1.5 0 002.121 2.121l1.414-1.415a1.5 1.5 0 002.121 2.121l1.414-1.415a1.5 1.5 0 002.121 2.121l1.414-1.415a1.5 1.5 0 000-2.121l-1.414-1.415a1.5 1.5 0 00-2.121-2.121zM6.343 5.65l-1.415 1.415a1.5 1.5 0 000 2.121l1.415 1.415a1.5 1.5 0 002.121-2.121l-1.415-1.415a1.5 1.5 0 00-2.121 0zM11.5 13.5a1 1 0 10-2 0v1.875a1 1 0 102 0V13.5zM17 13.5a1 1 0 10-2 0v1.875a1 1 0 102 0V13.5z" />
                        </svg>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>ดูแลและอัพเดตระบบ</span>
                        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul id="dropdown-Maintain" class="hidden py-2 space-y-2">
                        <li>
                            <a href="#" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">ตรวจสอบการทำงานของระบบ</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11">อัพเดตระบบ</a>
                        </li>

                    </ul>
                </li> -->
            <!----------------------------------- end ดูแลและอัพเดตระบบ ----------------------------------->



            <!-- <li>
                    <a href="#" class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-white dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Kanban</span>
                        <span class="inline-flex items-center justify-center px-2 ml-3 text-sm font-medium text-gray-800 bg-gray-200 rounded-full dark:bg-gray-700 dark:text-gray-300">Pro</span>
                    </a>
                </li> -->
            <!-- <li>
                    <a href="#" class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-white dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z">
                            </path>
                            <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z">
                            </path>
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">สมัครเข้ามาใหม่</span>
                        <span class="inline-flex items-center justify-center w-3 h-3 p-3 ml-3 text-sm font-medium text-blue-600 bg-blue-200 rounded-full dark:bg-blue-900 dark:text-blue-200">3</span>
                    </a>
                </li> -->
            <!-- <li>
                    <a href="#" class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-white dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Users</span>
                    </a>
                </li> -->
            <!-- <li>
                    <a href="?page=Exercises" class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-white dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">test</span>
                    </a>
                </li>
                <li>
                    <a href="?page=Questions" class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-white dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">test2</span>
                    </a>
                </li> -->
            <!-- <li>
                <a href="../logout.php" class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 dark:text-white group-hover:text-white dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">Logout</span>
                </a>
            </li> -->
        </ul>

    </aside>
</div>

<script src="https://unpkg.com/flowbite@1.3.4/dist/flowbite.js"></script>
<script src="../scripts/select.js"></script>