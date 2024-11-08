// Get the current page from the URL
const params = new URLSearchParams(window.location.search);
const currentPage = params.get("page");

// Map of page names to their corresponding link IDs
const pageLinkMap = {
  // header
  system: "system-head",
  education: "education-link",
  student: "student-link",

  dashboard: "dashboard-link",
  student_dashboard: "student_dashboard-link",
  courses_dashboard: "courses_dashboard-link",
  //   sidebar
  New_student_registration_system: "New-student-registration-system-link",
  equipment_management: "equipment_management",
  System_for_borrowing: "System_for_borrowing",
  BorrowingDetails: "System_for_borrowing",
  Budget_for_borrowing: "Budget_for_borrowing",
  Borrow_Office_Supplies: "Borrow_Office_Supplies",
  borrowing_Borrow_history: "borrowing_Borrow_history",
  Manage_News: "Manage-News-link",
  ManageBook: "ManageBook-link",
  ShowBook: "ShowBook-link",
  Canceled_registration: "Canceled_registration-link",
  Statistics_and_reports: "Statistics_and_reports",
  ai_analysis: "ai_analysis-link",

  //   educationsidebar
  Manage_courses: "Manage-courses-link",
  Manage_grade: "Manage_grade-link",
  Manage_enrollments: "Manage-enrollments-link",
  Add_enrollment: "Manage-enrollments-link",
  Manage_Activity: "Manage-Activity-link",
  Manage_Credits: "Manage-Credits-link",
  Check_Manage_Credits: "Check_Manage_Credits-link",
  Reports_and_statistics: "reports-statistics-link",
  Questions: "questions-link",
  Evaluation_management: "Evaluation-management-link",
  Graduation_system: "Graduation-system-link",
  add_Graduation_system: "Graduation-system-link",
  Graduation_history: "Graduation_history-link",
  eligible_students: "eligible_students-link",
  eligible_students_nnet: "eligible_students_nnet-link",
  add_eligible_students_nnet: "eligible_students_nnet-link",
  Manage_exam_Midterm: "Manage_exam_Midterm",
  add_exams: "Manage_exam_Midterm",
  Manage_exam_Final: "Manage_exam_Final",
  Student_registration_results: "Student_registration_results-link",
  detail_Student_registration_results: "Student_registration_results-link",
  Manage_academic_results: "Manage_academic_results-link",
  detail_Manage_academic_results: "Manage_academic_results-link",
  //   Teachersidebar
  Teacher_Manage: "Teacher-Manage-link",
  reset_password: "reset-password-link",
  Home_Room: "Home-Room-link",
  Room: "Home-Room-link",
  Lesson_plan: "Lesson_plan_link",
  your_classroom: "your_classroom_link",
  detali_classroom: "your_classroom_link",
  lesson_detail: "your_classroom_link",
  show_exam: "your_classroom_link",

  //   Studensidebar
  Manage_student: "Manage-student-link",
  reset_password: "reset_password-link",
  Studentcredit: "Studentcredit-link",
  manage_attendance: "manage_attendance-link",
  StudentGrade: "StudentGrade-link",
  manage_access_rights: "manage_access_rights-link",
  scores_management: "scores_management-link",
  add_scores_management: "scores_management-link",

  // setting
  edit_profile: "edit-profile-link",
  Manage_Toolbar_setting: "Manage_Toolbar_setting-link",
  Manage_screen_setting: "Manage_screen_setting-link",
  Manage_Tap_setting: "Manage_Tap_setting-link",
  Manage_table_setting: "Manage_table_setting-link",
};

const dropdownMap = {
  //   sidebars
  New_student_registration_system: "dropdown-register",
  Canceled_registration: "dropdown-register",
  equipment_management: "dropdown-System_for_borrowing",
  System_for_borrowing: "dropdown-System_for_borrowing",
  Budget_for_borrowing: "dropdown-System_for_borrowing",
  Borrow_Office_Supplies: "dropdown-System_for_borrowing",
  borrowing_Borrow_history: "dropdown-System_for_borrowing",
  BorrowingDetails: "dropdown-System_for_borrowing",
  Manage_News: "dropdown-application",
  ManageBook: "dropdown-ManageBook",
  ShowBook: "dropdown-ManageBook",
  Statistics_and_reports: "dropdown-Manage-reports",
  ai_analysis: "dropdown-Manage-reports",
  //   educationsidebar
  Manage_courses: "dropdown-Manage-courses",
  Manage_grade: "dropdown-Manage-courses",
  Manage_Activity: "dropdown-Manage-activity",
  Manage_Credits: "dropdown-Manage-activity",
  Check_Manage_Credits: "dropdown-Manage-activity",
  Reports_and_statistics: "dropdown-Manage-activity",
  eligible_students: "dropdown-Manage-exam",
  Manage_exam_Midterm: "dropdown-Manage-exam",
  add_exams: "dropdown-Manage-exam",
  Manage_exam_Final: "dropdown-Manage-exam",
  Graduation_system: "dropdown-Manage-Graduation",
  Graduation_history: "dropdown-Manage-Graduation",
  add_Graduation_system: "dropdown-Manage-Graduation",
  //   Teachersidebar
  Teacher_Manage: "dropdown-Manage-Teacher",
  reset_password: "dropdown-Manage-Teacher",
  Lesson_plan: "dropdown-Lesson-plan",
  your_classroom: "dropdown-class-room",
  detali_classroom: "dropdown-class-room",
  lesson_detail: "dropdown-class-room",
  show_exam: "dropdown-class-room",

  //   Studensidebar
  Manage_student: "dropdown-Manage-users",
  reset_password: "dropdown-Manage-users",
  // reset_password: "dropdown-academic-results",
  // StudentGrade: "dropdown-Manage-users",
  // manage_attendance: "dropdown-Manage-users",

  // setting
  Manage_Toolbar_setting: "dropdown-Manage-setting",
  Manage_screen_setting: "dropdown-Manage-setting",
  Manage_Tap_setting: "dropdown-Manage-setting",
  Manage_table_setting: "dropdown-Manage-setting",
};

if (currentPage && pageLinkMap[currentPage]) {
  document.getElementById(pageLinkMap[currentPage]).classList.add("bg-red-500");
}

if (currentPage && dropdownMap[currentPage]) {
  const dropdownId = dropdownMap[currentPage];
  const dropdown = document.getElementById(dropdownId);
  if (dropdown) {
    dropdown.classList.remove("hidden");
  }
}
