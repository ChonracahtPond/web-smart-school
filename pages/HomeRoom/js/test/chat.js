const chatBox = document.getElementById("chatBox");
const chatCloseButton = document.getElementById("chatCloseButton");
const chatSendButton = document.getElementById("chatSendButton");
const chatInput = document.getElementById("chatInput");
const chatMessages = document.getElementById("chatMessages");

// Function to toggle chat visibility
function toggleChat() {
  chatBox.classList.toggle("hidden");
  chatBox.classList.toggle("collapsed");
}

// Function to send a message
function sendMessage() {
  const message = chatInput.value.trim();
  if (message) {
    const messageElement = document.createElement("div");
    messageElement.textContent = message;
    messageElement.classList.add("bg-gray-100", "p-2", "rounded-lg", "mb-2");
    chatMessages.appendChild(messageElement);
    chatInput.value = "";
    chatMessages.scrollTop = chatMessages.scrollHeight;
  }
}

// Event listeners
document.addEventListener("DOMContentLoaded", () => {
  const chatIcon = document.querySelector("#chatHeader h2");

  chatCloseButton.addEventListener("click", () => {
    if (chatBox.classList.contains("collapsed")) {
      chatBox.classList.remove("collapsed");
      chatIcon.classList.remove("hidden");
      chatCloseButton.innerHTML = '<i class="fas fa-times"></i>'; // Update icon if needed
    } else {
      chatBox.classList.add("collapsed");
      chatIcon.classList.add("hidden");
      chatCloseButton.innerHTML = '<i class="fas fa-chevron-right"></i>'; // Change icon to indicate collapsed state
    }
  });

  chatSendButton.addEventListener("click", sendMessage);

  // Optional: Send message on Enter key press
  chatInput.addEventListener("keypress", (event) => {
    if (event.key === "Enter") {
      event.preventDefault();
      sendMessage();
    }
  });
});
