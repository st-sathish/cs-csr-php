<?php
session_start();
if(!isset($_SESSION['username'])) {
  header("location:<?php echo BASE_URL ?>/index.php");
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
                            <button type="button" class="btn btn-primary" id="sold_btn">Mark As Sold</button>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary" id="remove_btn">Remove All</button>
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
                                      <div style="text-align: center;"><input name="select_all" value="1" id="select-all" type="checkbox"></div>
                                    </th>
                                    <th>Item Name</th>
                                    <th>Bar Code</th>
                                    <th>Expiry Date</th>
                                    <th>Purchase Price</th>
                                    <th>Selling Price</th>
                                    <th>Category</th>
                                    <th>Sold</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Total</th>
                                    <th>Total</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
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
                  <label for="price">Purchase Price:<span title="Purchasd price"><i class="glyphicon glyphicon-question-sign help-icon"></i></span></label>
                  <input type="text" name="purchase_price" class="form-control" id="purchase_price">
                </div>
                <div class="form-group">
                  <label for="price">Selling Price:<span title="Selling price"><i class="glyphicon glyphicon-question-sign help-icon"></i></span></label>
                  <input type="text" name="selling_price" class="form-control" id="selling_price">
                </div>
                <div class="form-group">
                  <label for="category">Category:<span class="required">*</span><span title="Choose the item category"><i class="glyphicon glyphicon-question-sign help-icon"></i></span></label>
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
            var expirydate = $("#datepicker").val();
            if (expirydate == '' || expirydate == undefined) {
              $("#msg").html("Please enter expiry date");
              $("#msg").addClass("text-danger");
              return false;;
            }
            var category = $("#category").val();
            if (category == '' || category == undefined) {
              $("#msg").html("Please select a category");
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
                  $('#purchase_price').val(item["purchase_price"]);
                  $('#selling_price').val(item["selling_price"]);
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
            var table = $('#item-datatable')
                .DataTable({
                  "processing": true, 
                  "serverSide": true,
                  "language": {
                      searchPlaceholder: "Search by Item Name"
                  },
                  "ajax": {
                    "url" :'../../controllers/ItemsDisplayController.php'
                  },
                  "columns": [
                    {
                      "data": "i_id",
                      'targets': 0,
                      'searchable':false,
                      'orderable':false,
                      'className': 'dt-body-center',
                      'render': function (data, type, full, meta){
                         return '<input type="checkbox" class="row" data-id="'+data+'" name="id[]">';
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
                      "data": "purchase_price" 
                    },
                    { 
                      "data": "selling_price" 
                    },
                    { 
                      "data": "category.name"
                    },
                    { 
                      "data": "is_sold",
                      "render": function(data) {
                          return data == 1 ? "Yes" : "No";
                      }
                    },
                    { "data": "i_id",
                        title:"Action",
                        render:function(data, type, row, meta) {
                          return "<a href=javascript:void(0) onclick='editItem("+data+")'><i class='glyphicon glyphicon-edit action'></i></a>"
                        }
                    }
                  ],
                  order: [[ 5, "desc" ]],
                  searching : true,
                  ordering: false,
                  scrollY: "300px",
                  scrollCollapse: false,
                  "createdRow": function( row, data, dataIndex){
                      if(data[3] ==  `someVal`){
                          $(row).addClass('redClass');
                      }
                  },
                  footerCallback: function ( row, data, start, end, display ) {
                      var api = this.api(), data;
           
                      // Remove the formatting to get integer data for summation
                      var intVal = function ( i ) {
                          return typeof i === 'string' ?
                              i.replace(/[\$,]/g, '')*1 :
                              typeof i === 'number' ?
                                  i : 0;
                      };
           
                      // Total over all pages
                      total_col4 = api
                          .column( 4 )
                          .data()
                          .reduce( function (a, b) {
                              return intVal(a) + intVal(b);
                          }, 0 );
           
                      // Total over this page
                      pageTotal_col4 = api
                          .column( 4, { page: 'current'} )
                          .data()
                          .reduce( function (a, b) {
                              return intVal(a) + intVal(b);
                          }, 0 );

                      // Total over all pages
                      total_col5 = api
                          .column( 5 )
                          .data()
                          .reduce( function (a, b) {
                              return intVal(a) + intVal(b);
                          }, 0 );
           
                      // Total over this page
                      pageTotal_col5 = api
                          .column( 5, { page: 'current'} )
                          .data()
                          .reduce( function (a, b) {
                              return intVal(a) + intVal(b);
                          }, 0 );
           
                      // Update footer
                      $( api.column( 4 ).footer() ).html(
                          pageTotal_col4 +' ('+ total_col4 +' total)'
                      );

                      // Update footer
                      $( api.column( 5 ).footer() ).html(
                          pageTotal_col5 +' ('+ total_col5 +' total)'
                      );
                  }
            });
            // Handle click on "Select all" control
             $('#select-all').on('click', function(){
                // Check/uncheck all checkboxes in the table
                var rows = table.rows({ 'search': 'applied' }).nodes();
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
             });
              $('#sold_btn').click(function() {
                  mkPostRequestMarkAsSold(getAllSelectedCheckbox());
              });
              $('#remove_btn').click(function() {
                  mkPostRequestDelete(getAllSelectedCheckbox());
              });
         }

         function getAllSelectedCheckbox() {
            var ids = [];
            $('#item-datatable').find('input[type="checkbox"]:checked').each(function() {
                ids.push($(this).attr('data-id'));
            });
            return ids;
         }

        function mkPostRequestMarkAsSold(ids) {
            mkPostRequest('mark_as_sold.php', ids, "please select checkbox to mark as sold");
        }
        function mkPostRequestDelete(ids) {
            mkPostRequest('delete.php', ids, "please select checkbox to Delete");
        }

        function mkPostRequest(php_file, ids, msg) {
          if(ids.length == 0) {
                alert(msg);
                return;
            }
            $.ajax({
                url: '<?php echo BASE_URL ?>' + '/api/v1/items/'+php_file,
                data: {
                  'username':'<?php echo $_SESSION['username']?>',
                  'ids': ids
                },
                method: 'POST',
                success: function(data) {
                    var resp = JSON.parse(data);
                    alert(resp.message);
                    location.reload();
                }
            });
        }
        </script>
    </body>
</html>
