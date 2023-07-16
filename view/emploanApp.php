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

    input[type="search"]{
      width:300px !important;
    }

    </style>

    <script type="text/javascript">
      window.alert = function() {};
      alert = function() {};
    </script>

</head>

<body>

  <?php
    include('common/empsidebar.php');

  ?>
  <!-- /# sidebar -->
  <script type="text/javascript">
    document.getElementById('loanApp').className = 'active';
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
                              <h1>Company Loan Details</span></h1>
                          </div>
                      </div>
                  </div>
                  <!-- /# column -->
                  <div class="col-lg-4 p-l-0 title-margin-left">
                      <div class="page-header">
                          <div class="page-title">
                              <ol class="breadcrumb">
                                  <li class="breadcrumb-item"><a href="#">Loan Applications</a></li>
                              </ol>
                          </div>
                      </div>

                      <?php
                      $countloan = "SELECT employee_loans.*, employee.* FROM employee_loans INNER JOIN employee ON employee_loans.empID = employee.empID WHERE status='Pending' AND employee_loans.empID='$session_empID'";
                      $resultcl = $con->query($countloan);
                      $countcl1 = $resultcl->num_rows;

                      $countloan2 = "SELECT employee_loans.*, employee.* FROM employee_loans INNER JOIN employee ON employee_loans.empID = employee.empID WHERE status='Approved' AND employee_loans.empID='$session_empID'";
                      $resultcl2 = $con->query($countloan2);
                      $countcl2 = $resultcl2->num_rows;

                      $tot = $countcl1+$countcl2;
                      if ($tot <= 0) {
                       ?>
                      <a href='emploanFormAdd.php?user=<?php echo  $session_empID; ?>' style="float:right"><button type="submit" class="btn-sm btn btn-success" >Apply for Loan</button></a>
                    <?php } ?>
                  </div>
                  <!-- /# column -->
              </div>

              <!-- /# row -->
              <section id="main-content">
                <div class="row">
                  <div class="col-lg-12 col-sm-12">
                    <div class="card">
                      <div class="card-title">
                          <h4>Company Loans</h4>
                      </div>
                      <div class="bootstrap-data-table-panel"> <br>
                        <?php
                          $sql_loan = "SELECT employee_loans.*, employee.* FROM employee_loans INNER JOIN employee ON employee_loans.empID = employee.empID WHERE status='Approved' AND employee_loans.empID='$session_empID'";
                          $result_loan = $con->query($sql_loan);
                          $count1 = $result_loan->num_rows;
                          if ($count1 > 0) {
                        ?>
                        <h6 style="color:#00cc99">Approved Loans</h6>
                          <div class="table-responsive" style="margin-top:20px">
                              <table class="table table-bordered">
                                  <thead>
                                      <tr style="background-color:#cccc">
                                          <th>#</th>
                                          <th>Loan Details</th>
                                          <th>Issue Month <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                          <th>Loan Ammount <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                          <th>Due Ammount <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                          <th>Paid Ammount <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                          <th>Monthly Installment <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                          <th>Total installments <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                          <th>Paid Installment <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                          <th>Status <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    $no1=1;
                                    while ($row_loanlist = $result_loan->fetch_array()) {
                                      ?>
                                   <tr>
                                     <th style="color:gray !important"><?php echo $no1++; ?></th>
                                     <td style="text-align:center">
                                        <a href="emploanForm.php?id=<?php echo $row_loanlist['loanID']; ?>&user=<?php echo $row_loanlist['empID']; ?>&stat=approved" target="blank"><i class="ti-write"></i></a>
                                     </td>
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
                                   </tr>
                                 <?php  } ?>
                                 </tbody>
                              </table>
                          </div> <?php } ?> <br><br>


                          <?php
                            $sql_loan2 = "SELECT employee_loans.*, employee.* FROM employee_loans INNER JOIN employee ON employee_loans.empID = employee.empID WHERE status='Pending' AND employee_loans.empID='$session_empID'";
                            $result_loan2 = $con->query($sql_loan2);
                            $count2 = $result_loan2->num_rows;
                            if ($count2 > 0) {
                          ?>
                          <h6 style="color:#0099ff">Pending Loans</h6>
                          <div class="table-responsive" style="margin-top:20px">
                            <table class="table table-bordered">
                              <thead>
                                <tr style="background-color:#cccc">
                                  <th>#</th>
                                  <th>Application</th>
                                  <th style="text-align:center;">Requested Ammount <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                  <th style="text-align:center;">Applied Date <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                  <th style="text-align:center;">Status <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                  <th style="text-align:center;">Cancel <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $no2=1;
                                while ($row_loanlist2 = $result_loan2->fetch_array()) {
                                  ?>
                                  <tr>
                                    <th style="color:gray !important"><?php echo $no2++; ?></th>
                                    <td style="text-align:center">
                                      <a href="emploanForm.php?id=<?php echo $row_loanlist2['loanID']; ?>&user=<?php echo $row_loanlist2['empID']; ?>&stat=pending" target="blank"><i class="ti-write"></i></a>
                                    </td>
                                    <td  align="right">Rs. <?php echo number_format($row_loanlist2['loanAmount'],2); ?></td>
                                    <td  align="center"><?php echo $row_loanlist2['applyDate']; ?></td>
                                    <td  align="left" style="width:30%"><?php echo $row_loanlist2['process']; ?></td>
                                    <td  align="right">
                                      <button type="button" class="btn btn-sm btn-danger sweet-message" data-id="<?php echo $row_loanlist2['loanID'] ?>">Cancel</button>
                                    </td>
                                  </tr>
                                <?php  } ?>
                              </tbody>
                            </table>
                          </div> <?php } ?> <br><br>


                          <?php
                            $sql_loan3 = "SELECT employee_loans.*, employee.* FROM employee_loans INNER JOIN employee ON employee_loans.empID = employee.empID WHERE status='Rejected' AND employee_loans.empID='$session_empID'";
                            $result_loan3 = $con->query($sql_loan3);
                            $count3 = $result_loan3->num_rows;
                            if ($count3 > 0) {
                          ?>
                            <h6 style="color:#bf4040">Rejected Loans</h6>
                        <div class="table-responsive" style="margin-top:20px">
                            <table class="table table-bordered">
                                <thead>
                                    <tr style="background-color:#cccc">
                                        <th>#</th>
                                        <th>Application</th>
                                        <th>Letter <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                        <th style="text-align:center;">Requested Ammount <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                        <th style="text-align:center;">Applied Date <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                        <th >Reason for Rejection <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                        <th >Inquire From <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $no3=1;
                                  while ($row_loanlist3 = $result_loan3->fetch_array()) {
                                    ?>
                                 <tr>
                                   <th style="color:gray !important"><?php echo $no3++; ?></th>
                                   <td style="text-align:center">
                                      <a href="emploanForm.php?id=<?php echo $row_loanlist3['loanID']; ?>&user=<?php echo $row_loanlist3['empID']; ?>&stat=rejected" target="blank"><i class="ti-write"></i></a>
                                   </td>
                                   <td style="text-align:center">
                                      <a href="emploanLetter.php?id=<?php echo $row_loanlist3['loanID']; ?>&user=<?php echo $row_loanlist3['empID']; ?>&stat=letter" target="blank"><i class="ti-write"></i></a>
                                   </td>
                                   <td align="right">Rs. <?php echo number_format($row_loanlist3['loanAmount'],2); ?></td>
                                   <td align="center"><?php echo $row_loanlist3['applyDate']; ?></td>
                                   <td align="left"><?php echo $row_loanlist3['rejectSub']; ?></td>
                                   <td  align="right"><?php echo $row_loanlist3['hrCheck']; ?></td>
                                 </tr>
                               <?php  } ?>
                                 </tbody>
                            </table>
                        </div>  <?php } ?> <br>


                      </div>
                    </div>
                  </div>
                </div>

                <?php include('build\cancelLoanReq.php') ?>


    <?php include('common/footer.php') ?>
   <!-- footer -->
   <?php include('common/tableExport.php') ?>

</body>

</html>
