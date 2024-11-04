<?php
include '../includes/header.php'
    ?>
<link rel="stylesheet" href="../assets/css/unit.style.css">
<link rel="stylesheet" href="../assets/css/add-medicine.style.css">

<link rel="stylesheet" href="../assets/css/index.css">
<?php
include '../includes/header__rest.php';
?>

<div class="container">
    <div class="section">
        <div class="sidebar__section">
            <?php include '../includes/sidebar.php' ?>
        </div>
        <div class="body__section">
            <div class="body__header__section">
                <?php include "../includes/navbar.php"; ?>
            </div>
            <div class="body__detail__container">
                <div class="dashboard__header__section">
                    <img src="../assets/images/category-page.png" alt="">
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
                            <div class="design" style="background: #12618f;"></div>
                            <div class="customer__section">
                                <img src="../assets/images/expense_dash.png" alt="">
                                <span class="total-expense"></span>
                            </div>
                            <p>Total Expenses</p>
                        </div>
                        <div class="body__information__details" id="revenue">
                            <div class="design" style="background: rgb(31, 197, 16);"></div>
                            <div class="revenue__section">
                                <img src="../assets/images/revenue.png" alt="">
                                <span class="revenue-value"></span>
                            </div>
                            <p>Expected Revenue</p>
                        </div>
                        <div class="body__information__details" id="total-medicine">
                            <div class="design" style="background: #4A89DC"></div>
                            <div class="medicine__section">
                                <img src="../assets/images/medicine-color.png" alt="">
                                <span class="profit"></span>
                            </div>
                            <p>Total Profit</p>
                        </div>
                        <div class="body__information__details" id="low-stock">
                            <div class="design" style="background: #dfe94f
                                "></div>
                            <div class="stock__section">
                                <img src="../assets/images/low.png" alt="">
                                <span class="low-stock"></span>
                            </div>
                            <p>Running low on Stock</p>
                        </div>
                        <div class="body__information__details" id="purchases">
                            <div class="design" style="background: #ee2121"></div>
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
                            <a class="navigator-item" href="../pages/add-medicine.php">
                                <span>
                                    <img src="../assets/images/medicine-color.png" alt="">

                                    Add Medicine
                                </span>
                            </a>


                            <a class="navigator-item" href="../pages/sales-report.php">
                                <span>
                                    <img src="../assets/images/sales-report.png" alt="">

                                    Sales Report
                                </span>
                            </a>

                            <a class="navigator-item" href="../purchase-report.php">
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
                                    <div style="width: 100%, height:100%">
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
                                                    <td id="today-sales">29</td>

                                                </tr>
                                                <tr>
                                                    <td style="font-weight:600">Total Purchase</td>
                                                    <td></td>
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
                                <table id="itemTable" >
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
                                    <button id="prevBtn" disabled class="activity-prevBtn"
                                        style="width: 3rem; height: 30px; font-size: 0.6em; background: #1c67c9;">PREV</button>
                                    <span id="activity-currentPage"></span>
                                    <button id="nextBtn" class="activity-nextBtn"
                                        style="width: 3rem; height: 30px; font-size: 0.6em; background: #1c67c9;">NEXT</button>
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
                                    <button id="prevBtn" disabled class="sales-prevBtn"
                                        style="width: 3rem; height: 30px; font-size: 0.6em; background: #1c67c9;">PREV</button>
                                    <span id="currentPage"></span>
                                    <button id="nextBtn" class="sales-nextBtn"
                                        style="width: 3rem; height: 30px; font-size: 0.6em; background: #1c67c9;">NEXT</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">

    </div>
</div>
<script src="../assets/js/Chart.js"></script>
<script src="../utils/some-functions.js"></script>
<!-- <script src="../assets/js/customized__chart.js"></script> -->
<script src="../assets/js/dashboard.js"></script>
<?php
include '../includes/footer.php';
?>