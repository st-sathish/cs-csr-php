<?php
session_start();
if(!isset($_SESSION['username'])) {
  header("location:/csr/index.php");
}
include_once "../constants.php";
$page = "categories";
error_reporting(0);
if(isset($_POST['change_password_form'])) {
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];
    if(sizeof($newPassword) != sizeof($confirm_password)) {
        $_SESSION['msg'] = "New and Confirm Password are wrong";
    }
}
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
            <?php echo $_SESSION['msg'] ?>
            <!-- Page Content Holder -->
            <div id="content">
                <?php include "shared/header.php";?>
                <div class="sub-content">
                    <form action="" name="change_password_form" method="POST">
                        <div class="col-md-12">
                            <input type="password" class="form-control" placeholder="Old Password" name="old_password"/>
                        </div>
                        <div class="col-md-12">
                            <input type="password" class="form-control" placeholder="New Password" name="new_password"/>
                        </div>
                        <div class="col-md-12">
                            <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password"/>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary">Change Password</button>
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
