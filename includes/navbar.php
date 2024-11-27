<link rel="stylesheet" href="../assets/css/navbar.css">

<body>

    <header style="align-items: center;">
        <div class="nav-container">
            <div class="nav-container-assets">
                <img src="../assets/images/menu.png" id="menu" alt="">
            </div>


            <?php if (isset($_SESSION['username'])) { ?>
                <div class="nav-item dropdown" style="z-index:2; width: 2rem; cursor: pointer;">
                    <span class="notification"> <?php if (isset($_SESSION['notifications']) && !empty($_SESSION['notifications'])) {
                        echo count($_SESSION['notifications']);
                    } else {
                        echo 0;
                    }
                    ?>
                    </span>
                    <img src="../assets/images/notification.png" alt="" class="dropdown-toggle"
                        style="width:20px; height:20px; margin-top:45%; z-index:-1;">
                    <div class="dropdown-menu" style="left: -20rem; width:400px;">
                        <!-- <a href="../pages/user-profile.php">User Profile</a>
                        <button id="logoutBtn" type="button">Log out</button> -->
                        <div class="tableContainer">
                            <span class="arrow" style="display:none;">&#9662;</span>

                            <div class="message_div" style="border-radius:0; background: transparent;">

                                <?php if (isset($_SESSION['notifications']) && !empty($_SESSION['notifications']))
                                    foreach ($_SESSION['notifications'] as $notification) {
                                        echo "<div style='border-radius: 0;' class='message'>";
                                        echo "<div></div>";
                                        echo "<p style='color: red; font-weight: bold; text-align:center;'>{$notification}</p>";
                                        echo "</div>";
                                    } else {
                                    echo "<p>No notifications available.</p>";
                                }

                                ?>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="nav-item dropdown" style="z-index:2;">
                    <a href="#" class="dropdown-toggle">
                        <?php echo $_SESSION['username']; ?>
                        <span class="arrow">&#9662;</span></a>
                    <!-- <img src="../assets/images/avarta.png" alt=""> -->
                    <div class="dropdown-menu" style="left: -6rem;">
                        <a href="../pages/user-profile.php">User Profile</a>
                        <button id="logoutBtn" type="button">Log out</button>
                    </div>
                </div>


            <?php } ?>
            <!-- <div class="nav-item">
                <a href="#">Contact</a>
            </div> -->
        </div>
    </header>
</body>
<script>

    document.querySelectorAll('.dropdown-toggle').forEach(item => {
        item.addEventListener('click', (event) => {
            // Prevent the default action (optional)
            event.preventDefault();

            // Toggle the dropdown menu
            const dropdownMenu = item.nextElementSibling;
            const arrow = item.querySelector('.arrow');

            if (dropdownMenu.style.display === 'block') {
                dropdownMenu.style.display = 'none';
                arrow.classList.remove('rotate');
            } else {
                // Close all other dropdowns
                document.querySelectorAll('.dropdown-menu').forEach(menu => menu.style.display = 'none');
                document.querySelectorAll('.arrow').forEach(arrow => arrow.classList.remove('rotate'));

                // Open the current one
                dropdownMenu.style.display = 'block';
                if (arrow !== null) {

                    arrow.classList.add('rotate');
                }
            }
        });
    });
</script>
<script src="../utils/some-functions.js"></script>
<script src="../assets/js/logout.js"></script>