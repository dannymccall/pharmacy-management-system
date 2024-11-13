<?php include '../includes/auth.php' ?>


<?php
include '../includes/header.php';
?>

<link rel="stylesheet" href="../assets/fonts/fonts.css">
<link rel="stylesheet" href="../assets/css/unit.style.css">
<link rel="stylesheet" href="../assets/css/add-medicine.style.css">
<link rel="stylesheet" href="../assets/css/report.generation.css">
<link rel="icon" href="../assets/images/logo2.png" type="image/png">

<style>

</style>
<?php


include '../includes/header__rest.php';
?>

<div class="container">
    <div class="section">
        <div class="sidebar__section">
            <?php include '../includes/sidebar.php'; ?>
        </div>
        <div class="body__section">
            <div class="body__header__section">
                <?php include "../includes/navbar.php"; ?>
            </div>
            <div class="body__detail__container">
                <div class="unit__header">
                    <img src="../assets/images/search_dash.png" alt="Medicine Image">
                    <div class="unit__sub__header">
                        <h1><?= $navigationHeader ?></h1>
                        <h2><?= $navigator ?> <span><?= $sub_navigator ?></span></h2>
                    </div>
                </div>
                <input type="hidden" name="searchType" id="searchType" value="<?= $searchKind ?>">
                <div class="form">
                    <div style="display: flex; flex-direction: row; justify-content: space-between;;">
                        <h1 class="header" style="width: 100%;">-----<?= $header ?>-----</h1>
                        <button class="new-search" style="display: none;">New Search</button>
                    </div>
                    <p class="error" style="color:red; width: 30%; align-self: flex-start; font-size: 0.8em;">
                        jdhfjdksf</p>
                    <div class="search-form">
                        <div class="form-input">
                            <label for="medicine-name"><?= $keyword ?></label>
                            <input type="text" name="searchInput" id="searchInput"
                                style="width: 50%; font-size: 0.9em; border: 2px solid #e6e6e6;"
                                placeholder="Please enter an invoice ID...">
                        </div>
                        <div class="form-input">
                            <button type="button" onclick="search()">Search...</button>
                        </div>

                    </div>

                    <div class="circular-motion-container" style="display: none;">
                        <div class="animated-element box1"></div>
                    </div>
                    <div class="table-container" id="table-container" style="display: none;">
                        <div class="wisvee-pharmacy"
                            style="    margin: auto;text-align: center;display: flex;flex-direction: column;gap: 10px;">
                            <img src="../assets/images/logo2.png" alt="" srcset=""
                                style="width: 100px; height: 100px; margin: auto;">
                            <h2 style="font-family: 'Courier New', Courier, monospace;font-size: 2em;">WISVEE PHARMACY
                            </h2>
                            <p style="font-family: Arial, Helvetica, sans-serif;font-size: 0.9em;">Email:
                                <span>viviankudatsi@yahoo.com</span>
                            </p>
                            <p style="font-family: Arial, Helvetica, sans-serif;font-size: 0.9em;">Tel: <span
                                    style=" color: #1f65c0;">0248744219 / 0269465943</span></p>
                            <p
                                style="margin-bottom: 18px; font-weight: 600;font-family: Arial, Helvetica, sans-serif;font-size: 0.9em;">
                                ----<?= $searchType ?>----</p>
                        </div>
                        <table id="itemTable" style="margin-bottom: 20px;" class="summary-table">
                            <p style="margin-bottom: 25px; font-weight: 600; font-family: Arial, Helvetica, sans-serif;"
                                class="summary_paragraph">
                                Summary</p>
                            <thead id="summary-head">
                                <?php if ($searchKind === 'searchInvoice') { ?>
                                    <tr>
                                        <th>Invoice Date</th>
                                        <th>Action Taker</th>
                                        <th>Sub Total</th>
                                        <th>Total Profit</th>
                                        <th>Invoice ID</th>
                                        <th>Payment Mode</th>
                                    </tr>
                                <?php } else if ($searchKind === 'searchMedicine') { ?>
                                        <tr>
                                            <th>Medicine Name</th>
                                            <th>Medicine Category</th>
                                            <th>Medicine Unit</th>
                                            <th> Unit Cost Price</th>
                                            <th> Unit Selling Price</th>
                                            <th> Quantity</th>
                                            <th> Qty Sold</th>
                                            <th> Collected Quantity</th>
                                            <th> Images</th>
                                        </tr>
                                <?php } else if ($searchKind === 'searchUser') { ?>
                                            <tr>
                                                <th>Frist name</th>
                                                <th>Middle name</th>
                                                <th>Last name</th>
                                                <th>Username</th>
                                                <th>Role</th>
                                                <th>Image</th>
                                            </tr>
                                <?php } ?>
                            </thead>
                            <tbody class="table__body" id="summary-body">

                            </tbody>
                        </table>
                        <table id="itemTable" class="details-table">
                            <thead id="details-head">
                                <?php if ($searchKind === 'searchInvoice') { ?>
                                    <p style="margin-bottom: 18px; font-weight: 600; font-family: Arial, Helvetica, sans-serif;"
                                        class="details_paragraph">
                                        Details</p>
                                    <tr>
                                        <th>Invoice Date</th>
                                        <th>Item information</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                    </tr>
                                <?php } else if ($searchKind === 'searchUser') { ?>
                                        <p style="margin-bottom: 18px; font-weight: 600; font-family: Arial, Helvetica, sans-serif;"
                                            class="details_paragraph">
                                            Activities</p>
                                        <tr>
                                            <th>Date</th>
                                            <th>Username</th>
                                            <th>Activity</th>
                                        </tr>

                                <?php } ?>
                            </thead>
                            <tbody class="table__body" id="details-body">

                            </tbody>
                        </table>
                        <?php if ($searchKind === 'searchInvoice') { ?>
                            <div class="report-summary"
                                style="background: #F2F2F2;   width: 15rem;margin-top: 15px;osition: relative;">
                                <p class="report-header">Report Summary</p>

                                <!-- <p style="margin-bottom: 18px; font-weight: 600; font-family: Arial, Helvetica, sans-serif;"
                                class="details_paragraph">
                                Details</p> -->
                                <?php if ($searchKind === 'searchInvoice' || $searchKind === 'purchaseReport') { ?>
                                    <div class="summary-details">
                                        <div>
                                            <p id="total-quantity">Total Quantity</p>
                                            <span class="quantity-span"></span>

                                        </div>
                                        <div class="grand-total">
                                            <p id="grand-total">Grand Total</p>
                                            <span class="total-span"></span>

                                        </div>
                                    </div>

                                <?php } else if ($searchKind === 'expenseReport') { ?>
                                        <div class="summary-details">
                                            <div>
                                                <p id="grand-total">Grand Total</p>
                                                <span class="expense-total-span"></span>

                                            </div>
                                        </div>
                                <?php } ?>
                            </div>
                            <button class="printBtn" style="border-radius: 3px; margin: 20px 0 30px 0">Print</button>
                        <?php } ?>
                        <div class="page-break"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="footer">
    </div>
</div>

<script src="../utils/some-functions.js"></script>
<script src="../utils/make-request.js"></script>
<script src="../assets/js/sweetalert.min.js"></script>
<script src="../assets/js/add-medicine.js"></script>

<?php
include '../includes/footer.php';
?>