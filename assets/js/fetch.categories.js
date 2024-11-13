const tBody = selectElement(".table__body");

document.addEventListener("DOMContentLoaded", fetchCategories());

async function fetchCategories() {
  // Start the interval after the page has loaded

  const response = await makeRequest(
    "../php/category.script.php",
    "GET",
    "",
    "fetchCategory"
  );

  const { success, categories } = response;
  const tBody = document.querySelector("tbody");

  // Clear existing rows before adding new ones
  tBody.innerHTML = "";

  if (success) {
    if (categories && categories.length > 0) {
      categories.map((category) => {
        // Create a table row dynamically
        const tr = document.createElement("tr");
        const newRecord = `
              <td>${category.categoryname}</td>
              <td>
                  <span>
                      <img src="../assets/images/edit.png" id="edit-icon-${category.id}" class="edit-icon" alt="Edit">
                      <img src="../assets/images/delete.png" id="delete-icon-${category.id}" class="delete-icon" alt="Delete Icon">
                      <input type="hidden" class='id' value="${category.id}" />
                  </span>
              </td>
          `;
        tr.innerHTML = newRecord;
        tBody.appendChild(tr);

        // Attach the delete function to the delete icon
        const deleteIcon = document.querySelector(
          `#delete-icon-${category.id}`
        );
        const editIcon = document.querySelector(`#edit-icon-${category.id}`);

        console.log(editIcon);
        deleteIcon.addEventListener("click", function () {
          deleteFunction(category.id); // Pass the category's ID
        });

        editIcon.addEventListener("click", function () {
          openEditForm(category);
        });
      });
    } else {
      // If no categories, show a "No Categories" message
      const noRecord = `<td style="text-align:center; font-family:Arial, Helvetica, sans-serif; font-size: 0.8em" colSpan="3">No Categories</td>`;
      const tr = document.createElement("tr");
      tr.innerHTML = noRecord;
      tBody.appendChild(tr);
    }
  }
  // Use clearInterval when you want to stop the interval (example usage)
  // clearInterval(intervalId);
}

// Delete function that accepts the unit ID
async function deleteFunction(categoryId) {
  Swal.fire({
    title: "Warning!",
    text: "Deleting this will delete everything associated with it. Do you want to continue?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it",
    cancelButtonText: "Cancel",
    cancelButtonColor: "#f54c2f",
    reverseButtons: true,
  }).then(async (result) => {
    if (result.isConfirmed) {
      const response = await makeRequest(
        "../php/category.script.php",
        "DELETE",
        { id: categoryId },
        "deleteCategory"
      );
      const { success, message } = response;
      if (success) {
        Swal.fire({
          title: "Success",
          text: `Item unit with ID: ${categoryId} has been deleted`,
          icon: "success",
          confirmButtonText: "OK",
        });
        clearTableRows(tBody);
        await fetchCategories()
      }
    }
  });
}

async function openEditForm(item) {
  Swal.fire({
    title: "Edit Category",
    html: `
            <form id="userForm" style="display: flex; flex-direction: column; gap: 15px; width:100%;">
                <div style="width:100%;">
                  <label for="unitname" class="custom-label" style="font-family:Arial, Helvetica, sans-serif; font-size: 0.8em; width: 20rem;">Category Name:</label>
                  <input type="text" id="categoryname" name="categoryname" value=${item.categoryname} class="custom-input" style="font-family:Arial, Helvetica, sans-serif; padding: 5px; outline: none; border: 1px solid gray; border-radius: 5px; width:50%;">
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
  
      const { id } = item;
      if (!categoryname) {
        Swal.showValidationMessage(
          "Please enter both category name and category"
        );
        return false;
      }

      const response = await makeRequest(
        "../php/category.script.php",
        "PUT",
        { categoryname, id },
        "editCategory"
      );

      if (response.success) {
        Swal.fire({
          title: "Success",
          text: `Item unit with ID: ${id} has been editted`,
          icon: "success",
          confirmButtonText: "OK",
        });
        clearTableRows(tBody)
        await fetchCategories();
      }
    }
  });
}


toggleMenu()