let currentPage = 1;
const itemsPerPage = 5;

document.addEventListener("DOMContentLoaded", fetchMedicine(currentPage));

async function fetchMedicine(page) {
  const response = await makeRequest(
    `../php/medicine.script.php?page=${page}`,
    "GET",
    "",
    "fetchMedicines"
  );
  console.log(response);
  const tBody = selectElement(".table__body");
  tBody.innerHTML = "";
  const { success, medicines, current_page, items_per_page, total_items } =
    response;

  if (success) {
    if (medicines.length > 0) {
      medicines.map((medicine) => {
        // Create a table row dynamically
        const tr = document.createElement("tr");
        const newRecord = `
                <td>${medicine.medicinename}</td>
                <td>${medicine.medicinecategory}</td>
                <td>${medicine.medicineunit}</td>
                <td>GHS ${medicine.medicinecostunitprice}</td>
                <td>GHS ${medicine.medicinesellingunitprice}</td>
                <td> ${medicine.quantity}</td>
                <td><img src="../assets/images/logo_pharmacy.png" style="width: 40px; height: 50px;"></td>
                <td>
                    <span>
                        <img src="../assets/images/edit.png" id="edit-icon-${medicine.id}" class="edit-icon" alt="">
                        <img src="../assets/images/delete.png" id="delete-icon-${medicine.id}" class="delete-icon" alt="Delete Icon">
                        <input type="hidden" class='id' value="${medicine.id}" />
                    </span>
                </td>
            `;
        tr.innerHTML = newRecord;
        tBody.appendChild(tr);

        // Attach the delete function to the delete icon
        const deleteIcon = document.querySelector(
          `#delete-icon-${medicine.id}`
        );
        const editIcon = document.querySelector(`#edit-icon-${medicine.id}`);

        const span = document.createElement("span");
        span.classList.add("pagination-infomation", "your-new-class"); // Add classes
        span.style.color = "blue"; // Add inline style for color
        span.style.fontWeight = "bold"; // Make text bold
        span.innerHTML = `Page ${current_page} of ${Math.ceil(
          total_items / items_per_page
        )}`;
        document.getElementById("currentPage").innerHTML = span.innerHTML;

        document.getElementById("prevBtn").disabled = current_page === 1;
        document.getElementById("nextBtn").disabled =
          current_page === Math.ceil(total_items / items_per_page);

        deleteIcon.addEventListener("click", function () {
          deleteFunction(medicine.id); // Pass the unit's ID
        });

        editIcon.addEventListener("click", function () {
          openEditForm(medicine);
        });
      });
    } else {
      const noRecord = `<td style="text-align:center; font-family:Arial, Helvetica, sans-serif; font-size: 0.8em" colSpan="7">No Medicines</td>`;
      const tr = document.createElement("tr");
      tr.innerHTML = noRecord;
      tBody.appendChild(tr);
    }
  }
}

document.getElementById("prevBtn").addEventListener("click", () => {
  if (currentPage > 1) {
    currentPage--;
    fetchMedicine(currentPage);
  }
});

document.getElementById("nextBtn").addEventListener("click", () => {
  currentPage++;
  fetchMedicine(currentPage);
});

if (document.querySelector("#prevBtn").type === "disabled") {
  document.querySelector("#preBtn").style.background = "#b8b8b8";
}
if (document.querySelector("#nextBtn").type === "disabled") {
  document.querySelector("#nextBtn").style.background = "#b8b8b8";
}

// Delete function that accepts the unit ID
async function deleteFunction(medicineId) {
  console.log({ medicineId });
  Swal.fire({
    title: "Question!",
    text: "Are you sure you want to delete",
    icon: "question",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it",
    cancelButtonText: "Cancel",
    cancelButtonColor: "#f54c2f",
    reverseButtons: true,
  }).then(async (result) => {
    if (result.isConfirmed) {
      const response = await makeRequest(
        "../php/medicine.script.php",
        "DELETE",
        { id: medicineId },
        "deleteMedicine"
      );
      const { success, message } = response;
      fetchMedicine(currentPage);
      if (success) {
        Swal.fire({
          title: "Success",
          text: `Item unit with ID: ${medicineId} has been deleted`,
          icon: "success",
          confirmButtonText: "OK",
        });
      }
    }
  });
}

async function openEditForm(medicine) {
  const modal = document.querySelector(".modal");
  modal.classList.add("open-modal");

  document.querySelector('.modal .close').addEventListener('click', ()=> {
    removeModal('.modal','open-modal');
  })
  document.querySelector("#medicine-name").value = medicine.medicinename;
  const medicinecategory = document.querySelector("#category");
  const medicineunit = document.querySelector("#unit");

  const newUnitOption = document.createElement("option");
  newUnitOption.value = medicine.medicineunit; // Set the value attribute
  newUnitOption.textContent = medicine.medicineunit; // Set the visible text

  // Append the new option to the select element
  medicineunit.appendChild(newUnitOption);

  const newCategoryOption = document.createElement("option");
  newCategoryOption.value = medicine.medicinecategory;
  newCategoryOption.textContent = medicine.medicinecategory;

  medicinecategory.appendChild(newCategoryOption);

  document.querySelector("#cost-price").value = medicine.medicinecostunitprice;
  document.querySelector("#selling-price").value =
    medicine.medicinesellingunitprice;
  // document.querySelector("#quantity").value = medicine.quantity;
  document.querySelector(".id").value = medicine.id;

  const unitResponse = await makeRequest(
    "../php/unit.script.php",
    "GET",
    "",
    "fetchUnits"
  );

  const unitArray = unitResponse.units.filter((unit) => {
    return unit.unit !== medicine.medicineunit;
  });

  unitArray.map((item) => {
    const dbUnit = document.createElement("option");
    dbUnit.value = item.unit;
    dbUnit.textContent = item.unit;

    medicineunit.appendChild(dbUnit);
  });

  const categoryResponse = await makeRequest(
    "../php/category.script.php",
    "GET",
    "",
    "fetchCategory"
  );

  const categoryArray = categoryResponse.categories.filter((category) => {
    return category.category !== medicine.medicinecategory;
  });

  categoryArray.map((item) => {
    const dbCategory = document.createElement("option");
    dbCategory.value = item.category;
    dbCategory.textContent = item.category;

    medicinecategory.appendChild(dbCategory);
  });
}

document
  .querySelector(".update-button")
  .addEventListener("click", async function (e) {
    e.preventDefault();

    const medicinename = document.querySelector("#medicine-name").value;
    const medicinecategory = document.querySelector("#category").value;
    const medicineunit = document.querySelector("#unit").value;
    const medicinecostunitprice = parseFloat(document.querySelector("#cost-price").value)
    const medicinesellingunitprice =
      parseFloat(document.querySelector("#selling-price").value);
    const quantity = parseInt(document.querySelector("#quantity").value);
    const id = document.querySelector(".id").value;

    if(isNaN(quantity)){
      selectElement(".modal .error").textContent = 'Please quantity cannot be empty';
      selectElement(".modal .error").style.display = "block";
      return;
    }else{
      selectElement(".error").style.display = "none";

    }
    const formData = {
      medicinename,
      medicinecategory,
      medicineunit,
      medicinecostunitprice,
      medicinesellingunitprice,
      quantity,
      id,
    };

    Swal.fire({
      title: "Question!",
      text: "Are you sure you want to edit",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Yes",
      cancelButtonText: "Cancel",
      cancelButtonColor: "#f54c2f",
      reverseButtons: true,
    }).then(async (result) => {
      if (result.isConfirmed) {
        const response = await makeRequest(
          "../php/medicine.script.php",
          "PUT",
          formData,
          "editMedicine"
        );
        const { success, message } = response;
        console.log(response)
        if (success) {
          selectElement(".error").style.display = "none";
          removeModal('.modal','open-modal');

          Swal.fire({
            title: "Success",
            text: `Item unit with ID: ${id} has been deleted`,
            icon: "success",
            confirmButtonText: "OK",
          });
        }
      }
    });
  });


  toggleMenu()