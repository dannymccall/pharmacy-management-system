<link rel="stylesheet" href="../assets/css/navbar.css">

<body>

    <header>
        <div class="nav-container">
            <div class="nav-container-assets">
                <img src="../assets/images/menu.png" alt="">
            </div>


            <?php if (isset($_SESSION['username'])) { ?>
                <div class="nav-item dropdown" style="z-index:2;">
                    <a href="#" class="dropdown-toggle">
                        <?php echo $_SESSION['username']; ?>
                        <span class="arrow">&#9662;</span></a>
                    <!-- <img src="../assets/images/avarta.png" alt=""> -->
                    <div class="dropdown-menu">
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
                arrow.classList.add('rotate');
            }
        });
    });
</script>
<script src="../utils/some-functions.js"></script>
<script src="../assets/js/logout.js"></script>
