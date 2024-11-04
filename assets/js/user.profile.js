function triggerFileInput() {
  document.querySelector("#file").click();
}

const username = document.querySelector("#username").value;
const avarta = document.querySelector("#avarta");
document.addEventListener(
  "DOMContentLoaded",
  fetchUserDetails(avarta, username)
);

function uploadImage(event) {
  const file = event.target.files[0];
  if (!file) return;

  const progressBar = document.getElementById("progressBar");
  const statusDiv = document.getElementById("uploadStatus");
  statusDiv.textContent = "Uploading...";
  statusDiv.style.display = "block";
  progressBar.value = 0;

  const formData = new FormData();
  formData.append("image", file);

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "../php/userAuthentication.php", true);

  xhr.setRequestHeader("Service", "changeAvarta");

  // Track upload progress
  xhr.upload.addEventListener("progress", (event) => {
    if (event.lengthComputable) {
      const percentComplete = (event.loaded / event.total) * 100;
      progressBar.value = percentComplete;
    }
  });

  // Handle response
  xhr.onload = function () {
    if (xhr.status === 200) {
      const data = JSON.parse(xhr.responseText);
      progressBar.style.display = "block";
      if (data.success) {
        statusDiv.textContent = "Image uploaded successfully!";
        setInterval(() => {
          progressBar.style.display = "none";
          statusDiv.style.display = "none";
        }, 5000);
        fetchUserDetails(avarta, username);
      } else {
        statusDiv.textContent = "Error: " + data.message;
      }
    } else {
      statusDiv.textContent = "Upload failed.";
    }
    progressBar.value = 0; // Reset progress bar after upload
  };

  // Handle errors
  xhr.onerror = function () {
    statusDiv.textContent = "Error uploading image.";
  };

  // Send form data
  xhr.send(formData);
}

// Function to open tabs
function openTab(event, tabName) {
  const contents = document.querySelectorAll(".tab-content");
  contents.forEach((content) => content.classList.remove("active"));

  const buttons = document.querySelectorAll(".tab-button");
  buttons.forEach((button) => button.classList.remove("active"));

  document.getElementById(tabName).classList.add("active");
  event.currentTarget.classList.add("active");
}

// Set a default tab on page load
document.addEventListener("DOMContentLoaded", function () {
  document.querySelector(".tab-button").click();
});

document
  .querySelector("#changePasswordForm")
  .addEventListener("submit", async (e) => {
    e.preventDefault();
    const oldPassword = document.querySelector("#old-password").value;
    const newPassword = document.querySelector("#new-password").value;
    const confirmPassword = document.querySelector("#confirm-password").value;

    if (
      oldPassword.trim().length === 0 ||
      newPassword.trim().length === 0 ||
      confirmPassword.trim().length === 0
    ) {
      console.log("password cannot be empty");
      showErrorMessage(".error", "All fields required");
      return;
    }

    const formData = {
      oldPassword,
      newPassword,
      confirmPassword,
      username,
    };
    const response = await makeRequest(
      "../php/userAuthentication.php",
      "PUT",
      formData,
      "changePassword"
    );

    if (response.success) {
      showMessage('Hello', response.message, 'success', 'OK', '','', () => {
        this.reset();
      })
      window.location.href = "../index.php";
    } else {
      showErrorMessage(".error", response.message);
    }
  });
