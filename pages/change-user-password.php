<?php include '../includes/auth.php' ?>


<?php
include '../includes/header.php'
    ?>
<link rel="stylesheet" href="../assets/css/unit.style.css">
<link rel="stylesheet" href="../assets/css/reset.password.style.css">
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
                    <img src="../assets/images/resetpassword.png" alt="">
                    <div class="unit__sub__header">
                        <h1>User</h1>
                        <h2>user / <span>reset-password</span></h2>
                    </div>
                </div>

                <div class="form" style="">
                    <h1>Reset Password</h1>
                    <form action="" id="resetPasswordForm" style="width">
                        <p>WPS-Change User Password</p>
                        <p class="error" style="width: 15rem;"></p>
                        <div class="form-section">
                            <div class="form__input">
                                <input type="text" name="username" id="user" placeholder="username">
                            </div>
                        </div>
                        <div class="button-section">
                            <button type="submit" class="button">Change</button>
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
<script src="../assets/js/sweetalert.min.js"></script>
<script src="../assets/js/change-password.js"></script>
<?php
include '../includes/footer.php';
?>