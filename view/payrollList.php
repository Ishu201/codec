<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string
// include 'model/departmentmodel.php';

$ob = new dbconnection();
$con = $ob->connection();
//to display task list

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
        top:70px;
        left:20px;
        margin-bottom: 10px
      }

      .table-responsive{
        margin-top:65px;
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
  } elseif ($_SESSION['username'] == 'Accounts') {
    include('common/Accsidebar.php');
  }
  ?>
    <!-- /# sidebar -->
    <script type="text/javascript">
      document.getElementById('payments').className = 'active open';
      document.getElementById('payList').className = 'active';
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
                                <h1>Employee Payment Records and Payslips</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Employee Payments</a></li>
                                    <li class="breadcrumb-item myactive">Payroll List</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>

                <!-- /# row -->
                <section id="main-content">
                  <div class="row">
                    <div class="col-lg-7 col-sm-12">
                      <div class="card">
                        <div class="card-title">
                            <h4>View Salary Payments</h4>
                        </div>
                        <form class="" >
                          <div class="row">
                            <div class="col-lg-4">
                              <div class="form-group">
                                  <label>Month <span style="color:red">*</span></label>
                                  <input type="month"  class="form-control" name="month" max="<?php echo date('Y-m'); ?>" value="" required>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group">
                                  <label>Department <span style="color:red">*</span></label>
                                  <select class="form-control" name="deptID" required>
                                    <option value="">Select</option>
                                    <?php
                                    $sql = "SELECT * FROM department";
                                    $result = $con->query($sql);
                                    while ($row = $result->fetch_array()){
                                  ?>
                                  <option <?php if(isset($_REQUEST['deptID']) == $row['deptID']){  $dept = $row['deptName']; } ?> value="<?php echo $row['deptID']; ?>"><?php echo $row['deptName']; ?></option>
                                <?php } ?>
                                    ?>
                                  </select>
                              </div>
                            </div>
                            <div class="col-lg-2">
                              <br>
                              <div style="margin-top:10px;">
                                <button type="submit" class="btn btn-success">Show</button>
                              </div>
                            </div>
                          </div>

                        </form>
                      </div>
                    </div>
                    <br> <br>
                    <div class="col-lg-12 col-sm-12">
                      <?php if (isset($_REQUEST['month'])) { ?>
                      <div class="card">
                        <div class="card-title">
                            <h4>Employee Payroll List - <?php echo $_REQUEST['month']; ?></h4> &nbsp <span style="font-size:15px;font-weight:bold">(<?php echo $dept; ?>)</span>
                        </div>
                        <div class="bootstrap-data-table-panel">
                            <div class="table-responsive">
                                <table id="bootstrap-data-table-export" class="table table-bordered">
                                    <thead>
                                        <tr style="background-color:#d6d6d6">
                                            <th>Employee Name <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Designation <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Worked Days <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Basic Salary <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>EPF Amount <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <?php if($_REQUEST['deptID'] == '13'){ ?>
                                              <th>OT Payment <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <?php } ?>
                                            <th>Gross Salary <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Net Salary <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Pay Date <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php

                                        $month = $_REQUEST['month'];
                                        $deptID = $_REQUEST['deptID'];

                                        $sql_empd = "SELECT employee.*,designation.* FROM employee INNER JOIN designation ON employee.desigID = designation.desigID WHERE employee.empJobStatus ='Working' AND employee.deptID='$deptID'";
                                        $result_empd = $con->query($sql_empd);

                                      while ($row_empd = $result_empd->fetch_array()) {
                                        $empID = $row_empd['empID'];


                                          $sql_salary = "SELECT * FROM salary_master WHERE month ='$month' AND empID='$empID'";
                                          $result_salary = $con->query($sql_salary);
                                          $row_salary = $result_salary->fetch_array();
                                           $ggcount = $result_salary->num_rows;

                                           if ($ggcount > 0) {
                                      ?>
                                        <tr>
                                            <td style="text-transform:capitalize"><?php echo $row_empd['empName']; ?></td>
                                            <td style="text-transform:capitalize"><?php echo $row_empd['designation']; ?></td>

                                            <?php
                                            $machID = $row_empd['machineID'];
                                              $sql_work = "SELECT COUNT(*) FROM attendance_exported_table WHERE date LIKE '$month%' AND machineID='$machID' AND status='On'";
                                              $result_work = $con->query($sql_work);
                                              $row_work = $result_work->fetch_array()
                                             ?>
                                            <td style="text-align:center;"><?php echo $row_work[0]; ?></td>
                                            <td style="text-align:right">Rs.<?php echo number_format($row_salary['basic'],2); ?></td>
                                            <td style="text-align:right"><?php if($row_salary['epf_amount'] == '0'){ echo '-'; } else{ echo 'Rs.'.number_format($row_salary['epf_amount'],2); } ?></td>
                                            <?php if($_REQUEST['deptID'] == '13'){ ?>
                                              <td style="text-align:right"><?php if($row_salary['ot_pay'] == '0'){ echo '-'; } else{ echo 'Rs.'.number_format($row_salary['ot_pay'],2); } ?></td>
                                            <?php } ?>
                                            <td style="text-align:right">Rs.<?php echo number_format($row_salary['total_addition'],2); ?></td>
                                            <td style="text-align:right">Rs.<?php echo number_format($row_salary['net_salary'],2); ?></td>
                                            <td style="text-align:right"><?php echo $row_salary['payDate']; ?></td>

                                            <td>
                                              <a href='viewPayslip.php?salaryID=<?php echo $row_salary['salaryID']; ?>&emp=<?php echo $empID; ?>&month=<?php echo $row_salary['month']; ?>' target="_blank" style="float:right"><button class="btn-sm btn-info btn " >View Payslip</button></a>
                                            </td>
                                        </tr>
                                      <?php  } else{ ?>
                                        <tr>
                                            <td style="text-transform:capitalize"><?php echo $row_empd['empName']; ?></td>
                                            <td style="text-transform:capitalize"><?php echo $row_empd['designation']; ?></td>

                                            <?php
                                            $machID = $row_empd['machineID'];
                                              $sql_work = "SELECT COUNT(*) FROM attendance_exported_table WHERE date LIKE '$month%' AND machineID='$machID' AND status='On'";
                                              $result_work = $con->query($sql_work);
                                              $row_work = $result_work->fetch_array()
                                             ?>
                                            <td style="text-align:center;"><?php echo $row_work[0]; ?></td>
                                            <td style="text-align:right">Rs.<?php echo number_format($row_empd['basic_salary'],2); ?></td>
                                            <td style="text-align:right">-</td>
                                            <?php if($_REQUEST['deptID'] == '13'){ ?>
                                              <td style="text-align:right">-</td>
                                            <?php } ?>
                                            <td style="text-align:right">-</td>
                                            <td style="text-align:right">-</td>
                                            <td style="text-align:right">-</td>

                                            <td>
                                              Not Generated
                                            </td>
                                        </tr>
                                        <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>


      <?php include('common/footer.php') ?>
     <!-- footer -->
     <?php include('common/tableExport.php') ?>

</body>

</html>
