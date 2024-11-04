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
                            <h1>Profile</h1>
                            <h2>user / <span>profile</span></h2>
                        </div>

                    </div>
                </div>

                <div class="form">
                    <h1 style="width: 100%;">User Profile</h1>
                    <div class="user__profile" style="align-self: center;">

                        <div>
                            <img src="../assets/images/user_profile.jpg" id="avarta" alt="" srcset="">
                        </div>
                        <div class="edit__section">
                            <img src="../assets/images/edit__profile.png" alt="" onclick="triggerFileInput()">
                            <input type="file" name="file" id="file" onchange="uploadImage(event)">
                        </div>
                        <input type="hidden" name="username" id="username" value="<?php if (isset($_SESSION['username']))
                            echo $_SESSION['username']; ?>">
                        <progress id="progressBar" class="progress-bar" value="0" max="100"></progress>
                        <div id="uploadStatus"></div>
                        <div class="tab user__profile__details">
                            <button class="tab-button" onclick="openTab(event, 'Tab1')">User Details</button>
                            <button class="tab-button" onclick="openTab(event, 'Tab2')">Security</button>
                            <button class="tab-button" onclick="openTab(event, 'Tab3')">Latest activity</button>
                        </div>
                        <div id="Tab1" class="tab-content">
                            <div class="user__details" style="gap:20px;">
                                <div>
                                    <h3>Fullname:</h3>
                                    <p>
                                        <?php
                                        if (isset($_SESSION['username'])) {
                                            echo $_SESSION['firstname'] . ' ' . $_SESSION['middlename'] . ' ' . $_SESSION['lastname'];
                                        }

                                        ?>
                                    </p>
                                </div>
                                <div>
                                    <h3>Username:</h3>
                                    <p> <?php
                                    if (isset($_SESSION['username'])) {
                                        echo $_SESSION['username'];
                                    }

                                    ?></p>

                                </div>
                                <div>
                                    <h3>Role:</h3>
                                    <p> <?php
                                    if (isset($_SESSION['username'])) {
                                        echo $_SESSION['user_role'] === 'super_admin' ? 'Super Admin' : '';
                                    }

                                    ?></p>


                                </div>

                            </div>
                        </div>

                        <div id="Tab2" class="tab-content">
                            <div class="user__security">
                                <div style="width: 12rem;">

                                    <button type="button" id="logoutBtn"
                                        style="width:5rem; padding:4px; border-radius:3px;">Logout</button>
                                </div>
                                <div style="width:100%">
                                    <p style="margin-left: 32px; font-weight: 600; font-size: 1em">Change Password</p>
                                    <p class="error" style="color:red; width: 65%; text-align:start; font-size: 0.8em;">
                                        jdhfjdksf</p>
                                    <div class="div" style="display:flex; flex-direction: ">
                                        <form action="" method="post" id="changePasswordForm" style="display:flex; flex-direction: column;">
                                            <input type="password" placeholder="Old password" id="old-password"
                                                style="margin-bottom: 10px; width:80%">
                                            <input type="password" placeholder="New password" id="new-password"  style="width:80%">
                                            <input type="password" placeholder="Confirm new password"
                                                id="confirm-password"  style="10px; width:80%">
                                            <input type="hidden" name="hidden" id="hidden">
                                            <button type="submit"
                                                style="margin-top: 10px; border-radius: 2px; position: relative;">Submit</button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div id="Tab3" class="tab-content">
                            <h3>Role:</h3>
                            <p>This is the content of Tab 3.</p>
                        </div>
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
<script src="../assets/js/user.profile.js"></script>
<script src="../assets/js/logout.js"></script>
<?php
include '../includes/footer.php';
?>