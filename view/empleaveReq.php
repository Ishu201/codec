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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>

    <style media="screen">
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

    .leave-rem{
      color:#343957;
      font-weight: bold;
    }

    .media{
      border: none !important;
    }

    .card-header:hover{
      background-color: #e0e0d1;
    }

    .reqHeading{
      font-weight: bold;
    }
    </style>

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

    <?php include('src/itemAlert.php') ?>

    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Employee Leave Requests</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Leave Application</a></li>
                                    <li class="breadcrumb-item myactive">Leave Requests</li>
                                </ol>
                            </div>
                        </div>
                        <a href='empAddLeaveReq.php' style="float:right"><button type="submit" class="btn-sm btn btn-success" >Leave Application</button></a>
                    </div>
                    <!-- /# column -->
                </div>

                <!-- /# row -->
                <section id="main-content">
                  <div class="row">
                    <div class="col-lg-12 col-sm-12">
                      <div class="card">
                        <div class="card-title">
                            <h4>Leave Requests</h4>
                        </div>
                        <div class="bootstrap-data-table-panel">
                            <div class="table-responsive">
                                <table id="bootstrap-data-table-export" class="table  table-bordered">
                                    <thead>
                                        <tr  style="background-color:#cccc">
                                            <th>Leave Type <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Reason </th>
                                            <th>Start Date <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>End Date <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Duration <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th style="text-align:center">Application Status <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Leave Status &nbsp<i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $sql_leaves = "SELECT * FROM leave_requests WHERE empID='$session_empID' ORDER BY date DESC";
                                      $result_leaves = $con->query($sql_leaves);
                                      $no = 1;
                                      while ($row_leaves = $result_leaves->fetch_array()) {
                                        $employee = $row_leaves['empID'];
                                          $sql_emp = "SELECT * FROM employee WHERE empID='$employee'";
                                          $result_emp = $con->query($sql_emp);
                                          $row_emp = $result_emp->fetch_array();

                                        $leaveT = $row_leaves['leaveID'];
                                          $sql_lt = "SELECT * FROM company_leaves WHERE leaveID='$leaveT'";
                                          $result_lt = $con->query($sql_lt);
                                          $row_lt = $result_lt->fetch_array();
                                       ?>
                                        <tr>
                                            <td><?php echo $row_lt['leave_type']; ?></td>
                                            <td><?php echo $row_leaves['reason']; ?></td>
                                            <td><?php echo $row_leaves['startDate']; ?></td>
                                            <td><?php echo $row_leaves['endDate']; ?></td>
                                            <td><?php echo $row_leaves['duration']; ?></td>
                                            <td style="text-align:center">
                                              <?php
                                                if ($row_leaves['status'] == 'Pending') {
                                                  echo '<span style="color:#0099ff;font-weight:bold">Pending</span>';
                                                } else if ($row_leaves['status'] == 'Approved') {
                                                  echo '<span style="color:#28A745;font-weight:bold">Approved</span>';
                                                } else{
                                                  echo '<span style="color:red;font-weight:bold">Rejected</span>';
                                                }
                                               ?>
                                            </td>
                                            <td>
                                              <?php
                                                if ($row_leaves['status'] == 'Approved') {
                                                  if ($row_leaves['leave'] == 'Yes') {
                                                    echo '<a class="btn btn-sm btn-warning" href="controller/leaveStat.php?id='.$row_leaves['reqID'].'&stat=end">End</a>';
                                                  } else if($row_leaves['leave'] == '') {
                                                    echo '<a class="btn btn-sm btn-info" href="controller/leaveStat.php?id='.$row_leaves['reqID'].'&stat=start">Start</a>';
                                                  } else{
                                                    echo '<a class="btn btn-sm btn-default" href="#">Done</a>';
                                                  }
                                                } else if($row_leaves['status'] == 'Pending') {
                                                  echo '<button type="button"  style="color:white" class="btn btn-sm btn-danger sweet-message" data-id="'.$row_leaves['reqID'].'" style="color:#31475B">Cancel</button>';
                                                } else{
                                                  echo '-';
                                                }
                                               ?>
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

                  <?php include('build\cancelLeaveReq.php') ?>
                  <?php include('build/leaveApp.php') ?>


      <?php include('common/footer.php') ?>
     <!-- footer -->
     <?php include('common/tableExport.php') ?>

</body>

</html>
