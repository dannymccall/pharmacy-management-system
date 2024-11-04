<?php
include '../includes/header.php';
?>
<link rel="stylesheet" href="../assets/fonts/fonts.css">
<link rel="stylesheet" href="../assets/css/unit.style.css">
<link rel="stylesheet" href="../assets/css/add-medicine.style.css">


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
                <div class="unit__header" style="gap:20px;">
                    <img src="../assets/images/sale.png" alt="Medicine Image">
                    <div class="unit__sub__header">
                        <h1>Invoice</h1>
                        <h2>invoice / <span>add invoice</span></h2>
                    </div>
                </div>

                <div class="form">
                    <h1>New Invoice</h1>
                    <p class="error"></p>
                    <form action="" id="purchaseForm" class="form-flex">

                        <div class="form-input">
                            <label for="date">Invoice Date</label>
                            <input type="date" name="invoice-date" style="width: 65%;" id="medicine-name">
                        </div>
                        <div class="form-input">
                            <label for="date">Payment Mode</label>
                            <select name="paymentMode" id="paymentMode">
                                <option value="">---Select payment mode---</option>
                                <option value="momo">Mobile Money</option>
                                <option value="cash">Cash</option>
                            </select>
                        </div>

                        <!-- <div class="form-input">
                         
                            <select name="category" id="category">
                                <option value="">Select category</option>
                            </select>
                        </div> -->
                        <div class="form">
                            <h1>Add a New Invoice</h1>
                            <div class="table-container">
                                <table id="myTable">
                                    <thead>
                                        <tr>
                                            <th>Item Information</th>
                                            <th>Unit</th>
                                            <th>Category</th>
                                            <th>Unit Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table__body" id="myTable">
                                        <tr>
                                            <td>
                                                <select class="item-select">
                                                    <option value="">Select Item</option>
                                                </select>
                                            </td>
                                            <td> <input type="text" readonly name="unit" placeholder="Unit" id="unit"
                                                    class="unit"></td>
                                            <td> <input type="text" name="bach-id" placeholder="Bach ID" id="bach-id"
                                                    readonly class="bach-id">
                                            </td>
                                            <td> <input type="number" step="any" name="unit-price"
                                                    placeholder="Unit price" id="" class="unit-price" readonly></td>
                                            <td> <input type="number" name="quantity" placeholder="Quantity"
                                                    id="quanity" class="quantity">
                                            </td>

                                            <td> <input type="number" step="any" name="total" id="total" class="total"
                                                    readonly placeholder="Total"></td>
                                            <td>
                                                <button type="button" style="width: 6rem; background: #fa382a;"
                                                    class="delete-btn">Delete</button>
                                            </td>

                                        </tr>


                                    </tbody>
                                </table>
                                <div class="form-input"
                                    style="display: flex; flex-direction: row; align-items:center; justify-content: space-between;"
                                    id="calculation-div">
                                    <div class="calculation" style="background: #BDBDBD">
                                        <button type="button"
                                            style="background: #6D6E70; font-size: 0.9em; width: 8rem; border-radius: 3px;"
                                            class="add-new-item">Add New Item</button>
                                        <p class="sub__total">Sub total: <span></span></p>
                                    </div>
                                    <div class="checkout">
                                        <div class="checkout__header">
                                            <h1>Checkout</h1>
                                        </div>
                                        <div style="padding:7px;">
                                            <div class="grand-total">
                                                <p>Grand Total</p>
                                                <p class="total-amount">0.00</p>
                                            </div>
                                            <div class="amount-paid">
                                                <p>Paid</p>
                                                <input type="number" name="paid" id="paid" step="any">
                                            </div>
                                            <div class="balance">
                                                <p>Change</p>
                                                <p class="change"></p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <p class="error">gfhgfd</p>

                        <div class="form-input">
                            <button type="submit">Submit</button>
                        </div>

                        <div class="form-input">
                            <div class="loader__div" style="display:none;">
                                <?php include '../components/loader.php'; ?>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-container" id="printInvoice" style="display:none;">
                    <div class="wisvee-pharmacy"
                        style="    margin: auto;text-align: center;display: flex;flex-direction: column;gap: 5px;">
                        <h2 style="font-family: 'Courier New', Courier, monospace;font-size: 1em;">WISVEE PHARMACY</h2>
                        <h2 style="font-family: 'Courier New', Courier, monospace;font-size: 1em;">Ajaasco Top</h2>
                        <p style="font-family: Arial, Helvetica, sans-serif;font-size: 0.9em;">Email:
                            <span>viviankudatsi@yahoo.com</span>
                        </p>
                        <p style="font-family: Arial, Helvetica, sans-serif;font-size: 0.9em;">Tel: <span
                                style=" color: #1f65c0;">0248744219 / 0269465943</span></p>
                        <p
                            style="margin-bottom: 18px; font-weight: 600;font-family: Arial, Helvetica, sans-serif;font-size: 0.9em;">
                            ---Sales Invoice---</p>
                    </div>
                    <table id="printInvoiceTable" style="width: 30%; margin:auto;" class="printInvoiceTable">

                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>QTY</th>
                                <th>Units</th>
                                <th>Rate</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody class="table__body" id="invoice-quantity">

                        </tbody>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Invoice No</th>
                                <th>Sub Total</th>
                                <th>Amount Paid</th>
                                <th>Change</th>
                            </tr>
                        </thead>
                        <tbody class="table__body" id="invoice-details">

                        </tbody>

                    </table>
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
<script src="../assets/js/add-invoice.js"></script>

<?php
include '../includes/footer.php';
?>