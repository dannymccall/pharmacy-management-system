<?php include '../includes/auth.php' ?>
<?php
include '../includes/header.php';
?>
<link rel="stylesheet" href="../assets/fonts/fonts.css">
<link rel="stylesheet" href="../assets/css/unit.style.css">
<!-- <link rel="stylesheet" href="../assets/css/add-medicine.style.css"> -->
<link rel="stylesheet" href="../assets/css/report.generation.css">
<link rel="icon" href="../assets/images/logo2.png" type="image/png">

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
                <?php
                include "../includes/navbar.php";
                ?>
            </div>
            <div class="body__detail__container">
                <div class="unit__header">
                    <img src="../assets/images/report_gen.png" alt="Medicine Image">
                    <div class="unit__sub__header">
                        <h1><?= $navigationHeader ?></h1>
                        <h2><?= $navigator ?> <span><?= $sub_navigator ?></span></h2>
                    </div>
                </div>
                <input type="hidden" name="reportType" id="reportType" value="<?= $reportKind ?>">
                <div class="form">
                    <div style="display: flex; flex-direction: row; justify-content: space-between;;">
                        <h1 class="header"><?= $header ?></h1>
                        <button class="new-report" style="display: none;">New Report</button>
                    </div>
                    <p class="error"></p>
                    <form action="" id="reportForm" class="form-flex" style="display: 100%">
                        <div class="dates">
                            <div class="form-input" id="startDateDiv">
                                <label for="startDate">Start Date</label>
                                <input type="date" name="startDate" id="startDate" style="">
                            </div>

                            <div class="form-input" id="endDateDiv">
                                <label for="endDate">End Date</label>
                                <input type="date" name="endDate" id="endDate">
                            </div>
                            <div class="form-input" id="endDateDiv">
                                <label for="endDate">Filter By</label>
                                <select name="filter-by" id="filter-by">
                                    <option value="">All</option>
                                    <option value="momo">Mobile money payment</option>
                                    <option value="cash">Cash payment</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-input">
                            <button type="submit">Generate</button>
                        </div>

                        <div class="circular-motion-container" style="display: none;">
                            <div class="animated-element box1"></div>
                        </div>
                    </form>
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
                                <?= $reportType ?>
                            </p>
                        </div>
                        <table id="itemTable" style="margin-bottom: 20px;" class="summary-table">
                            <p style="margin-bottom: 25px; font-weight: 600; font-family: Arial, Helvetica, sans-serif;"
                                class="summary_paragraph">
                                Summary</p>
                            <thead id="summary-head">
                                <?php if ($reportKind === 'salesReport') { ?>
                                    <tr>
                                        <th>Invoice Date</th>
                                        <th>Action Taker</th>
                                        <th>Sub Total</th>
                                        <th>Total Profit</th>
                                        <th>Invoice ID</th>
                                        <th>Payment Mode</th>
                                    </tr>
                                <?php } else if ($reportKind === 'purchaseReport') { ?>
                                        <tr>
                                            <th>Purchase Date</th>
                                            <th>Sub Total</th>
                                            <th>Payment Mode</th>
                                            <th>Purchase ID</th>
                                        </tr>
                                <?php } else if ($reportKind === 'expenseReport') { ?>
                                            <tr>
                                                <th>Expense Date</th>
                                                <th>Expense Category</th>
                                                <th>Purpose</th>
                                                <th>Total</th>
                                                <th>Description</th>
                                            </tr>
                                <?php } ?>
                            </thead>
                            <tbody class="table__body" id="summary-body">

                            </tbody>
                        </table>
                        <table id="itemTable" class="details-table">
                            <thead id="details-head">
                                <?php if ($reportKind === 'salesReport') { ?>
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
                                <?php } else if ($reportKind === 'purchaseReport') { ?>
                                        <p style="margin-bottom: 18px; font-weight: 600; font-family: Arial, Helvetica, sans-serif;"
                                            class="details_paragraph">
                                            Details</p>
                                        <tr>
                                            <th>Purchase Date</th>
                                            <th>Medicina Name</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                            <th>Bacth ID</th>
                                        </tr>

                                <?php } ?>
                            </thead>
                            <tbody class="table__body" id="details-body">

                            </tbody>
                        </table>
                        <div class="report-summary"
                            style="background: #F2F2F2;   width: 15rem;margin-top: 15px;osition: relative;">
                            <p class="report-header">Report Summary</p>

                            <!-- <p style="margin-bottom: 18px; font-weight: 600; font-family: Arial, Helvetica, sans-serif;"
                                class="details_paragraph">
                                Details</p> -->
                            <?php if ($reportKind === 'salesReport' || $reportKind === 'purchaseReport') { ?>
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

                            <?php } else if ($reportKind === 'expenseReport') { ?>
                                    <div class="summary-details">
                                        <div>
                                            <p id="grand-total">Grand Total</p>
                                            <span class="expense-total-span"></span>

                                        </div>
                                    </div>
                            <?php } ?>
                        </div>
                        <button class="printBtn" style="border-radius: 3px; margin: 20px 0 30px 0">Print Report</button>
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
<script src="../assets/js/report.js"></script>

<?php
include '../includes/footer.php';
?>