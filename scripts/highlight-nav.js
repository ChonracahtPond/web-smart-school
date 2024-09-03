// Get the current page from the URL
const params = new URLSearchParams(window.location.search);
const currentPage = params.get("page");

// Map of page names to their corresponding link IDs
const pageLinkMap = {
  system: "system-link",
  education: "education-link",
  student: "student-link",
};

const dropdownMap = {};

// Highlight the current page link
if (currentPage && pageLinkMap[currentPage]) {
  const linkId = pageLinkMap[currentPage];
  const linkElement = document.getElementById(linkId);
  if (linkElement) {
    linkElement.classList.add("bg-purple-200"); // Highlight color for the active page
  }
}

// Show the corresponding dropdown
if (currentPage && dropdownMap[currentPage]) {
  const dropdownId = dropdownMap[currentPage];
  const dropdown = document.getElementById(dropdownId);
  if (dropdown) {
    dropdown.classList.remove("hidden");
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const currentPage = window.location.pathname.split("/").pop();

  const navItems = document.querySelectorAll("header ul li a");
  navItems.forEach((item) => {
    const href = item.getAttribute("href");
    if (href === currentPage) {
      item.parentElement.classList.add(
        "bg-purple-200",
        "text-gray-600",
        "rounded-lg"
      );
      item.parentElement.classList.add("h-[50px]");
    } else {
      item.parentElement.classList.remove(
        "bg-purple-200",
        "text-gray-600",
        "rounded-lg"
      );
    }
  });
});
