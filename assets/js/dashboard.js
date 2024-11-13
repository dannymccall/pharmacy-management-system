// const userExistUsername = fetchUser()
// let activityCurrentPage = 1;
// let salesCurrentPage = 1;
let itemsPerPage = 5;
document.addEventListener("DOMContentLoaded", fetchDashboardDetails());

async function fetchDashboardDetails(page) {
  const response = await makeRequest(
    `../php/dashboard.script.php?page=${page}`,
    "GET",
    "",
    "getDashboardDetails"
  );
  console.log({ response });
  const {
    expectedRevenue,
    lowStockCondition,
    totalExpense,
    totalProfit,
    monthSales,
    monthTotals,
    totalPurchases,
    totalInvoiceSales,
    todaySales,
    todaysExpense,
    todaysPurchase,
  } = response.data;

  console.log({
    expectedRevenue,
    lowStockCondition,
    totalExpense,
    totalProfit,
    monthTotals,
    monthSales,
  });
  logValue(0, expectedRevenue, ".revenue-value", true);
  logValue(0, totalProfit, ".profit", true);
  logValue(0, totalExpense, ".total-expense", true);
  logValue(0, lowStockCondition, ".low-stock", false);
  logValue(0, totalPurchases, ".purchases", true);
  logValue(0, todaysPurchase, "#today-purchase", true);
  logValue(0, todaysExpense, "#today-expense", true);

  //   var myChart = document.getElementById('myChart').getContext('2d');

  // const ctx = document.getElementById('salesChart').getContext('2d');

  const salesChart = document.querySelector("#sales-chart").getContext("2d");
  const reportChart = document.querySelector("#report-chart").getContext("2d");
  const notification = document.querySelector(".notification");
  const tableContainer = document.querySelector(".tableContainer");

  // notification.textContent = notifications.length;
  // console.log(notification)
  // if (notifications.length == 0) {
  //   const notficationElement = document.querySelector("p");
  //   notficationElement.textContent = "No notifications yet";
  //   tableContainer.appendChild(notficationElement);
  // } else {
  //   notifications.forEach((notification) => {
  //     const notficationElement = document.querySelector("p");
  //     notficationElement.textContent = notification;
  //     tableContainer.appendChild(notficationElement);
  //   });
  // }
  drawSalesChart(
    "bar",
    monthTotals,
    monthSales,
    "Monthly Sales Report",
    salesChart
  );

  let todaysInvoiceSales = 0;
  todaysInvoiceSales = todaySales.reduce((accum, curr) => {
    return (accum += parseFloat(curr.subtotal));
  }, 0);

  logValue(0, todaysInvoiceSales, "#today-sales", true);

  // const activityBody = document.querySelector(".activity__body");
  // todaysActivities.activity.forEach((item) => {
  //   const tr = document.createElement("tr");
  //   const date = new Date(item.created_at).toDateString();
  //   const newRecord = `
  //   <td>${date}</td>
  //   <td>${item.activity}</td>
  //   <td> ${item.username}</td>
  //   `;
  //   tr.innerHTML = newRecord;
  //   activityBody.appendChild(tr);
  // });

  // fetchNextInformation(
  //   ".activity-prevBtn",
  //   ".activity-nextBtn",
  //   activityCurrentPage
  // );
  // fetchNextInformation(".sales-prevBtn", ".sales-nextBtn", salesCurrentPage);

  // document.querySelector("#activity-currentPage").innerHTML = `Page ${
  //   todaysActivities.current_page
  // } of ${Math.ceil(
  //   todaysActivities.total_items / todaysActivities.items_per_page
  // )}`;
  // document.querySelector(".activity-prevBtn").disabled =
  //   todaysActivities.current_page === 1;
  // document.querySelector(".activity-nextBtn").disabled =
  //   todaysActivities.current_page ===
  //   Math.ceil(todaysActivities.total_items / todaysActivities.items_per_page);

  // const salesBody = document.querySelector(".sales__body");

  // todaySales.invoices.map((item) => {
  //   console.log(item);
  //   let products = JSON.parse(item.items);

  //   const tr = document.createElement("tr");
  //   const date = new Date(item.dateofsale).toDateString();
  //   const newRecord = `
  //    <td class="purchase-date">${date}</td>
  //     <td>${item.invoicenumber}</td>
  //     <td>GHS ${parseFloat(item.subtotal).toFixed(2)}</td>
  //     <td>GHS ${parseFloat(item.totalprofit).toFixed(2)}</td>
  //     <td>${item.paymentmode}</td>
  //     <td>GHS ${parseFloat(item.amountpaid).toFixed(2)}</td>
  //     <td>GHS ${parseFloat(item.balance).toFixed(2)}</td>
  //   `;
  //   tr.innerHTML = newRecord;
  //   salesBody.appendChild(tr);
  // });

  drawGraphReportChart(
    "pie",
    [totalInvoiceSales, totalPurchases, totalExpense],
    ["Total Sales", "Total Purchases", "Total Expenses"],
    "Monthly sales",
    reportChart
  );
}

// function fetchNextInformation(prevelement, nextelement, page) {
//   document.querySelector(prevelement).addEventListener("click", () => {
//     if (page > 1) {
//       page--;
//       fetchDashboardDetails(page);
//     }
//   });

//   document.querySelector(nextelement).addEventListener("click", () => {
//     page++;
//     fetchDashboardDetails(page);
//   });
// }

toggleMenu();
