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
                    <div class="unit">
                        <img src="../assets/images/unit.png" alt="">
                        <div class="unit__sub__header">
                            <h1>Unit</h1>
                            <h2>medicine / <span>view-units</span></h2>
                        </div>

                    </div>
                    <a href="../pages/add-unit.php" class="add__new__unit">
                        <img src="../assets/images/add.png" alt="">
                        Add new unit
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
                    <h1>Unit List</h1>
                    <p class="error">gfhgfd</p>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Unit</th>
                                    <th>Unit Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="table__body">

                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <div class="footer">

    </div>
</div>
<!-- <script src="../utils/make-request.js"></script> -->
<!-- <script src="../assets/js/add-unit.js"></script> -->
<script src="../utils/some-functions.js"></script>
<script src="../assets/js/sweetalert.min.js"></script>
<script src="../assets/js/fetch.units.js"></script>

<?php
include '../includes/footer.php';
?>