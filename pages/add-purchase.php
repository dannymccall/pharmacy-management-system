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
                    <img src="../assets/images/purchase-dash.png" alt="Medicine Image">
                    <div class="unit__sub__header">
                        <h1>Purchase</h1>
                        <h2>purchase / <span>add purchase</span></h2>
                    </div>
                </div>

                <div class="form">
                    <h1>Add Purchase</h1>
                    <p class="error"></p>
                    <form action="" id="purchaseForm" class="form-flex">

                        <div class="form-input">
                            <label for="date">Purchased Date</label>
                            <input type="date" name="purchased-date" style="width: 65%;" id="medicine-name">
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
                            <h1>Purchase Medicine</h1>
                            <div class="table-container">
                                <table id="myTable">
                                    <thead>
                                        <tr>
                                            <th>Medicine Name</th>
                                            <th>Expiry Date</th>
                                            <th>Bach ID</th>
                                            <th>Unit Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table__body">
                                        <tr>
                                            <td>
                                                <input type="text" name="medicine-name" placeholder="Medicine Name"
                                                    id="medicine-name">
                                            </td>
                                            <td> <input type="date" name="date" placeholder="Date" id="date"></td>
                                            <td> <input type="text" name="bach-id" placeholder="Batch ID" id="bach-id">
                                            </td>
                                            <td> <input type="number" step="any" name="unit-price"
                                                    placeholder="Unit price" id="unit-price" class="unit-price"></td>
                                            <td> <input type="number" name="quantity" placeholder="Quantity"
                                                    id="quantity" class="quantity">
                                            </td>

                                            <td> <input type="number" step="any" name="total" placeholder="Total" id="total" class="total" readonly></td>
                                            <td>
                                                <button type="button" style="width: 6rem; background: #fa382a;"
                                                    class="delete-btn">Delete</button>
                                            </td>

                                        </tr>
                                      

                                    </tbody>
                                </table>
                                <div class="form-input" style="display: flex; flex-direction: row; align-items:center; gap: 15px;">
                                    <button type="button" style="background: #2acdfa; font-size: 0.9em; width: 8rem;"
                                        class="add-new-item">Add New
                                        Item</button>
                                        <p class="sub__total">Sub total: <span></span></p>
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

            </div>
        </div>
    </div>
    <div class="footer">
    </div>
</div>

<script src="../utils/some-functions.js"></script>
<script src="../utils/make-request.js"></script>
<script src="../assets/js/sweetalert.min.js"></script>
<script src="../assets/js/add-purchase.js"></script>

<?php
include '../includes/footer.php';
?>