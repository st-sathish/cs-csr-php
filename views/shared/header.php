<?php
include "../../constants.php";
?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                <i class="glyphicon glyphicon-align-left"></i>
            </button>
        </div>
    </div>
    <div class="header-right">
        <div class="profile_details">
            <ul>
                <li class="dropdown profile_details_drop">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <div class="profile_img">
                            <span class="prfil-img"><img src="images/admin.png"alt=""></span>
                            <div class="user-name">
                                <p><?php echo $_SESSION['name']; ?></p>
                                <span><?php echo $_SESSION['role']; ?></span>
                            </div>
                            <i class="fa fa-angle-down lnr"></i>
                            <i class="fa fa-angle-up lnr"></i>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                    <ul class="dropdown-menu drp-mnu">
                        <li> <a href="<?php echo BASE_URL ?>/change_password.php">
                            <i class="fa fa-cog"></i> Change Password</a>
                        </li>
                        <li> <a href="<?php echo BASE_URL ?>/logout.php">
                            <i class="fa fa-sign-out"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</nav>