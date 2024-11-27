const expenseForm = document.querySelector("#expenseForm");
const expenseSelect = document.querySelector("#expense-category");


async function fetchExpenseCategories() {
  const response = await makeRequest(
    "../php/expense.category.script.php",
    "GET",
    "",
    "fetchExpenseCategories"
  );
  console.log(response);

  response.expensecategories.forEach((category) => {
    const expenseOption = document.createElement("option");
    expenseOption.value = category.categoryname;
    expenseOption.textContent = category.categoryname;

    expenseSelect.appendChild(expenseOption);
  });
}

fetchExpenseCategories();
expenseForm.addEventListener("submit", async function (e) {
  e.preventDefault();

  const expenseDate = document.querySelector("#expense-date").value;
  const expenseCategory = document.querySelector("#expense-category").value;
  const purpose = document.querySelector("#purpose").value;
  const total = document.querySelector("#total").value;
  const expenseDescription = document.querySelector("#expenseDescription").value;


  const formData = {
    expenseDate,
    expenseCategory,
    purpose,
    total,
    expenseDescription
  };

  console.log(formData);
  const response = await makeRequest(
    "../php/expense.script.php",
    "POST",
    formData,
    "addExpense"
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

document
  .querySelector(".add-category-btn")
  .addEventListener("click", async function () {
    Swal.fire({
      title: "Add Expense Category",
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
        const categoryname = document.querySelector("#categoryname").value;

        const response = await makeRequest(
          "../php/expense.script.php",
          "POST",
          { categoryname },
          "addExpenseCategory"
        );

        if (response.success) {
          expenseSelect.innerHTML = '';
         await  fetchExpenseCategories();
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


toggleMenu()