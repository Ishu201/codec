<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string
include 'model/employeemodel.php';
include 'model/designationmodel.php';
include 'model/departmentmodel.php';

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

    .dataTables_length{
      position: absolute;
      top:50px;
      right:5px;
      margin-bottom: 10px;
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
  } elseif ($_SESSION['username'] == 'Accounts') {
    include('common/Accsidebar.php');
  } elseif ($_SESSION['username'] == 'HR') {
    include('common/HRsidebar.php');
  } elseif ($_SESSION['username'] == 'Development') {
    include('common/leadsidebar.php');
  }
  ?>
    <!-- /# sidebar -->
    <script type="text/javascript">
      document.getElementById('loan').className = 'active open';
      document.getElementById('loanData').className = 'active';
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
                                <h1>Approved Employee Loan Report</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Employee Loans</a></li>
                                    <li class="breadcrumb-item myactive">Loan Details</li>
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
                            <h4>Loans Granted from the Company</h4>
                        </div>
                        <div class="bootstrap-data-table-panel">
                          <?php
                            $sql_loan = "SELECT employee_loans.*, employee.* FROM employee_loans INNER JOIN employee ON employee_loans.empID = employee.empID WHERE status='Approved'";
                            $result_loan = $con->query($sql_loan);
                          ?>
                            <div class="table-responsive">
                                <table id="bootstrap-data-table-export" class="table table-bordered">
                                    <thead>
                                        <tr style="background-color:#cccc">
                                            <th>#</th>
                                            <th>Employee Name <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Issue Month <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Loan Ammount <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Due Ammount <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Paid Ammount <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Installment <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Total installments <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Paid Installment <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Status <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Action <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      while ($row_loanlist = $result_loan->fetch_array()) {
                                        ?>
                                     <tr>
                                       <th style="color:gray !important"><?php echo $row_loanlist['loanID']; ?></th>
                                       <td><?php echo $row_loanlist['empName']; ?></td>
                                       <td><?php echo $row_loanlist['startMonth']; ?></td>
                                       <td align="right">Rs. <?php echo number_format($row_loanlist['payback_amt'],2); ?></td>
                                       <td align="right">Rs. <?php echo number_format($row_loanlist['remain'],2); ?></td>
                                       <td align="right">Rs. <?php echo number_format($row_loanlist['paid'],2); ?></td>
                                       <td align="right">Rs. <?php echo number_format($row_loanlist['monthly'],2); ?></td>

                                       <?php
                                        $tot = $row_loanlist['duration'];
                                       ?>
                                       <td style="text-align:center;"><?php echo ($tot*12); ?></td>
                                       <td style="text-align:center;"><?php echo $row_loanlist['count']; ?></td>
                                       <td><?php echo $row_loanlist['process']; ?>
                                         </td>
                                         <td>
                                           <?php if ($row_loanlist['process'] == 'Paying') {
                                             ?>
                                             <button type="button" class="btn btn-sm btn-info sweet-message" data-id="<?php echo  $row_loanlist['loanID']; ?>">Settle</button>
                                             <?php
                                           } ?>

                                         </td>
                                     </tr>
                                   <?php  } ?>
                                    </tbody>
                                </table>
                            </div> <br>
                        </div>
                      </div>
                    </div>
                  </div>

                  <?php include('build/settleLoan.php') ?>

      <?php include('common/footer.php') ?>
     <!-- footer -->
     <?php include('common/tableExport.php') ?>

</body>

</html>
