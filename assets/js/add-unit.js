const button = selectElement("button");
const unitForm = selectElement("#unitForm");
const loaderDiv = selectElement(".loader__div");
let errorMessage = selectElement(".error");

// button.addEventListener('click', () => {
//     loaderDiv.style.display = 'block'
// })

unitForm.addEventListener("submit", async function (e) {
  e.preventDefault();

  button.style.display = "none";
  loaderDiv.style.display = "block";

  const unitname = document.querySelector("#unit-name").value;
  const unit = document.querySelector("#unit").value;
  const formData = {
    unitname,
    unit,
  };
  console.log(formData);

  const reponse = await makeRequest(
    "../php/unit.script.php",
    "POST",
    formData,
    "addUnit"
  );

  const { success, message } = reponse;

  console.log(reponse);
  if (!success) {
    errorMessage.textContent = message;
    errorMessage.style.display = "block";
    loaderDiv.style.display = "none";
    button.style.display = "block";
  } else {
    errorMessage.style.display = "none";
    // let countDown = 5;
    // const interval = setInterval(() => {
    //   countDown--;
    //   if (countDown === 0) {
    //     clearInterval(interval);
    //     window.location.href = "pages/dashboard.php";
    //     swal.close(); // Close the alert when countdown ends
    //   }
    //   swal.update({
    //     text: `${message}, navigating to dashboard in ${
    //       countDown > 0 ? countDown : ""
    //     } seconds`,
    //   });
    // }, 1000);

    new swal({
      title: "Success!",
      text: `${message},`,
      icon: "success",
      showCancelButton: true,
      confirmButtonText: "Add another",
      cancelButtonText: "Go to unit list",
      reverseButtons: true,
    }).then((result) => {
      if (result.isConfirmed) window.location.href = "../pages/add-unit.php";
      else window.location.href = "../pages/view.units.php";
    });
  }
});
