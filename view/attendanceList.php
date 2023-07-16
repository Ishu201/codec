<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string
include 'model/departmentmodel.php';

$ob = new dbconnection();
$con = $ob->connection();
$obj = new department;
$result = $obj->viewDept();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('common/files.php') ?>
    <link rel="stylesheet" href="assets/css/pagination.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

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
      top:86px;
      left:15px;
    }

    .table-responsive{
      margin-top:40px;
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
      document.getElementById('attlist').className = 'active';
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
                                <h1>Total Employee Attendance List</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Attendance</a></li>
                                    <li class="breadcrumb-item myactive">Total Attendance</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>

                <!-- /# row -->
                <section id="main-content">

                  <div class="row">
                    <div class="col-lg-8 col-sm-12">
                      <div class="card">
                        <div class="card-title">
                            <h4>Select Required Deparment</h4>
                        </div>
                        <form class="" >
                          <div class="row">
                            <div class="col-lg-5">
                              <div class="form-group">
                                  <label>Date <span style="color:red">*</span></label>
                                  <input type="date"  class="form-control" name="date" value="<?php if (!isset($_REQUEST['date'])) {  echo date('Y-m-d'); } else{ echo $_REQUEST['date']; } ?>" max="<?php echo date('Y-m-d'); ?>" placeholder="Select the Month" required>
                              </div>
                            </div>
                            <div class="col-lg-5">
                              <div class="form-group">
                                  <label>Department <span style="color:red">*</span></label>
                                  <select class="form-control" name="dept" required>
                                    <option value="">Select Department</option>
                                    <option  value="all">All Departments</option>

                                    <?php $k=1;
                                      while ($row = $result->fetch_array()) {
                                    ?>

                                    <option  value="<?php echo $row['deptID']; ?>"><?php echo $row['deptName']; ?></option>

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
                    </div> <br><br>

                    <?php
                      if (isset($_REQUEST['date'])) {
                        $date = $_REQUEST['date'];
                        $deptID = $_REQUEST['dept'];

                        if ($deptID == 'all') {
                          $condition = '';
                        } else{
                          $condition = 'AND employee.deptID='.$deptID.'';
                        }

                        $sql_empd = "SELECT employee.*,designation.* FROM employee INNER JOIN designation ON employee.desigID = designation.desigID WHERE employee.empJobStatus ='Working' $condition";
                        $result_empd = $con->query($sql_empd);

                     ?>

                    <div class="col-lg-12 col-sm-12">
                      <div class="card">
                        <div class="card-title" >
                            <h4>Attendance Report By Date</h4>
                            <h6><?php  $month = $_REQUEST['date'];
                            $mon = DateTime::createFromFormat("Y-m-d" , $month);
                            echo $mon->format('l - Y F d'); ?>
                          </h6>
                        </div> <br>
                        <div class="bootstrap-data-table-panel">
                            <div class="table-responsive">
                              <table id="bootstrap-data-table-export" class="table  table-bordered">
                                  <thead>
                                      <tr style="background-color:#D6D6D6">
                                          <th>#</th>
                                          <th>Employee Name</th>
                                          <th>Designation <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                          <th>Day In <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                          <th>Day Out <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                          <th>Work Hrs <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                          <th>OT Hrs<i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                          <th>Late (Mins)<i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                          <th style="text-align:center">Status <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    $k = 1;
                                      while ($row_empd = $result_empd->fetch_array()) {
                                        $mid = $row_empd['machineID'];
                                        $statjob = $row_empd['empJobStatus'];

                                        $sql_attendace1 = "SELECT * FROM attendance_exported_table WHERE date='$date'";
                                        $result_attendace1 = $con->query($sql_attendace1);
                                        $row_attendace1 = $result_attendace1->fetch_array();
                                        $rowcount= mysqli_num_rows($result_attendace1);


                                        $sql_attendace = "SELECT * FROM attendance_exported_table WHERE machineID='$mid' AND date='$date'";
                                        $result_attendace = $con->query($sql_attendace);
                                        $row_attendace = $result_attendace->fetch_array();

                                        if ($rowcount > 0) {
                                    ?>
                                      <tr>
                                          <td><?php echo  $k; ?></td>
                                          <td><?php echo  $row_empd['empName']; ?></td>
                                          <td><?php echo  $row_empd['designation']; ?></td>
                                          <td style="text-align:right"><?php if ($row_attendace['DayIn'] != '0') { echo $row_attendace['DayIn']; } else{ echo '-'; }  ?></td>
                                          <td style="text-align:right"><?php if ($row_attendace['DayOut'] != '0') { echo $row_attendace['DayOut']; } else{ echo '-'; }  ?></td>
                                          <td style="text-align:right"><?php if ($row_attendace['workingHrs'] != 0) { echo number_format($row_attendace['workingHrs'], 2); } else{ echo '-'; }  ?></td>
                                          <td style="text-align:right"><?php if ($row_attendace['OThrs'] != 0) { echo number_format($row_attendace['OThrs'], 2); } else{ echo '-'; } ?></td>
                                          <td style="text-align:right"><?php if ($row_attendace['late'] != 0) { echo number_format($row_attendace['late'], 2); } else{ echo '-'; } ?></td>
                                          <td><?php
                                            if ($row_attendace['status'] == 'On') {
                                              echo '<span class="badge badge-info" >On Duty</span>';
                                            } else {
                                              $empID = $row_empd['empID'];

                                              $sql_leaves = "SELECT * FROM leave_requests WHERE `empID`='$empID' AND `status`='Approved' AND `leave`='Yes'";
                                              $result_leaves = $con->query($sql_leaves);
                                              $row_leaves = $result_leaves->fetch_array();
                                              $rowcount3 = mysqli_num_rows($result_leaves);

                                              $c_date = $date;

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
                                    <?php } ?>
                                    <?php $k++; } ?>
                                  </tbody>
                              </table>
                            </div> <br>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                  </div>


      <?php include('common/footer.php') ?>
     <!-- footer -->
     <?php include('common/tableExport.php') ?>

</body>

</html>
