const selectElement = (selector) => {
  const element = document.querySelector(selector) || "";
  if (element) return element;
  throw new Error(`There is no element like ${element}`);
};

const selectElementValue = (selectValue) => {
  const element = document.querySelector(selectValue).value || "";
  if (element) return element;
  throw new Error(`There is not element with value like ${element}`);
};

function showErrorMessage(className, message) {
  document.querySelector(`${className}`).textContent = message;
  document.querySelector(`${className}`).style.display = "block";
  setTimeout(() => {
    document.querySelector(`${className}`).style.display = "none";
  }, 5000);
}
async function makeRequest(url, method, data, service) {
  try {
    const response = await fetch(url, {
      method: method,
      headers: {
        "Content-Type": "application/json",
        Service: service,
      },
      body: data ? JSON.stringify(data) : null,
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const result = await response.json();
    return result;
  } catch (error) {
    console.error("Error making POST request:", error);
    throw error; // Re-throw the error after logging it
  }
}

async function showMessage(
  greeting,
  message,
  icon,
  confirmButtonText,
  showCancelButton,
  cancelButtonColor,
  cb
) {
  const result = await Swal.fire({
    title: greeting,
    text: message,
    icon: icon,
    confirmButtonText: confirmButtonText,
    showCancelButton: showCancelButton,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: cancelButtonColor,
    animation: true,
  });

  if (result.isConfirmed) {
    cb();
  } else if (result.dismiss === Swal.DismissReason.cancel) {
    Swal.fire("Cancelled", "Your content is safe", "error");
  }
}

class UserProfile {
  constructor(firstname, lastname) {
    this.firstname = firstname;
    this.lastname = lastname;
  }
  fullName() {
    return this.firstname + " " + this.lastname;
  }
}

const medicineUrl = "../php/medicine.script.php";
const categoryUrl = "../php/category.script.php";

function removeModal(className, classToRemove) {
  const modal = document.querySelector(className);
  console.log(modal);
  modal.classList.remove(classToRemove);
}

function showModal(className, classToAdd) {
  const modal = document.querySelector(className);
  console.log(modal);
  modal.classList.add(classToAdd);
}

async function fetchExpenseCategories() {
  const response = await makeRequest(
    "../php/expense.category.script.php",
    "GET",
    "",
    "fetchExpenseCategories"
  );
  return response;
}

async function fetchUserDetails(imageId, username) {
  const response = await makeRequest(
    `../php/userAuthentication.php?username=${username}`,
    "GET",
    "",
    "fetchDetails"
  );
  imageId.src = `../uploads/${response.user.avarta}`;
}

function displayORRemoveElement(element) {
  if (element.style.display === "block") element.style.display = "none";
  else element.style.display = "block";
}

function reportSmmary(data, reportType, element) {
  // const tBody = selectElement(".table__body");
  if (data.length > 0 && data instanceof Array) {
    data.forEach((item) => {
      const tr = document.createElement("tr");
      let newRecord = null;
      let date = null;
      switch (reportType) {
        case "salesReport":
        case "searchInvoice":
          date = new Date(item.dateofsale).toDateString();
          newRecord = `
        <td class="purchase-date">${date}</td>
        <td> ${item.actiontaker}</td>
        <td>GHS ${item.subtotal.toFixed(2)}</td>
        <td>GHS ${item.totalProfit}</td>
        <td> ${item.invoicenumber}</td>
        <td> ${item.paymentmode}</td>     
      `;
          break;
        case "purchaseReport":
          date = new Date(item.date).toDateString();
          newRecord = `
        <td class="item-date">${date}</td>
        <td>GHS ${item.subtotal.toFixed(2)}</td>
        <td> ${item.paymentmode}</td>
        <td>P0987654</td>
      `;
          break;
        case "expenseReport":
          date = new Date(item.expensedate).toDateString();
          newRecord = `
          <td class="user-date">${date}</td>
      <td> ${item.expensecategory}</td>
      <td> ${item.purpose}</td>
      <td>GHS ${item.total.toFixed(2)}</td>
      <td> ${item.description}</td>
        `;
          break;
        case "searchMedicine":
          newRecord = `
                <td>${item.medicinename}</td>
                <td>${item.medicinecategory}</td>
                <td>${item.medicineunit}</td>
                <td>GHS ${item.medicinecostunitprice}</td>
                <td>GHS ${item.medicinesellingunitprice}</td>
                <td> ${item.quantity}</td>
                 <td>${item.qtysold}</td>
                <td>${item.collectedquantity}</td>
                <td><img src="../assets/images/logo_pharmacy.png" style="width: 40px; height: 50px;"></td>`;
          break;
        case "searchUser":
          console.log("foud");
          console.log({ data });
          newRecord = `
             <td class="user-date">${data.firstname}</td>
              <td> ${data.middlename}</td>
              <td> ${data.lastname}</td>
              <td> ${data.username}</td>
              <td> ${data.role}</td>
              <td><img src="../uploads/${data.avarta}" style="width: 50px; height: 65;"></td>
          `;
          break;
        default:
          return;
      }
      tr.innerHTML = newRecord;
      element.appendChild(tr);
    });
  } else if (data instanceof Object && reportType === "searchUser") {
    console.log({ data });
    let newRecord = `
   <td class="user-date">${data.firstname}</td>
    <td> ${data.middlename}</td>
    <td> ${data.lastname}</td>
    <td> ${data.username}</td>
    <td> ${data.role}</td>
    <td><img src="../uploads/${data.avarta}" style="width: 50px; height: 50px; border-radius:50px;"></td>
`;
    const tr = document.createElement("tr");

    tr.innerHTML = newRecord;
    element.appendChild(tr);
  }
}

function reportDetails(data, reportType, element, dateOfEvent) {
  // const tBody = selectElement(".table__body");
  if (data.length > 0) {
    data.forEach((item) => {
      const tr = document.createElement("tr");
      let newRecord = null;
      let date = null;
      switch (reportType) {
        case "salesReport":
        case "searchInvoice":
          date = new Date(dateOfEvent).toDateString();
          newRecord = `
         <td>${date}</td>
         <td>${item.item_information || item.medicineName}</td>
         <td> ${item.category}</td>
              <td> ${item.quantity}</td>
              <td>GHS ${item.unitPrice}</td>
              <td>GHS ${item.total}</td>
      `;
          break;
        case "purchaseReport":
          date = new Date(dateOfEvent).toDateString();
          newRecord = `
         <td>${date}</td>
         <td>${item.medicineName}</td>
              <td> ${item.quantity}</td>
              <td>GHS ${item.unitPrice}</td>
              <td>GHS ${item.total}</td>
              <td> ${item.batchId}</td>
            
      `;
          break;
        case "searchUser":
          date = new Date(dateOfEvent).toDateString();
          newRecord = `
       
        <td> ${new Date(item.created_at).toLocaleString()}</td>
        <td> ${item.username}</td>
        <td> ${item.activity}</td>
       
          `;
          break;
        default:
          return;
      }
      tr.innerHTML = newRecord;
      element.appendChild(tr);
    });
  }
}

function displayNoReports(element, message) {
  const p = document.createElement("p");
  p.classList.add("no-reports");
  p.textContent = `${message}`;
  element.appendChild(p);
}

function printTableContent(printElement) {
  const printContent = document.getElementById(printElement).outerHTML;
  const originalContent = document.body.innerHTML;

  // Replace body content with the table content and print
  document.body.innerHTML = printContent;

  let path = window.location.pathname;
  let filename = path.substring(path.lastIndexOf("/") + 1);

  if (
    filename === "sales-report.php" ||
    filename === "purchase-report.php" ||
    filename === "expense-report.php"
  )
    document.querySelector(".printBtn").style.display = "none";
  window.print();

  // Restore the original body content after printing
  document.body.innerHTML = originalContent;
  location.reload(); // Reload to re-apply JavaScript functionality if needed
}

function clearTableRows(tableBody) {
  while (tableBody.rows.length > 0) {
    tableBody.deleteRow(0);
  }
}

function logValue(i, data, element, showFormat) {
  setTimeout(() => {
    document.querySelector(element).innerHTML = showFormat
      ? `GHS ${i.toFixed(2)}`
      : i;
    if (i < data) {
      logValue(i + 1, data, element, showFormat); // Recursive call with all parameters
    }
  }, 70);
}

// Variable to store the current chart instance


function drawChart(type, data, labels, labelName, target) {
  // Check if a chart instance already exists on the canvas and destroy it


  // Create a new chart instance and store it in the global variable
  currentChart = new Chart(target, {
    type: type, // e.g., 'bar', 'pie', etc.
    data: {
      labels: labels,
      datasets: [
        {
          label: labelName, // e.g., 'Total Sales ($)'
          data: data,
          backgroundColor: [
            "rgba(75, 192, 192, 0.5)",
            "rgba(255, 99, 132, 0.6)",
            "rgba(54, 162, 235, 0.6)",
            "rgba(255, 206, 86, 0.6)",
          ],
          borderColor: [
            "rgba(75, 192, 192, 1)",
            "rgba(255, 99, 132, 1)",
            "rgba(54, 162, 235, 1)",
          ],
          borderWidth: 1,
        },
      ],
    },
    // Add other options as needed
  });
}
