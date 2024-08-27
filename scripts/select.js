// Get the current page from the URL
const params = new URLSearchParams(window.location.search);
const currentPage = params.get("page");

// Map of page names to their corresponding link IDs
const pageLinkMap = {
  dashboard: "dashboard-link",
  //   sidebar
  New_student_registration_system: "New_student_registration_system",
  equipment_management: "equipment_management",
  System_for_borrowing: "System_for_borrowing",
  Borrow_Office_Supplies: "Borrow_Office_Supplies",
  Manage_News: "Manage_News",

  //   educationsidebar
  Manage_courses: "Manage-courses-link",
  Manage_enrollments: "Manage-enrollments-link",
  Manage_Activity: "manage-activity-link",
  Manage_Credits: "manage-credits-link",
  Reports_and_statistics: "reports-statistics-link",
  Questions: "questions-link",
};

// Map of page names to their corresponding dropdown IDs
const dropdownMap = {
  //   sidebar
  New_student_registration_system: "dropdown-register",
  equipment_management: "dropdown-System_for_borrowing",
  System_for_borrowing: "dropdown-System_for_borrowing",
  Borrow_Office_Supplies: "dropdown-System_for_borrowing",
  Manage_News: "dropdown-application",
  //   educationsidebar
  Manage_courses: "dropdown-Manage-courses",
  Manage_enrollments: "dropdown-Manage-courses",
  Manage_Activity: "dropdown-Manage-activity",
  Manage_Credits: "dropdown-Manage-activity",
  Reports_and_statistics: "dropdown-Manage-activity",
  // Add more mappings if you have more dropdowns
};

// Add the bg-red-500 class to the corresponding link
if (currentPage && pageLinkMap[currentPage]) {
  document.getElementById(pageLinkMap[currentPage]).classList.add("bg-red-500");
}

// Expand the dropdown if the current page belongs to it
if (currentPage && dropdownMap[currentPage]) {
  const dropdownId = dropdownMap[currentPage];
  const dropdown = document.getElementById(dropdownId);
  if (dropdown) {
    dropdown.classList.remove("hidden");
  }
}