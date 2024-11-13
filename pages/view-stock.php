<?php include '../includes/auth.php' ?>


<?php
include '../includes/header.php'
    ?>
<link rel="icon" href="assets/images/logo.png" type="image/png">
<link rel="stylesheet" href="../assets/css/unit.style.css">
<link rel="stylesheet" href="../assets/css/add-medicine.style.css">
<link rel="icon" href="../assets/images/logo2.png" type="image/png">

<?php
include '../includes/header__rest.php';
?>
<style>

</style>
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
                <div class="unit__header">
                    <div class="unit">
                        <img src="../assets/images/unit.png" alt="">
                        <div class="unit__sub__header">
                            <h1>Stock</h1>
                            <h2>stock / <span>stock-report</span></h2>
                        </div>

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
                <div class="form">

                    <div class="stock-information">
                        <h1>All Stock</h1>
                        <div class="outOfStock">
                            <div></div>
                            <p>Running out of stock</p>
                            <div></div>
                            <p>In stock</p>
                        </div>
                    </div>
                    <p class="error">gfhgfd</p>
                    <div class="table-container">
                        <table id="itemTable">
                            <thead>
                                <tr>
                                    <th>Medicine Name</th>
                                    <th>Unit Cost Price</th>
                                    <th>Unit Selling Price</th>
                                    <th> Medicine Unit</th>
                                    <th> Medicine Category</th>
                                    <th> Unit Profit</th>
                                    <th> Qty in Stock</th>
                                    <th> Qty Sold</th>
                                    <th> Collected Quantity</th>
                                    <th> Image</th>
                                </tr>
                            </thead>
                            <tbody class="table__body">

                            </tbody>
                        </table>
                        <div class="pagination">
                            <button id="prevBtn" style="width: 3rem; height: 30px; font-size: 0.6em;">PREV</button>
                            <span id="currentPage"></span>
                            <button id="nextBtn" style="width: 3rem; height: 30px; font-size: 0.6em; ">NEXT</button>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="footer">

    </div>
</div>
<!-- <script src="../utils/make-request.js"></script> -->
<!-- <script src="../assets/js/add-unit.js"></script> -->
<script src="../utils/some-functions.js"></script>
<script src="../assets/js/sweetalert.min.js"></script>
<script src="../assets/js/fetch-stock.js"></script>

<?php
include '../includes/footer.php';
?>