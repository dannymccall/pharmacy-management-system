const button = selectElement("button");
const categoryForm = selectElement("#categoryForm");
const loaderDiv = selectElement(".loader__div");
let errorMessage = selectElement(".error");

// button.addEventListener('click', () => {
//     loaderDiv.style.display = 'block'
// })

categoryForm.addEventListener("submit", async function (e) {
  e.preventDefault();

  button.style.display = "none";
  loaderDiv.style.display = "block";
  const categoryname = document.querySelector("#category-name").value;
  const category = document.querySelector("#category").value;


  if (categoryname.trim() === "" || category.trim() === "") {
    errorMessage.textContent = "All fields required";
    errorMessage.style.display = "block";
    return;
}

  const formData = {
    categoryname,
    category,
  };
  console.log(formData);

  const reponse = await makeRequest(
    "../php/category.script.php",
    "POST",
    formData,
    "addCategory"
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


    new swal({
      title: "Success!",
      text: `${message},`,
      icon: "success",
      showCancelButton: true,
      confirmButtonText: "Add another",
      cancelButtonText: "Go to category list",
      reverseButtons: true,
    }).then((result) => {
      if (result.isConfirmed) window.location.href = "../pages/add-category.php";
      else window.location.href = "../pages/view.categories.php";
    });
  }
});
