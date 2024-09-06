// Get the current page from the URL
const params = new URLSearchParams(window.location.search);
const currentPage = params.get("page");

// Map of page names to their corresponding link IDs
const pageLinkMap = {
  dashboard: "dashboard-link",
  student_dashboard: "student_dashboard-link",
  courses_dashboard: "courses_dashboard-link",
  //   sidebar
  New_student_registration_system: "New-student-registration-system-link",
  equipment_management: "equipment_management",
  System_for_borrowing: "System_for_borrowing",
  Budget_for_borrowing: "Budget_for_borrowing",
  Borrow_Office_Supplies: "Borrow_Office_Supplies",
  borrowing_Borrow_history: "borrowing_Borrow_history",
  Manage_News: "Manage-News-link",
  ManageBook: "ManageBook-link",
  ShowBook: "ShowBook-link",
  Canceled_registration: "Canceled_registration-link",
  Statistics_and_reports: "Statistics_and_reports",

  //   educationsidebar
  Manage_courses: "Manage-courses-link",
  Manage_enrollments: "Manage-enrollments-link",
  Manage_Activity: "manage-activity-link",
  Manage_Credits: "manage-credits-link",
  Reports_and_statistics: "reports-statistics-link",
  Questions: "questions-link",
  Evaluation_management: "Evaluation-management-link",
  Graduation_system: "Graduation-system-link",
  //   Teachersidebar
  Teacher_Manage: "Teacher-Manage-link",
  reset_password: "reset-password-link",
  //   Studensidebar
  Manage_student: "Manage-student-link",
  reset_password: "reset_password-link",
  StudentGrade: "StudentGrade-link",
  Studentcredit: "Studentcredit-link",
  manage_attendance: "manage_attendance-link",
  StudentGrade: "StudentGrade-link",
  manage_access_rights: "manage_access_rights-link",

  // setting
  edit_profile: "edit-profile-link",
  Manage_Toolbar_setting: "Manage_Toolbar_setting-link",
  Manage_screen_setting: "Manage_screen_setting-link",
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
  Manage_News: "dropdown-application",
  ManageBook: "dropdown-ManageBook",
  ShowBook: "dropdown-ManageBook",
  Statistics_and_reports: "dropdown-Manage-reports",
  //   educationsidebar
  Manage_courses: "dropdown-Manage-courses",
  Manage_Activity: "dropdown-Manage-activity",
  Manage_Credits: "dropdown-Manage-activity",
  Reports_and_statistics: "dropdown-Manage-activity",
  //   Teachersidebar
  Teacher_Manage: "dropdown-Manage-Teacher",
  reset_password: "dropdown-Manage-Teacher",
  //   Studensidebar
  Manage_student: "dropdown-Manage-users",
  reset_password: "dropdown-Manage-users",
  StudentGrade: "dropdown-Manage-users",
  // manage_attendance: "dropdown-Manage-users",

  // setting
  Manage_Toolbar_setting: "dropdown-Manage-setting",
  Manage_screen_setting: "dropdown-Manage-setting",
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
