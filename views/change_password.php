<?php
session_start();
include_once "../constants.php";
if(!isset($_SESSION['username'])) {
  header("location:<?php echo BASE_URL?>/index.php");
}
$page = "change_password";
error_reporting(0);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Collapsible sidebar using Bootstrap 3</title>

         <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <!-- Our Custom CSS -->
        <link href="../css/style1.css" rel="stylesheet" type="text/css" media="all"/>
        <!-- Scrollbar Custom CSS -->
        <link rel="stylesheet" href="../css/jquery.mCustomScrollbar.min.css">
        <link rel="stylesheet" href="../css/jquery.dataTables.min.css">
    </head>
    <body>
        <div class="wrapper">
            <?php include "shared/menu.php";?>
            <!-- Page Content Holder -->
            <div id="content">
                <?php include "shared/header.php";?>
                <div class="col-md-4 col-md-offset-4">
                    <div class="form-group required"><?php echo $_SESSION['msg'] ?></div>
                    <form action="<?php echo BASE_URL ?>/controllers/UserController.php?action=change_password" name="change_password_form" method="POST">
                        <div class="form-group">    
                            <input type="password" class="form-control" placeholder="Old Password" name="old_password"/>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="New Password" name="new_password"/>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password"/>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="submit" value="Change Password" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
		  <!-- jQuery CDN -->
		 <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
		 <!-- Bootstrap Js CDN -->
		 <script src="../js/bootstrap.min.js"></script>
		 <script type="text/javascript">
		     $(document).ready(function () {
		         
		     });
		 </script>
	</body>
</html>
