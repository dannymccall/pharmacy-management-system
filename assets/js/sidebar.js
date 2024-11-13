const user = document.querySelector("#username").value;
const avartaImage = document.querySelector("#user_image");
document.addEventListener(
  "DOMContentLoaded",
  
  fetchUserDetails(avartaImage, user)
);
