const resetPasswordForm = document.querySelector("#resetPasswordForm");
const error = document.querySelector(".error");

resetPasswordForm.addEventListener("submit", async function (e) {
  e.preventDefault();
  const username = document.querySelector("#username").value;

  if (username.trim().length === 0) {
    showErrorMessage(".error", "Username cannot be empty");
    return;
  }

  const response = await makeRequest(
    "../php/userAuthentication.php",
    "POST",
    { username },
    "forgotPassword"
  );

  if (response.success) {
    username.value = '';
    Swal.fire({
      title: "Hello",
      icon: "success",
      html: `
               <p style="font-family:Arial, Helvetica, sans-serif; font-size: 0.8em"> ${response.message} </p> <br>
               <p style="font-family:Arial, Helvetica, sans-serif; font-size: 0.6em"> Please don't share this password with anybody </p> <br>
               <p style="font-family:Arial, Helvetica, sans-serif; font-size: 0.6em"> Password: <span style="font-weight: 700;">${response.password} <span></p>
            `,
      focusConfirm: false, // Prevent focus on the confirm button
      showCancelButton: false,
      cancelButtonText: "Cancel",
      confirmButtonText: "OK",
    }).then((result) => {
      let path = window.location.pathname;
      let filename = path.substring(path.lastIndexOf("/") + 1);
      if (result.isConfirmed && filename !== "reset-password.php") {
        return;
      } else if (result.isConfirmed && filename === "reset-password.php") {
        window.location.href = "../index.php";
      }
    });
  } else {
    showErrorMessage(".error", response.message);
  }
});


toggleMenu()