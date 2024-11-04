const tBody = selectElement(".table__body");

document.addEventListener("DOMContentLoaded",fetchUnits());

async function fetchUnits() {
  const response = await makeRequest(
    "../php/unit.script.php",
    "GET",
    "",
    "fetchUnits"
  );
  const { success, units } = response;

  if (success) {
    if (units) {
      units.map((unit) => {
        // Create a table row dynamically
        const tr = document.createElement("tr");
        const newRecord = `
            <td>${unit.unit}</td>
            <td>${unit.unitname}</td>
            <td>
                <span>
                    <img src="../assets/images/edit.png" id="edit-icon-${unit.id}" class="edit-icon" alt="Edit Icon">
                    <img src="../assets/images/delete.png" id="delete-icon-${unit.id}" class="delete-icon" alt="Delete Icon">
                    <input type="hidden" class='id' value="${unit.id}" />
                </span>
            </td>
        `;
        tr.innerHTML = newRecord;
        tBody.appendChild(tr);

        // Attach the delete function to the delete icon
        const deleteIcon = document.querySelector(`#delete-icon-${unit.id}`);
        const editIcon = document.querySelector(`#edit-icon-${unit.id}`);

        deleteIcon.addEventListener("click", function () {
          console.log("hello");
          deleteFunction(unit.id); // Pass the unit's ID
        });

        editIcon.addEventListener("click", function () {
          console.log("hello");
          openEditForm(unit.id, unit.unitname, unit.unit);
        });

        console.log(editIcon)
      });
    } else {
      const noRecord = `<td style="text-align:center; font-family:Arial, Helvetica, sans-serif; font-size: 0.8em" colSpan="3">No Units</td>`;
      const tr = document.createElement("tr");
      tr.innerHTML = noRecord;
      tBody.appendChild(tr);
    }
  }
}
// Delete function that accepts the unit ID
async function deleteFunction(unitId) {
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
        "../php/unit.script.php",
        "DELETE",
        { id: unitId },
        "deleteUnit"
      );
      const { success, message } = response;
      if (success) {
        Swal.fire({
          title: "Success",
          text: `Item unit with ID ${unitId} has been deleted`,
          icon: "success",
          confirmButtonText: "OK",
        });
        await fetchUnits();
      }
    }
  });
}

async function openEditForm(id, unitname, unit) {
  const style = document.createElement("style");
  style.innerHTML = `
  .my-custom-title {
    font-family: 'Courier New', Courier, monospace; /* Replace with desired font */
    font-size: 24px;
    color: #ff5733;
  }
`;
  document.head.appendChild(style);
  Swal.fire({
    title: "Edit Unit",
    html: `
            <form id="userForm" style="display: flex; flex-direction: column; gap: 15px; width:100%;">
                <div style="width:100%;">
                  <label for="unitname" class="custom-label" style="font-family:Arial, Helvetica, sans-serif; font-size: 0.8em; width: 20rem;">Unit Name:</label>
                  <input type="text" id="unitname" name="unitname" value=${unitname} class="custom-input" style="font-family:Arial, Helvetica, sans-serif; padding: 5px; outline: none; border: 1px solid gray; border-radius: 5px; width:50%;">
                </div>
                <div style="width:100%;">
                  <label for="unit" class="unit" style="font-family:Arial, Helvetica, sans-serif; font-size: 0.8em; width: 40rem; margin-right:30px;">Unit:</label>
                  <input type="text" id="unit" name="unit" value=${unit} class="custom-input" style="font-family:Arial, Helvetica, sans-serif; padding: 5px; outline: none; border: 1px solid gray; border-radius: 5px;width:50%;">
                </div>
            </form>
        `,
    focusConfirm: false, // Prevent focus on the confirm button
    showCancelButton: true,
    cancelButtonText: "Cancel",
    confirmButtonText: "Submit",
  }).then(async (result) => {
    if (result.isConfirmed) {
      const unitname = selectElementValue("#unitname");
      const unit = selectElementValue("#unit");

      if (!unitname || !unit) {
        Swal.showValidationMessage("Please enter both unit name and unit");
        return false;
      }

      const response = await makeRequest(
        "../php/unit.script.php",
        "PUT",
        { unitname, unit, id },
        "editUnit"
      );

      if (response.success) {
        Swal.fire({
          title: "Success",
          text: `Item unit with ID: ${id} has been editted`,
          icon: "success",
          confirmButtonText: "OK",
          customClass: {
            title: "my-customer-title",
          },
        });
        await fetchUnits()
      }
    }
  });
}
