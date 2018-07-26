<!-- Sidebar Holder -->
<nav id="sidebar">
    <ul class="list-unstyled components">
        <li <?php if($page == 'dashboard') {
            echo 'class="active"';
            }?> >
            <a href="<?php echo BASE_URL ?>/views/dashboard.php"><i class="glyphicon glyphicon-home"></i>
                <span class="menu-text">Dashboard</span></a>
        </li>
        <li <?php if($page == 'categories') {
            echo 'class="active"';
            }?>>
            <a href="<?php echo BASE_URL ?>/views/category/categories.php"><i class="glyphicon glyphicon-link"></i>
                <span class="menu-text">Category</span></a>
        </li>
        <li <?php if($page == 'items') {
            echo 'class="active"';
            }?>>
            <a href="<?php echo BASE_URL ?>/views/item/items.php"><i class="glyphicon glyphicon-paperclip"></i>
                <span class="menu-text">Items</span></a>
        </li>
        <li <?php if($page == 'expired_items') {
            echo 'class="active"';
            }?>>
            <a href="<?php echo BASE_URL ?>/views/item/expired_items.php"><i class="glyphicon glyphicon-paperclip"></i>
                <span class="menu-text">Expired Items</span></a>
        </li>
        <li <?php if($page == 'sold_items') {
            echo 'class="active"';
            }?>>
            <a href="<?php echo BASE_URL ?>/views/item/sold_items.php"><i class="glyphicon glyphicon-paperclip"></i>
                <span class="menu-text">Sold Items</span></a>
        </li>
        <li <?php if($page == 'debtors') {
            echo 'class="active"';
            }?>>
            <a href="<?php echo BASE_URL ?>/views/debtor/debtors.php"><i class="glyphicon glyphicon-paperclip"></i>
                <span class="menu-text">Debtors</span></a>
        </li>
    </ul>
</nav>