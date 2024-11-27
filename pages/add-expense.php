<?php include '../includes/auth.php' ?>


<?php
include '../includes/header.php';
?>
<link rel="stylesheet" href="../assets/fonts/fonts.css">
<link rel="stylesheet" href="../assets/css/unit.style.css">
<link rel="stylesheet" href="../assets/css/add-medicine.style.css">

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
                <?php include "../includes/navbar.php"; ?>
            </div>
            <div class="body__detail__container">
                <div class="unit__header">
                    <div class="unit">
                        <img src="../assets/images/unit.png" alt="">
                        <div class="unit__sub__header">
                            <h1>Expense</h1>
                            <h2>expense / <span>add-expense</span></h2>
                        </div>

                    </div>
                    <a href="../pages/view.expense.php" class="add__new__unit" style="width: 10rem; border-radius:2px;">
                        Manage Expense
                    </a>
                </div>

                <div class="form">
                    <h1>Add New Expense</h1>
                    <p class="error"></p>
                    <form action="" id="expenseForm" class="form-flex">

                        <div class="form-input">
                            <label for="expense-date">Expense Date</label>
                            <input type="date" name="expense-date" id="expense-date">
                        </div>

                        <div class="form-input">
                            <label for="expense-category">Expense Category</label>
                            <select name="expense-category" id="expense-category">
                                <option value="">Select category</option>
                            </select>
                            <button class="add-category-btn" type="button"
                                style="display:flex; flex-direction:row; align-items:center; gap:3px; left:5px;">
                                <img src="../assets/images/add-blue.png" alt="">
                                Add New Expense Category
                            </button>
                        </div>
                        <div class="form-input">
                            <label for="purpose">Purpose</label>
                            <input type="text" step="any" name="purpose" id="purpose" />
                        </div>
                        <div class="form-input">
                            <label for="total">Total</label>
                            <input type="number" step="any" name="total" id="total" />
                        </div>
                        <div class="form-input textarea" style="width: 79%;">
                            <label for="description">Description</label>
                            <textarea id="expenseDescription" name="description" rows="10" cols="50"
                                placeholder="Enter details of the expense..."></textarea>

                        </div>


                        <div class="form-input">
                            <button type="submit">Submit</button>
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
<script src="../assets/js/add-expense.js"></script>

<?php
include '../includes/footer.php';
?>