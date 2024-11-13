let currentPage = 1;
const itemsPerPage = 5;
let purchasedDate = null;

document
  .querySelector(".view-modal .close")
  .addEventListener("click", function () {
    removeModal(".view-modal", "open-view-modal");
    // console.log(this.classList);
  });

async function fetchInvoiceItems(page) {
  const response = await makeRequest(
    `../php/invoice.script.php?page=${page}`,
    "GET",
    "",
    "fetchInvoices"
  );
  console.log(response);
  return response;
}
document.addEventListener("DOMContentLoaded", fetchInvoice(currentPage));
let dbPurchases = null;
async function fetchInvoice(page) {
  try {
    const response = await fetchInvoiceItems(page);

    const tBody = selectElement(".table__body");
    tBody.innerHTML = "";

    const { success, invoices, current_page, items_per_page, total_items } =
      response;
    if (success && invoices.length > 0) {
      dbPurchases = invoices;
      renderInvoices(invoices);
      updatePagination(current_page, items_per_page, total_items);
    } else {
      displayNoRecords(tBody);
    }
  } catch (error) {
    console.error("Error fetching medicine data:", error);
  }
}

function renderInvoices(invoices) {
  const tBody = selectElement(".table__body");
  invoices.forEach((invoice) => {
    const tr = document.createElement("tr");
    const date = new Date(invoice.dateofsale).toDateString();
    const newRecord = `
      <td class="purchase-date">${date}</td>
      <td class="purchase-date">${invoice.invoicenumber}</td>
      <td>GHS ${invoice.subtotal.toFixed(2)}</td>
      <td>GHS ${parseFloat(invoice.totalprofit).toFixed(2)}</td>
      <td>GHS ${parseFloat(invoice.amountpaid).toFixed(2)}</td>
      <td>GHS ${parseFloat(invoice.balance).toFixed(2)}</td>
      <td> ${invoice.paymentmode}</td>
      <td>
        <span>
          <img src="../assets/images/view.png" id="view-icon-${
            invoice.id
          }" class="view-icon" alt="">
          <img src="../assets/images/delete.png" id="delete-icon-${
            invoice.id
          }" class="delete-icon" alt="Delete Icon">
          <input type="hidden" class='id' value="${invoice.id}" />
        </span>
      </td>
    `;
    tr.innerHTML = newRecord;
    tBody.appendChild(tr);

    addIconListeners(invoice);
  });
}
function addIconListeners(invoice) {
  document
    .querySelector(`#view-icon-${invoice.id}`)
    .addEventListener("click", () => {
      purchasedDate = invoice.date;
      document.querySelector("#new-hidden").value = invoice.id;
      openViewTable(invoice);
    });

  document
    .querySelector(`#delete-icon-${invoice.id}`)
    .addEventListener("click", () => {
      deleteFunction(invoice.id);
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
  tr.innerHTML = `<td style="text-align:center; font-family:Arial, Helvetica, sans-serif; font-size: 0.8em" colSpan="7">No Invoices</td>`;
  tBody.appendChild(tr);
}

document.getElementById("prevBtn").addEventListener("click", () => {
  if (currentPage > 1) {
    currentPage--;
    fetchInvoice(currentPage);
  }
});

document.getElementById("nextBtn").addEventListener("click", () => {
  currentPage++;
  fetchInvoice(currentPage);
});

// if (document.querySelector("#prevBtn").disabled) {
//   document.querySelector("#prevBtn").style.background = "#b8b8b8";
// } else {
//   document.querySelector("#prevBtn").style.background = "#1c67c9";
// }
// if (document.querySelector("#nextBtn").disabled) {
//   document.querySelector("#nextBtn").style.background = "#b8b8b8";
// }

// Delete Invoice
async function deleteFunction(invoiceId) {
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
        "../php/invoice.script.php",
        "DELETE",
        { id: invoiceId },
        "deleteInvoice"
      );
      if (response.success) {
        Swal.fire(
          "Success",
          `Item with ID: ${invoiceId} has been deleted`,
          "success"
        );
        fetchInvoice(currentPage);
      }
    }
  } catch (error) {
    console.error("Error deleting purchase:", error);
  }
}

async function makeUpdateRequest(body) {
  const response = await makeRequest(
    "../php/invoice.script.php",
    "PUT",
    body,
    "editInvoice"
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
        fetchInvoice(currentPage);
      }
    }
  } catch (error) {
    console.error("Error updating purchase:", error);
  }
}

async function openEditForm(product, purchase) {
  console.log({ product, purchase });

  const modal = document.querySelector(".modal");
  modal.classList.add("open-modal");
  document
    .querySelector(".modal .close")
    .addEventListener("click", function () {
      removeModal(".modal", "open-modal");

    });
  document.querySelector(".modal #item-information").value =
    product.item_information;
  document.querySelector(".modal #qty").value = product.quantity;
  // document.querySelector(".modal #old-quantity").value = product.quantity;

  document.querySelector(".modal #unit-price").value = product.unitPrice;

  document.querySelector(".modal #total").value = product.total;

  document.querySelector(".modal #productId").value = product.productId;

  // let oldQuantity = document.querySelector("#qty").value;

  console.log({ product });
  // const [year, day, month] = product.dateofsale.split("-");

  // const date = new Date(year, month - 1, day);
  // const formattedDate = `${date.getFullYear()}-${String(
  //   date.getMonth() + 1
  // ).padStart(2, "0")}-${String(date.getDate()).padStart(2, "0")}`;

  // document.querySelector("#date").value = formattedDate;
  // document.querySelector("#batch-id").value = product.batchId;

  const inputQuantity = selectElement("#qty");
  const inputUnitPriceForm = selectElement("#unit-price");
  inputQuantity.addEventListener("input", function () {
    let inputUnitPrice = selectElement("#unit-price");
    let inputTotal = selectElement("#total");

    let quantity = Number(this.value);
    let unitPrice = parseFloat(inputUnitPrice.value);

    if (!isNaN(quantity) && !isNaN(unitPrice)) {
      inputTotal.value = quantity * unitPrice;
    } else {
      inputTotal.value = ""; // or set to 0 if preferred
    }

    console.log("total ", inputTotal.value);
  });

  inputUnitPriceForm.addEventListener("input", function () {
    let quantityPrice = selectElement("#qty");
    let inputTotal = selectElement("#total");

    let quantity = Number(quantityPrice.value);
    let unitPrice = parseFloat(this.value);

    if (!isNaN(quantity) && !isNaN(unitPrice)) {
      inputTotal.value = quantity * unitPrice;
    } else {
      inputTotal.value = ""; // or set to 0 if preferred
    }

    console.log("total ", inputTotal.value);
  });

  document
    .querySelector("#update-button-purchase")
    .addEventListener("click", async function (e) {
      e.preventDefault();

      const medicineName = document.querySelector(
        ".modal #item-information"
      ).value;
      const quantity = document.querySelector(".modal #qty").value;
      const total = document.querySelector(".modal #total").value;
      // const date = document.querySelector("#date").value;
      const unitPrice = document.querySelector(".modal #unit-price").value;
      // const batchId = document.querySelector("#batch-id").value;
      const productId = document.querySelector(".modal #productId").value;

      console.log({ quantity, total, medicineName, unitPrice, productId });

      console.log({ medicineName });
      updatePurchase(
        purchase,
        "Invoice Item Edited",
        "Are you sure you want to edit this purchase again",
        () => {
          let products = JSON.parse(purchase.items);
          console.log(productId, product.productId);
          products.map((product) => {
            if (product.productId === productId) {
              console.log("found match");
              product.item_information = medicineName;
              product.quantity = Number(quantity);
              console.log("303", product.quantity);
              product.total = Number(total);
              product.unitPrice = Number(unitPrice);
              // product.batchId = batchId;
              // product.date = date;
            }
          });
          console.log({ products });

          console.log({ products });
          let newTotal = products.reduce((accum, curr) => {
            return accum + Number(curr.total);
          }, 0);

          console.log({ newTotal });
          purchase.newSubTotal = newTotal;
          purchase.newTotal = newTotal;
          console.log({ purchase });
          purchase.items = JSON.stringify(products);
        }
      );
    });
}

//open view table after click on the view fron invoice table
async function openViewTable(invoice) {
  const totalSpan = document.querySelector(".total__span");
  const quantitySpan = document.querySelector(".quantity__span");
  const viewModal = document.querySelector(".view-modal");
  console.log({ viewModal });
  viewModal.classList.add("open-view-modal");

  document
    .querySelector(".view-modal .close")
    .addEventListener("click", function () {
      this.classList.remove("open-view-modal");
      // console.log(this.classList)
      // totalSpan.textContent = ''
    });
  let subtotal = 0;
  let totalQuantity = 0;
  const tBody = document.querySelector(".view-modal table tbody");

  clearTableRows(tBody);
  // console.log(tBody)
  const products = JSON.parse(invoice.items);

  console.log(invoice);
  subtotal = products.reduce((accum, curr) => {
    return accum + Number(curr.total);
  }, 0);

  totalQuantity = products.reduce((accum, curr) => {
    return accum + Number(curr.quantity);
  }, 0);
  console.log("subtotal: ", subtotal);
  console.log("quantity: ", totalQuantity);



  totalSpan.textContent = `GHS ${subtotal.toFixed(2)}`;

  quantitySpan.textContent = `${totalQuantity}`;
  products.map((item) => {
    // Create a table row dynamically

    const tr = document.createElement("tr");
    // let date = new Date(purchase.date);
    const newRecord = `
              <td>${item.item_information || item.medicineName}</td>
              <td> ${item.quantity}</td>
              <td>GHS ${item.unitPrice}</td>
              <td>GHS ${item.total}</td>
              <td> ${item.category}</td>
              <td>
                  <span>
                      <img src="../assets/images/edit.png" id="edit-icon-${
                        item.productId
                      }" class="edit-icon" alt="">
                      <img src="../assets/images/delete.png" id="delete-icon-${
                        item.productId
                      }" class="delete-icon" alt="Delete Icon">
                      
                      <input type="hidden" class='id' value="${
                        item.productId
                      }" />
                  </span>
              </td>
          `;
    tr.innerHTML = newRecord;
    tBody.appendChild(tr);

    const editIcon = document.querySelector(`#edit-icon-${item.productId}`);
    const deleteIcon = document.querySelector(`#delete-icon-${item.productId}`);

    console.log(editIcon);
    editIcon.addEventListener("click", function () {
      openEditForm(item, invoice);
    });

    deleteIcon.addEventListener("click", function () {
      deletePurchaseItems(item.productId, invoice);
    });
  });
}

//Delete invoice item from the invoice items list
async function deletePurchaseItems(productId, invoice) {
  let newTotal = 0;
  let products = JSON.parse(invoice.items);
  console.log(products.length);

  if (products.length === 1) {
    // document.querySelector(".view-modal .error").textContent =
    //   "Please there is only one item in the list, try deleting the invoice if you still want to continue with this";
    // document.querySelector(".view-modal .error").style.display = "block";
    // setTimeout(() => {
    //   document.querySelector(".view-modal .error").style.display = "none";
    // }, 5000);
    showErrorMessage(
      ".view-modal .error",
      "Please there is only one item in the list, try deleting the invoice if you still want to continue with this"
    );
    return;
  } else {
    updatePurchase(
      invoice,
      "Invoice Item Deleted",
      "Are you sure you want to delete this invoice?",
      () => {
        // Use filter to remove the product based on productId
        invoice.itemToDelete = productId;
        console.log({ invoice });
        newTotal = products.reduce((accum, curr) => {
          return accum + Number(curr.total);
        }, 0);
        console.log({ newTotal });

        invoice.newSubTotal = newTotal;

        // Convert the products array back to a JSON string
        invoice.items = JSON.stringify(products);

        // Optionally log the updated products
        console.log(invoice.products);
        removeModal('.view-modal', 'open-view-modal')
      }
    );
  }
}

// function calculateRowTotal(row) {
//   const unitPrice = parseFloat(row.querySelector(".unit-price").value) || 0;
//   const quantity = parseInt(row.querySelector(".quantity").value) || 0;
//   const total = unitPrice * quantity;
//   row.querySelector(".total").value = total.toFixed(2);
//   return total;
// }
// document.querySelector(".add-new-form").addEventListener("input", function(e){
//   const target = e.target;

//   console.log(target)
// })

async function fetchMedicine() {
  const response = await makeRequest(
    `../php/medicine.script.php`,
    "GET",
    "",
    "fetchMedicines"
  );
  const { medicines } = response;
  const selectItemInformationElement = document.querySelector(
    ".add-item-modal #item-information"
  );
  medicines.forEach((medicine) => {
    const option = document.createElement("option");
    option.value = medicine.medicinename;
    option.textContent = medicine.medicinename;
    selectItemInformationElement.appendChild(option);
  });

  selectItemInformationElement.addEventListener("change", function () {
    const selectedMedicine = medicines.filter(
      (medicine) => medicine.medicinename === this.value
    );
    document.querySelector("#new-unit-price").value =
      selectedMedicine[0].medicinecostunitprice.toFixed(2);
    document.querySelector("#new-date").value =
      selectedMedicine[0].medicinecategory;
    document.querySelector("#new-batch-id").value =
      selectedMedicine[0].medicineunit;
  });
}

fetchMedicine();

const addNewItemBtn = document.querySelector(".add-new-item");
addNewItemBtn.addEventListener("click", function (e) {
  console.log("hello");

  document
    .querySelector(".add-item-modal")
    .classList.add("open-add-item-modal");
  // date = document.querySelector('.purchase-date').textContent;
});

document.querySelector('.add-item-modal .close').addEventListener('click', function(){
  removeModal('.add-item-modal', 'open-add-item-modal');
})
document
  .querySelector("#new-add-button-purchase")
  .addEventListener("click", async function (e) {
    e.preventDefault();
    const newItemMecineName = document.querySelector(
      ".add-item-modal #item-information"
    ).value;
    const newQuantity = document.querySelector(
      ".add-item-modal #new-qty"
    ).value;
    const newUnitPrice = document.querySelector(
      ".add-item-modal #new-unit-price"
    ).value;
    const newTotal = document.querySelector(".add-item-modal #new-total").value;
    const newDate = document.querySelector(".add-item-modal #new-date").value;
    const newBatchId = document.querySelector(
      ".add-item-modal #new-batch-id"
    ).value;
    const category = document.querySelector(".add-item-modal #new-date").value;

    const errorMessage = document.querySelector(".add-item-modal .error");

    console.log({ newItemMecineName });
    console.log({ errorMessage });
    if (
      newItemMecineName.trim().length <= 0 ||
      newQuantity.trim().length <= 0
    ) {
      errorMessage.textContent = "All fields required";
      errorMessage.style.display = "block";
      errorMessage.style.alignSelf = "center";
      return;
    }
    let purchaseToUpdate = null;
    let newTotalSub = 0;
    dbPurchases.map((purchase) => {
      if (purchase.date === purchasedDate) {
        const products = JSON.parse(purchase.items);
        products.push({
          item_information: newItemMecineName,
          unitPrice: Number(newUnitPrice),
          total: Number(newTotal),
          quantity: Number(newQuantity),
          date: newDate,
          batchId: newBatchId,
          productId: generateProductId(),
          category: category,
        });
        newTotalSub = products.reduce((accum, curr) => {
          return accum + Number(curr.total);
        }, 0);
        console.log({ products });

        purchase.newSubTotal = newTotalSub;
        console.log({purchase})
        purchase.items = JSON.stringify(products);
        console.log({ newTotalSub });
        purchaseToUpdate = purchase;
      }
    });

    console.log({purchaseToUpdate})
    function generateProductId() {
      const length = 7;
      const characters = "1234567890";
      return Array.from(
        { length },
        () => characters[Math.floor(Math.random() * characters.length)]
      ).join("");
    }

    updatePurchase(
      purchaseToUpdate,
      "Purchase Updated",
      "Are you sure you want insert this purchase",
      () => {
        () => {};
        removeModal('.add-item-modal', 'open-add-item-modal');
        removeModal(".modal", "open-modal")
      }
    );
  });

document.querySelector("#new-qty").addEventListener("input", function () {
  let newUnitPrice = document.querySelector("#new-unit-price").value;
  document.querySelector("#new-total").value = (
    newUnitPrice * this.value
  ).toFixed(2);
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


toggleMenu()