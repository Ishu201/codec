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
        display: none;
      }


      .dataTables_filter{
        position: absolute;
        top:75px;
        left:20px;
        margin-bottom: 10px;
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

      .readonlyFeilds{
        font-weight: bold;
        background-color: transparent !important;
        border:1px solid #DEE2E6 !important;
        color :#b3b3b3 !important;
        cursor: not-allowed;
      }

      .readonlyFeilds:hover{
        border:1px solid #DEE2E6 !important;
      }

    </style>


</head>

<body onload="calcute()">

  <script type="text/javascript">
    function calcute(){
      cal_total1();
      cal_total2();
      cal_total3();
      cal_total4();
      cal_total5();
      cal_total6();
      cal_total7();
      cal_total8();
      cal_total9();
      cal_total10();
      cal_total11();
      cal_total12();
      cal_total13();
      cal_total14();
      cal_total15();
    }
  </script>

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
                                    <li class="breadcrumb-item"><a href="#">Employee Payments</a></li>
                                    <li class="breadcrumb-item myactive">Generate Payrolls</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>

                <?php include('src/itemAlert.php') ?>

                <!-- /# row -->
                <section id="main-content">
                  <div class="row">
                    <div class="col-lg-7 col-sm-12">
                      <div class="card">
                        <div class="card-title">
                            <h4>Select a Department</h4>
                        </div>
                        <form class="" >
                          <div class="row">
                            <div class="col-lg-4">
                              <div class="form-group">
                                  <label>Month <span style="color:red">*</span></label>
                                  <input type="month"  class="form-control" name="month" value="<?php if (isset($_REQUEST['month'])) { echo $_REQUEST['month']; } ?>" max="<?php echo date('Y-m'); ?>">
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group">
                                  <label>Department <span style="color:red">*</span></label>
                                  <select class="form-control" name="deptID" >
                                    <option value="">Select</option>
                                    <?php
                                    $sql = "SELECT * FROM department";
                                    $result = $con->query($sql);
                                    while ($row = $result->fetch_array()){
                                  ?>
                                  <option  value="<?php echo $row['deptID']; ?>"><?php echo $row['deptName']; ?></option>
                                <?php } ?>
                                    ?>
                                  </select>
                              </div>
                            </div>
                            <div class="col-lg-2">
                              <br>
                              <div style="margin-top:10px;text-align:left;">
                                <button type="submit" class="btn btn-success">Show</button>
                              </div>
                            </div>
                          </div>

                        </form>
                      </div>
                    </div>
                    <br> <br>

                    <?php
                    if (isset($_REQUEST['month'])) {
                      $month = $_REQUEST['month'];
                      $cgc = $_REQUEST['month'];
                      $deptID = $_REQUEST['deptID'];

                      $sql_empd = "SELECT employee.*,designation.* FROM employee INNER JOIN designation ON employee.desigID = designation.desigID WHERE employee.empJobStatus ='Working' AND employee.deptID='$deptID' ORDER BY employee.empName";
                      $result_empd = $con->query($sql_empd);
                     ?>
                    <div class="col-lg-12 col-sm-12" >
                      <div class="card">
                        <div class="card-title">
                            <h4>Monthly Payroll List - <b><?php echo $month; ?></b></h4>
                        </div>
                        <div class="bootstrap-data-table-panel">
                            <div class="table-responsive">
                                <table id="bootstrap-data-table-export" border="1" class="table  table-bordered">
                                    <thead>
                                        <tr style="background-color:#d6d6d6">
                                            <th>Employee Name</th>
                                            <th width='140px' >Basic (Rs.)</th>
                                            <th>EPF</th>
                                            <?php if ($deptID == 13){ ?>
                                              <th width='100px' >OT Hrs</th>
                                              <th  width='120px' >OT Payment (Rs.)</th>
                                            <?php } ?>
                                            <th width='140px' >Allowances (Rs.)</th>
                                            <th width='110px' >Bonus (Rs.)</th>
                                            <th width='140px' >Deductions (Rs.)</th>
                                            <th width='140px' >Loan Charges (Rs.)</th>
                                            <th>Late Mins</th>
                                            <th width='110px' >Penalty (Rs.)</th>
                                            <th width='140px' >EPF (Rs.)</th>
                                            <th width='140px' >Net Payment (Rs.)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $jtno = 1;
                                        while ($row_empd = $result_empd->fetch_array()) {
                                          $empID = $row_empd['empID'];

                                          $sql_empd2 = "SELECT employee.*,employee_salary.* FROM employee INNER JOIN employee_salary ON employee.empID = employee_salary.empID WHERE  employee.empID='$empID'";
                                          $result_empd2 = $con->query($sql_empd2);
                                          $row_empd2 = $result_empd2->fetch_array();

                                          $sql_sal = "SELECT * FROM salary_master WHERE month ='$month' AND empID='$empID'";
                                          $result_sal = $con->query($sql_sal);
                                          $rowcount= mysqli_num_rows($result_sal);
                                          $row_sal = $result_sal->fetch_array();

                                          if ($rowcount > 0) {
                                            $pay = 'Paid';
                                          } else{
                                            $pay = 'Not Paid';

                                      ?>
                                      <script type="text/javascript">
                                      $( document ).ready(function() {
                                        cal_total<?php echo $jtno; ?>();
                                      });
                                      </script>
                                      <input type="hidden" name="empID<?php echo $jtno; ?>" id="getempID<?php echo $jtno; ?>" value="<?php echo $empID; ?>">
                                      <input type="hidden" name="month<?php echo $jtno; ?>" id="germonth<?php echo $jtno; ?>" value="<?php echo $month; ?>">
                                        <tr>
                                            <td><?php echo $row_empd['empName']; ?></td>
                                            <td>
                                              <?php
                                                $desigID = $row_empd2['desigID'];
                                                $sql_basic = "SELECT * FROM designation  WHERE desigID='$desigID'";
                                                $result_basic = $con->query($sql_basic);
                                                $row_basic = $result_basic->fetch_array();
                                              ?>
                                              <input type="number" style="text-align:right;width:100%" class="form-control readonlyFeilds" name="basic<?php echo $jtno; ?>" readonly value="<?php echo number_format((float)$row_basic['basic_salary'], 2, '.', ''); ?>" required id="basic<?php echo $jtno; ?>">
                                            </td>
                                            <td style="text-align:center">
                                              <?php if ($row_empd2['epfState'] == 'yes') { ?>
                                                  <?php echo $row_empd2['epf']; ?>%
                                                  <input type="hidden"  class="form-control" name="" readonly value="<?php echo $row_empd2['epf']; ?>" id="epfRate<?php echo $jtno; ?>">
                                              <?php } else{
                                                ?> -
                                                  <input type="hidden"  class="form-control" value="0" id="epfRate<?php echo $jtno; ?>">
                                                <?php
                                              } ?>
                                            </td>
                                            <?php  ?>
                                              <?php
                                              $machineID = $row_empd2['machineID'];
                                              $sql_ot = "SELECT SUM(OThrs),SUM(late) FROM attendance_exported_table  WHERE machineID='$machineID' AND date LIKE '$month%'";
                                              $result_ot = $con->query($sql_ot);
                                              $row_ot = $result_ot->fetch_array();
                                              $ot_hrs = number_format((float)$row_ot[0], 2, '.', '');
                                              $ot_rate = $row_empd2['OTrate'];
                                              $tot = $ot_hrs * $ot_rate;
                                              if ($deptID == 13){
                                              ?>
                                              <td>
                                                <input type="text"  class="form-control" style="width:100%;background-color:white;border:none !important;color:gray;font-weight:normal"  readonly value="<?php echo $ot_hrs; ?>" required id="ot_hrs<?php echo $jtno; ?>" name="ot_hrs<?php echo $jtno; ?>">
                                                <input type="hidden"  class="form-control"  readonly value="<?php echo $ot_rate; ?>" required id="ot_rate<?php echo $jtno; ?>">
                                              </td>
                                              <td>
                                                <input type="number"  class="form-control readonlyFeilds" style="text-align:right;width:100%" name="ot_pay<?php echo $jtno; ?>" readonly id="ot_pay<?php echo $jtno; ?>" value="<?php echo number_format((float)$tot, 2, '.', ''); ?>">
                                              </td>
                                            <?php } else{ ?>
                                              <input type="hidden"   value="0 Hrs"  id="ot_hrs<?php echo $jtno; ?>" name="ot_hrs">
                                              <input type="hidden" value="0"  id="ot_rate<?php echo $jtno; ?>">
                                              <input type="hidden"  name="ot_pay<?php echo $jtno; ?>" readonly id="ot_pay<?php echo $jtno; ?>" value="0">
                                            <?php } ?>
                                            <td>
                                              <input type="number"  class="form-control readonlyFeilds" style="text-align:right;width:100%" name="allowance<?php echo $jtno; ?>" readonly value="<?php echo number_format((float)$row_empd2['allowance'], 2, '.', ''); ?>" required id="allowance<?php echo $jtno; ?>">
                                            </td>
                                            <td><input type="number"  class="form-control" style="text-align:right;width:100%"  name="special_allowance<?php echo $jtno; ?>" id="special_allowance<?php echo $jtno; ?>"  onchange="cal_total<?php echo $jtno; ?>()"></td>
                                            <td>
                                              <input type="number"  class="form-control readonlyFeilds" style="text-align:right;width:100%" name="other<?php echo $jtno; ?>" id="other<?php echo $jtno; ?>"  value="<?php echo number_format((float)$row_empd2['other'], 2, '.', ''); ?>" readonly required>
                                            </td>
                                            <td><input type="number"  class="form-control readonlyFeilds" style="text-align:right;width:100%"  readonly name="loans<?php echo $jtno; ?>" id="loans<?php echo $jtno; ?>"  value="<?php echo number_format((float)$row_empd2['personalLoans'], 2, '.', ''); ?>" ></td>
                                            <td style="text-align:center">
                                              <?php echo $row_ot[1]; ?>
                                              <input type="hidden" name="latemins<?php echo $jtno; ?>" id="latemins<?php echo $jtno; ?>" value="<?php echo $row_ot[1]; ?>">
                                            </td>
                                            <td><input type="number"  class="form-control" style="text-align:right;width:100%" name="special_deduction<?php echo $jtno; ?>"  id="special_deduction<?php echo $jtno; ?>" onchange="cal_total<?php echo $jtno; ?>()"></td>
                                            <td>
                                              <?php if ($row_empd['epfState'] == 'yes') { ?>
                                                <input type="number"  class="form-control readonlyFeilds" style="text-align:right;width:100%" name="epf_amount<?php echo $jtno; ?>" readonly required id="epf_amount<?php echo $jtno; ?>">
                                            <?php } else{ ?>
                                              <input type="text"   class="form-control readonlyFeilds" style="text-align:right;width:100%" value="0" readonly required name="epf_amount<?php echo $jtno; ?>" id="epf_amount<?php echo $jtno; ?>">
                                            <?php } ?>
                                            </td>
                                            <td>
                                              <input type="text"  class="form-control readonlyFeilds" name="net_salary" readonly  required id="net_salary<?php echo $jtno; ?>" style="text-align:right;width:100%">
                                              <input type="hidden" name="total_addition<?php echo $jtno; ?>" id="total_addition<?php echo $jtno; ?>" value="">
                                              <input type="hidden" name="total_deduction<?php echo $jtno; ?>" id="total_deduction<?php echo $jtno; ?>" value="">
                                              <input type="hidden" name="deptID" id="deptID<?php echo $jtno; ?>" value="<?php echo $_REQUEST['deptID']; ?>">
                                              <input type="hidden" name="empName<?php echo $jtno; ?>" id="empName<?php echo $jtno; ?>" value="<?php echo $row_empd['empName']; ?>">
                                            </td>
                                            <td>
                                              <?php if ($pay == 'Paid'){ ?>
                                                <a href='viewPayslip.php?salaryID=<?php echo $row_sal['salaryID']; ?>&emp=<?php echo $empID; ?>&month=<?php echo $row_sal['month']; ?>' target="_blank" style="float:right"><button class="btn-sm btn-danger btn " >Payslip</button></a>
                                              <?php }else{ ?>
                                                <button class="btn-sm btn-primary btn " id="genBtn<?php echo $jtno; ?>" onclick="generateSal<?php echo $jtno; ?>('<?php echo $empID ?>','<?php echo $_GET['month']; ?>')">Generate</button>
                                              <?php } ?>
                                            </td>
                                        </tr>
                                      <?php } ?>

                                        <script type="text/javascript">
                                        function cal_total<?php echo $jtno; ?>(){
                                          var total_addition = 0;
                                          var total_deduction = 0;
                                          var base_salary = 0;
                                          var epf_amt = 0;

                                          var basic = document.getElementById('basic<?php echo $jtno; ?>').value;
                                          var allowance = document.getElementById('allowance<?php echo $jtno; ?>').value;
                                          var special_allowance = document.getElementById('special_allowance<?php echo $jtno; ?>').value;
                                          var ot_pay = document.getElementById('ot_pay<?php echo $jtno; ?>').value;
                                          var epfRate = document.getElementById('epfRate<?php echo $jtno; ?>').value;
                                          //
                                          var other = document.getElementById('other<?php echo $jtno; ?>').value;
                                          var loans = document.getElementById('loans<?php echo $jtno; ?>').value;
                                          var special_deduction = document.getElementById('special_deduction<?php echo $jtno; ?>').value;


                                          if(special_allowance == '' ) { special_allowance = 0 }
                                          if(loans == '' ) { loans = 0 }
                                          if(special_deduction == '' ) { special_deduction = 0 }

                                          epf_amt = (parseInt(basic,'10') * parseInt(epfRate,'10')) / 100;
                                          total_addition = (parseInt(basic,'10')+parseInt(allowance,'10')+parseInt(special_allowance,'10')+parseInt(ot_pay,'10'));
                                          total_deduction = (parseInt(other,'10')+parseInt(loans,'10')+parseInt(special_deduction,'10')+parseInt(epf_amt,'10'));

                                          base_salary = total_addition - total_deduction;

                                          document.getElementById('epf_amount<?php echo $jtno; ?>').value = epf_amt;
                                          document.getElementById('net_salary<?php echo $jtno; ?>').value = base_salary;
                                          document.getElementById('total_addition<?php echo $jtno; ?>').value = total_addition;
                                          document.getElementById('total_deduction<?php echo $jtno; ?>').value = total_deduction;
                                        }

                                          function generateSal<?php echo $jtno; ?>(empID,month){
                                            // var empID = document.getElementById('getempID<?php echo $jtno; ?>').value;
                                            var basic = document.getElementById('basic<?php echo $jtno; ?>').value;
                                            var ot_hrs = document.getElementById('ot_hrs<?php echo $jtno; ?>').value;
                                            var ot_pay = document.getElementById('ot_pay<?php echo $jtno; ?>').value;
                                            var allowance = document.getElementById('allowance<?php echo $jtno; ?>').value;
                                            var special_allowance = document.getElementById('special_allowance<?php echo $jtno; ?>').value;
                                            var total_addition = document.getElementById('total_addition<?php echo $jtno; ?>').value
                                            var other = document.getElementById('other<?php echo $jtno; ?>').value;
                                            var loans = document.getElementById('loans<?php echo $jtno; ?>').value;
                                            var epf_amount = document.getElementById('epf_amount<?php echo $jtno; ?>').value
                                            var latehrs = document.getElementById('latemins<?php echo $jtno; ?>').value;
                                            var special_deduction = document.getElementById('special_deduction<?php echo $jtno; ?>').value;
                                            var total_deduction = document.getElementById('total_deduction<?php echo $jtno; ?>').value
                                            var net_salary = document.getElementById('net_salary<?php echo $jtno; ?>').value
                                            var deptID = document.getElementById('deptID<?php echo $jtno; ?>').value
                                            var empName = document.getElementById('empName<?php echo $jtno; ?>').value

                                            $.ajax({
                                              type: "GET", //we are using GET method to get data from server side
                                              url: '/codec/view/controller/salaryGenerate.php', // get the route value
                                              data: {empID:empID,month:month,basic:basic,ot_hrs:ot_hrs,ot_pay:ot_pay,allowance:allowance,special_allowance:special_allowance,total_addition:total_addition,other:other,loans:loans,epf_amount:epf_amount,latehrs:latehrs,special_deduction:special_deduction,total_deduction:total_deduction,net_salary:net_salary,deptID:deptID,empName:empName}, //set data
                                            }).done(function (data) {
                                              console.log(data);
                                              document.getElementById('genBtn<?php echo $jtno; ?>').style.display='none'
                                            });
                                          }
                                        </script>
                                      <?php $jtno++; } ?>
                                    </tbody>

                                    <tfoot>
                                      <tr style="background-color:#d6d6d6;color:#373757">
                                          <th>Employee Name</th>
                                          <th>Basic (Rs.)</th>
                                          <th>EPF</th>
                                          <?php if ($deptID == 13){ ?>
                                            <th>OT Hrs</th>
                                            <th>OT Payment (Rs.)</th>
                                          <?php } ?>
                                          <th>Allocated <br>Allowance (Rs.)</th>
                                          <th>Bonus (Rs.)</th>
                                          <th>Deductions (Rs.)</th>
                                          <th>Loan Charges (Rs.)</th>
                                          <th>Late Mins</th>
                                          <th>Penalty (Rs.)</th>
                                          <th>EPF (Rs.)</th>
                                          <th>Net Payment (Rs.)</th>
                                          <th>Action</th>
                                      </tr>
                                    </tfoot>
                                </table>
                            </div> <br>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                  </div>


      <?php include('common/footer.php') ?>
     <!-- footer -->
     <?php include('common/tableExport.php') ?>

</body>

</html>
