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

<?php
 if ($_SESSION['username'] == '') {
   $msg = base64_encode('Please Log in to the system..!');
   header("Location:../index.php?msg=$msg");
}
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
        padding: 10px;
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
      document.getElementById('descipline').className = 'active';
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
                                <h1>Desciplinary Records</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Employees</a></li>
                                    <li class="breadcrumb-item myactive">Desciplinary List</li>
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
                            <h4>Disciplinary Actions</h4>
                        </div>
                        <div class="bootstrap-data-table-panel">
                            <div class="table-responsive">
                                <table id="bootstrap-data-table-export" class="table table-bordered">
                                    <thead>
                                        <tr style="background-color:#cccc">
                                            <th  style="width:15%">Employee Name <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th style="width:25%">Description</th>
                                            <th>Status <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Verbal 1</th>
                                            <th>Verbal 2</th>
                                            <th>Verbal 3</th>
                                            <th>Written 1</th>
                                            <th>Written 2</th>
                                            <th>Demotion</th>
                                            <th>Suspension</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $sql_desc = "SELECT * FROM disciplinary";
                                      $result_desc = $con->query($sql_desc);
                                      while($row_desc = $result_desc->fetch_array()){

                                        $empID = $row_desc['empID'];
                                        $sql_getname = "SELECT * FROM employee WHERE empID='$empID'";
                                        $result_getname = $con->query($sql_getname);
                                        $row_getname = $result_getname->fetch_array();
                                        $name = $row_getname['empName'];

                                        $deptID = $row_getname['deptID'];
                                        $sql_getdept = "SELECT * FROM department WHERE deptID='$deptID'";
                                        $result_getdept = $con->query($sql_getdept);
                                        $row_getdept = $result_getdept->fetch_array();
                                        $dept = $row_getdept['deptName'];
                                       ?>
                                        <tr>
                                            <td><b><?php echo $name ?></b> <br><?php echo $dept; ?></td>
                                            <td><b><?php echo $row_desc['title'] ?></b> <br><?php echo $row_desc['description'] ?></td>
                                            <td style="text-align:center">
                                              <?php
                                                if ($row_desc['status'] == 'On') {
                                                  echo "<span class='badge badge-dark' >On</span>";
                                                } else{
                                                  echo 'Off';
                                                }
                                              ?>
                                              <br> <?php echo $row_desc['date_end'] ?>
                                            </td>
                                            <td><?php echo $row_desc['date'] ?></td>
                                            <td><?php echo $row_desc['date2'] ?></td>
                                            <td><?php echo $row_desc['date3'] ?></td>
                                            <td><?php echo $row_desc['date4'] ?></td>
                                            <td><?php echo $row_desc['date5'] ?></td>
                                            <td><?php echo $row_desc['date6'] ?></td>
                                            <td><?php echo $row_desc['date7'] ?></td>
                                            <td style="text-align:center">
                                              <?php if ($row_desc['status'] != 'off') { ?>
                                                <button class="btn-sm btn-danger btn sweet-message delete" data-id="<?php echo $row_desc['disID']; ?>" data-emp="<?php echo $row_desc['empID']; ?>">End</button>
                                              <?php  } else{ echo '-'; } ?>

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
      <?php include('build/removeDesc.php') ?>
     <!-- footer -->
     <?php include('common/tableExport.php') ?>

</body>

</html>
