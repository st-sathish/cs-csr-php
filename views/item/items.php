<?php
session_start();
if(!isset($_SESSION['username'])) {
  header("location:/csr/index.php");
}
$page = "items";
include "../../constants.php";
error_reporting(0);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Items</title>

         <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <!-- Our Custom CSS -->
        <link href="../../css/style1.css" rel="stylesheet" type="text/css" media="all"/>
        <!-- Scrollbar Custom CSS -->
        <link rel="stylesheet" href="../../css/jquery.mCustomScrollbar.min.css">
        <link rel="stylesheet" href="../../css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="../../css/jquery-ui.css">
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
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary">Mark As Sold</button>
                        </div>
                         <div class="col-md-2 ">
                            <button type="button" class="btn btn-primary" data-toggle="modal" 
                            data-target="#myModal">Add Item</button>
                        </div>
                    </div>
                    <div class="col-md-12" style="padding-top:25px">
                        <table id="item-datatable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                      <label>Select All</label>
                                      <div style="text-align: center;"><input type="checkbox"></div>
                                    </th>
                                    <th>Item Name</th>
                                    <th>Bar Code</th>
                                    <th>Expiry Date</th>
                                    <th>Price</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th>Modified By</th>
                                    <th>Modified At</th>
                                    <th>Category</th>
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
                <h4 class="modal-title"></h4>
              </div>
              <div class="modal-body">
              <div id="msg"></div>
              <form method="POST" onsubmit="return validateForm()" id="item_form">
                <input type="hidden" id="itemId" name="itemId" />
                <div class="form-group">
                  <label for="itemName">Item Name:<span class="required">*</span>
                  <span title="Product item/particular name"><i class="glyphicon glyphicon-question-sign help-icon"></i></span></label>
                  <input type="text" name="itemName" class="form-control" id="itemName">
                </div>
                <div class="form-group">
                  <label for="barCode">Bar Code:<span class="required">*</span>
                  <span title="Product bar code for unique identitiy"><i class="glyphicon glyphicon-question-sign help-icon"></i></span></label>
                  <input type="text" name="barCode" class="form-control" id="barCode">
                </div>
                <div class="form-group">
                  <label for="expiryDate">Expiry Date:<span class="required">*</span>
                  <span title="This will alert admin 3 months/2 weeks before the product has been expired"><i class="glyphicon glyphicon-question-sign help-icon"></i></span></label>
                  <input type="text" name="expiryDate" class="form-control" id="datepicker" readonly="readonly">
                </div>
                <div class="form-group">
                  <label for="price">Price:<span title="Product MRP price"><i class="glyphicon glyphicon-question-sign help-icon"></i></span></label>
                  <input type="text" name="price" class="form-control" id="price">
                </div>
                <div class="form-group">
                  <label for="category">Category:<span title="Choose the item category"><i class="glyphicon glyphicon-question-sign help-icon"></i></span></label>
                  <select id="category" class="form-control" name="category"></select>
                </div>
                <div class="col-md-offset-8">
                    <button type="submit" class="btn btn-success" id="submitBtn"></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
              </form>
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
     <script type="text/javascript" src="../../js/jquery-ui.min.js"></script>
     <script type="text/javascript" src="../../js/category.js"></script>
         <script type="text/javascript">
             $(document).ready(function () {
                $(".modal-title").html("Add Item");
                $("#submitBtn").html("Save");
                $("#item_form").attr("action", '<?php echo BASE_URL ?>' + '/controllers/ItemController.php?action=add_item');
                 $("#sidebar").mCustomScrollbar({
                    theme: "minimal"
                });
                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar, #content').toggleClass('active');
                    $('.collapse.in').toggleClass('in');
                    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
                });
                initDataTable();
                category.getCategories(parseCategories);
                $( "#datepicker" ).datepicker();
             });
         function validateForm() {
            var itemName = $("#itemName").val();
            if (itemName == '' || itemName == undefined) {
              $("#msg").html("Please enter Item Name");
              $("#msg").addClass("text-danger");
              return false;;
            }
            var barcode = $("#barCode").val();
            if (barcode == '' || barcode == undefined) {
              $("#msg").html("Please enter Bar Code");
              $("#msg").addClass("text-danger");
              return false;;
            }
            return true;
         }

         function parseCategories(results) {
            for(var i =0;i < results.length;i++) {
              $("#category").append('<option value="'+results[i].c_id+'">'+results[i].name+'</option>');
            }
         }

         function editItem(item_id) {
          $("#item_form").attr("action", '<?php echo BASE_URL ?>' + '/controllers/ItemController.php?action=edit_item');
          $(".modal-title").html("Update Item");
          $("#submitBtn").html("Update");
            $.ajax({
                url: '<?php echo BASE_URL ?>' + '/api/v1/items/get_item.php?item_id=' + item_id,
                success: function(data) {
                  var item = JSON.parse(data);
                  $("#itemId").val(item["i_id"]);
                  $("#itemName").val(item["item_name"]);
                  $('#barCode').val(item["barcode"]);
                  $('#datepicker').val(item["expiry_date"]);
                  $('#price').val(item["price"]);
                  $("#category select").val(item["category"]["c_ids"]);
                  $("#myModal").modal('show');
                }
            });
         }

         function formatDate(data) {
            var date = new Date(data);
            var month = date.getMonth() + 1;
            return (month.length > 1 ? month : "0" + month) + "-" + date.getDate() + "-" + date.getFullYear();
         }

         function initDataTable() {
            $('#item-datatable')
                .DataTable({
                  "processing": true, 
                  "serverSide": true,
                  "language": {
                      searchPlaceholder: "Search by Item Name"
                  },
                  "ajax": {
                    url:'../../controllers/ItemsDisplayController.php'
                  },
                  "columns": [
                    {
                     'targets': 0,
                     'searchable':false,
                     'orderable':false,
                     'className': 'dt-body-center',
                     'render': function (data, type, full, meta){
                         return '<input type="checkbox" name="id[]" value="' 
                            + $('<div/>').text(data).html() + '">';
                      }
                    },
                    { 
                      "data": "item_name"
                    },
                    { 
                      "data": "barcode" 
                    },
                    { 
                      "data": "expiry_date" 
                    },
                    { 
                      "data": "price" 
                    },
                    { 
                      "data": "created_by"
                    },
                    { 
                      "data": "created_at",
                      "render": formatDate
                    },
                    { 
                      "data": "modified_by" 
                    },
                    { 
                      "data": "modified_at",
                      "render": formatDate
                    },
                    { "data": "category.name" },
                    { "data": "i_id",
                        title:"Action",
                        render:function(data, type, row, meta) {
                          return "<a href=javascript:void(0) onclick='editItem("+data+")'><i class='glyphicon glyphicon-edit action'></i></a>&nbsp;&nbsp;&nbsp;<a href=javascript:void(0)><i class='glyphicon glyphicon-trash action' aria-hidden='true'></i></a>"
                        }
                    }
                  ],
                  order: [[ 9, "desc" ]],
                  searching : true,
                  scrollY: "300px",
                  scrollCollapse: false
            });
         }
         </script>
    </body>
</html>
