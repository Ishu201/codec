<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string

$ob = new dbconnection();
$con = $ob->connection();

$id = $_REQUEST['id'];
$empID = $_REQUEST['user'];


 ?>


  <!DOCTYPE html>
<html lang="en">
<head>
  <title>Loan Application</title>
  <link rel="icon" type="image/png" href="../res/images/logoIcon.png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link href="assets/css/lib/toastr/toastr.min.css" rel="stylesheet">

  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }

    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}

    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }

    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }

    .btn:focus{
      outline: none !important
    }

    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;}
    }
  </style>

</head>



<body  style="background-color:#f2f2f2">
 <br><br>
<div class="container-fluid text-center">
  <div class="row content">
    <div class="col-lg-2"></div>
    <div class="col-sm-8 text-left" style="background-color:white;margin-bottom:40px">
      <br>
      <div class="row">
        <div class="col-lg-7"> <br>
          <img src="../res/images/logo.png" width="280px" style="margin-left:20px;">
        </div>
        <div class="col-lg-5 text-right" style="padding-right:50px;color:#006e99"> <br>
          <p>Codec Solutions, <br>
          No. 10 - 2 /1, 10th Lane,<br>
          Colombo – 03, Sri Lanka <br> </p>
          <p>+94 7777 21122</p>
          <p>codecsolutions@yahoo.com</p>
        </div>
      </div>

      <hr style="border-color: #2966A3"> <br>

      <?php
        $sql_loan = "SELECT * FROM employee_loans WHERE loanID='$id'";
        $result_loan = $con->query($sql_loan);
        $row_loanlist = $result_loan->fetch_array();

        $sql_emp = "SELECT * FROM employee WHERE empID='$empID'";
        $result_emp = $con->query($sql_emp);
        $row = $result_emp->fetch_array();


      ?>

      <?php include('src/itemAlert.php') ?>

      <div class="row" style="width:90%;margin:auto">
        <div class="col-lg-12" style="background-color:#2966a3;color:white">
          <center><h5>Employee Personal Details</h5><center>
        </div>
        <div class="row">
          <div class="col-lg-8"> <br>
            <div class="row">
              <div class="col-lg-4">
                <td>Employee ID :</td>
              </div>
              <div class="col-lg-8">
                <input type="text" required readonly name="empID" value="EID<?php echo sprintf("%05d", $empID) ?>" class="form-control">
              </div>
            </div> <br>
            <div class="row">
              <div class="col-lg-4">
                <h5>Employee Name :</h5>
              </div>
              <div class="col-lg-8">
                <input  type="text"  class="form-control" readonly name="empName" value="<?php echo $row['empName']; ?>" required>
              </div>
            </div> <br>

            <?php
              $desigID = $row['desigID'];
              $sql_desig = "SELECT * FROM designation WHERE desigID='$desigID'";
              $result_desig = $con->query($sql_desig);
              $row_desig = $result_desig->fetch_array();
            ?>
            <div class="row">
              <div class="col-lg-4">
                <h5>Designation :</h5>
              </div>
              <div class="col-lg-8">
                <input type="text" readonly required name="designation" value="<?php echo $row_desig['designation'] ?>" class="form-control">
              </div>
            </div> <br>
            <div class="row">
              <div class="col-lg-4">
                <h5>Employee Type :</h5>
              </div>
              <div class="col-lg-8">
                <input type="text" readonly required name="empType" value="<?php echo $row['empType'] ?>" class="form-control" style="text-transform:capitalize">
              </div>
            </div>
          </div>
          <div class="col-lg-4 text-right" > <br>
            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>"  height="220px" width="200px" style="border:1px solid gray">
          </div>
        </div> <br>
        <div class="col-lg-12">
          <h1>Application for Loan</h1>
          <div class="row">
            <div class="col-lg-4">
              <h5>Apply Date :</h5>
            </div>
            <div class="col-lg-8">
              <input type="date" required readonly name="" value="<?php echo $row_loanlist['applyDate']; ?>" class="form-control" placeholder="Application Date..">
            </div>
          </div> <br>
          <div class="row">
            <div class="col-lg-4">
              <h5>Requesting Loan Amount :</h5>
            </div>
            <div class="col-lg-8">
              <input type="text" required readonly name="" value="Rs. <?php echo number_format($row_loanlist['loanAmount'],2); ?>" class="form-control" placeholder="Loan Amount">
            </div>
          </div> <br>
          <div class="row">
            <div class="col-lg-12">
              <h5>Loan Requesting Letter</h5>
              <textarea name="name" required readonly placeholder="Loan Requesting Letter..." class="form-control" style="height:250px;"><?php echo $row_loanlist['letter']; ?></textarea>
            </div>
          </div> <br>
        </div>

        <div class="col-lg-12" style="background-color:#2966a3;color:white;margin-top:10px">
          <center><h5>Employee Company Status</h5><center>
        </div>

        <div class="col-lg-12">
          <div class="row">
            <br>
            <div class="col-lg-2">
              <h5>Basic Salary :</h5>
            </div>
            <?php
                $desigID = $row['desigID'];
                $sql2 = "SELECT * FROM designation WHERE desigID ='$desigID'";
                $result2 = $con->query($sql2);
                $row_amt = $result2->fetch_array();
                $value = $row_amt['basic_salary'];

             ?>
            <div class="col-lg-5">
              <input type="text" name="" readonly value="Rs. <?php echo number_format($value,2); ?>" class="form-control" placeholder="Loan Amount">
            </div>
          </div> <br>
          <?php
            if (($row['desciplinary'] == 'Demotion') or ($row['desciplinary'] == 'Suspend')) {
              $desc_stat = 'Not Eligible';
            } else{
              $desc_stat = 'Eligible';
            }
           ?>
          <div class="row">
            <div class="col-lg-2">
              <h5>Desciplinary Status :</h5>
            </div>
            <div class="col-lg-4">
              <input type="text" readonly name="" value="<?php echo $desc_stat; ?>" class="form-control" placeholder="Loan Amount">
            </div>
            <div class="col-lg-2">
              <h5>Loan Status :</h5>
            </div>
            <?php
              if ($row['loanStat'] == 'No') {
                $stats = 'No Proceeding Loans';
              } else{
                $stats = 'Already Processing a Loan';
              }
             ?>
            <div class="col-lg-4">
              <input type="text" name="" readonly value="<?php echo $stats; ?>" class="form-control">
            </div>
          </div> <br>
        <form class="" action="operation/loanHr.php" method="post">
          <input type="hidden" name="loanID" value="<?php echo $id; ?>">
          <input type="hidden" name="userhidden" value="<?php echo $empID; ?>">
          <div class="row">
            <div class="col-lg-12">
              <h5>HR Recommendation Remark :</h5>
              <textarea  id="hrRemark" name="hrRemark" required placeholder="HR Recommendation Remark..." class="form-control" style="height:150px;" <?php if($row_loanlist['hrRemark'] != ''){ echo 'readonly'; } ?>><?php echo $row_loanlist['hrRemark']; ?>
              </textarea>
            </div>
            <div class="col-lg-6 text-right" >
              <br>
              <h5>Checked By :</h5>
            </div>
            <div class="col-lg-6">
              <br>
              <?php
              if ($row_loanlist['hrCheck'] == '') { ?>
                <select id="submit_hr" disabled class="form-control" name="hrCheck" onchange="this.form.submit()">
                  <option value="">Select..</option>
                  <?php
                  $sql_hr = "SELECT * FROM employee WHERE deptID ='4'";
                  $result_hr = $con->query($sql_hr);
                  while ($row_hr = $result_hr->fetch_array()) {
                   ?>
                  <option value="<?php echo $row_hr['empName']; ?>"><?php echo $row_hr['empName']; ?></option>
                <?php } ?>
                </select>
              <?php } else{ ?>
                <input type="text" class="form-control" readonly value="<?php echo $row_loanlist['hrCheck']; ?>">
              <?php } ?>
            </div>
          </div> <br> </form>
        </div>

        <div class="col-lg-12" style="background-color:#2966a3;color:white;margin-top:10px">
          <center><h5>Loan Application Completion</h5><center>
        </div>

        <div class="col-lg-12">
          <div class="row">
            <br>
            <div class="col-lg-3">
              <h5>Status :</h5>
            </div>
            <div class="col-lg-3">
              <?php
                if ($row_loanlist['status'] == 'Pending') {
                  echo '<button type="button" class="btn btn-sm btn-warning">Pending</button><br><br>';
                } else if ($row_loanlist['status'] == 'Approved') {
                  echo '<button type="button" class="btn btn-sm btn-success">Approved</button>';
                }else{
                  echo '<button type="button" class="btn btn-sm btn-danger">Rejected</button>';
                }
               ?>
            </div>
            <?php if ($row_loanlist['status'] == 'Approved') {  ?>
            <div class="col-lg-2">
              <h5>Total Payback :</h5>
            </div>
            <div class="col-lg-4">
              <input type="text" id="payback" name="payback" readonly value="Rs. <?php  echo number_format($row_loanlist['payback_amt'],2); ?>" class="form-control loaninput" disabled placeholder="Payback Amount">
            </div>
        </div> <br> <br>
          <div class="row">
            <div class="col-lg-2">
              <h5>Loan Interest :</h5>
            </div>
            <div class="col-lg-4">
              <input type="text" readonly name="" value="<?php if ($row_loanlist['status'] == 'Approved') { echo $row_loanlist['interest']; } ?> % " class="form-control" placeholder="Loan Amount">
            </div>
            <div class="col-lg-2">
              <h5>Monthly Charge :</h5>
            </div>
            <div class="col-lg-4">
              <input type="text" readonly name="" value="Rs. <?php if ($row_loanlist['status'] == 'Approved') { echo number_format($row_loanlist['monthly'],2); } ?>"  class="form-control" placeholder="Loan Amount">
            </div>
          </div> <br> <br>
          <div class="row">
            <div class="col-lg-2">
              <h5>Payback Duration :</h5>
            </div>
            <div class="col-lg-2">
              <input type="text" readonly name="" value="<?php if ($row_loanlist['status'] == 'Approved') { echo $row_loanlist['duration']; } ?> Years" class="form-control">
            </div>
            <div class="col-lg-1">
              <h5>From :</h5>
            </div>
            <div class="col-lg-3">
              <input type="month" readonly  value="<?php if ($row_loanlist['status'] == 'Approved') { echo $row_loanlist['startMonth']; } ?>" class="form-control form-inline">
            </div>
            <div class="col-lg-1">
              <h5>To :</h5>
            </div>
            <div class="col-lg-3">
              <input type="month" readonly name="" value="<?php if ($row_loanlist['status'] == 'Approved') { echo $row_loanlist['endMonth']; } ?>" class="form-control">
            </div>
          </div> <br>
        <?php }
            if ($row_loanlist['status'] == 'Rejected') {
           ?>
          <div class="row">
            <div class="col-lg-12"> <br>
               <h5>&nbsp &nbsp Reason for Loan Rejection :</h5>
               <input type="text" class="form-control" name="subject" value="<?php if ($row_loanlist['status'] == 'Rejected') { echo $row_loanlist['rejectSub']; } ?>" placeholder="subject" style="width:50%" readonly> <br>
              <textarea name="name" readonly placeholder="Loan Rejection Reason..." class="form-control" style="height:100px;"><?php if ($row_loanlist['status'] == 'Rejected') { echo $row_loanlist['reason']; } ?></textarea>
            </div>
          </div>
        <?php } ?>
           <br><br>
        </div>
      <hr style="border-color: #2966A3;">
      <br><br>
    </div>

  </div>
</div> <br><br>


</body>
<script src="assets/js/lib/toastr/toastr.min.js"></script>
<script src="assets/js/lib/toastr/toastr.init.js"></script>

<script type="text/javascript">
$(document).ready(function(){
  $("#hrRemark").change(function(){
    var qual = $('#hrRemark').val();
    if (qual == '') {
      $("#submit_hr").prop('disabled', true);
    }else{
      $("#submit_hr").prop('disabled', false);
    }
  });
});

</script>

</html>
