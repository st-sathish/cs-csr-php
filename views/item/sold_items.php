<?php
session_start();
if(!isset($_SESSION['username'])) {
  header("location:<?php echo BASE_URL ?>/index.php");
}
$page = "sold_items";
include "../../constants.php";
error_reporting(0);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Expired Items</title>

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
                            <button type="button" class="btn btn-primary" id="remove_btn">Remove All</button>
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
                                    <th>Sold</th>
                                    <th>Category</th>
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
                                </tr>
                            </tfoot>
                        </table>
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
                 $("#sidebar").mCustomScrollbar({
                    theme: "minimal"
                });
                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar, #content').toggleClass('active');
                    $('.collapse.in').toggleClass('in');
                    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
                });
                initDataTable();
             });

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
                    url:'../../controllers/ItemsDisplayController.php?action=sold'
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
                      "data": "is_sold",
                      "render": function(data) {
                          return data == 1 ? "Yes" : "No";
                      }
                    },
                    { 
                      "data": "category.name"
                    }
                  ],
                  order: [[ 1, "desc" ]],
                  searching : true,
                  scrollY: "300px",
                  scrollCollapse: false,
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