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
                            <h1>Purchase</h1>
                            <h2>purchase / <span>manage-purchase</span></h2>
                        </div>

                    </div>
                    <a href="../pages/add-purchase.php" class="add__new__unit" style="border-radius: 2px;">
                        Add new purchase
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
                    <h1>Purchase List</h1>
                    <p class="error">gfhgfd</p>
                    <div class="table-container">
                        <table id="itemTable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Sub Total</th>
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
                                style="width: 3rem; height: 30px; font-size: 0.6em; ">NEXT</button>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <div class="modal" style="z-index:1;">
        <div class="form" style="width: 70%; height:82%;">
            <h1>Edit Purchase</h1>
            <p class="error"></p>
            <form action="" id="medicineForm" class="form-flex">

                <div class="form-input">
                    <label for="medicine-name">Medicine Name</label>
                    <input type="text" name="medicine-name" id="medicine-name">
                </div>



                <div class="form-input">
                    <label for="quantity">Quantity</label>
                    <input type="number" step="any" name="qty" id="qty" />
                </div>

                <div class="form-input">
                    <label for="unit-price">Unit Price</label>
                    <input type="number" step="any" name="unit-price" id="unit-price" />
                </div>
                <div class="form-input">
                    <label for="cost-price">Total</label>
                    <input type="number" step="any" name="total" id="total" />
                </div>
                <div class="form-input">
                    <label for="sellingprice">Purchase Date</label>
                    <input type="date" step="any" name="date" id="date" />
                </div>
                <div class="form-input">
                    <label for="quantity">Batch ID</label>
                    <input type="text" name="batch-id" id="batch-id">
                </div>
                <input type="hidden" name="" id="hidden">

                <div class="form-input">
                    <button type="submit" class="update-button" id="update-button-purchase"
                        style="font-size: 0.7em; width: 5rem; border-radius:0px;">Update </button>
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
        <div class="form" style="width: 70%; height:83%;">
            <h1 style="font-weight: 600; font-size:1.2em">Insert new item purchase</h1>
            <p class="error" style="text-align: center; margin: auto;"></p>
            <form action="" id="medicineForm" class="form-flex">

                <div class="form-input">
                    <label for="medicine-name">Medicine Name</label>
                    <input type="text" name="new-item-medicine-name" id="new-item-medicine-name">
                </div>



                <div class="form-input">
                    <label for="quantity">Quantity</label>
                    <input type="number" step="any" name="new-qty" id="new-qty" />
                </div>

                <div class="form-input">
                    <label for="unit-price">Unit Price</label>
                    <input type="number" step="any" name="new-unit-price" id="new-unit-price" />
                </div>
                <div class="form-input">
                    <label for="cost-price">Total</label>
                    <input type="number" step="any" name="new-total" id="new-total" />
                </div>
                <div class="form-input">
                    <label for="sellingprice">Purchase Date</label>
                    <input type="date" step="any" name="new-date" id="new-date" />
                </div>
                <div class="form-input">
                    <label for="batchId">Batch ID</label>
                    <input type="text" name="new-batch-id" id="new-batch-id">
                </div>
                <input type="hidden" name="" id="new-hidden">

                <div class="form-input">
                    <button type="submit" class="update-button" id="new-add-button-purchase">Add Item </button>
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
                <h1>Purchase Details</h1>
                <button class="add-new-item">Insert Item</button>
            </div>
            <p class="error"></p>
            <div class="table-container">
                <table id="itemTable">
                    <thead>
                        <tr>
                            <th>Medicine Name</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                            <th>Batch ID</th>
                            <th>Purchase Date</th>
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
<script src="../assets/js/fetch-purchase.js" defer></script>

<?php
include '../includes/footer.php';
?>