const circularMotion = document.querySelector(".circular-motion-container");
const generateBtn = document.querySelector(".form-input button");
const tableContainer = document.querySelector(".table-container");
const table_container = document.getElementById("table-container");
const formInput = document.querySelector(".search-form");
const summaryBody = document.querySelector("#summary-body");
const detailsBody = document.querySelector("#details-body");
const summaryHead = document.querySelector("#summary-head");
const summaryTable = document.querySelector(".summary-table");
const detailsTable = document.querySelector(".details-table");
const summaryPara = document.querySelector(".summary_paragraph");
const detailsPara = document.querySelector(".details_paragraph");
const detail = document.querySelector("#summaryBody");
const header = document.querySelector(".header");
const searchKind = document.querySelector("#searchType").value;
const reportSummaryBody = document.querySelector("#report-summaryBody");

async function fetchDynamicReport(searchType, keyword) {
  return await makeRequest(
    `../php/search.script.php?query=${keyword}`,
    "GET",
    "",
    searchType
  );
}

let totalProducts = 0;
let totalAmount = 0;
let quantity = 0;
let totalQuantity = 0;
async function search() {
  clearTableRows(detailsBody);
  clearTableRows(summaryBody);
  const query = document.getElementById("searchInput").value;
  // if (!query) {
  //   document.getElementById("results").innerHTML = "Please enter a search term";
  //   return;
  // }

  console.log({ query });

  console.log(searchKind);

  if(typeof query === 'string' && query.trim().length === 0){
    showErrorMessage('.error', 'Please enter a keyword');
    return;
  }
  try {
    const response = await fetchDynamicReport(searchKind, query);
    console.log({ response });
    const { success, searchResults } = response;

    // generateBtn.style.display = "none";
    displayORRemoveElement(circularMotion);
    console.log(searchResults);
    if (success) {
      setTimeout(() => {
        displayORRemoveElement(tableContainer);
        circularMotion.style.display = "none"; // formInput.style.display = "none";
        document.querySelector(".new-search").style.display = "block";
        header.textContent = "---Search Results---";
      }, 1000);
      if (typeof searchResults !== undefined) {
        console.log({ searchResults });

        const user = searchResults[0];

        console.log(user);
        if (searchKind === "searchUser") {
          reportSmmary(searchResults[0], searchKind, summaryBody);
        } else {
          reportSmmary(searchResults, searchKind, summaryBody);
        }
        // displayORRemoveElement(circularMotion)
        // const data = JSON.parse(report.items);
        // products = report;
        if (searchKind === "expenseReport") {
          const totalExpenseAmount = report.reduce((accum, curr) => {
            return (accum += Number(curr.total));
          }, 0);

          document.querySelector(".expense-total-span").textContent =
            totalExpenseAmount.toFixed(2);
        }

        if (searchKind === "searchInvoice" || searchKind === "purchaseReport") {
          searchResults.map((reportItem) => {
            console.log(reportItem);
            let date =
              searchKind === "searchInvoice"
                ? reportItem.dateofsale
                : searchKind === "purchaseReport"
                ? reportItem.date
                : "";
            const items =
              searchKind === "searchInvoice"
                ? JSON.parse(reportItem.items)
                : searchKind === "purchaseReport"
                ? JSON.parse(reportItem.products)
                : "";
            totalProducts = items.reduce((accum, curr) => {
              return accum + Number(curr.total);
            }, 0);

            quantity = items.reduce((accum, curr) => {
              return accum + Number(curr.quantity);
            }, 0);
            totalAmount += totalProducts;
            totalQuantity += quantity;
            console.log({ totalAmount, totalQuantity });
            document.querySelector(".quantity-span").textContent =
              Number(totalQuantity);
            document.querySelector(
              ".total-span"
            ).textContent = `GHS ${totalAmount.toFixed(2)}`;

            reportDetails(items, searchKind, detailsBody, date);
          });
        } else {
          reportDetails(searchResults, searchKind, detailsBody);
        }
        // const tr = document.createElement('tr');
        // tr.innerHTML = `
        //    <td>${Number(totalQuantity)}</td>
        //     <td>GHS ${totalAmount.toFixed(2)}</td>
        // `
        // reportSummaryBody.appendChild(tr)
      } else {
        summaryTable.style.display = "none";
        detailsTable.style.display = "none";
        detailsPara.style.display = "none";
        summaryPara.style.display = "none";
        circularMotion.style.display = "none";

        document.querySelector(".printBtn").style.display = "none";
        displayNoReports(
          tableContainer,
          "No Sale Report for the given periods"
        );
      }
    }
  } catch (error) {
    console.log(error.message);
  }
}

document.querySelector(".printBtn").addEventListener("click", function () {
  printTableContent("table-container");
  this.style.display = "none";
});

document.querySelector(".new-search").addEventListener("click", function () {
  header.textContent = "Generate New Search";
  tableContainer.style.display = "none";
  totalAmount = 0;
  displayORRemoveElement(formInput);
  displayORRemoveElement(generateBtn);
  // while (detailsBody.rows.length > 0) {
  //   detailsBody.deleteRow(0);
  // }
  // while (summaryBody.rows.length > 0) {
  //   summaryBody.deleteRow(0);
  // }
  clearTableRows(detailsBody);
  clearTableRows(summaryBody);
  this.style.display = "none";
});


toggleMenu()