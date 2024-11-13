<?php
include '../includes/header.php'
    ?>
<link rel="stylesheet" href="../assets/css/sidebar.css">
<?php
include '../includes/header__rest.php';
?>

<div class="sidebar__container" style="overflow: hidden;">
    <div class="sidebar__container__items">
        <div class="sidebar__header">
            <img src="../assets/images/logo2.png" class="logo" alt="" srcset="">
        </div>
        <div class="sidebar__user__details">
            <img src="../assets/images/avarta-dark.png" class="avarta" alt="avarta" id="user_image" srcset="">
            <div class="side_user">
                <input type="hidden" id="username" value="<?php if (isset($_SESSION['username']))
                    echo $_SESSION['username'] ?>">
                    <?php
                if (isset($_SESSION['username']))
                    echo '<h1 class="user-credentials">' . strtoupper($_SESSION['firstname']) . ' ' . strtoupper($_SESSION['middlename']) . ' ' . strtoupper($_SESSION['lastname']) . '</h1>';
                if (isset($_SESSION['username'])) {
                    if ($_SESSION['user_role'] === 'super admin')
                        echo '<h1 class="user-type">super admin</h1>';
                    else
                        echo '<h1 class="user-type">sales agent</h1>';
                }
                ?>
            </div>
        </div>
        <div class="sidebar">
            <div class="menu-item">
                <div class="menu-item-inner-div">
                    <img src="../assets/images/dashboard.png" alt="">

                    <span class="menu-title">
                        <a href="../pages/dashboard.php"
                            style="color:#fff; width: 100%; z-index:-1; height:100%; text-decoration: none;">Dashboard</a>
                    </span>
                </div>
            </div>
            <div class="menu-item">
                <div>
                    <div class="menu-item-inner-div">
                        <img src="../assets/images/invoice.png" alt="">
                        <span class="menu-title">Invoice</span>
                    </div>
                    <div class="submenu">
                        <a href="../pages/add-invoice.php">New Invoice</a>
                        <a href="../pages/view.invoices.php">Manage Invoice</a>
                    </div>

                </div>
                <span class="arrow">&#9662;</span>
            </div>
            <div class="menu-item">
                <div>

                    <div class="menu-item-inner-div">
                        <img src="../assets/images/search.png" alt="">
                        <span class="menu-title">Search</span>
                    </div>
                    <div class="submenu">
                        <a href="../pages/medicine-search.php">Medicine</a>
                        <a href="../pages/invoice-search.php">Invoice</a>
                        <a href="../pages/user.search.php">User</a>
                    </div>
                </div>
                <span class="arrow">&#9662;</span>
            </div>

            <div class="menu-item">
                <div>

                    <div class="menu-item-inner-div">
                        <img src="../assets/images/product.png" alt="">
                        <span class="menu-title">Product</span>
                    </div>
                    <div class="submenu">
                        <a href="../pages/view.categories.php">Categories</a>
                        <a href="../pages/view.units.php">Units</a>
                        <a href="../pages/add-product.php">Add Product</a>
                        <a href="../pages/view.product.php">Manage Product</a>

                    </div>

                </div>
                <span class="arrow">&#9662;</span>
            </div>

            <!-- <div class="menu-item">
                <div>

                    <div class="menu-item-inner-div">
                        <img src="../assets/images/company.png" alt="">
                        <span class="menu-title">Suppliers</span>
                    </div>
                    <div class="submenu">
                        <a href="#">Add Supplier</a>
                        <a href="#">Manage Suppliers</a>
                        <a href="#">Supplier Ledger</a>
                        <a href="#">Suppliers Sales Details</a>
                    </div>

                </div>
                <span class="arrow">&#9662;</span>
            </div> -->

            <div class="menu-item">
                <div>

                    <div class="menu-item-inner-div">
                        <img src="../assets/images/report.png" alt="">
                        <span class="menu-title">Reports</span>
                    </div>
                    <div class="submenu">
                        <a href="../pages/sales-report.php">Sales Report</a>
                        <a href="../pages/purchase-report.php">Purchase Report</a>
                        <a href="../pages/expense-report.php">Expense Report</a>
                    </div>

                </div>
                <span class="arrow">&#9662;</span>
            </div>
            <div class="menu-item">
                <div>
                    <div class="menu-item-inner-div">
                        <img src="../assets/images/stock.png" alt="">
                        <span class="menu-title">Stock</span>
                    </div>
                    <div class="submenu">
                        <a href="../pages/view-stock.php">Stock Report</a>

                    </div>

                </div>
                <span class="arrow">&#9662;</span>
            </div>
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'super admin') { ?>
                <div class="menu-item">
                    <div>

                        <div class="menu-item-inner-div">
                            <img src="../assets/images/purchase.png" alt="">
                            <span class="menu-title">Purchase</span>
                        </div>
                        <div class="submenu">
                            <a href="../pages/add-purchase.php">Add Purchase</a>
                            <a href="../pages/view.purchases.php">Manage Purchase</a>
                        </div>
                    </div>
                    <span class="arrow">&#9662;</span>

                </div>
                <!-- <div class="menu-item">
                <div>
                    <div class="menu-item-inner-div">
                        <img src="../assets/images/return.png" alt="">
                        <span class="menu-title">Returns</span>
                    </div>
                    <div class="submenu">
                        <a href="#">Sales Report</a>
                        <a href="#">Purchase Report</a>
                    </div>

                </div>
                <span class="arrow">&#9662;</span>
            </div> -->
                <div class="menu-item">
                    <div>
                        <div class="menu-item-inner-div">
                            <img src="../assets/images/hrm.png" alt="">
                            <span class="menu-title">Human Resource</span>
                        </div>
                        <div class="submenu">
                            <a href="../pages/wisvee.php">WISVEE</a>
                            <a href="../pages/users.php">Users</a>
                            <a href="../pages/add-user.php">Add user</a>
                            <a href="../pages/change-user-password.php">Reset user password</a>
                        </div>

                    </div>
                    <span class="arrow">&#9662;</span>

                </div>
            <?php } ?>
            <div class="menu-item">
                <div>
                    <div class="menu-item-inner-div">
                        <img src="../assets/images/expense.png" alt="">
                        <span class="menu-title">Expenses</span>
                    </div>
                    <div class="submenu">
                        <a href="../pages/add-expense.php">Add Expense</a>
                        <a href="../pages/view.expense.php">Manage Expense</a>
                    </div>

                </div>
                <span class="arrow">&#9662;</span>

            </div>

        </div>

    </div>
</div>
<script src="../utils/some-functions.js"></script>
<script src="../assets/js/sidebar.js"></script>
<script>

    document.querySelectorAll('.menu-item').forEach(item => {
        item.addEventListener('click', () => {
            const submenu = item.querySelector('.submenu');
            const arrow = item.querySelector('.arrow');

            // If the submenu exists, toggle its height
            if (submenu) {
                // Close all other open submenus and reset arrows
                document.querySelectorAll('.submenu').forEach(sm => {
                    if (sm !== submenu) {
                        sm.style.maxHeight = '0';
                        sm.previousElementSibling.querySelector('.arrow')?.classList.remove('rotate');
                    }
                });

                // Toggle the current submenu's max-height
                submenu.style.maxHeight = submenu.style.maxHeight === '0px' || submenu.style.maxHeight === ''
                    ? submenu.scrollHeight + 'px'
                    : '0';

                // Toggle the arrow rotation
                if (arrow) {
                    arrow.classList.toggle('rotate');
                }
            }
        });
    });
</script>
<?php
include '../includes/footer.php';
?>