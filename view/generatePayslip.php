<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string
// include 'model/departmentmodel.php';

$ob = new dbconnection();
$con = $ob->connection();
//to display task list

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    <style media="screen">
      p{
        font-size:15px;
      }

      input:read-only {
        background-color: #f2f2f2 !important;
      }

      input:read-only:hover {
      cursor: not-allowed;
      }
    </style>
</head>

<body onload="cal_total()">

  <?php if ($_SESSION['username'] == 'Admin') {
    include('common/sidebar.php');
  } elseif ($_SESSION['username'] == 'Accounts') {
    include('common/Accsidebar.php');
  }
  ?>
    <!-- /# sidebar -->
    <script type="text/javascript">
      document.getElementById('payments').className = 'active open';
      document.getElementById('genPay').className = 'active';
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
                                <h1>Manage and Generate Payslips</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="generatePayroll.php">Generate Payrolls</a></li>
                                    <li class="breadcrumb-item myactive">Generate Payslip</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>

                <?php include('src/loanAlert.php') ?>

                <!-- /# row -->
                <section id="main-content">
                  <div class="row">
                    <div class="col-lg-12 col-sm-12">
                      <div class="card">
                        <div class="card-title">
                            <h4>Salary Arrangement</h4>
                        </div> <br>
                        <form  method="post" action="controller/salaryGenerate.php" >
                        <div class="row">
                          <?php
                          $empID = $_REQUEST['emp'];

                          $sql_empd = "SELECT employee.*,employee_salary.* FROM employee INNER JOIN employee_salary ON employee.empID = employee_salary.empID WHERE  employee.empID='$empID'";
                          $result_empd = $con->query($sql_empd);
                          $row_empd = $result_empd->fetch_array();
                          ?>
                          <div class="col-lg-7" style="margin-left:20px">
                            <b><p style="text-transform:capitalize">Employee Name : <span style="color:#333333;"><?php echo $row_empd['empName']; ?></span></p></b>
                            <b><p>Month : <span style="color:#333333;"><?php echo date('Y-m', strtotime(date('Y-m')." -1 month")); ?></span></p></b>
                            <b><p>EPF Number : <span style="color:#333333;"><?php echo $row_empd['epfNo']; ?></span></p></b>
                          </div>
                        </div>

                        <hr style="background-color:gray">
                        <input type="hidden" name="empID" value="<?php echo $empID; ?>">

                        <div class="row">
                          <div class="col-lg-4" >
                            <p>Basic Salary</p>
                            <?php
                              $desigID = $row_empd['desigID'];
                              $sql_basic = "SELECT * FROM designation  WHERE desigID='$desigID'";
                              $result_basic = $con->query($sql_basic);
                              $row_basic = $result_basic->fetch_array();
                            ?>
                            <input type="number"  class="form-control" name="basic" readonly value="<?php echo number_format((float)$row_basic['basic_salary'], 2, '.', ''); ?>" required id="basic">
                          </div>
                          <?php if ($row_empd['epfState'] == 'yes') { ?>
                            <div class="col-lg-2" >
                              <p>EPF Percentage</p>
                              <input type="text"  class="form-control" name="" readonly value="<?php echo $row_empd['epf']; ?>%" required >
                              <input type="hidden"  class="form-control" name="" readonly value="<?php echo $row_empd['epf']; ?>" id="epfRate">
                            </div>
                          <?php } else{
                            ?>
                              <input type="hidden"  class="form-control" value="0" id="epfRate">
                            <?php
                          } ?>
                        </div> <br> <br>
                        <p style="border-bottom:1px solid #d6d6d6;color:#333333;font-weight:bold">Additions</p>
                        <div class="row">
                          <div class="col-lg-4">
                            <p>Allocated Allowance</p>
                            <input type="number"  class="form-control" name="allowance" readonly value="<?php echo number_format((float)$row_empd['allowance'], 2, '.', ''); ?>" required id="allowance">
                          </div>
                          <div class="col-lg-4">
                            <p>Special Allowance / Bonus</p>
                            <input type="number"  class="form-control" name="special_allowance" id="special_allowance"  onchange="cal_total()">
                          </div>
                        </div> <br>

                        <?php
                        $month = date('Y-m', strtotime(date('Y-m')." -1 month"));
                        $machineID = $row_empd['machineID'];
                        $sql_ot = "SELECT SUM(OThrs),SUM(late) FROM attendance_exported_table  WHERE machineID='$machineID' AND date LIKE '$month%'";
                        $result_ot = $con->query($sql_ot);
                        $row_ot = $result_ot->fetch_array();
                        $ot_hrs = number_format((float)$row_ot[0], 2, '.', '');
                        $ot_rate = $row_empd['OTrate'];
                        $tot = $ot_hrs * $ot_rate;
                        ?>

                        <?php if ($row_empd['empType'] == 'worker') { ?>
                        <div class="row">
                          <div class="col-lg-3">
                            <p>Total OT Hours</p>
                            <input type="text"  class="form-control"  readonly value="<?php echo $ot_hrs; ?> Hrs" required id="ot_hrs" name="ot_hrs">
                            <input type="hidden"  class="form-control"  readonly value="<?php echo $ot_rate; ?>" required id="ot_rate">
                          </div>
                          <div class="col-lg-3">
                            <p>OT Payment (Rate - Rs.<?php echo $row_empd['OTrate']; ?>.00)</p>
                            <input type="number"  class="form-control" name="ot_pay" readonly id="ot_pay" value="<?php echo number_format((float)$tot, 2, '.', ''); ?>">
                          </div>
                        </div> <br> <br>
                      <?php } else{ ?>
                        <input type="hidden"   value="0 Hrs"  id="ot_hrs" name="ot_hrs">
                        <input type="hidden" value="0"  id="ot_rate">
                        <input type="hidden"  name="ot_pay" readonly id="ot_pay" value="0">
                      <?php } ?>

                      <p style="border-bottom:1px solid #d6d6d6;color:#333333;font-weight:bold">Deductions</p>

                        <div class="row">
                          <?php if ($row_empd['epfState'] == 'yes') { ?>
                          <div class="col-lg-4">
                            <p>EPF Amount</p>
                            <input type="number"  class="form-control" name="epf_amount" readonly required id="epf_amount">
                          </div>
                        <?php } else{ ?>
                          <input type="hidden"  value="0" readonly required name="epf_amount" id="epf_amount">
                        <?php } ?>
                          <div class="col-lg-4">
                            <p>Other Deduction</p>
                            <input type="number"  class="form-control" name="other" id="other"  value="<?php echo number_format((float)$row_empd['other'], 2, '.', ''); ?>" readonly required>
                          </div>
                          <?php

                          ?>
                          <div class="col-lg-4">
                            <p>Loan Charges</p>
                            <input type="number"  class="form-control" readonly name="loans" id="loans"  value="<?php echo number_format((float)$row_empd['personalLoans'], 2, '.', ''); ?>" >
                          </div>
                        </div> <br>

                        <div class="row">
                          <div class="col-lg-4" >
                            <p>Total Late Minutes</p>
                            <input type="text"  class="form-control" name="latehrs" readonly value="<?php echo number_format((float)$row_ot[1], 2, '.', ''); ?>" required id="latehrs">
                          </div>
                          <div class="col-lg-4">
                            <p>Penalty Deduction</p>
                            <input type="number"  class="form-control" name="special_deduction" id="special_deduction" onchange="cal_total()">
                          </div>
                        </div>

                        <br>
                        <div class="row">
                          <div class="col-lg-8"></div>
                          <div class="col-lg-4" style="text-align:right">
                            <p>Net Payment</p>
                            <input type="text"  class="form-control" name="net_salary" readonly  required id="net_salary" style="text-align:right">
                            <br> <br>
                            <input type="hidden" name="total_addition" id="total_addition" value="">
                            <input type="hidden" name="total_deduction" id="total_deduction" value="">
                            <input type="hidden" name="deptID" value="<?php echo $_REQUEST['deptID']; ?>">
                            <input type="hidden" name="empName" value="<?php echo $row_empd['empName']; ?>">
                            <button style="float:right" type="submit" class="btn btn-success" name="submit">Generate</button>
                          </div>
                        </div>
                      </form>
                        <br>

                      </div>
                    </div>

                  </div>

                  <script type="text/javascript">
                  function cal_total(){
                    var total_addition = 0;
                    var total_deduction = 0;
                    var base_salary = 0;
                    var epf_amt = 0;

                    var basic = document.getElementById('basic').value;
                    var allowance = document.getElementById('allowance').value;
                    var special_allowance = document.getElementById('special_allowance').value;
                    var ot_pay = document.getElementById('ot_pay').value;
                    var epfRate = document.getElementById('epfRate').value;
                    //
                    var other = document.getElementById('other').value;
                    var loans = document.getElementById('loans').value;
                    var special_deduction = document.getElementById('special_deduction').value;


                    if(special_allowance == '' ) { special_allowance = 0 }
                    if(loans == '' ) { loans = 0 }
                    if(special_deduction == '' ) { special_deduction = 0 }

                    epf_amt = (parseInt(basic,'10') * parseInt(epfRate,'10')) / 100;
                    total_addition = (parseInt(basic,'10')+parseInt(allowance,'10')+parseInt(special_allowance,'10')+parseInt(ot_pay,'10'));
                    total_deduction = (parseInt(other,'10')+parseInt(loans,'10')+parseInt(special_deduction,'10')+parseInt(epf_amt,'10'));

                    base_salary = total_addition - total_deduction;

                    document.getElementById('epf_amount').value = epf_amt;
                    document.getElementById('net_salary').value = base_salary;
                    document.getElementById('total_addition').value = total_addition;
                    document.getElementById('total_deduction').value = total_deduction;
                  }

                  </script>


      <?php include('common/footer.php') ?>
     <!-- footer -->

</body>

</html>
