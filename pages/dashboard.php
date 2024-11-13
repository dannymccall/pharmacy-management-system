<?php include '../includes/auth.php' ?>

<?php
include '../includes/header.php'
    ?>
<link rel="stylesheet" href="../assets/css/unit.style.css">
<link rel="stylesheet" href="../assets/css/add-medicine.style.css">

<link rel="stylesheet" href="../assets/css/index.css">
<link rel="icon" href="../assets/images/logo2.png" type="image/png">
<?php

include '../includes/header__rest.php';
?>

<div class="container">
    <div class="section">
        <div class="sidebar__section">
            <?php include '../includes/sidebar.php' ?>
        </div>

        <div style="width: 100%; height:100%; display: flex; flex-direction: column; justify-content: space-between;">
            <div class="body__section">
                <div class="body__header__section">
                    <?php include "../includes/navbar.php"; ?>
                </div>
                <div class="body__detail__container">
                    <div class="dashboard__header__section">
                        <img src="../assets/images/dashboard_menu.png" alt="">
                        <div class="dashboard__section__sub__header">
                            <div style="width:100%; display:flex; gap: 5px;">
                                <h1>Welcome</h1>
                                <input type="hidden" name="username" id="username" value="<?php
                                if (isset($_SESSION['username']))
                                    echo $_SESSION['username']; ?>">
                                <?php
                                if (isset($_SESSION['username']))
                                    echo '<h1 class="user-credentials">' . $_SESSION['username'] . '</h1>';
                                ?>
                            </div>
                            <h2>Dashboard</h2>
                        </div>
                    </div>
                    <!-- <div class="charts">
                            <canvas id="sales-data" width="400" height="200"></canvas>
                            <canvas id="inventory-data" width="400" height="200"></canvas>
                            <canvas id="purchase-data" width="400" height="200"></canvas>
                            <canvas id="customer-data" width="400" height="200"></canvas>
                            <canvas id="prescription-data" width="400" height="200"></canvas>
                            <canvas id="operation-data" width="400" height="200"></canvas>
                        </div> -->
                    <div style="width:100%; height:100%; padding:20px;">
                        <div class="body__information">
                            <div class="body__information__details" id="expense">
                                <div class="design"></div>
                                <div class="customer__section">
                                    <img src="../assets/images/expense_dash.png" alt="">
                                    <span class="total-expense"></span>
                                </div>
                                <p>Total Expenses</p>
                            </div>
                            <div class="body__information__details" id="revenue">
                                <div class="design"></div>
                                <div class="revenue__section">
                                    <img src="../assets/images/revenue.png" alt="">
                                    <span class="revenue-value"></span>
                                </div>
                                <p>Expected Revenue</p>
                            </div>
                            <div class="body__information__details" id="total-medicine">
                                <div class="design"></div>
                                <div class="medicine__section">
                                    <img src="../assets/images/profit.png" alt="">
                                    <span class="profit"></span>
                                </div>
                                <p>Total Profit</p>
                            </div>
                            <div class="body__information__details" id="low-stock">
                                <div class="design"></div>
                                <div class="stock__section">
                                    <img src="../assets/images/low.png" alt="">
                                    <span class="low-stock"></span>
                                </div>
                                <p>Running low on Stock</p>
                            </div>
                            <div class="body__information__details" id="purchases">
                                <div class="design"></div>
                                <div class="expired__section">
                                    <img src="../assets/images/expired.png" alt="">
                                    <span class="purchases">589</span>
                                </div>
                                <p>Total Purchases</p>
                            </div>
                            <div class="navigators">
                                <a class="navigator-item" href="../pages/add-invoice.php">
                                    <span>
                                        <img src="../assets/images/invoice-dark.png" alt="">
                                        Create New Invoice
                                    </span>
                                </a>
                                <a class="navigator-item" href="../pages/add-product.php">
                                    <span>
                                        <img src="../assets/images/product-black.png" alt="">
                                        Add Product
                                    </span>
                                </a>
                                <a class="navigator-item" href="../pages/sales-report.php">
                                    <span>
                                        <img src="../assets/images/sales-report.png" alt="">
                                        Sales Report
                                    </span>
                                </a>
                                <a class="navigator-item" href="../pages/purchase-report.php">
                                    <span>
                                        <img src="../assets/images/purchase-report.png" alt="">
                                        Purchase Report
                                    </span>
                                </a>
                            </div>
                        </div>
                        <div class="body__information__section">
                            <div
                                style="display: flex; flex-direction: row; width:100%; gap:20px; justify-content: space-between;">
                                <div class="chart__information">
                                    <canvas id="sales-chart"></canvas>
                                </div>
                                <div class="table__information">
                                    <div class="table-container">
                                        <div style="width: 100%;">
                                            <h2 class="table-title">Todays report</h2>
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <td>Todays Report</td>
                                                        <td>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="font-weight: 600">Total Sales</td>
                                                        <td id="today-sales"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:600">Total Purchase</td>
                                                        <td id="today-purchase"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:600">Total Expense</td>
                                                        <td id="today-expense"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="piechart" style="width: 100%; height:50%,background-color: #fff;">
                                        <h1>GRAPH REPORT</h1>
                                        <canvas id="report-chart" width="300" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="table__information__sales__activities">
                                <div class="table__activities__sales">
                                    <h1>Recent Activities</h1>
                                    <table id="itemTable">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Activity</th>
                                                <th>User</th>
                                            </tr>
                                        </thead>
                                        <tbody class="activity__body">
                                        </tbody>
                                    </table>
                                    <div class="pagination">
                                        <button id="prevBtn" class="activity-prevBtn"
                                            style="width: 3rem; height: 30px; font-size: 0.6em; ">PREV</button>
                                        <span id="activity-currentPage"></span>
                                        <button id="nextBtn" class="activity-nextBtn"
                                            style="width: 3rem; height: 30px; font-size: 0.6em;;">NEXT</button>
                                    </div>
                                </div>
                                <div class="table__activities__sales">
                                    <h1>Recent Sales</h1>
                                    <table id="itemTable">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Invoice Number</th>
                                                <th>Sub Total</th>
                                                <th>Total Profit</th>
                                                <th>Payment Mode</th>
                                                <th>Amount Paid</th>
                                                <th>Change</th>
                                            </tr>
                                        </thead>
                                        <tbody class="sales__body">
                                        </tbody>
                                    </table>
                                    <div class="pagination">
                                        <button id="prevBtn" class="sales-prevBtn"
                                            style="width: 3rem; height: 30px; font-size: 0.6em; ">PREV</button>
                                        <span id="sales__currentPage"></span>
                                        <button id="nextBtn" class="sales-nextBtn"
                                            style="width: 3rem; height: 30px; font-size: 0.6em;">NEXT</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer"
                style="width:100%; height: 100%; position: :fixed; bottom: 0;background-color: #fff; z-index:1;">
                fgfdgfdsgfd
            </div>
        </div>
    </div>

</div>
<script src="../utils/some-functions.js"></script>
<script src="../assets/js/Chart.js"></script>
<!-- <script src="../assets/js/customized__chart.js"></script> -->
<script src="../assets/js/dashboard.js"></script>
<script>
    let activityCurrentPage = 1;
    let salesCurrentPage = 1;
    let activityMaxPage = 1;
    let salesMaxPage = 1;

    // Fetch today's activities
    async function fetchRecentActivities(page) {
        const response = await fetch(`../php/activities.script.php?page=${page}`, {
            headers: {
                'Service': "getRecentActivities"
            }
        });

        const data = await response.json();
        console.log(data);

        if (data.success && data.activities.length > 0) {
            const activityBody = document.querySelector(".activity__body");
            activityBody.innerHTML = ""; // Clear previous data before appending new rows
            console.log({ data })
            data.activities.forEach((item) => {
                const tr = document.createElement("tr");
                const date = new Date(item.date).toDateString();
                const newRecord = `
                <td>${date}</td>
                <td>${item.activity}</td>
                <td>${item.username}</td>
            `;
                tr.innerHTML = newRecord;
                activityBody.appendChild(tr);
            });
        }

        activityMaxPage = Math.ceil(data.total_items / data.items_per_page);
        document.querySelector("#activity-currentPage").innerHTML = `Page ${data.current_page} of ${activityMaxPage}`;
        document.querySelector(".activity-prevBtn").disabled = data.current_page === 1;
        document.querySelector(".activity-nextBtn").disabled = data.current_page === activityMaxPage;
    }

    // Fetch today's sales
    async function fetchRecentSales(page) {
        const response = await fetch(`../php/invoice.script.php?page=${page}`, {
            headers: {
                'Service': "getRecentSales"
            }
        });

        const data = await response.json();
        console.log(data);

        if (data.success && data.todaySales.length > 0) {
            const salesBody = document.querySelector(".sales__body");
            salesBody.innerHTML = ""; // Clear previous data before appending new rows

            data.todaySales.forEach((item) => {
                const tr = document.createElement("tr");
                const date = new Date(item.dateofsale).toDateString();
                const newRecord = `
                <td class="purchase-date">${date}</td>
                <td>${item.invoicenumber}</td>
                <td>GHS ${parseFloat(item.subtotal).toFixed(2)}</td>
                <td>GHS ${parseFloat(item.totalprofit).toFixed(2)}</td>
                <td>${item.paymentmode}</td>
                <td>GHS ${parseFloat(item.amountpaid).toFixed(2)}</td>
                <td>GHS ${parseFloat(item.balance).toFixed(2)}</td>
            `;
                tr.innerHTML = newRecord;
                salesBody.appendChild(tr);
            });
        }

        salesMaxPage = Math.ceil(data.total_items / data.items_per_page);
        document.querySelector("#sales__currentPage").innerHTML = `Page ${data.current_page} of ${salesMaxPage}`;
        document.querySelector(".sales-prevBtn").disabled = data.current_page === 1;
        document.querySelector(".sales-nextBtn").disabled = data.current_page === salesMaxPage;
    }

    // Set up event listeners once
    document.querySelector(".activity-prevBtn").addEventListener("click", () => {
        if (activityCurrentPage > 1) {
            activityCurrentPage--;
            fetchRecentActivities(activityCurrentPage);
        }
    });

    document.querySelector(".activity-nextBtn").addEventListener("click", () => {
        if (activityCurrentPage < activityMaxPage) {
            activityCurrentPage++;
            fetchRecentActivities(activityCurrentPage);
        }
    });

    document.querySelector(".sales-prevBtn").addEventListener("click", () => {
        if (salesCurrentPage > 1) {
            salesCurrentPage--;
            fetchRecentSales(salesCurrentPage);
        }
    });

    document.querySelector(".sales-nextBtn").addEventListener("click", () => {
        if (salesCurrentPage < salesMaxPage) {
            salesCurrentPage++;
            fetchRecentSales(salesCurrentPage);
        }
    });

    // Initial fetch on page load
    fetchRecentActivities(activityCurrentPage);
    fetchRecentSales(salesCurrentPage);



</script>
<?php
include '../includes/footer.php';
?>