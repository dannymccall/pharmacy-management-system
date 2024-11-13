// Helper function to select elements
let itemSelect = document.querySelectorAll(".table__body select");
let select = selectElement(".table__body select");

async function fetchMedicines() {
  const response = await makeRequest(
    `../php/medicine.script.php`,
    "GET",
    "",
    "fetchMedicines"
  );

  return response;
}

async function insertOption() {
  const response = await fetchMedicines();
  createOptionElement(response, document, select);
}

function inputUnitPriceAfterItemSelection(element) {
  element.addEventListener("change", async function () {
    const response = await fetchMedicines();

    const selectedItem = this.value;
    const priceField = this.closest("tr").querySelector(".unit-price");
    const batchId = this.closest("tr").querySelector(".bach-id");
    const unitValue = this.closest("tr").querySelector(".unit");
    const selectedObject = response.medicines.filter((medicine) => {
      return medicine.medicinename.toLowerCase() === selectedItem.toLowerCase();
    });

    console.log({ selectedObject });

    priceField.value = parseFloat(
      selectedObject[0].medicinesellingunitprice
    ).toFixed(2);
    batchId.value = selectedObject[0].medicinecategory;
    unitValue.value = selectedObject[0].medicineunit;
    //   const [year, day, month] = selectedObject[0].date.split("-");

    //   const date = new Date(year, month - 1, day);
    // const formattedDate = `${date.getFullYear()}-${String(
    //   date.getMonth() + 1
    // ).padStart(2, "0")}-${String(date.getDate()).padStart(2, "0")}`;
  });
}

//create option in the select element
function createOptionElement(response, element, parentElement) {
  response.medicines.map((medicine) => {
    const option = element.createElement("option");
    option.value = medicine.medicinename;
    option.textContent = medicine.medicinename;

    parentElement.appendChild(option);
  });
}

insertOption();

// Calculate the total for a row and update its 'total' field
function calculateRowTotal(row) {
  const unitPrice = parseFloat(row.querySelector(".unit-price").value) || 0;
  const quantity = parseInt(row.querySelector(".quantity").value) || 0;
  const total = unitPrice * quantity;
  row.querySelector(".total").value = total.toFixed(2);
  return total;
}

// Calculate and update the subtotal by summing all row totals
function updateSubTotal() {
  let subTotal = 0;
  document.querySelectorAll(".total").forEach((totalField) => {
    const total = parseFloat(totalField.value) || 0;
    subTotal += total;
  });
  document.querySelector(".sub__total span").textContent = subTotal.toFixed(2);
  document.querySelector(".total-amount").textContent = subTotal.toFixed(2);
}

const paid = document.querySelector("#paid");

paid.addEventListener("input", function () {
  const totalAmount = document.querySelector(".total-amount").textContent;
  console.log(paid.value, totalAmount);
  const change = Number(this.value) - Number(totalAmount);

  document.querySelector(".change").textContent = Number(change).toFixed(2);
  console.log({ change });
});

// Handle adding a new row to the table
async function addNewRow() {
  const tBody = selectElement("tbody");
  const tr = document.createElement("tr");
  tr.classList.add("medicine-row");

  tr.innerHTML = `
      <td>
       <select class="item-select">
          <option value="">Select Item</option>
        </select>
      </td>
      <td> <input type="text" readonly name="unit" placeholder="Unit" id="unit" class="unit"></td>
      <td><input type="text" name="bach-id" placeholder="Batch ID" class="bach-id" readonly></td>
      <td><input type="number" step="any" name="unit-price" placeholder="Unit price" class="unit-price"></td>
      <td><input type="number" name="quantity" placeholder="Quantity" class="quantity"></td>
      <td><input type="number" step="any" name="total" placeholder="Total" class="total" readonly></td>
      <td><button type="button" class="delete-btn" style="width: 6rem; background: #fa382a;">Delete</button></td>
    `;

  // fetchMedicines(tr);
  tBody.appendChild(tr);
  updateSubTotal(); // Update subtotal after adding a new row
  const response = await fetchMedicines();

  const selectOption = tr.querySelector("select");
  createOptionElement(response, document, selectOption);
  inputUnitPriceAfterItemSelection(selectOption);
}

itemSelect.forEach((elementSelect) => {
  inputUnitPriceAfterItemSelection(elementSelect);
});
// Event listener for adding a new item
selectElement(".add-new-item").addEventListener("click", addNewRow);

// Event delegation for updating row totals and subtotals on input changes
document.querySelector("tbody").addEventListener("input", (e) => {
  const target = e.target;

  // Update total and subtotal when quantity or unit price is changed
  if (
    target.classList.contains("unit-price") ||
    target.classList.contains("quantity")
  ) {
    const row = target.closest("tr");
    calculateRowTotal(row);
    updateSubTotal();
  }
});

// Event delegation for deleting rows
document.querySelector("tbody").addEventListener("click", (e) => {
  if (e.target.classList.contains("delete-btn")) {
    const row = e.target.closest("tr");
    row.remove(); // Remove the row
    updateSubTotal(); // Recalculate the subtotal
  }
});

// Restrict negative input values for number fields
document.addEventListener("input", (e) => {
  if (e.target.type === "number" && e.target.value < 0) {
    e.target.value = 0; // Reset negative numbers to 0
  }
});

// Event listener for form submission
document
  .querySelector("#purchaseForm")
  .addEventListener("submit", async function (e) {
    e.preventDefault();

    const rows = document.querySelectorAll("#myTable tbody tr");
    console.log("paymentmode", document.querySelector("#paymentMode").value);
    const formData = {
      products: [], // This array will hold product objects
      invoiceDate: document.querySelector('input[name="invoice-date"]').value,
      paymentMode: document.querySelector("#paymentMode").value,
      amountPaid: document.querySelector("#paid").value,
      change: document.querySelector(".change").textContent,
    };
    rows.forEach((row) => {
      console.log(row);
      const productData = {
        unit: row.querySelector('input[name="unit"]').value,
        quantity: row.querySelector('input[name="quantity"]').value,
        category: row.querySelector('input[name="bach-id"]').value,
        unitPrice: row.querySelector('input[name="unit-price"]').value,
        total: row.querySelector('input[name="total"]').value,
        item_information: row.querySelector(".item-select").value,
        productId: generateProductId(),
      };
      formData.products.push(productData);
    });

    console.log({ formData });

    const response = await makeRequest(
      "../php/invoice.script.php",
      "POST",
      formData,
      "addInvoice"
    );

    if (!response.success) {
      // selectElement(".error").textContent = response.message;
      // selectElement(".error").style.display = "block";
      showErrorMessage('.error', response.message);
      console.log(response);
    } else {
      console.log(response);
      selectElement(".error").style.display = "none";
      document.querySelector(".total-amount").textContent = '0.00';
      document.querySelector(".change").textContent ='0.00';

      paid.value = '';
      const { data } = response;
      const InvoiceTBody = document.querySelector("#invoice-details");
      const InvoiceDetailsBody = document.querySelector("#invoice-quantity");
      // const printInvoiceTable = document.getElementById("#printInvoiceTable");
      const tr = document.createElement("tr");
      tr.innerHTML = `
         <td class="purchase-date">${data.invoiceDate}</td>
         <td class="purchase-date">${data.invoicenumber}</td>
      <td>GHS ${parseFloat(data.subtotal).toFixed(2)}</td>
      <td>GHS ${parseFloat(data.amountPaid).toFixed(2)}</td>
      <td>GHS ${parseFloat(data.change).toFixed(2)}</td>
      `;

      InvoiceTBody.appendChild(tr);

      data.products.forEach((item) => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
         <td class="purchase-date">${item.item_information}</td>
         <td class="purchase-date">${item.quantity}</td>
         <td class="purchase-date">${item.unit}</td>
      <td>GHS ${parseFloat(item.unitPrice).toFixed(2)}</td>
      <td>GHS ${parseFloat(item.total).toFixed(2)}</td>
      `;

        InvoiceDetailsBody.appendChild(tr);
      });
      Swal.fire({
        title: "Success",
        html: `${response.message} <br>Do you wish print ?`,
        icon: "success",
        showCancelButton: true,
        confirmButtonText: "YES",
        cancelButtonText: "NO",
        cancelButtonColor: "#f54c2f",
      }).then((result) => {
        if (result.isConfirmed) {
          document.querySelector('#printInvoice').style.display = 'block';

          printTableContent('printInvoice');
        }
      });
      const tbody = document.querySelector(".table__body"); // Reset the form after successful submission
      clearTableRows(tbody);
      document.querySelector(".sub__total span").textContent = 0.0;
    }
  });

// Helper function to generate a random product ID
function generateProductId() {
  const length = 7;
  const characters = "1234567890";
  return Array.from(
    { length },
    () => characters[Math.floor(Math.random() * characters.length)]
  ).join("");
}


toggleMenu()