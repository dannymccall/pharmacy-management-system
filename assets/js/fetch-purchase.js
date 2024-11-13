let currentPage = 1;
const itemsPerPage = 5;
let purchasedDate = null;
  const tBody = selectElement(".table__body");

// document.querySelector('.modal .close').addEventListener('click', function(){
//   removeModal('.modal ')
//   // console.log(this.classList)
// })
document.querySelector('.view-modal .close').addEventListener('click', function(){
    console.log('hello')
  // this.classList.remove('open-view-modal')
  removeModal('.view-modal', 'open-view-modal')
})

document.addEventListener("DOMContentLoaded", fetchPurchases(currentPage));
let dbPurchases = null;
async function fetchPurchases(page) {
  try {
    const response = await makeRequest(
      `../php/purchase.script.php?page=${page}`,
      "GET",
      "",
      "fetchPurchases"
    );
    console.log({response})
    const tBody = selectElement(".table__body");
    tBody.innerHTML = "";

    const { success, purchases, current_page, items_per_page, total_items } =
      response;
    if (success && purchases.length > 0) {
      dbPurchases = purchases;
      renderPurchases(purchases);
      updatePagination(current_page, items_per_page, total_items);
    } else {
      displayNoRecords(tBody);
    }
  } catch (error) {
    console.error("Error fetching medicine data:", error);
  }
}

function renderPurchases(purchases) {
  purchases.forEach((purchase) => {
    const tr = document.createElement("tr");
    const date = new Date(purchase.date).toDateString();
    const newRecord = `
      <td class="purchase-date">${date}</td>
      <td>GHS ${purchase.subtotal.toFixed(2)}</td>
      <td> ${purchase.paymentmode}</td>
      <td>
        <span>
          <img src="../assets/images/view.png" id="view-icon-${
            purchase.id
          }" class="view-icon" alt="">
          <img src="../assets/images/delete.png" id="delete-icon-${
            purchase.id
          }" class="delete-icon" alt="Delete Icon">
          <input type="hidden" class='id' value="${purchase.id}" />
        </span>
      </td>
    `;
    tr.innerHTML = newRecord;
    tBody.appendChild(tr);

    addIconListeners(purchase);
  });
}
function addIconListeners(purchase) {
  document
    .querySelector(`#view-icon-${purchase.id}`)
    .addEventListener("click", () => {
      purchasedDate = purchase.date;
      document.querySelector("#new-hidden").value = purchase.id;
      openViewTable(purchase);
    });

  document
    .querySelector(`#delete-icon-${purchase.id}`)
    .addEventListener("click", () => {
      deleteFunction(purchase.id);
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
    fetchPurchases(currentPage);
  }
});

document.getElementById("nextBtn").addEventListener("click", () => {
  currentPage++;
  fetchPurchases(currentPage);
});

if (document.querySelector("#prevBtn").disabled) {
  document.querySelector("#prevBtn").style.background = "#b8b8b8";
}
if (document.querySelector("#nextBtn").disabled) {
  document.querySelector("#nextBtn").style.background = "#b8b8b8";
}

async function deleteFunction(purchaseId) {
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
        "../php/purchase.script.php",
        "DELETE",
        { id: purchaseId },
        "deletePurchase"
      );
      if (response.success) {
        Swal.fire(
          "Success",
          `Item with ID: ${purchaseId} has been deleted`,
          "success"
        );
        fetchPurchases(currentPage);
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

async function openEditForm(product, purchase) {
  console.log({ product, purchase });

  const modal = document.querySelector(".modal");
  modal.classList.add("open-modal");

  document.querySelector('.modal .close').addEventListener('click', function(){
    removeModal('.modal', 'open-modal')
  })
  document.querySelector("#medicine-name").value = product.medicineName;
  document.querySelector("#qty").value = product.quantity;

  document.querySelector("#unit-price").value = product.unitPrice;

  document.querySelector("#total").value = product.total;

  document.querySelector("#productId").value = product.productId;

  const [year, day, month] = product.date.split("-");

  const date = new Date(year, month - 1, day);
  const formattedDate = `${date.getFullYear()}-${String(
    date.getMonth() + 1
  ).padStart(2, "0")}-${String(date.getDate()).padStart(2, "0")}`;

  document.querySelector("#date").value = formattedDate;
  document.querySelector("#batch-id").value = product.batchId;

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

      const medicineName = document.querySelector("#medicine-name").value;
      const quantity = document.querySelector("#qty").value;
      const total = document.querySelector("#total").value;
      const date = document.querySelector("#date").value;
      const unitPrice = document.querySelector("#unit-price").value;
      const batchId = document.querySelector("#batch-id").value;
      const productId = document.querySelector("#productId").value;

      let newTotal = 0;

      updatePurchase(
        purchase,
        "Purchased Item Edited",
        "Are you sure you want to edit this purchase again",
        () => {
          let products = JSON.parse(purchase.products);
          console.log({quantity})
          products.map((product) => {
            if (product.productId === productId) {
              console.log('found')
              product.medicineName = medicineName;
              product.quantity = Number(quantity);
              product.total = Number(total);
              product.unitPrice = Number(unitPrice);
              product.batchId = batchId;
              product.date = date;
              console.log({product})
            }
            // newTotal += Number(product.total);

          });
          console.log(purchase)
          newTotal = products.reduce((accum, curr) => {
            return accum + Number(curr.total)
          });

          console.log({newTotal})
          purchase.newSubTotal = newTotal;
          purchase.products = JSON.stringify(products);
          removeModal('.modal', 'open-modal');
        }
      );
      console.log({ purchase });
    });
}

async function openViewTable(purchase) {
  const viewModal = document.querySelector(".view-modal");
  const totalSpan = document.querySelector(".total__span");
  const quantitySpan = document.querySelector(".quantity__span");

  console.log({ viewModal });

  viewModal.classList.add("open-view-modal");

  let subtotal = 0;
  let totalQuantity = 0;
  const tBody = document.querySelector(".view-modal table tbody");
   clearTableRows(tBody);
  document.querySelector('.view-modal .close').addEventListener('click', function(){
    removeModal('.view-modal open-view-modal');
    console.log('do')
    clearTableRows(tBody);
    totalSpan.textContent = '';
    quantitySpan.textContent = '';
  })
  // console.log(tBody)
  const products = JSON.parse(purchase.products);
  console.log(typeof products);
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
  products.map((product) => {
    // Create a table row dynamically

    const tr = document.createElement("tr");
    // let date = new Date(purchase.date);
    const newRecord = `
              <td>${product.medicineName}</td>
              <td> ${product.quantity}</td>
              <td>GHS ${product.unitPrice}</td>
              <td>GHS ${product.total}</td>
              <td> ${product.batchId}</td>
              <td> ${product.date}</td>
              <td>
                  <span>
                      <img src="../assets/images/edit.png" id="edit-icon-${product.productId}" class="edit-icon" alt="">
                      <img src="../assets/images/delete.png" id="delete-icon-${product.productId}" class="delete-icon" alt="Delete Icon">
                      
                      <input type="hidden" class='id' value="${product.productId}" />
                  </span>
              </td>
          `;
    tr.innerHTML = newRecord;
    tBody.appendChild(tr);

    const editIcon = document.querySelector(`#edit-icon-${product.productId}`);
    const deleteIcon = document.querySelector(
      `#delete-icon-${product.productId}`
    );

    console.log(editIcon);
    editIcon.addEventListener("click", function () {
      openEditForm(product, purchase);
    });

    deleteIcon.addEventListener("click", function () {
      deletePurchaseItems(product.productId, purchase);
    });
  });
}

async function deletePurchaseItems(productId, purchase) {

  let newTotal = 0;
  let products = JSON.parse(purchase.products);
  updatePurchase(
    purchase,
    "Purchase Item Deleted",
    "Are you sure you want to delete this purchase?",
    () => {

      // Use filter to remove the product based on productId
      products = products.filter((product) => {
        // Return true for products you want to keep
        return product.productId !== productId;

      });
      
     newTotal = products.reduce((accum, curr) => {
        return accum + Number(curr.total)
      },0)
      console.log({newTotal})

      purchase.newSubTotal = newTotal;

      // Convert the products array back to a JSON string
      purchase.products = JSON.stringify(products);

      // Optionally log the updated products
      console.log(purchase.products);
    }
  );
}

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
  clearTableRows(tBody)
})
document
  .querySelector("#new-add-button-purchase")
  .addEventListener("click", async function (e) {
    e.preventDefault();
    const newItemMecineName = document.querySelector(
      "#new-item-medicine-name"
    ).value;
    const newQuantity = document.querySelector("#new-qty").value;
    const newUnitPrice = document.querySelector("#new-unit-price").value;
    const newTotal = document.querySelector("#new-total").value;
    const newDate = document.querySelector("#new-date").value;
    const newBatchId = document.querySelector("#new-batch-id").value;

    const errorMessage = document.querySelector(".add-item-modal .error");
    console.log({ errorMessage });
    if (
      newItemMecineName.trim().length <= 0 ||
      newQuantity.trim().length <= 0
    ) {
      showErrorMessage(".add-item-modal .error", "All fields Required")
      return;
    }
    let purchaseToUpdate = null;
    let newTotalSub = 0;
    dbPurchases.map((purchase) => {
      if (purchase.date === purchasedDate) {
        const products = JSON.parse(purchase.products);
        products.push({
          medicineName: newItemMecineName,
          unitPrice: Number(newUnitPrice),
          total: Number(newTotal),
          quantity: Number(newQuantity),
          date: newDate,
          batchId: newBatchId,
          productId: generateProductId(),
        });
        newTotalSub = products.reduce((accum, curr) => {
          return accum + Number(curr.total)
        },0)
        console.log({ products });

        purchase.newSubTotal = newTotalSub;
        purchase.products = JSON.stringify(products);
        console.log({newTotalSub})
        purchaseToUpdate = purchase;
      }
    });

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