document.querySelector("#logoutBtn").addEventListener("click", async () => {
  const response = await makeRequest(
    "../php/userAuthentication.php",
    "POST",
    "",
    "logout"
  );

  if (response.success) {
    window.location.href = "../index.php";
  }
});
