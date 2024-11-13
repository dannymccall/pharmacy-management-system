<?php

session_set_cookie_params([
    'lifetime' => 60 * 60 * 24 * 7, // 7 hours in seconds
    'path' => '/',
    'domain' => '',
    'secure' => true, // Use if you have HTTPS
    'httponly' => true,
    'samesite' => 'Strict',
]);
session_start();
if (isset($_SESSION['username'])) {
    header('Location: pages/dashboard.php');
}
include __DIR__ . '/includes/header.php'

    ?>
<link rel="stylesheet" href="assets/css/admin__login.css">
<?php
include __DIR__ . '/includes/header__rest.php';
?>


<?php

// include __DIR__ . '/db/db.php'; 

// $sql = "INSERT INTO users(firstname, lastname, username, role, password) values(:firstname, :lastname, :username, :role, :password)";

// $stmt = $pdo->prepare($sql);

// $firstname = 'Daniel';
// $lastname = 'Palmer';
// $explode = str_split($firstname);
// $username = strtolower($explode[0]) . strtolower($lastname);


// $role = 'super_admin';
// $password = '123456';  // Make sure the password is a string
// $hashed_password = password_hash($password, PASSWORD_DEFAULT);


// $stmt->bindParam(':firstname', $firstname);
// $stmt->bindParam(':lastname', $lastname);
// $stmt->bindParam(':username', $username);
// $stmt->bindParam(':role', $role);
// $stmt->bindParam(':password', $hashed_password);

// try{
//     $stmt->execute();

//     echo 'user inserted';
// }catch(PDOException $e){
//     echo 'something happened ' . $e->getMessage();
// }
?>
<div class="container">

    <div class="container__section">

        <div class="section">
            <div class="section-welcome">
                <h1>Welcome back</h1>
                <p>Welcome back! Don’t miss your latest updates. Please log in.</p>
            </div>
        </div>
        <div class="login__section">
            <img src="assets/images/lock.png" class="locker" alt="lock" srcset="">
            <h1>Login</h1>
            <p class="error" style="width:90%;"></p>
            <form action="" class="form" id="userForm">
                <div class="form__input">
                    <input type="text" name="username" id="username" placeholder="username">
                    <img src="assets/images/user_black.png" alt="">
                </div>
                <div class="form__input">
                    <input type="password" name="password" id="password" placeholder="password">
                    <img src="assets/images/locker_black.png" alt="">
                </div>
                <a href="./pages/reset-password.php">Forgot password</a>
                <div class="button__container">
                    <button type="submit">
                        Submit
                    </button>

                    <div style="width: 100%; height:100%; display:flex; justify-content:center; align-items:center; display:none;"
                        class="loader__div">

                        <?php include './components/loader.php' ?>
                    </div>


                </div>
            </form>
        </div>
    </div>
</div>
<script src="utils/some-functions.js"></script>
<script src="utils/make-request.js"></script>
<script src="assets/js/login.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<?php
include __DIR__ . '/includes/footer.php';
?>