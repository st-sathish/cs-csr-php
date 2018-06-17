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
        <ul class="nav navbar-top-links navbar-right hidden-xs">
            <li class="dropdown">
                <a class="dropdown-toggle user" data-toggle="dropdown" href="#" aria-expanded="false">
                    <span style="color:#fff"><?php echo $_SESSION['name']; ?></span>
                    <img src="<?php echo BASE_URL ?>/images/user.jpg" alt="" data-src="<?php echo BASE_URL ?>/images/user.jpg" data-src-retina="<?php echo BASE_URL ?>/images/user.jpg" class="img-responsive img-circle user-img">
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeInUp">
                    <li class="user-information">
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object user-profile-image img-circle" src="<?php echo BASE_URL ?>/images/user.jpg">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $_SESSION['name']; ?></h4>
                                <hr style="margin:8px auto">
                            </div>
                        </div>
                    </li>
                    <li class="divider"></li>
                        <li><a href="<?php echo BASE_URL ?>/change_password.php"><i class="fa fa-lock fa-fw"></i>Change Password</a></li>
                    <li class="divider"></li>
                        <li><a href="<?php echo BASE_URL ?>/logout.php" class="text-danger"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>