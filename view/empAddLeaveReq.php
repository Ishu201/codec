<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string
//include '../model/commonmodel.php';
$ob = new dbconnection();
$con = $ob->connection();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('common/files.php') ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
  <?php
    include('common/empSidebar.php') ;
  ?>

    <!-- /# sidebar -->
    <script type="text/javascript">
      document.getElementById('leave').className = 'active open';
      document.getElementById('leaveReq').className = 'active';
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
                                <h1>Leave Request Application</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-5 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="empleaveReq.php">Leave Requests</a></li>
                                    <li class="breadcrumb-item myactive">Leave Application</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->
                <section id="main-content">
                    <div class="col-lg-12 col-sm-12">
                      <div class="card">
                        <div class="card-title">
                            <h4>Leave Request Application</h4>
                        </div>
                        <div class="basic-form"> <br>
                            <form method="post" action="controller/sendLeave_req.php">
                              <div class="row">
                                <div class="col-lg-3 col-sm-6">
                                  <div class="form-group">
                                      <label>Leave Type <span style="color:red">*</span></label>
                                      <select class="form-control" id="leaveID" name="leaveID" required>
                                        <option value="">Select Leave Type</option>
                                        <?php
                                          $sql4 = "SELECT * FROM company_leaves WHERE stat ='Active'";
                                          $result4 = $con->query($sql4);
                                          while ($row_cleave = $result4->fetch_array()) {
                                            $type = $row_cleave['leave_type'];
                                            $sql6 = "SELECT * FROM employee_leaves WHERE leaveID ='$type' AND empID ='$session_empID' AND stat='On'";
                                            $result6 = $con->query($sql6);
                                            $row6 = $result6->fetch_array();
                                            if ($row6['leaveID'] != $row_cleave['leave_type']) {
                                              $stat = 'style="display:none"';
                                            } else{
                                              $stat = '';
                                            }

                                            if (($row6['days']-$row6['used']) == 0) {
                                              $condition = 'disabled';
                                            } else{
                                              $condition = '';
                                            }

                                        ?>
                                        <option  value="<?php echo $row_cleave['leaveID']; ?>" <?php echo $stat; echo $condition; ?>><?php echo $row_cleave['leave_type']; ?> - (<?php echo $row6['days']-$row6['used']; ?> Days)</option>
                                        <?php } ?>
                                      </select>
                                  </div>
                                </div>
                                <div class="col-lg-3 col-sm-4">
                                  <div class="form-group">
                                      <label>From Date <span style="color:red">*</span></label>
                                      <input type="date" class="form-control" name="startDate" min="<?php echo date('Y-m-d'); ?>" id="startDate" required>
                                  </div>
                                </div>

                                <?php
                                  $stop_date = date('Y-m-d');
                                  $stop_date = date('Y-m-d', strtotime($stop_date . ' +1 day'));
                                ?>

                                <div class="col-lg-3 col-sm-4">
                                  <div class="form-group">
                                      <label>To Date <span style="color:red">*</span></label>
                                      <input type="date"  class="form-control" name="endDate" id="endDate" min="<?php echo $stop_date; ?>" onchange="get_duration();" required>
                                      <input type="hidden" name="duration" id="duration" value="">
                                      <input type="hidden" name="empID"  value="<?php echo $session_empID; ?>">
                                  </div>
                                </div>


                                <script type="text/javascript">
                                function get_duration(){
                                  var start = $('#startDate').val();
                                  var end = $('#endDate').val();

                                  var startDay = new Date(start);
                                  var endDay = new Date(end);

                                 var millisBetween = startDay.getTime() - endDay.getTime();

                                 var days = millisBetween / (1000 * 3600 * 24);

                              // Show the final number of days between dates
                                 var difference = Math.round(Math.abs(days));

                                  if (difference == 1) {
                                    difference = '1 Day'
                                  } else{
                                    difference = difference+' Days'
                                  }

                                  $('#duration').val(difference);
                                }

                                </script>


                                <div class="col-lg-12 col-sm-6">
                                  <div class="form-group">
                                      <label>Reason for the Leave <span style="color:red">*</span></label>
                                      <textarea class="form-control" name="reason" rows="8" style="height:150px" cols="80" required></textarea>
                                  </div>
                                </div>
                              </div>


                              <div class="float-right">
                                <button type="reset" class="btn btn-default">Clear</button>
                                <button type="submit" class="btn btn-success">Send Request</button>
                              </div>
                            </form>
                        </div>
                      </div>
                    </div>
                  <!-- </div> -->


      <?php include('common/footer.php') ?>
     <!-- footer -->

</body>

</html>
