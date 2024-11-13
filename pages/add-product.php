<?php include '../includes/auth.php' ?>

<?php
include '../includes/header.php';
?>

<link rel="stylesheet" href="../assets/css/unit.style.css">
<link rel="stylesheet" href="../assets/css/add-medicine.style.css">
<!-- <link rel="stylesheet" href="../assets/css/add-product.style.css"> -->
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
                        <img src="../assets/images/addproduct.png" alt="">
                        <div class="unit__sub__header">
                            <h1>Product</h1>
                            <h2>product / <span>add-product</span></h2>
                        </div>

                    </div>
                    <a href="./view.product.php" class="add__new__unit" style="border-radius: 2px;">
                        Manage Product
                    </a>
                </div>

                <div class="form">
                    <h1>Add New Product</h1>
                    <p class="error"></p>
                    <form action="" id="medicineForm" class="form-flex" style="display: flex; flex-direction: column">
                        <div class="form-input">
                            <label for="medicine-name">Product Name</label>
                            <input type="text" name="medicine-name" id="medicine-name">
                        </div>

                        <div class="form-input">
                            <label for="category">Category</label>
                            <select name="category" id="category">
                                <option value="">Select category</option>
                            </select>
                            <button class="add-category-btn" type="button"
                                style="display:flex; flex-direction:row; align-items:center; gap:3px; left:5px;">
                                <img src="../assets/images/add-blue.png" alt="">
                                Add New Category
                            </button>
                        </div>
                        <div class="form-input">
                            <label for="unit">Unit</label>
                            <select name="unit" id="unit">
                                <option value="">Select unit</option>
                            </select>
                            <button class="add-unit-btn" id="add-unit-btn" type="button"
                                style="display:flex; flex-direction:row; align-items:center; gap:3px; left:5px;">
                                <img src="../assets/images/add-blue.png" alt="">
                                Add New unit
                            </button>
                        </div>
                        <div class="form-input">
                            <label for="cost-price">Unit Cost Price</label>
                            <input type="number" step="any" name="cost-price" id="cost-price" />
                        </div>
                        <div class="form-input">
                            <label for="sellingprice">Unit Selling Price</label>
                            <input type="number" step="any" name="selling-price" id="selling-price" />
                        </div>
                        <div class="form-input">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" id="quantity">
                        </div>


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
<script src="../assets/js/add-product.js"></script>

<?php
include '../includes/footer.php';
?>