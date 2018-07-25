<?php
session_start();
include_once "../constants.php";
if(!isset($_SESSION['username'])) {
  header("location:/csr/index.php");
}
$page = "dashboard";
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
    </head>
    <body>
        <div class="wrapper">
            <?php include "shared/menu.php";?>
            <!-- Page Content Holder -->
            <div id="content">
                <?php include "shared/header.php";?>
                <div class="sub-content">
                </div>
            </div>
        </div>
		<!-- jQuery CDN -->
		 <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
		 <!-- Bootstrap Js CDN -->
		 <script src="../js/bootstrap.min.js"></script>
		 <!-- jQuery Custom Scroller CDN -->
         <script src="../js/jquery.mCustomScrollbar.concat.min.js"></script>
		 <script type="text/javascript">
		     $(document).ready(function () {
		         $("#sidebar").mCustomScrollbar({
                    theme: "minimal"
                });
                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar, #content').toggleClass('active');
                    $('.collapse.in').toggleClass('in');
                    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
                });
		     });
		 </script>
	</body>
</html>
