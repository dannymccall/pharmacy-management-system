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
<div class="container" style="position: absolute;">
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
                            <h1>Invoices</h1>
                            <h2>invoice / <span>manage-invoice</span></h2>
                        </div>

                    </div>
                    <div class="search-container">
                        <input type="text" id="searchQuery" class="search-input" placeholder="Search Medicines">
                        <button id="searchBtn" class="search-button">
                            <img src="../assets/images/search-product.png" style="width:20px; height:20px;"  alt=""> <!-- Font Awesome Search Icon -->
                        </button>
                    </div>
                    <a href="../pages/add-invoice.php" class="add__new__unit" style="font-size: 0.8em; width: 14rem; border-radius:2px;">
                        Add new invoice
                    </a>
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
                    <h1>Invoice List</h1>
                    <p class="error">gfhgfd</p>
                    <div class="table-container">
                        <table id="itemTable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Invoice ID</th>
                                    <th>Sub Total</th>
                                    <th>Total Profit</th>
                                    <th>Amount Paid</th>
                                    <th>Change</th>
                                    <th>Payment Mode</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="table__body">

                            </tbody>
                        </table>
                        <div class="pagination">
                            <button id="prevBtn" 
                                style="width: 3rem; height: 30px; font-size: 0.6em;">PREV</button>
                            <span id="currentPage"></span>
                            <button id="nextBtn"
                                style="width: 3rem; height: 30px; font-size: 0.6em;">NEXT</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" style="z-index:1;">
        <div class="form" style="width: 70%; height:70%;">
            <h1>Edit Invoice</h1>
            <p class="error"></p>
            <form action="" id="medicineForm" class="form-flex">

                <div class="form-input">
                    <label for="medicine-name">Medicine Name</label>
                    <input type="text" name="medicine-name" id="item-information">
                </div>



                <div class="form-input">
                    <label for="quantity">Quantity</label>
                    <input type="number" step="any" name="qty" id="qty" />
                </div>

                <div class="form-input">
                    <label for="unit-price">Unit Price</label>
                    <input type="number" step="any" name="unit-price" readonly id="unit-price" />
                </div>
                <div class="form-input">
                    <label for="cost-price">Total</label>
                    <input type="number" step="any" name="total" readonly id="total" />
                </div>
              

                <div class="form-input">
                    <button type="submit" class="update-button" id="update-button-purchase" style="font-size: 0.7em; width: 5rem; border-radius:0px;">Update</button>
                </div>

                <input type="hidden" name="" value="" id="productId">
                <div class="button-section">
                    <div class="loader__div" style="display:none;">
                        <?php include '../components/loader.php'; ?>
                    </div>
                </div>
            </form>
        </div>
        <div class="close" id="close-edit-form-modal">
            <span>x</span>
        </div>
    </div>
    <div class="add-item-modal" style="z-index:1;">
        <div class="form add-new-form" style="width: 70%; height:73%;">
            <h1 style="font-weight: 600; font-size:1.2em">Insert new item invoice</h1>
            <p class="error" style="text-align: center; margin: auto;"></p>
            <form action="" id="medicineForm" class="form-flex">

                <div class="form-input">
                    <label for="medicine-name">Medicine Name</label>
                    <!-- <input type="text" name="new-item-medicine-name" id="new-item-medicine-name"> -->
                    <select name="select-item-information" id="item-information">
                        <option value="">Item information</option>
                    </select>
                </div>
                <div class="form-input">
                    <label for="quantity">Quantity</label>
                    <input type="number" step="any" name="new-qty" id="new-qty" />
                    <input type="hidden" step="any" name="old-quantity" id="old-quantity" />
                </div>

                <div class="form-input">
                    <label for="unit-price">Unit Price</label>
                    <input type="number" step="any" name="new-unit-price" id="new-unit-price" />
                </div>
                <div class="form-input">
                    <label for="cost-price">Total</label>
                    <input type="number" step="any" name="new-total"  id="new-total" readonly/>
                </div>
                <div class="form-input">
                    <label for="sellingprice">Medicine Category</label>
                    <input type="text" step="any" name="new-date" id="new-date" readonly/>
                </div>
                <div class="form-input">
                    <label for="batchId">Medicine Unit</label>
                    <input type="text" name="new-batch-id" id="new-batch-id" readonly>
                </div>
                <input type="hidden" name="" id="new-hidden">

                <div class="form-input">
                    <button type="submit" class="update-button" id="new-add-button-purchase">Add Item</button>
                </div>

                <input type="hidden" name="" value="" id="productId">
                <div class="button-section">
                    <div class="loader__div" style="display:none;">
                        <?php include '../components/loader.php'; ?>
                    </div>
                </div>
            </form>
        </div>
        <div class="close">
            <span>x</span>
        </div>
    </div>
    <div class="view-modal">
        <div class="form" style="width: 70%; height:70%;">
            <div style="display: flex; flex-direction: row; justify-content:space-between; align-items:center;">
                <h1>Invoice Details</h1>
                <p class="error" style="text-align: center; margin: auto;"></p>
                <button class="add-new-item">Insert Item</button>
            </div>
            <p class="error"></p>
            <div class="table-container">
                <table id="itemTable">
                    <thead>
                        <tr>
                            <th>Item Information</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table__body">

                    </tbody>
                </table>
                <div class="calculation">
                    <div class="calculation__details">
                        <h2>Sub Total:
                            <span class="total__span"></span>
                        </h2>
                    </div>
                    <div class="calculation__details">
                        <h2>Total Quantity:
                            <span class="quantity__span">
                            </span>
                        </h2>

                    </div>
                </div>
            </div>

        </div>
        <div class="close">
            <span>x</span>
        </div>
    </div>
    <div class="footer">

    </div>
</div>
<!-- <script src="../utils/make-request.js"></script> -->
<!-- <script src="../assets/js/add-unit.js"></script> -->
<script src="../utils/some-functions.js" defer></script>
<script src="../assets/js/sweetalert.min.js" defer></script>
<script src="../assets/js/fetch-invoices.js" defer></script>

<?php
include '../includes/footer.php';
?>