<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string

$ob = new dbconnection();
$con = $ob->connection();
//to display task list

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('common/files.php') ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <style media="screen">
      .autocompleter-item:hover{
        cursor:pointer;
        font-size:17px !important;
      }
      .autocompleter-item{
        font-size:16px !important;
        margin: 5px;
        color: #0066cc;
      }
    </style>
</head>

<body>

  <?php if ($_SESSION['username'] == 'Admin') {
    include('common/sidebar.php');
  } elseif ($_SESSION['username'] == 'Accounts') {
    include('common/Accsidebar.php');
  }
  ?>
    <!-- /# sidebar -->
    <script type="text/javascript">
      document.getElementById('organization').className = 'active open';
      document.getElementById('expenses').className = 'active';
    </script>


    <?php include('common/header.php') ?>
    <!-- head bar -->


    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-7 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>New Expense</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-5 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                              <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="expenses.php">Company Expenses</a></li>
                                <li class="breadcrumb-item myactive">Add New Payment</li>
                              </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->
                <section id="main-content">

                  <?php include('src/itemAlert.php') ?>


                  <script src="../vendor/autocomplete/src/jquery.autocompleter.min.js"></script>
                  <script src="../vendor/autocomplete/main.js"></script>

                    <div class="col-lg-12 col-sm-12">
                      <div class="card">
                        <div class="card-title">
                            <h4>Add Expense</h4>
                        </div>
                        <div class="basic-form"> <br>
                            <form id="myForm" method="post" action="controller/expenses.php" enctype="multipart/form-data" autocomplete="on">
                              <label id="err" style="display:none;color:red">Salary Payments on <b><?php echo date('F Y', strtotime(date('Y-m')." -1 month")); ?> </b>are not Generated</label>
                              <label id="paiderr" style="display:none;color:red">Salary Payments on <b><?php echo date('F Y', strtotime(date('Y-m')." -1 month")); ?> </b>are Already Paid</label>
                              <div class="row">
                                <div class="col-lg-4 col-sm-6">
                                  <div class="form-group">
                                      <label>Expense Type <span style="color:red">*</span></label>
                                      <input type="text" id="expense_type" name="type" class="form-control" value="" required>
                                  </div>
                                </div>

                                <div class="col-lg-4 col-sm-6">
                                  <div class="form-group">
                                      <label>Pay Account <span style="color:red">*</span></label>
                                      <select  class="form-control" name="account" required>
                                        <option value="">Select Account</option>
                                        <option value="Check Account">Check Account</option>
                                        <option value="Call Account">Call Account</option>
                                      </select>
                                  </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                  <div class="form-group">
                                      <label>Payment Method <span style="color:red">*</span></label>
                                      <select id="method" class="form-control" name="method" required>
                                        <option value="">Select Method</option>
                                        <option value="Online Banking">Online Banking</option>
                                        <option value="Bank Transaction">Bank Transaction</option>
                                        <option value="Check Payment">Check Payment</option>
                                        <option value="Cash Payment">Cash Payment</option>
                                      </select>
                                  </div>
                              </div>
                            </div>

                            <?php
                            $pay_amt = 0;
                            $month = date('Y-m', strtotime(date('Y-m')." -1 month"));;
                              $sql_empd = "SELECT SUM(net_salary) FROM salary_master WHERE month='$month'";
                              $result_empd = $con->query($sql_empd);
                              $row_empd = $result_empd->fetch_array();

                              $sql = "SELECT * FROM salary_master WHERE month='$month' AND payDate=''";
                              $result= $con->query($sql);
                               $count = $result->num_rows;

                               if ($count > 0) {
                                 $pay_amt = $row_empd[0];
                               } else{
                                 $pay_amt = 'paid';
                               }
                            ?>

                            <script type="text/javascript">
                            $("#expense_type").change(function(){
                              var val = $('#expense_type').val();
                              if (val == 'Salary Payments <?php echo date('F Y', strtotime(date('Y-m')." -1 month")); ?>') {
                                var pay_amt = '<?php echo $pay_amt; ?>'
                                if (pay_amt == '0') {
                                  $("#err").css("display", "block");
                                  $("#amount").prop("readonly", true);
                                  $('#method option[value="Bank Transaction"]').attr("selected", "selected");
                                } else if(pay_amt == 'paid'){
                                  $("#amount").prop("readonly", true);
                                  $("#paiderr").css("display", "block");
                                  $('#method option[value="Bank Transaction"]').attr("selected", "selected");
                                }else{
                                  $('#amount').val(pay_amt+'.00')
                                  $('#method option[value="Bank Transaction"]').attr("selected", "selected");
                                }

                              } else{
                                $("#err").css("display", "none");
                                $("#paiderr").css("display", "none");
                                $('#amount').val('')
                                $("#amount").removeAttr('readonly');
                              }
                            });
                            </script>


                              <div class="row">
                                <div class="col-lg-4 col-sm-6">
                                  <div class="form-group">
                                      <label>Payment Amount <span style="color:red">*</span></label>
                                      <input type="number" id="amount" name="amount" class="form-control" value="" required>
                                  </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                  <div class="form-group">
                                      <label>Pay Date <span style="color:red">*</span></label>
                                      <input type="date" name="paidDate" class="form-control" max="<?php echo date('Y-m-d'); ?>"  value="<?php echo date('Y-m-d'); ?>" required>
                                  </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                  <br> <br>
                                  <button style="float:right" type="submit" class="btn btn-success" id="submitform" name="submit">Upload</button>
                                  <p id="err2" style="display:none;color:red;"><b>Please Enter Payment Amount..!</b></p>
                                </div>
                              </div>

                            </form>
                        </div>
                      </div>
                    </div>
                  <!-- </div> -->

                  <script type="text/javascript">
                  $( "#myForm" ).submit(function( event ) {
                      var val = $('#amount').val()
                      if ((val == '0') || (val == '')) {
                        $("#err2").css("display", "block");
                        event.preventDefault();
                      }
                    });
                  </script>


                  <div class="row">
                      <div class="col-lg-12">
                          <div class="footer">
                              <p>2022 © Developed By Ishu Nawodya</p>
                          </div>
                      </div>
                  </div>
              </section>
            </div>
            </div>
            </div>

            <!-- <script src="assets/js/sweetAlert.js"></script> -->
            <!-- jquery vendor -->
            <!-- <script src="assets/js/lib/jquery.min.js"></script> -->
            <script src="assets/js/lib/jquery.nanoscroller.min.js"></script>
            <!-- nano scroller -->
            <script src="assets/js/lib/menubar/sidebar.js"></script>
            <script src="assets/js/lib/preloader/pace.min.js"></script>
            <!-- sidebar -->

            <script src="assets/js/lib/bootstrap.min.js"></script>
            <script src="assets/js/scripts.js"></script>
            <!-- bootstrap -->

            <script src="assets/js/lib/calendar-2/moment.latest.min.js"></script>
            <script src="assets/js/lib/calendar-2/pignose.calendar.min.js"></script>
            <script src="assets/js/lib/calendar-2/pignose.init.js"></script>

            <script src="assets/js/lib/toastr/toastr.min.js"></script>
            <script src="assets/js/lib/toastr/toastr.init.js"></script>


            <script src="assets/js/lib/weather/jquery.simpleWeather.min.js"></script>
            <script src="assets/js/lib/weather/weather-init.js"></script>
            <script src="assets/js/lib/circle-progress/circle-progress.min.js"></script>
            <script src="assets/js/lib/circle-progress/circle-progress-init.js"></script>
            <script src="assets/js/lib/chartist/chartist.min.js"></script>
            <script src="assets/js/lib/sparklinechart/jquery.sparkline.min.js"></script>
            <script src="assets/js/lib/sparklinechart/sparkline.init.js"></script>
            <script src="assets/js/lib/owl-carousel/owl.carousel.min.js"></script>
            <script src="assets/js/lib/owl-carousel/owl.carousel-init.js"></script>
            <!-- scripit init-->
            <script src="assets/js/dashboard2.js"></script>
     <!-- footer -->

          <script src="assets/js/lib/toastr/toastr.min.js"></script>
          <script src="assets/js/lib/toastr/toastr.init.js"></script>

          <script type="text/javascript">
          /**
           * Crayola colors in JSON format
           * from: https://gist.github.com/jjdelc/1868136
           */
          var colors =
          [
              {
                  "label": "Salary Payments <?php echo date('F Y', strtotime(date('Y-m')." -1 month")); ?>",
              },
              {
                  "label": "Electricity Bill",
              },
              {
                  "label": "Maintenance Bill",
              },
              {
                  "label": "Water Bill",
              },
              {
                  "label": "Meal Allowance",
              },
              {
                  "label": "Function Charges",
              },
              {
                  "label": "Network Bill",
              },
              {
                  "label": "Product Purchase",
              },
              {
                  "label": "Donations",
              },
              {
                  "label": "Other",
              },
          ];

          $(function () {
            $('#expense_type').autocompleter({
                  // marker for autocomplete matches
                  highlightMatches: true,

                  // object to local or url to remote search
                  source: colors,

                  // abort source if empty field
                  empty: false,

                  // max results
                  limit: 5,

                  callback: function (value, index, selected) {
                      if (selected) {
                          $('.icon').css('background-color', selected.hex);
                      }
                  }
              });
          });

          </script>

</body>

</html>
