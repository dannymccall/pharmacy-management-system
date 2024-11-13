<?php include '../includes/auth.php' ?>

<?php
include '../includes/header.php'
    ?>
<link rel="stylesheet" href="../assets/css/unit.style.css">
<link rel="icon" href="../assets/images/logo2.png" type="image/png">

<?php
include '../includes/header__rest.php';
?>

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
                    <img src="../assets/images/unit.png"  alt="">
                    <div class="unit__sub__header">
                        <h1>Unit</h1>
                        <h2>medicine / <span>add-unit</span></h2>
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
                    <h1>Add New Unit</h1>
                    <p class="error"></p>
                    <form action="" id="unitForm">
                        <div class="form-section">
                            <div class="form-input">
                                <label for="Unit-Name">Unit name:</label>
                                <input type="text" name="unit-name" id="unit-name" placeholder="eg.miligram">
                            </div>
                            <div class="form-input">
                                <label for="Unit">Unit:</label>
                                <input type="text" name="unit" id="unit" placeholder="eg.mg">
                            </div>

                        </div>
                        <div class="button-section">
                            <button type="submit" class="button">Submit</button>
                        </div>
                        <div class="button-section">
                            <div class="loader__div" style="display:none;">
                                <?php include '../components/loader.php' ?>

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
<script src="../assets/js/add-unit.js"></script>
<script src="../assets/js/sweetalert.min.js"></script>
<?php
include '../includes/footer.php';
?>