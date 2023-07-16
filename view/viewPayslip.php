<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string
// include 'model/departmentmodel.php';

$ob = new dbconnection();
$con = $ob->connection();
//to display task list

$empID = $_REQUEST['emp'];
$salaryID = $_REQUEST['salaryID'];
$month = $_REQUEST['month'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Payslip</title>
  <link rel="icon" type="image/png" href="../res/images/logoIcon.png">
    <?php //include('common/files.php') ?>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- <link href="assets/css/style.css" rel="stylesheet"> -->

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body onload="print()" style="background-color:#f2f2f2">
    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">

                <div class="row">
                    <br><br>
                </div>

                <!-- /# row -->
                <section id="main-content">
                  <div class="row">
                    <div class="col-lg-1"> </div>
                    <div class="col-lg-10 col-sm-12">
                      <div class="card">
                          <div class="container mt-5 mb-5">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="text-center lh-1 mb-2">
                                  <h6 class="fw-bold">Paysheet</h6> <span class="fw-normal">Payment Slip for  <?php  echo date("F Y", strtotime($month)); ?></span>
                                </div>
                                <div class="d-flex justify-content-end"> <br> </div> <hr>
                                <div class="row">
                                  <div class="col-md-12">

                                    <?php
                                      $sql_empd = "SELECT employee.*,employee_salary.* FROM employee INNER JOIN employee_salary ON employee.empID = employee_salary.empID WHERE  employee.empID='$empID'";
                                      $result_empd = $con->query($sql_empd);
                                      $row_empd = $result_empd->fetch_array();
                                    ?>

                                    <div class="row">
                                      <div class="col-md-6">
                                        <div> <span class="fw-bolder">EMP Code</span> <small class="ms-3">EID<?php echo sprintf("%05d", $empID) ?></small> </div>
                                      </div>
                                      <div class="col-md-6" style="text-align:right">
                                        <div> <span class="fw-bolder">EMP Name</span> <small class="ms-3" style="text-transform:capitalize"><?php echo $row_empd['empName']; ?></small> </div>
                                      </div>
                                    </div>
                                    <div class="row" style="margin-top:10px">
                                      <div class="col-md-6">
                                        <div> <span class="fw-bolder">EPF No.</span> <small class="ms-3"><?php echo $row_empd['epfNo']; ?></small> </div>
                                      </div>
                                      <div class="col-md-6" style="text-align:right">
                                        <div> <span class="fw-bolder">Mode of Pay</span> <small class="ms-3">Bank Transaction</small> </div>
                                      </div>
                                    </div>
                                    <?php
                                      $desigID = $row_empd['desigID'];
                                      $sql_basic = "SELECT * FROM designation  WHERE desigID='$desigID'";
                                      $result_basic = $con->query($sql_basic);
                                      $row_basic = $result_basic->fetch_array();
                                    ?>
                                    <div class="row" style="margin-top:10px">
                                      <div class="col-md-6">
                                        <div> <span class="fw-bolder">Designation</span> <small class="ms-3"><?php echo $row_basic['designation']; ?></small> </div>
                                      </div>
                                      <div class="col-md-6" style="text-align:right">
                                        <?php
                                        $sql_bank = "SELECT * FROM employee_bank WHERE empID='$empID'";
                                        $result_bank = $con->query($sql_bank);
                                        $countme = $result_bank->num_rows;
                                        if ($countme > 0) {
                                          $row_bank = $result_bank->fetch_array();
                                            $num = $row_bank['accountNo'];

                                            $numlength = (strlen((string)$num))-4;
                                            $star = '';
                                            for($no=1;$no <= $numlength;$no++){
                                              $star .= '*';
                                            }

                                            $fnum = substr($num, 0, 2) . $star . substr($num, -2);
                                        } else{
                                          $fnum = '**********';
                                        }

                                        ?>
                                        <div> <span class="fw-bolder">Bank Acc No.</span> <small class="ms-3"><?php echo $fnum; ?></small> </div>
                                      </div>
                                    </div>
                                  </div>
                                  <table class="mt-4 table table-bordered">
                                    <thead class="bg-dark text-white">
                                      <tr>
                                        <th scope="col">Earnings</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Deductions</th>
                                        <th scope="col">Amount</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                        $sql_salary = "SELECT * FROM salary_master WHERE salaryID='$salaryID'";
                                        $result_salary = $con->query($sql_salary);
                                        $row_salary = $result_salary->fetch_array();
                                       ?>

                                       <?php


                                       ?>
                                      <tr>
                                        <th scope="row">Basic</th>
                                        <td style="text-align:right"><?php echo number_format((float)$row_salary['basic'], 2, '.', ''); ?></td>
                                        <th>EPF</th>
                                        <td style="text-align:right"><?php echo number_format((float)$row_salary['epf_amount'], 2, '.', ''); ?></td>
                                      </tr>
                                      <tr>
                                        <th scope="row">Allowance</th>
                                        <td style="text-align:right"><?php echo number_format((float)$row_salary['allowance'], 2, '.', ''); ?></td>
                                        <th>Loan Charges</th>
                                        <td style="text-align:right"><?php echo number_format((float)$row_salary['loans'], 2, '.', ''); ?></td>
                                      </tr>
                                      <tr>
                                        <th scope="row">OT Payments</th>
                                        <td style="text-align:right"><?php echo number_format((float)$row_salary['ot_pay'], 2, '.', ''); ?></td>
                                        <th>Other</th>
                                        <td style="text-align:right"><?php echo number_format((float)$row_salary['other'], 2, '.', ''); ?></td>
                                      </tr>
                                      <tr>
                                        <th scope="row">Special Incentive</th>
                                        <td style="text-align:right"><?php echo number_format((float)$row_salary['special_allowance'], 2, '.', ''); ?></td>
                                        <th>Penalty Charges</th>
                                        <td style="text-align:right"><?php echo number_format((float)$row_salary['late_deduction'], 2, '.', ''); ?></td>
                                      </tr>

                                      <tr style="height:45px">
                                        <th scope="row"></th>
                                        <td  style="text-align:right"></td>
                                        <td colspan="2"></td>
                                      </tr>

                                      <tr class="border-top">
                                        <th scope="row">Total Earning</th>
                                        <td style="text-align:right"><?php echo number_format((float)$row_salary['total_addition'], 2, '.', ''); ?></td>
                                        <th>Total Deductions</th>
                                        <td style="text-align:right"><?php echo number_format((float)$row_salary['total_deduction'], 2, '.', ''); ?></td>
                                      </tr>

                                      <tr class="border-top">
                                        <th colspan="3" scope="row">Net Salary</th>
                                        <th style="text-align:right"><?php echo number_format((float)$row_salary['net_salary'], 2, '.', ''); ?></th>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <br>
                                <div class="d-flex justify-content-end">
                                  <div class="d-flex flex-column mt-2" style="text-align:right;"> <br> <span class="fw-bolder">CODEC Solutions</span> <br><br><br> <span class="mt-4">Signed By</span> </div>
                                </div>
                              </div>
                            </div>
                          </div>
                      </div>
                    </div>
                    <div class="col-lg-1"> </div>
                  </div> <br><br>


      <?php //include('common/footer.php') ?>
     <!-- footer -->

</body>

</html>
