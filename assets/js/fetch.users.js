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

document.addEventListener("DOMContentLoaded", fetchUsers(currentPage));
let dbPurchases = null;
async function fetchUsers(page) {
  try {
    const response = await makeRequest(
      `../php/userAuthentication.php?page=${page}`,
      "GET",
      "",
      "fetchUsers"
    );

    console.log(response);
    const tBody = selectElement(".table__body");
    tBody.innerHTML = "";

    const { success, users, current_page, items_per_page, total_items } =
      response;
    if (success && users.length > 0) {
      renderPurchases(users);
      updatePagination(current_page, items_per_page, total_items);
    } else {
      displayNoRecords(tBody);
    }
  } catch (error) {
    console.error("Error fetching medicine data:", error);
  }
}

function renderPurchases(users) {
  const tBody = selectElement(".table__body");
  users.forEach((user) => {
    const tr = document.createElement("tr");
    const date = new Date(user.date).toDateString();
    const newRecord = `
      <td class="user-date">${user.firstname}</td>
      <td> ${user.middlename}</td>
      <td> ${user.lastname}</td>
      <td> ${user.username}</td>
      <td> ${user.role}</td>
      <td>
        <span>
          <img src="../assets/images/edit.png" id="edit-icon-${user.id}" class="edit-icon" alt="">
          <img src="../assets/images/delete.png" id="delete-icon-${user.id}" class="delete-icon" alt="Delete Icon">
          <input type="hidden" class='id' value="${user.id}" />
        </span>
      </td>
    `;
    tr.innerHTML = newRecord;
    tBody.appendChild(tr);

    addIconListeners(user);
  });
}
function addIconListeners(user) {
  document
    .querySelector(`#edit-icon-${user.id}`)
    .addEventListener("click", () => {
      document.querySelector("#hidden").value = user.id;
      openEditForm(user);
    });

  document
    .querySelector(`#delete-icon-${user.id}`)
    .addEventListener("click", () => {
      deleteFunction(user.id);
    });
}

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
  tr.innerHTML = `<td style="text-align:center; font-family:Arial, Helvetica, sans-serif; font-size: 0.8em" colSpan="7">No Purchases</td>`;
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

async function deleteFunction(userId) {
  try {
    const confirmed = await Swal.fire({
      title: "Question!",
      text: "Are you sure you want to delete",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it",
      cancelButtonText: "Cancel",
      cancelButtonColor: "#f54c2f",
      reverseButtons: true,
    });

    if (confirmed.isConfirmed) {
      const response = await makeRequest(
        "../php/userAuthentication.php",
        "DELETE",
        { id: userId },
        "deleteUser"
      );
      if (response.success) {
        Swal.fire(
          "Success",
          `User with ID: ${userId} has been deleted`,
          "success"
        );
        fetchUsers(currentPage);
      }
    }
  } catch (error) {
    console.error("Error deleting purchase:", error);
  }
}

async function makeUpdateRequest(body) {
  const response = await makeRequest(
    "../php/purchase.script.php",
    "PUT",
    body,
    "editPurchase"
  );

  return response;
}
async function updatePurchase(body, messageAfterOperation, question, cb) {
  try {
    const confirmed = await Swal.fire({
      title: "Question!",
      text: question,
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Yes",
      cancelButtonText: "Cancel",
      cancelButtonColor: "#f54c2f",
      reverseButtons: true,
    });

    if (confirmed.isConfirmed) {
      cb();
      const response = await makeUpdateRequest(body);
      console.log(response);
      if (response.success) {
        Swal.fire("Success", messageAfterOperation, "success");
        fetchPurchases(currentPage);
      }
    }
  } catch (error) {
    console.error("Error updating purchase:", error);
  }
}

async function openEditForm(user) {
  showModal(".user-view-modal", "open-user-view-modal");

  document.querySelector("#firstname").value = user.firstname;
  document.querySelector("#lastname").value = user.lastname;

  document.querySelector("#middlename").value = user.middlename;

  //   document.querySelector("#role").value = user.role;

  const option = selectElement("#role option");
  const role = selectElement("#role");
  console.log({ option });
  option.value = user.role;
  option.textContent = user.role;

  const optionElement = document.createElement("option");

  optionElement.value = user.role === "super admin" ? "sales agent" : user.role;
  optionElement.textContent =
    user.role === "super admin" ? "sales agent" : "super admin";
  role.appendChild(optionElement);

  document
    .querySelector("#updateUserForm")
    .addEventListener("submit", async function (e) {
      e.preventDefault();

      const firstname = document.querySelector("#firstname").value;
      const lastname = document.querySelector("#lastname").value;

      const middlename = document.querySelector("#middlename").value;

      const role = document.querySelector("#role").value;
      const id = user.id;
      const formData = {
        firstname,
        lastname,
        middlename,
        role,
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
              "../php/userAuthentication.php",
              "PUT",
              formData,
              "updateUser"
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
                  fetchUsers(currentPage);
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

removeModal(closeBtn, "open-user-view-modal");
function debounce(fn, delay) {
  let timeoutID;
  return function (...args) {
    if (timeoutID) clearTimeout(timeoutID);
    timeoutID = setTimeout(() => {
      fn(...args);
    }, delay);
  };
}


toggleMenu()