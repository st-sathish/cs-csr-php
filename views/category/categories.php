<?php
session_start();
if(!isset($_SESSION['username'])) {
  header("location:/csr/index.php");
}
include "../../constants.php";
$page = "categories";
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
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <!-- Our Custom CSS -->
        <link href="../../css/style1.css" rel="stylesheet" type="text/css" media="all"/>
        <!-- Scrollbar Custom CSS -->
        <link rel="stylesheet" href="../../css/jquery.mCustomScrollbar.min.css">
        <link rel="stylesheet" href="../../css/jquery.dataTables.min.css">
    </head>
    <body>
        <div class="wrapper">
            <?php include "../shared/menu.php";?>
            <?php echo $_SESSION['msg'] ?>
            <!-- Page Content Holder -->
            <div id="content">
                <?php include "../shared/header.php";?>
                <div class="sub-content">
                    <div class="col-md-12">
                         <div class="col-md-2 col-md-offset-10">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Category</button>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table id="category-datatable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Category Name</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Category Dialog</h4>
              </div>
              <div class="modal-body">
              <div id="msg"></div>
              <form method="POST" action="../../controllers/CategoryController.php?action=add_category" 
              onsubmit="return validateForm()" id="item_form">
              <input type="hidden" id="categoryId" name="categoryId" />
                <div class="form-group">
                  <label for="category">Category Name:<span class="required">*</span></label>
                  <input type="text" name="category" class="form-control" id="category">
                </div>
                <button type="submit" class="btn btn-success" id="saveCategory">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </form>
              </div>
              <div class="modal-footer">
              </div>
            </div>

          </div>
        </div>
		  <!-- jQuery CDN -->
		 <script type="text/javascript" src="../../js/jquery-3.3.1.min.js"></script>
		 <!-- Bootstrap Js CDN -->
		 <script src="../../js/bootstrap.min.js"></script>
		 <!-- jQuery Custom Scroller CDN -->
     <script src="../../js/jquery.mCustomScrollbar.concat.min.js"></script>
     <script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
     <script type="text/javascript" src="../../js/category.js"></script>
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
                category.init();
                initDataTable();
		     });
         function validateForm() {
            var category = $("#category").val();
            if (category == '' || category == undefined) {
              $("#msg").html("Please enter category name");
              $("#msg").addClass("text-danger");
              return false;;
            }
            return true;
         }
         function initDataTable() {
            $('#category-datatable').DataTable({
                  "ajax":{"url":'../../controllers/CategoryDisplayController.php',"dataSrc":""},
                  "columns": [
                    { "data": "name" },
                    { "data": "created_by"},
                    { "data": "created_at" },
                    { "data": "c_id",
                        title:"Action",
                        render:function(data, type, row, meta) {
                          return "<a href=javascript:void(0) onclick='editCategory("+data+")'><i class='glyphicon glyphicon-edit action'></i></a>"
                        }
                    }
                  ],
                  order: [[ 3, "desc" ]],
                  searching : false,
                  scrollY: "300px",
                  scrollCollapse: false,
                  paging: true
            });
        }
        function editCategory(item_id) {
          $("#item_form").attr("action", '<?php echo BASE_URL ?>' + '/controllers/CategoryController.php?action=update_category');
          $("#submitBtn").html("Update");
            $.ajax({
                url: '<?php echo BASE_URL ?>' + '/api/v1/category/get_category.php?item_id=' + item_id,
                success: function(data) {
                  var item = JSON.parse(data);
                  $("#categoryId").val(item["c_id"]);
                  $("#category").val(item["name"]);
                  $("#myModal").modal('show');
                }
            });
         }
		 </script>
	</body>
</html>
