// Helper function to select elements
const tBody = selectElement("tbody");
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
  console.log({subTotal})
  document.querySelector("p span").textContent = subTotal.toFixed(2);
}

// Handle adding a new row to the table
function addNewRow() {

  const tr = document.createElement("tr");
  tr.classList.add("medicine-row");

  tr.innerHTML = `
    <td><input type="text" name="medicine-name" placeholder="Medicine Name"></td>
    <td><input type="date" name="date" placeholder="Date"></td>
    <td><input type="text" name="bach-id" placeholder="Batch ID"></td>
    <td><input type="number" step="any" name="unit-price" placeholder="Unit price" class="unit-price"></td>
    <td><input type="number" name="quantity" placeholder="Quantity" class="quantity"></td>
    <td><input type="number" step="any" name="total" placeholder="Total" class="total" readonly></td>
    <td><button type="button" class="delete-btn" style="width: 6rem; background: #fa382a;">Delete</button></td>
  `;

  tBody.appendChild(tr);
  updateSubTotal(); // Update subtotal after adding a new row
}

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
    const formData = {
      products: [],
      purchasedDate: document.querySelector('input[name="purchased-date"]')
        .value,
        paymentMode: document.querySelector('#paymentMode').value

    };

    rows.forEach((row) => {
      const productData = {
        date: row.querySelector('input[name="date"]').value,
        quantity: row.querySelector('input[name="quantity"]').value,
        batchId: row.querySelector('input[name="bach-id"]').value,
        unitPrice: row.querySelector('input[name="unit-price"]').value,
        total: row.querySelector('input[name="total"]').value,
        medicineName: row.querySelector('input[name="medicine-name"]').value,
        productId: generateProductId(),
      };
      formData.products.push(productData);
    });

    const response = await makeRequest(
      "../php/purchase.script.php",
      "POST",
      formData,
      "addPurchase"
    );

    if (!response.success) {
      selectElement(".error").textContent = response.message;
      selectElement(".error").style.display = "block";
    } else {
      Swal.fire({
        title: "Success",
        text: response.message,
        icon: "success",
        confirmButtonText: "OK",
      });
      clearTableRows(tBody);
      document.querySelector(".sub__total span").textContent = 0.00;    }
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
