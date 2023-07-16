<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string
include 'model/employeemodel.php';

$ob = new dbconnection();
$con = $ob->connection();


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('common/files.php') ?>
    <link rel="stylesheet" href="assets/css/pagination.css">

    <style media="screen">

    html,body{
      width: 100%;
      height: 100%;
      margin: 0px;
      padding: 0px;
      overflow-x: hidden;
    }

    input[type="search"]{
      width:300px !important;
    }

    .dataTables_length{
      position: absolute;
      top:50px;
      right:5px;
      margin-bottom: 10px;
    }

    .dt-buttons{
      display: none
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

    <?php include('common/sidebar.php') ?>
    <!-- /# sidebar -->
    <script type="text/javascript">
      document.getElementById('employees').className = 'active open';
      document.getElementById('userAcc').className = 'active';
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
                                <h1>Manage User Accounts of Employees</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Employees</a></li>
                                    <li class="breadcrumb-item myactive">User Accounts</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>

                <!-- /# row -->
                <section id="main-content">
                  <div class="row">
                    <div class="col-lg-12 col-sm-12">
                      <div class="card">
                        <div class="card-title">
                            <h4>CODEC Users</h4>
                        </div>

                        <div class="bootstrap-data-table-panel">
                            <div class="table-responsive">
                                <table id="bootstrap-data-table-export" class="table table-bordered">
                                    <thead>
                                        <tr style="background-color:#cccc">
                                            <th>#</th>
                                            <th>Employee Name <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Designation <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>User Email</th>
                                            <th>User Type <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Employement <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Permission <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $sql = "SELECT users.*, employee.*, designation.designation FROM users INNER JOIN (employee INNER JOIN designation ON employee.desigID = designation.desigID) ON users.empID = employee.empID";
                                      $result = $con->query($sql);
                                      $k = 1;
                                      while($row_user = $result->fetch_array()){
                                       ?>
                                        <tr>
                                            <td><?php echo $k; ?></td>
                                            <td><?php echo $row_user['empName']; ?></td>
                                            <td><?php echo $row_user['designation']; ?></td>
                                            <td><?php echo $row_user['username']; ?></td>
                                            <td>
                                              <?php if ($row_user['userType'] == 'Team') {
                                                echo 'Developeer';
                                              } else{
                                                echo 'Employee';
                                              } ?>
                                            </td>
                                            <td><?php echo $row_user['empJobStatus']; ?></td>
                                            <td>
                                              <?php if ($row_user['permission'] == 'Not') {
                                                echo '<a href="operation/approveUser.php?id='.$row_user['userID'].'&gets=Approved" ><span class="badge badge-success">Approve</span></a>';
                                              } else{
                                                echo '<a href="operation/approveUser.php?id='.$row_user['userID'].'&gets=Not" ><span class="badge badge-danger">Reject</span></a>';
                                              }
                                              ?>

                                            </td>
                                        </tr>
                                      <?php $k++; } ?>
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
