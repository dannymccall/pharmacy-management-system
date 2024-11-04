let currentPage = 1;
const itemsPerPage = 5;
let purchasedDate = null;

// document.querySelector('.modal').addEventListener('click', function(){
//   this.classList.remove('open-modal')
//   // console.log(this.classList)
// })
// document.querySelector('.view-modal .close').addEventListener('click', function(){

//   this.classList.remove('open-view-modal')
//   console.log(this.classList)
// })

document.addEventListener("DOMContentLoaded", fetchExpense(currentPage));
let dbPurchases = null;
async function fetchExpense(page) {
  try {
    const response = await makeRequest(
      `../php/expense.script.php?page=${page}`,
      "GET",
      "",
      "fetchExpense"
    );

    console.log(response);
    const tBody = selectElement(".table__body");
    tBody.innerHTML = "";

    const { success, expenses, current_page, items_per_page, total_items } =
      response;
    if (success && expenses.length > 0) {
      renderExpenses(expenses);
      updatePagination(current_page, items_per_page, total_items);
    } else {
      displayNoRecords(tBody);
    }
  } catch (error) {
    console.error("Error fetching medicine data:", error);
  }
}

function renderExpenses(expenses) {
  const tBody = selectElement(".table__body");
  expenses.forEach((expense) => {
    const tr = document.createElement("tr");
    const date = new Date(expense.expensedate).toDateString();
    const newRecord = `
      <td class="user-date">${date}</td>
      <td> ${expense.expensecategory}</td>
      <td> ${expense.purpose}</td>
      <td>GHS ${expense.total.toFixed(2)}</td>
      <td> ${expense.description}</td>
      <td>
        <span>
          <img src="../assets/images/edit.png" id="edit-icon-${
            expense.id
          }" class="edit-icon" alt="">
          <img src="../assets/images/delete.png" id="delete-icon-${
            expense.id
          }" class="delete-icon" alt="Delete Icon">
          <input type="hidden" class='id' value="${expense.id}" />
        </span>
      </td>
    `;
    tr.innerHTML = newRecord;
    tBody.appendChild(tr);

    addIconListeners(expense);
  });
}
function addIconListeners(expense) {
  document
    .querySelector(`#edit-icon-${expense.id}`)
    .addEventListener("click", () => {
      document.querySelector("#hidden").value = expense.id;
      openEditForm(expense);
    });

  document
    .querySelector(`#delete-icon-${expense.id}`)
    .addEventListener("click", () => {
      deleteFunction(expense.id);
    });
}

async function fetchCategory() {}

function updatePagination(current_page, items_per_page, total_items) {
  const span = document.createElement("span");
  span.classList.add("pagination-infomation");
  span.style.color = "blue";
  span.style.fontWeight = "bold";
  span.textContent = `Page ${current_page} of ${Math.ceil(
    total_items / items_per_page
  )}`;

  document.getElementById("currentPage").innerHTML = span.innerHTML;
  document.getElementById("prevBtn").disabled = current_page === 1;
  document.getElementById("nextBtn").disabled =
    current_page === Math.ceil(total_items / items_per_page);
}

function displayNoRecords(tBody) {
  const tr = document.createElement("tr");
  tr.innerHTML = `<td style="text-align:center; font-family:Arial, Helvetica, sans-serif; font-size: 0.8em" colSpan="7">No Expenses</td>`;
  tBody.appendChild(tr);
}

document.getElementById("prevBtn").addEventListener("click", () => {
  if (currentPage > 1) {
    currentPage--;
    fetchUsers(currentPage);
  }
});

document.getElementById("nextBtn").addEventListener("click", () => {
  currentPage++;
  fetchUsers(currentPage);
});

if (document.querySelector("#prevBtn").disabled) {
  document.querySelector("#prevBtn").style.background = "#b8b8b8";
}
if (document.querySelector("#nextBtn").disabled) {
  document.querySelector("#nextBtn").style.background = "#b8b8b8";
}

async function deleteFunction(expenseId) {
  try {
    const confirmed = await Swal.fire({
      title: "Question!",
      text: "Are you sure you want to delete this expense",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it",
      cancelButtonText: "Cancel",
      cancelButtonColor: "#f54c2f",
      reverseButtons: true,
    });

    if (confirmed.isConfirmed) {
      const response = await makeRequest(
        "../php/expense.script.php",
        "DELETE",
        { id: expenseId },
        "deleteExpense"
      );
      if (response.success) {
        Swal.fire(
          "Success",
          `Expense with ID: ${expenseId} has been deleted`,
          "success"
        );
        fetchExpense(currentPage);
      }
    }
  } catch (error) {
    console.error("Error deleting purchase:", error);
  }
}

async function openEditForm(expense) {
  showModal(".user-view-modal", "open-user-view-modal");

  document.querySelector("#expense-date").value = expense.expensedate;
  document.querySelector("#category").value = expense.categoryname;

  document.querySelector("#purpose").value = expense.purpose;
  document.querySelector("#total").value = expense.total;
  document.querySelector("#expenseDescription").value = expense.description;

  //   document.querySelector("#role").value = user.role;

  const option = selectElement("#category option");
  const categoryexpense = selectElement("#category");
  console.log({ option });
  option.value = expense.expensecategory;
  option.textContent = expense.expensecategory;

  const response = await fetchExpenseCategories();

  const expenseCategory = response.expensecategories.filter(
    (item) => item.categoryname !== expense.expensecategory
  );

  expenseCategory.forEach((category) => {
    const optionElement = document.createElement("option");

    optionElement.value = category.categoryname;
    optionElement.textContent = category.categoryname;
    categoryexpense.appendChild(optionElement);
  });

  document
    .querySelector("#updateExpenseForm")
    .addEventListener("submit", async function (e) {
      e.preventDefault();

      const expensedate = document.querySelector("#expense-date").value;
      const expensecategory = document.querySelector("#category").value;
      const purpose = document.querySelector("#purpose").value;
      const total = document.querySelector("#total").value;
      const description = document.querySelector("#expenseDescription").value;
      const id = expense.id;
      const formData = {
        expensedate,
        expensecategory,
        purpose,
        total,
        description,
        id,
      };
      console.log(formData);
      try {
        showMessage(
          "Hello",
          "Are you sure you want edit this user ?",
          "question",
          "YES",
          "CANCEL",
          "#F12E2E",
          async () => {
            const response = await makeRequest(
              "../php/expense.script.php",
              "PUT",
              formData,
              "editExpense"
            );
            if (response.success) {
              showMessage(
                "Hello",
                response.message,
                "success",
                "OK",
                "",
                "",
                async () => {
                  fetchExpense(currentPage);
                }
              );
            }
          }
        );
        removeModal(".user-view-modal", "open-user-view-modal");
      } catch (error) {
        console.log(error);
      }
    });
}

const closeBtn = selectElement(".user-view-modal .close").addEventListener(
  "click",
  () => {
    removeModal(".user-view-modal", "open-user-view-modal");
  }
);

// removeModal(closeBtn, "open-user-view-modal");
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

        // if (!unitname || !unit) {
        //   Swal.showValidationMessage("Please enter both unit name and unit");
        //   return false;
        // }

        const response = await makeRequest(
          "../php/expense.script.php",
          "POST",
          { categoryname },
          "addExpenseCategory"
        );

        if (response.success) {
          fetchExpenseCategories();
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
