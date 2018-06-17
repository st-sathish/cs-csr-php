<!-- Sidebar Holder -->
<nav id="sidebar">
    <ul class="list-unstyled components">
        <li <?php if($page == 'dashboard') {
            echo 'class="active"';
            }?> >
            <a href="#dashboard"><i class="glyphicon glyphicon-home"></i><span class="menu-text">Dashboard</span></a>
        </li>
        <li <?php if($page == 'categories') {
            echo 'class="active"';
            }?>>
            <a href="/csr/views/category/categories.php"><i class="glyphicon glyphicon-link"></i><span class="menu-text">Category</span></a>
        </li>
        <li <?php if($page == 'items') {
            echo 'class="active"';
            }?>>
            <a href="/csr/views/item/items.php"><i class="glyphicon glyphicon-paperclip"></i><span class="menu-text">Items</span></a>
        </li>
    </ul>
</nav>