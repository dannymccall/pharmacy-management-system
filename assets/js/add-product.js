const button = selectElement("button");
const medicineForm = selectElement("#medicineForm");
// const loaderDiv = selectElement(".loader__div");
let errorMessage = selectElement(".error");

// button.addEventListener('click', () => {
//     loaderDiv.style.display = 'block'
// })

const selectCategory = selectElement("#category");
const selectUnit = selectElement("#unit");

function createOptionRow(value, textContent, element) {
  const option = document.createElement("option");
  option.value = value;
  option.textContent = textContent;
  element.appendChild(option);
}

async function fetchCategories() {
  return await makeRequest(
    `../php/category.script.php`,
    "GET",
    "",
    "fetchCategory"
  );
}

async function fetchUnit() {
  return await makeRequest(`../php/unit.script.php`, "GET", "", "fetchUnits");
}

const c = async () => {
  const categoriesResponse = await fetchCategories();
  categoriesResponse.categories.map((item) => {
    createOptionRow(item.categoryname, item.categoryname, selectCategory);
  });
};

const u = async () => {
  const unitResponse = await fetchUnit();
  unitResponse.units.map((item) => {
    createOptionRow(item.unit, item.unit, selectUnit);
  });
};

document.addEventListener("DOMContentLoaded", async function () {
  c();
  u();
});

medicineForm.addEventListener("submit", async function (e) {
  e.preventDefault();

  button.style.display = "none";
  // loaderDiv.style.display = "block";

  const medicinename = document.querySelector("#medicine-name").value;
  const medicinecategory = document.querySelector("#category").value;
  const medicineunit = document.querySelector("#unit").value;
  const medicinecostunitprice = document.querySelector("#cost-price").value;
  const medicinesellingunitprice =
    document.querySelector("#selling-price").value;
  const quantity = document.querySelector("#quantity").value;

  const formData = {
    medicinename,
    medicinecategory,
    medicineunit,
    medicinecostunitprice,
    medicinesellingunitprice,
    quantity,
  };
  console.log(formData);

  const reponse = await makeRequest(
    `../php/medicine.script.php`,
    "POST",
    formData,
    "addMedicine"
  );

  const { success, message } = reponse;

  console.log(reponse);
  if (!success) {
    showErrorMessage(".error", message);
    scrollTo({ behavior: "smooth" });
    // loaderDiv.style.display = "none";
    button.style.display = "block";
  } else {
    errorMessage.style.display = "none";

    new swal({
      title: "Success!",
      text: `${message},`,
      icon: "success",
      showCancelButton: true,
      confirmButtonText: "Add another",
      cancelButtonText: "Go to Medicine list",
      reverseButtons: true,
    }).then((result) => {
      if (result.isConfirmed)
        window.location.href = "../pages/add-product.php";
      else window.location.href = "../pages/view.product.php";
    });
  }
});

function debounce(fn, delay) {
  let timeoutID;
  return function (...args) {
    if (timeoutID) clearTimeout(timeoutID);
    timeoutID = setTimeout(() => {
      fn(...args);
    }, delay);
  };
}

document
  .querySelector("#add-unit-btn")
  .addEventListener("click", async function () {
    Swal.fire({
      title: "Add Unit",
      html: `
            <form id="userForm" style="display: flex; flex-direction: column; gap: 15px; width:100%;">
                <div style="width:100%;">
                  <label for="unitname" class="custom-label" style="font-family:Arial, Helvetica, sans-serif; font-size: 0.8em; width: 20rem;">Unit Name:</label>
                  <input type="text" id="unitname" name="unitname"  class="custom-input" style="font-family:Arial, Helvetica, sans-serif; padding: 5px; outline: none; border: 1px solid gray; border-radius: 5px; width:50%;">
                </div>
                <div style="width:100%;">
                  <label for="unit" class="unit" style="font-family:Arial, Helvetica, sans-serif; font-size: 0.8em; width: 40rem; margin-right:30px;">Unit:</label>
                  <input type="text" id="unit" name="unit" class="custom-input" style="font-family:Arial, Helvetica, sans-serif; padding: 5px; outline: none; border: 1px solid gray; border-radius: 5px;width:50%;">
                </div>
            </form>
        `,
      focusConfirm: false, // Prevent focus on the confirm button
      showCancelButton: true,
      cancelButtonText: "Cancel",
      confirmButtonText: "Submit",
    }).then(async (result) => {
      if (result.isConfirmed) {
        const unitname = document.querySelector("#unitname").value;
        const unit = document.querySelector("input[name='unit']").value;
        console.log({ unit });

        // if (!unitname || !unit) {
        //   Swal.showValidationMessage("Please enter both unit name and unit");
        //   return false;
        // }

        const response = await makeRequest(
          "../php/unit.script.php",
          "POST",
          { unitname, unit },
          "addUnit"
        );

        if (response.success) {
          selectUnit.innerHTML = '';
          u();
          Swal.fire({
            title: "Success",
            text: response.message,
            icon: "success",
            confirmButtonText: "OK",
            customClass: {
              title: "my-customer-title",
            },
          });
        }
      }
    });
  });

document
  .querySelector(".add-category-btn")
  .addEventListener("click", async function () {
    Swal.fire({
      title: "Add Category",
      html: `
            <form id="userForm" style="display: flex; flex-direction: column; gap: 15px; width:100%;">
                <div style="width:100%;">
                  <label for="unitname" class="custom-label" style="font-family:Arial, Helvetica, sans-serif; font-size: 0.8em; width: 20rem;">Category Name:</label>
                  <input type="text" id="categoryname" name="categoryname"  class="custom-input" style="font-family:Arial, Helvetica, sans-serif; padding: 5px; outline: none; border: 1px solid gray; border-radius: 5px; width:50%;">
                </div>
            
            </form>
        `,
      focusConfirm: false, // Prevent focus on the confirm button
      showCancelButton: true,
      cancelButtonText: "Cancel",
      confirmButtonText: "Submit",
    }).then(async (result) => {
      if (result.isConfirmed) {
        const categoryname = selectElementValue("#categoryname");
        if (!categoryname ) {
          Swal.showValidationMessage(
            "Please enter both category name and category"
          );
          return false;
        }

        const response = await makeRequest(
          "../php/category.script.php",
          "POST",
          { categoryname },
          "addCategory"
        );

        if (response.success) {
          selectCategory.innerHTML = '';
          c();
          Swal.fire({
            title: "Success",
            text: response.message,
            icon: "success",
            confirmButtonText: "OK",
          });
        }
      }
    });
  });

toggleMenu();
// document.querySelector('#menu').addEventListener("click", () => {
//   document.querySelector('.sidebar__container ').style.width = '50px';
// })
