<?php
include '../includes/header.php'
    ?>
<link rel="icon" href="assets/images/logo.png" type="image/png">
<link rel="stylesheet" href="../assets/css/unit.style.css">
<link rel="stylesheet" href="../assets/css/add-medicine.style.css">
<link rel="stylesheet" href="../assets/css/user.profile.style.css">
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
                            <h2>user / <span>add-user</span></h2>
                        </div>

                    </div>
                    <a href="../pages/users.php" class="add__new__unit" style="width: 10rem; border-radius:2px;">
                        Manage users
                    </a>
                </div>

                <div class="form">
                    <h1 style="width: 75%;">Add New User</h1>
                    <p class="error" style="align-self: start;"></p>
                    <form action="" id="addUserForm" class="form-flex">

                        <div class="form-input">
                            <label for="firstname">First name</label>
                            <input type="text" name="firstname" id="firstname">
                        </div>

                        <div class="form-input">
                            <label for="lastname">Last name</label>
                            <input type="text" name="lastname" id="lastname" />
                        </div>
                        <div class="form-input">
                            <label for="middlename">Middle name</label>
                            <input type="text" name="middlename" id="middlename" />
                        </div>
                        <div class="form-input">
                            <label for="user-role">User Role</label>
                            <select name="user-role" id="user-role">
                                <option value="">--Select role--</option>
                                <option value="super admin">super admin</option>
                                <option value="sales agent">sales agent</option>
                            </select>
                        </div>

                        <div class="form-input">
                            <div class="loader__div" style="display:none;">
                                <?php include '../components/loader.php'; ?>
                            </div>
                        </div>

                        <div class="form-input" style="position: relative; bottom: 70px;">
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

<!-- <script src="../utils/make-request.js"></script> -->
<!-- <script src="../assets/js/add-unit.js"></script> -->
<script src="../utils/some-functions.js"></script>
<script src="../assets/js/sweetalert.min.js"></script>
<script src="../assets/js/add-user.js"></script>
<?php
include '../includes/footer.php';
?>