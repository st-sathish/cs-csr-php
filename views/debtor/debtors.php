<?php
session_start();
if(!isset($_SESSION['username'])) {
  header("location:<?php echo BASE_URL ?>/index.php");
}
$page = "debtors";
include "../../constants.php";
error_reporting(0);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Debtors</title>

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
                         <div class="col-md-2 ">
                            <button type="button" class="btn btn-primary" data-toggle="modal" 
                            data-target="#myModal">Add Debtor</button>
                        </div>
                    </div>
                    <div class="col-md-12" style="padding-top:25px">
                        <table id="debtor-datatable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                      <label>Select All</label>
                                      <div style="text-align: center;"><input name="select_all" value="1" id="select-all" type="checkbox"></div>
                                    </th>
                                    <th>Emp Id</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th>Modified By</th>
                                    <th>Modified At</th>
                                    <th>Debt Amount</th>
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
              <form method="POST" onsubmit="return validateForm()" id="debtor_form">
                <input type="hidden" id="debtorId" name="debtorId" />
                <div class="form-group">
                  <label for="debtorEmpId">Debtor Employee Id:<span class="required">*</span>
                  <span title="Employee Id"><i class="glyphicon glyphicon-question-sign help-icon"></i></span></label>
                  <input type="text" name="debtorEmpId" class="form-control" id="debtorEmpId">
                </div>
                <div class="form-group">
                  <label for="firstName">First Name:<span class="required">*</span>
                  <span title="First Name"><i class="glyphicon glyphicon-question-sign help-icon"></i></span></label>
                  <input type="text" name="firstName" class="form-control" id="firstName">
                </div>
                <div class="form-group">
                  <label for="lastName">Last Name:<span class="required">*</span>
                  <span title="Last Name"><i class="glyphicon glyphicon-question-sign help-icon"></i></span></label>
                  <input type="text" name="lastName" class="form-control" id="lastName">
                </div>
                <div class="form-group">
                  <label for="email">Email:<span class="required">*</span>
                  <span title="Email"><i class="glyphicon glyphicon-question-sign help-icon"></i></span></label>
                  <input type="text" name="email" class="form-control" id="email">
                </div>
                <div class="form-group">
                  <label for="debtAmount">Debt Amount:
                  <span title="Debt Amount"><i class="glyphicon glyphicon-question-sign help-icon"></i></span></label>
                  <input type="text" name="debtAmount" class="form-control" id="debtAmount">
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
                $(".modal-title").html("Add Debtor");
                $("#submitBtn").html("Save");
                $("#debtor_form").attr("action", '<?php echo BASE_URL ?>' + '/controllers/DebtorController.php?'+
                  'action=add_debtor');
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

            function validateForm() {
              var debtEmpId = $("#debtorEmpId").val();
              var firstName = $("#firstName").val();
              var lastName = $("#lastName").val();
              var email = $("#email").val();
              if (debtEmpId == '' || debtEmpId == undefined) {
                $("#msg").html("Please enter Debtor Employee Id");
                $("#msg").addClass("text-danger");
                return false;;
              }
              if (firstName == '' || firstName == undefined) {
                $("#msg").html("Please enter First Name");
                $("#msg").addClass("text-danger");
                return false;
              }
              if (lastName == '' || lastName == undefined) {
                $("#msg").html("Please enter Last Name");
                $("#msg").addClass("text-danger");
                return false;
              }
              if (email == '' || email == undefined) {
                $("#msg").html("Please enter Email");
                $("#msg").addClass("text-danger");
                return false;
              }
              return true;
           }

         function editDebtor(debt_id) {
          $("#debtor_form").attr("action", '<?php echo BASE_URL ?>' + '/controllers/DebtorController.php?action=edit_debtor');
          $(".modal-title").html("Update Debtor");
          $("#submitBtn").html("Update");
            $.ajax({
                url: '<?php echo BASE_URL ?>' + '/api/v1/debtors/get_debtor.php?debtor_id=' + debt_id,
                success: function(data) {
                  var item = JSON.parse(data);
                  $("#debtorId").val(item["debtor_id"]);
                  $("#debtorEmpId").val(item["debtor_emp_id"]);
                  $('#firstName').val(item["first_name"]);
                  $('#lastName').val(item["last_name"]);
                  $('#email').val(item["email"]);
                  $("#debtAmount").val(item["debtor_balance"]);
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
            var table = $('#debtor-datatable').DataTable({
                  "processing": true, 
                  "serverSide": true,
                  "language": {
                      searchPlaceholder: "Search by Email"
                  },
                  "ajax": {
                    "url" :'../../controllers/DebtorsDisplayController.php'
                  },
                  "columns": [
                    {
                      "data": "debtor_id",
                      'targets': 0,
                      'searchable':false,
                      'orderable':false,
                      'className': 'dt-body-center',
                      'render': function (data, type, full, meta){
                         return '<input type="checkbox" class="row" data-id="'+data+'" name="id[]">';
                      }
                    },
                    { 
                      "data": "debtor_emp_id"
                    },
                    { 
                      "data": "first_name" 
                    },
                    { 
                      "data": "last_name" 
                    },
                    { 
                      "data": "email" 
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
                    { 
                      "data": "debtor_balance"
                    },
                    { "data": "debtor_id",
                        title:"Action",
                        render:function(data, type, row, meta) {
                          return "<a href=javascript:void(0) title='Edit' onclick='editDebtor("+data+")'><i class='glyphicon glyphicon-edit action'></i></a>&nbsp;&nbsp;<a href=javascript:void(0) title='Intimate' onclick='intimate("+data+")'><i class='glyphicon glyphicon-envelope action'></i></a>"
                        }
                    }
                  ],
                  order: [[ 9, "desc" ]],
                  searching : true,
                  scrollY: "300px",
                  scrollCollapse: false
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
            $('#debtor-datatable').find('input[type="checkbox"]:checked').each(function() {
                ids.push($(this).attr('data-id'));
            });
            return ids;
         }

        function mkPostRequestDelete(ids) {
            mkPostRequest('delete_debtors.php', ids, "please select checkbox to Delete");
        }

        function mkPostRequest(php_file, ids, msg) {
          if(ids.length == 0) {
                alert(msg);
                return;
            }
            $.ajax({
                url: '<?php echo BASE_URL ?>' + '/api/v1/debtors/'+php_file,
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
