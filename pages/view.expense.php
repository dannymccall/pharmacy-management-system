<?php
include '../includes/header.php'
    ?>
<link rel="icon" href="assets/images/logo.png" type="image/png">
<link rel="stylesheet" href="../assets/css/unit.style.css">
<link rel="stylesheet" href="../assets/css/add-medicine.style.css">
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
                        <img src="../assets/images/expense_dollar.png" alt="">
                        <div class="unit__sub__header">
                            <h1>Expense</h1>
                            <h2>expense / <span>manage-expense</span></h2>
                        </div>

                    </div>
                    <a href="../pages/add-expense.php" class="add__new__unit" style="border-radius: 2px; width: 10rem;">
                        Add new expense
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
                    <h1>Expense List</h1>
                    <p class="error">gfhgfd</p>
                    <div class="table-container">
                        <table id="itemTable">
                            <thead>
                                <tr>
                                    <th>Expense Date</th>
                                    <th>Expense Category</th>
                                    <th>Purpose</th>
                                    <th>Total</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="table__body">

                            </tbody>
                        </table>
                        <div class="pagination">
                            <button id="prevBtn" disabled
                                style="width: 3rem; height: 30px; font-size: 0.6em; background: #1c67c9;">PREV</button>
                            <span id="currentPage"></span>
                            <button id="nextBtn"
                                style="width: 3rem; height: 30px; font-size: 0.6em; background: #1c67c9;">NEXT</button>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <div class="user-view-modal">
        <div class="form" style="width: 70%; height:70%;">
            <h1>Edit Expense</h1>
            <p class="error" style="text-align:center; margin: 5px auto;"></p>
            <form action="" id="updateExpenseForm" class="form-flex">

                <div class="form-input">
                    <label for="expense-date">Expense Date</label>
                    <input type="date" name="expense-date" id="expense-date">
                </div>

                <div class="form-input">
                    <label for="category">Expense Category</label>
                    <select name="category" id="category">
                        <option value=""></option>
                    </select>
                    <button class="add-category-btn" type="button"
                        style="display:flex; flex-direction:row; align-items:center; gap:3px; left:5px;">
                        <img src="../assets/images/add-blue.png" alt="">
                        Add New Expense Category
                    </button>
                </div>
                <div class="form-input">
                    <label for="purpose">Purpose</label>
                    <input type="text" name="purpose" id="purpose">

                </div>
                <div class="form-input">
                    <label for="total">Total</label>
                    <input type="text" name="total" id="total">
                </div>
                <div class="form-input textarea">
                    <label for="description">Description</label>
                    <textarea id="expenseDescription" name="description" rows="10" cols="50"
                        placeholder="Enter details of the expense..."></textarea>

                </div>
                <div class="form-input" style="visibility: hidden;">
                    <label for="total">Total</label>
                    <input type="text" name="total" id="total">
                </div>
                <input type="hidden" name="hidden" id="hidden">

                <div class="form-input">
                    <button type="submit" class="update-button" style="width: 5rem; border-radius:0;">Update</button>
                </div>

                <input type="hidden" name="" value="" class="id">
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
    <div class="footer">

    </div>
</div>
<!-- <script src="../utils/make-request.js"></script> -->
<!-- <script src="../assets/js/add-unit.js"></script> -->
<script src="../utils/some-functions.js"></script>
<script src="../assets/js/sweetalert.min.js"></script>
<script src="../assets/js/fetch.expense.js"></script>

<?php
include '../includes/footer.php';
?>