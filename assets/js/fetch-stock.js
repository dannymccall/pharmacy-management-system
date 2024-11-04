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
                <td style="color:#4A89DC;">${medicine.medicinename}</td>
                <td>GHS ${medicine.medicinecostunitprice}</td>
                <td>GHS ${medicine.medicinesellingunitprice}</td>
                <td>${medicine.medicineunit}</td>
                <td>${medicine.medicinecategory}</td>
                <td>${medicine.unitprofit}</td>
                <td> ${medicine.quantity}</td>
                <td>${medicine.qtysold}</td>
                <td>${medicine.collectedquantity}</td>
               <td><img src="../assets/images/logo_pharmacy.png" style="width: 40px; height: 50px;"></td>
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

        // deleteIcon.addEventListener("click", function () {
        //   deleteFunction(medicine.id); // Pass the unit's ID
        // });

        // editIcon.addEventListener("click", function () {
        //   openEditForm(medicine);
        // });
      });
    } else {
      const noRecord = `<td style="text-align:center; font-family:Arial, Helvetica, sans-serif; font-size: 0.8em" colSpan="7">No Stock</td>`;
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
