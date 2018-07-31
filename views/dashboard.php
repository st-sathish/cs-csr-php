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
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <h3 class="dashboard-heading"></h3>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <label class="circle-heading">Stocks</label>
                                <div class="circle">
                                    <span class="stock-total"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="circle-heading">Sold</label>
                                <div class="circle">
                                    <span class="sold-total"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top:20px">
                            <div class="col-md-6">
                                <label class="circle-heading">Expired</label>
                                <div class="circle">
                                    <span class="expired-total"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="circle-heading">Profit</label>
                                <div class="circle">
                                    <span class="profit-total"></span>
                                </div>
                            </div>
                        </div>
                    </div>
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
                initMetadata();
		     });
             function initMetadata() {
                $.ajax({
                url: '<?php echo BASE_URL ?>' + '/api/v1/dashboard.php',
                success: function(data) {
                  console.debug(data);
                  data = JSON.parse(data);
                  $(".dashboard-heading").html(data['banner_message']);
                  $(".sold-total").text(data['meta_data']['total_sold']);
                  $(".expired-total").text(data['meta_data']['total_expired']);
                  $(".stock-total").text(data['meta_data']['total_stock']);
                  $(".profit-total").text(data['meta_data']['total_profit']);
                }
            });
            }
		 </script>
	</body>
</html>
