const addUserForm = document.querySelector("#addUserForm");

addUserForm.addEventListener("submit", async function (e) {
  e.preventDefault();

  const firstname = document.querySelector("#firstname").value;
  const lastname = document.querySelector("#lastname").value;
  const middlename = document.querySelector("#middlename").value;
  const role = document.querySelector("#user-role").value;

  const formData = {
    firstname,
    lastname,
    middlename,
    role,
  };

  console.log(formData);
  const response = await makeRequest(
    "../php/userAuthentication.php",
    "POST",
    formData,
    "addUser"
  );

  if (!response.success) {
    showErrorMessage(".container .section .form .error", response.message);
  } else {
    Swal.fire({
      title: "Success",
      text: response.message,
      icon: "success",
      confirmButtonText: "OK",
    });
   this.reset();
  }
});
