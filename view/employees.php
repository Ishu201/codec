<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string
include 'model/employeemodel.php';
include 'model/designationmodel.php';
include 'model/departmentmodel.php';

$ob = new dbconnection();
$con = $ob->connection();

$emp = new employee;
$result_emp = $emp->viewEmp();

$dept = new department;
$desig = new designation;

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
        margin-bottom: 10px;
      }

      .dt-buttons{
        position: absolute;
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

      input[type="search"]{
        width:300px !important;
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
      document.getElementById('employees').className = 'active open';
      document.getElementById('emplist').className = 'active';
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
                                <h1>Manage the Employee List</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Employees</a></li>
                                    <li class="breadcrumb-item myactive">Employee List</li>
                                </ol>
                            </div>
                        </div>
                        <a href='addEmployee.php' style="float:right"><button type="submit" class="btn-sm btn btn-info" >Add New Employee</button></a>
                    </div>
                    <!-- /# column -->
                </div>

                <!-- /# row -->
                <section id="main-content">

                  <?php include('src/listempAlert.php') ?>

                  <div class="row">
                    <div class="col-lg-12 col-sm-12">
                      <div class="card">
                        <div class="card-title">
                            <h4>Employee List</h4>
                        </div>
                        <div class="bootstrap-data-table-panel">
                            <div class="table-responsive">
                                <table id="bootstrap-data-table-export" class="table  table-bordered">
                                    <thead>
                                        <tr style="background-color:#cccc">
                                            <th>#</th>
                                            <th>Employee Name</i></th>
                                            <th>Department <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Role <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Job Status <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Email</th>
                                            <th>Contact</th>
                                            <th width='15%'>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                        while ($row = $result_emp->fetch_array()) {
                                       ?>
                                        <tr>
                                            <td><?php echo sprintf("%04d", $row['empID']) ?></td>
                                            <td>
                                              <?php
                                                echo $row['empName'];
                                                $stat = $row['desciplinary'];
                                                if (($stat == 'Verbal Warning 1') or ($stat == 'Verbal Warning 2') or ($stat == 'Verbal Warning 3')) {
                                                  $color = 'background-color:#0099ff;color:white';
                                                }
                                                else if (($stat == 'Written Warning 1') or ($stat == 'Written Warning 2')) {
                                                  $color = 'background-color:#8c1aff;color:white';
                                                }
                                                else if ($stat == 'Demotion') {
                                                  $color = 'background-color:#00cc99;color:white';
                                                }
                                                else{
                                                  $color = 'background-color:#cc0000;color:white';
                                                }

                                                if ($stat != 'No') {
                                                  echo '
                                                    <span class="badge badge-secondary" style="float:right;font-size:10px !important;'.$color.';font-weight:bold">'.$row['desciplinary'].'</span>
                                                  ';
                                                }
                                              ?>
                                            </td>
                                            <td>
                                              <?php
                                               $deptID = $row['deptID'];
                                               $result_dept = $dept->viewDept_selected($deptID);
                                               $row_dept = $result_dept->fetch_array();

                                               echo $row_dept['deptName'];
                                               ?>
                                            </td>
                                            <td>
                                              <?php
                                               $desigID = $row['desigID'];
                                               $result_desig = $desig->viewDesig_selected($desigID);
                                               $row_desig = $result_desig->fetch_array();

                                               echo $row_desig['designation'];
                                               ?>
                                            </td>
                                            <td <?php if ($row['empJobStatus']=='Alumnus') { echo 'style="font-weight:bold"'; } ?>><?php echo $row['empJobStatus']; ?></td>
                                            <td style="text-transform:lowercase !important"><?php echo $row['empEmail'] ?></td>
                                            <td>0<?php echo $row['empContact'] ?></td>
                                            <?php
                                              if ($row['empJobStatus']=='Alumnus') {
                                            ?>

                                            <td>
                                              <a href="editEmployee.php?id=<?php echo  $row['empID']; ?>&stat=viewOnly" target="_blank">
                                                <button class="btn-sm btn btn-dark" style="width:210px;">View</button>
                                              </a>
                                            </td>

                                          <?php  }else{
                                            ?>
                                            <td>
                                              <a href="editEmployee.php?id=<?php echo  $row['empID']; ?>&stat=edit" target="_blank"><button class="btn-sm btn btn-success" >View</button></a>
                                              <?php
                                              $stat = $row['desciplinary'];
                                              if ($stat != 'Suspend') { ?>
                                                <a href="employees.php?msg=suspend&id=<?php echo  $row['empID']; ?>&code" ><button class="btn-sm btn btn-warning">Descipline</button></a>
                                              <?php } ?>
                                              <button class="btn-sm btn-danger btn sweet-message delete" data-id="<?php echo  $row['empID']; ?>" >Leave</button>
                                            </td>
                                          <?php } ?>
                                        </tr>
                                      <?php  } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div> <br>
                      </div>
                    </div>
                  </div>

                  <?php include('build/suspend.php'); ?>
                  <?php include('build/removeEmp.php'); ?>


      <?php include('common/footer.php') ?>
     <!-- footer -->
     <?php include('common/tableExport.php') ?>

</body>

</html>
