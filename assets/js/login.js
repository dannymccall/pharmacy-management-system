let button = document.querySelector("button");
let loaderDiv = document.querySelector(".loader__div");
let userForm = document.querySelector("#userForm");

// let errorMessage = document.querySelector(".error");

// button.addEventListener('click', () => {
//     loaderDiv.style.display = 'block'
// })

userForm.addEventListener("submit", async function (e) {
  e.preventDefault();

  button.style.display = "none";
  loaderDiv.style.display = "block";
  const username = document.querySelector("#username").value;
  const password = document.querySelector("#password").value;
  const formData = {
    username,
    password,
  };
  console.log(formData);

  const response = await makeRequest(
    "php/userAuthentication.php",
    "POST",
    formData,
    "userLogin"
  );

  const { success, message } = response;
  console.log(response);
  if (!success) {
    showErrorMessage(".container .container__section .login__section .error", message);
    loaderDiv.style.display = "none";
    button.style.display = "block";

  } else {
    console.log(response)
    let countDown = 5;
    const interval = setInterval(() => {
      countDown--;
      if (countDown === 0) {
        clearInterval(interval);
        window.location.href = "pages/dashboard.php";
        swal.close(); // Close the alert when countdown ends
      }
      swal.update({
        text: `${message}, navigating to dashboard in ${
          countDown > 0 ? countDown : ""
        } seconds`,
      });
    }, 1000);

    new swal({
      title: "Success!",
      text: `${message}, navigating to dashboard in ${countDown} seconds`,
      icon: "success",
      confirmButtonText: "OK",
    }).then((result) => {
      window.location.href = `pages/dashboard.php`;
    });
  }
});


