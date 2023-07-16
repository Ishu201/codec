<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string
include 'model/departmentmodel.php';

$ob = new dbconnection();
$con = $ob->connection();
//to display task list
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('common/files.php') ?>
    <link rel="stylesheet" href="assets/css/pagination.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>

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
        top:65px;
        left:15px;
      }

      .table-responsive{
        margin-top:60px;
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
      document.getElementById('attList').className = 'active';
    </script>

    <?php include('common/header.php') ?>
    <!-- head bar -->

    <?php
      $date = date('Y-m-d');
      $sql = "SELECT * FROM attendance_exported_table WHERE date='$date'";
      $result = $con->query($sql);
      $rowcount= mysqli_num_rows($result);

      if ($rowcount > 0) {
        $check_date = $date;
      }else{
        $sql_ddate = "SELECT max(date) FROM `attendance_exported_table`";
        $result_ddate = $con->query($sql_ddate);
        $row_ddate = $result_ddate->fetch_array();
        $check_date = $row_ddate[0];
      }
    ?>

    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Employee Attendance &nbsp - &nbsp <?php echo $check_date; ?></span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Attendance</a></li>
                                    <li class="breadcrumb-item myactive">Attendance List</li>
                                </ol>
                            </div>
                        </div>
                        <a href='addAttendance.php' style="float:right"><button type="submit" class="btn-sm btn btn-success" >Upload Attendance Record</button></a>
                    </div>
                    <!-- /# column -->
                </div>

                <?php include('src/attendanceAlert.php'); ?>

                <!-- /# row -->
                <section id="main-content">
                  <div class="row">
                    <div class="col-lg-12 col-sm-12">
                      <div class="card">
                        <div class="card-title">
                            <h4>Attendance and Working Hours</h4>
                        </div>
                        <div class="bootstrap-data-table-panel">
                            <div class="table-responsive">
                                <table id="bootstrap-data-table-export" class="table table-bordered">
                                    <thead>
                                        <tr style="background-color:#d6d6d6">
                                            <th>Employee Name</th>
                                            <th>Department <i class="ti-exchange-vertical float-right sortIcon"></i></th>
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
                                      // $sql_empd = "SELECT employee.*, department.deptID, department.deptName FROM employee INNER JOIN department ON employee.deptID = department.deptID WHERE employee.empJobStatus='Working'";
                                      // $result_empd = $con->query($sql_empd);
                                      // while ($row_empd = $result_empd->fetch_array()) {
                                      //
                                      //   $machineID = $row_empd['machineID'];
                                        $sql_attendace = "SELECT * FROM attendance_exported_table WHERE date='$check_date'";
                                        $result_attendace = $con->query($sql_attendace);
                                        while ($row_attendace = $result_attendace->fetch_array()){
                                          $mid = $row_attendace['machineID'];
                                          $sql_empd = "SELECT employee.*, department.deptID, department.deptName FROM employee INNER JOIN department ON employee.deptID = department.deptID WHERE employee.machineID='$mid'";
                                          $result_empd = $con->query($sql_empd);
                                          $row_empd = $result_empd->fetch_array();
                                      ?>
                                        <tr>
                                            <td style="text-transform:capitalize"><?php echo $row_empd['empName']; ?></td>
                                            <td><?php echo $row_empd['deptName']; ?></td>
                                            <td style="text-align:right"><?php if ($row_attendace['DayIn'] != '0') { echo $row_attendace['DayIn']; } else{ echo '-'; }  ?></td>
                                            <td style="text-align:right"><?php if ($row_attendace['DayOut'] != '0') { echo $row_attendace['DayOut']; } else{ echo '-'; }  ?></td>
                                            <td style="text-align:right"><?php if ($row_attendace['workingHrs'] != 0) { echo number_format($row_attendace['workingHrs'], 2); } else{ echo '-'; }  ?></td>
                                            <td style="text-align:right"><?php if ($row_attendace['OThrs'] != 0) { echo number_format($row_attendace['OThrs'], 2); } else{ echo '-'; } ?></td>
                                            <td style="text-align:right"><?php if ($row_attendace['late'] != 0) { echo $row_attendace['late']; } else{ echo '-'; } ?></td>
                                            <td><?php
                                              if ($row_attendace['status'] == 'On') {
                                                echo '<span class="badge badge-info" >On Duty</span>';
                                              } else {
                                                $empID = $row_empd['empID'];

                                                $sql_leaves = "SELECT * FROM leave_requests WHERE `empID`='$empID' AND `status`='Approved' AND `leave`='Yes'";
                                                $result_leaves = $con->query($sql_leaves);
                                                $row_leaves = $result_leaves->fetch_array();
                                                $rowcount3 = mysqli_num_rows($result_leaves);

                                                $c_date = $check_date;

                                                  if ($rowcount3 > 0) {
                                                    $start = $row_leaves['startDate'];
                                                    $end = $row_leaves['endDate'];

                                                      if ($start == $end) {
                                                        if ($c_date == $start){
                                                          echo '<span class="badge badge-dark" >On Leave</span>';
                                                        }else{
                                                          echo '<span class="badge badge-danger" >NP Leave</span>';
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
                                                          echo '<span class="badge badge-danger" >NP Leave</span>';
                                                        } else {
                                                           echo '<span class="badge badge-dark" >On Leave</span>';
                                                        }

                                                      }

                                                    //
                                                  } else{
                                                    echo '<span class="badge badge-danger" >NP Leave</span>';
                                                  }

                                              }  ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div> <br>
                        </div>
                      </div>
                    </div>
                  </div>


      <?php include('common/footer.php') ?>
     <!-- footer -->
     <?php include('common/tableExport.php') ?>

</body>

</html>
