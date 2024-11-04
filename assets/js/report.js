const circularMotion = document.querySelector(".circular-motion-container");
const generateBtn = document.querySelector(".form-input button");
const tableContainer = document.querySelector(".table-container");
const table_container = document.getElementById("table-container");
const reportForm = document.querySelector("#reportForm");
const summaryBody = document.querySelector("#summary-body");
const detailsBody = document.querySelector("#details-body");
const summaryHead = document.querySelector("#summary-head");
const summaryTable = document.querySelector(".summary-table");
const detailsTable = document.querySelector(".details-table");
const summaryPara = document.querySelector(".summary_paragraph");
const detailsPara = document.querySelector(".details_paragraph");
const detail = document.querySelector("#summaryBody");
const header = document.querySelector(".header");
const reportKind = document.querySelector("#reportType").value;
const reportSummaryBody = document.querySelector("#report-summaryBody");

async function fetchDynamicReport(body, reportType) {
  return await makeRequest(
    `../php/generate_report.php`,
    "POST",
    body,
    reportType
  );
}

let totalProducts = 0;
let totalAmount = 0;
let quantity = 0;
let totalQuantity = 0;
reportForm.addEventListener("submit", async function (e) {
  e.preventDefault();
  const startDate = document.querySelector("#startDate").value
    ? document.querySelector("#startDate").value + " 00:00:00"
    : null;
  const endDate = document.querySelector("#endDate").value
    ? document.querySelector("#startDate").value + " 23:59:59"
    : null;
  const filterBy = document.querySelector("#filter-by").value
    ? document.querySelector("#filter-by").value
    : null;

  if (new Date(startDate) > new Date(endDate)) {
    showErrorMessage(".error", "End date should be after start date");
    return;
  }
  console.log({ reportKind });

  const formData = {
    startDate,
    endDate,
    filterBy,
  };
  console.log(formData);
  try {
    const response = await fetchDynamicReport(
      formData,
      reportKind,
      startDate,
      endDate,
      filterBy
    );
    const { success, report } = response;

    console.log(report);
    generateBtn.style.display = "none";
    circularMotion.style.display = "block";
    if (success) {
      setTimeout(() => {
        displayORRemoveElement(tableContainer);
        displayORRemoveElement(circularMotion);
        reportForm.style.display = "none";
        document.querySelector(".new-report").style.display = "block";
        header.textContent = "---Report---";
      }, 1000);
      if (report.length > 0) {
        reportSmmary(report, reportKind, summaryBody);
        // const data = JSON.parse(report.items);
        // products = report;
        if (reportKind === "expenseReport") {
          const totalExpenseAmount = report.reduce((accum, curr) => {
            return (accum += Number(curr.total));
          }, 0);

          document.querySelector(".expense-total-span").textContent =
            totalExpenseAmount.toFixed(2);
        }
        if (reportKind === "salesReport" || reportKind === "purchaseReport") {
          report.map((reportItem) => {
            console.log(reportItem);
            let date =
              reportKind === "salesReport"
                ? reportItem.dateofsale
                : reportKind === "purchaseReport"
                ? reportItem.date
                : "";
            const items =
              reportKind === "salesReport"
                ? JSON.parse(reportItem.items)
                : reportKind === "purchaseReport"
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

            reportDetails(items, reportKind, detailsBody, date);
          });
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
});

document.querySelector(".printBtn").addEventListener("click", function () {
  printTableContent("table-container");
  this.style.display = "none";
});

document.querySelector(".new-report").addEventListener("click", function () {
  header.textContent = "Generate New Report";
  tableContainer.style.display = "none";
  totalAmount = 0;
  displayORRemoveElement(reportForm);
  displayORRemoveElement(generateBtn);
  while (detailsBody.rows.length > 0) {
    detailsBody.deleteRow(0);
  }
  while (summaryBody.rows.length > 0) {
    summaryBody.deleteRow(0);
  }
  this.style.display = "none";
});
