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
    <link rel="stylesheet" href="assets/css/pagination.css">

    <style media="screen">
    input[type="search"]{
      width:300px !important;
    }

      html,body{
        width: 100%;
        height: 100%;
        margin: 0px;
        padding: 0px;
        overflow-x: hidden;
      }

      .dataTables_length{
        position: absolute;
        top:50px;
        right:5px;
        margin-bottom: 10px
      }

      .dt-buttons{

      }


      .dataTables_filter{
        position: absolute;
        top:90px;
        left:15px;
      }

      .table-responsive{
        margin-top:55px;
      }

      .pagination{
        position: absolute;
        bottom: 10px;
        right: 15px;
      }

      .dataTables_info{
        margin-top: 10px;
      }

      .btn-sm{
        font-size: 13px;
      }

    </style>

    <script type="text/javascript">
      window.alert = function() {};
      alert = function() {};
    </script>
</head>

<body>

    <?php if ($_SESSION['username'] == 'Admin') {
      include('common/sidebar.php');
    } elseif ($_SESSION['username'] == 'HR') {
      include('common/HRsidebar.php');
    }
    ?>
    <!-- /# sidebar -->
    <script type="text/javascript">
      document.getElementById('attendance').className = 'active open';
      document.getElementById('attReport').className = 'active';
    </script>

    <?php include('common/header.php') ?>
    <!-- head bar -->


    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Individual Attendance Report</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Attendance</a></li>
                                    <li class="breadcrumb-item myactive">Attendance Reports</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>

                <!-- /# row -->
                <section id="main-content">
                  <div class="row">
                    <div class="col-lg-9 col-sm-12">
                      <div class="card">
                        <div class="card-title">
                            <h4>Select An Employee</h4>
                        </div>
                        <form class="" >
                          <div class="row">
                            <div class="col-lg-5">
                              <div class="form-group">
                                  <label>Month <span style="color:red">*</span></label>
                                  <input type="month"  class="form-control" name="month" value="<?php if (!isset($_REQUEST['month'])) {  echo date('Y-m'); } else{ echo $_REQUEST['month']; } ?>" placeholder="Select the Month"  required>
                              </div>
                            </div>
                            <div class="col-lg-5">
                              <div class="form-group">
                                  <label>Employee Name <span style="color:red">*</span></label>
                                  <select  style="text-transform:capitalize" class="form-control" name="searchid" required>
                                    <option value="">Select</option>

                                    <?php
                                    $sql_empd = "SELECT * FROM employee WHERE empJobStatus='working'";
                                    $result_empd = $con->query($sql_empd);
                                    while ($row_empd = $result_empd->fetch_array()) {
                                    ?>
                                    <option style="text-transform:capitalize" value="<?php echo $row_empd['empID']; ?>" <?php //echo $stat; ?>><?php echo $row_empd['empName']; ?></option>
                                  <?php } ?>
                                  </select>
                              </div>
                            </div>
                            <div class="col-lg-2">
                              <br>
                              <div style="margin-top:10px;text-align:center;">
                                <button type="submit" class="btn btn-success">Show</button>
                              </div>
                            </div>
                          </div>

                        </form>
                      </div>
                    </div>
                    <br> <br>


                    <?php
                      if (isset($_REQUEST['searchid'])) {
                        $empID = $_REQUEST['searchid'];
                     ?>

                     <?php
                     $sql_empd = "SELECT * FROM employee  WHERE empID='$empID'";
                     $result_empd = $con->query($sql_empd);
                     $row_empd = $result_empd->fetch_array();

                     ?>
                    <!-- result card -->
                    <div class="col-lg-12 col-sm-12">
                      <div class="card">
                        <div class="card-title">
                            <h4>Attendance and Working Hours &nbsp - &nbsp <?php echo $row_empd['empName']; ?></h4>
                            <h6><?php  $month = $_REQUEST['month'];
                            $mon = DateTime::createFromFormat("Y-m" , $month);
                            echo $mon->format('Y-F'); ?>
                          </h6>
                        </div>
                        <div class="bootstrap-data-table-panel">
                            <div class="table-responsive">
                                <table id="bootstrap-data-table-export" class="table table-bordered">
                                    <thead>
                                        <tr style="background-color:#d6d6d6">
                                            <th>Date <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th style="text-align:center">In <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th style="text-align:center">Out <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th style="text-align:center">Work Hours <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <?php if($row_empd['empType'] == 'worker'){ ?>
                                            <th style="text-align:center">OT Hours <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                          <?php } ?>
                                            <th style="text-align:center">Late (Mins) <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th style="text-align:center">Status <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                        $machineID = $row_empd['machineID'];
                                        $sql_attendace = "SELECT * FROM attendance_exported_table WHERE machineID='$machineID' AND date LIKE '$month%' ORDER BY date";
                                        $result_attendace = $con->query($sql_attendace);

                                          $total_work = 0;
                                          $total_ot = 0;
                                          $total_late = 0;

                                        while ($row_attendace = $result_attendace->fetch_array()) {

                                          $date = $row_attendace['date'];
                                          $date = DateTime::createFromFormat("Y-m-d" , $date);
                                        ?>
                                        <tr>
                                            <td><b><?php echo $date->format('Y-m-d'); ?> &nbsp - &nbsp <?php echo $date->format('l'); ?></b></td>
                                            <td style="text-align:right"><?php if ($row_attendace['DayIn'] != '0') { echo $row_attendace['DayIn']; } else{ echo '-'; }  ?></td>
                                            <td style="text-align:right"><?php if ($row_attendace['DayOut'] != '0') { echo $row_attendace['DayOut']; } else{ echo '-'; }  ?></td>
                                            <td style="text-align:right"><?php if ($row_attendace['workingHrs'] != 0) { echo number_format($row_attendace['workingHrs'], 2); } else{ echo '-'; }  ?></td>
                                            <?php if($row_empd['empType'] == 'worker'){ ?>
                                            <td style="text-align:right"><?php if ($row_attendace['OThrs'] != 0) { echo number_format($row_attendace['OThrs'], 2); } else{ echo '-'; } ?></td>
                                          <?php } ?>
                                            <td style="text-align:right"><?php if ($row_attendace['late'] != 0) { echo number_format($row_attendace['late'], 2); } else{ echo '-'; } ?></td>
                                            <td><?php
                                              if ($row_attendace['status'] == 'On') {
                                                echo '<span class="badge badge-info" >On Duty</span>';
                                              } else {
                                                $empID = $_REQUEST['searchid'];

                                                $sql_leaves = "SELECT * FROM leave_requests WHERE `empID`='$empID' AND `status`='Approved' AND `leave`='Yes'";
                                                $result_leaves = $con->query($sql_leaves);
                                                $row_leaves = $result_leaves->fetch_array();
                                                $rowcount3 = mysqli_num_rows($result_leaves);

                                                $c_date = $row_attendace['date'];

                                                  if ($rowcount3 > 0) {
                                                    $start = $row_leaves['startDate'];
                                                    $end = $row_leaves['endDate'];

                                                      if ($start == $end) {
                                                        if ($c_date == $start){
                                                          echo '<span class="badge badge-dark" >On Leave</span>';
                                                        }else{
                                                          echo '<span class="badge badge-danger" >Leave</span>';
                                                        }
                                                      }

                                                      else{
                                                        $final = 0;
                                                        $period = new DatePeriod(
                                                             new DateTime($start),
                                                             new DateInterval('P1D'),
                                                             new DateTime($end)
                                                        );

                                                        foreach ($period as $key => $value) {
                                                          $cdate = $value->format('Y-m-d');
                                                          if ($cdate == $c_date) {
                                                            $final = 1;
                                                          }
                                                        }

                                                        if ($final == 0) {
                                                          echo '<span class="badge badge-danger" >Leave</span>';
                                                        } else {
                                                           echo '<span class="badge badge-dark" >On Leave</span>';
                                                        }

                                                      }

                                                    //
                                                  } else{
                                                    echo '<span class="badge badge-danger" >Leave</span>';
                                                  }

                                              }  ?>
                                            </td>
                                        </tr>
                                      <?php
                                          $total_ot = $total_ot + $row_attendace['OThrs'];
                                          $total_work = $total_work + $row_attendace['workingHrs'];
                                          $total_late = $total_late + $row_attendace['late'];
                                        }
                                      ?>

                                      <tr>
                                        <th colspan="3"><b>Total</b></th>
                                        <td style="text-align:right"><b><?php echo number_format($total_work,2); ?> Hrs</b></td>
                                        <?php if($row_empd['empType'] == 'worker'){ ?>
                                        <td style="text-align:right"><b><?php echo number_format($total_ot,2); ?> Hrs</b></td>
                                      <?php } ?>
                                        <td style="text-align:right"><b><?php echo number_format($total_late,2); ?> Mins</b></td>
                                        <td></td>
                                      </tr>
                                    </tbody>
                                </table>
                            </div> <br>
                        </div>
                      </div>
                    </div>
                    <!-- result card -->
                  <?php } ?>

                  </div>


      <?php include('common/footer.php') ?>
     <!-- footer -->
     <?php include('common/tableExport.php') ?>

</body>

</html>
