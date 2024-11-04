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
                        <img src="../assets/images/unit.png" alt="">
                        <div class="unit__sub__header">
                            <h1>HRM</h1>
                            <h2>Human Resource / <span>wisvee</span></h2>
                        </div>

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
                    <h1>WISVEE</h1>
                    <div class="wisvee-pharmacy">
                        <img src="../assets/images/logo2.png" alt="" srcset=""
                            style="width: 100px; height: 100px; margin: auto;">
                        <h2>WISVEE PHARMACY</h2>
                        <p>Email: <span>viviankudatsi@yahoo.com</span></p>
                        <p>Tel: <span>0248744219 / 0269465943</span></p>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <!-- <div class="user-view-modal">
        <div class="form" style="width: 70%; height:70%;">
            <h1>Edit User</h1>
            <p class="error" style="text-align:center; margin: 5px auto;"></p>
            <form action="" id="updateUserForm" class="form-flex">

                <div class="form-input">
                    <label for="firstname">First Name</label>
                    <input type="text" name="firstname" id="firstname">
                </div>

                <div class="form-input">
                    <label for="middlename">Middle Name</label>
                    <input type="text" name="middlename" id="middlename">

                </div>
                <div class="form-input">
                    <label for="lastname">Last name</label>
                    <input type="text" name="lastname" id="lastname">
                </div>


                <div class="form-input">
                    <label for="user-role">User Role</label>
                    <select name="role" id="role">
                        <option value=""></option>

                    </select>
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
    </div> -->
    <div class="footer">

    </div>
</div>
<!-- <script src="../utils/make-request.js"></script> -->
<!-- <script src="../assets/js/add-unit.js"></script> -->
<script src="../utils/some-functions.js"></script>
<script src="../assets/js/sweetalert.min.js"></script>
<!-- <script src="../assets/js/fetch.users.js"></script> -->

<?php
include '../includes/footer.php';
?>