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
 <script type="text/javascript">
   print()
 </script>


<body  style="background-color:#f2f2f2">
 <br><br>
<div class="container-fluid text-center">
  <div class="row content">
    <div class="col-lg-2"></div>
    <div class="col-sm-8 text-left" style="background-color:#ffffff;margin-bottom:40px">
      <br>
      <table width='100%'>
        <tr>
          <td><img src="../res/images/logo.png" width="30%" style="margin-left:20px;"></td>
          <td>
            <div class="text-right" style="padding-right:10px;color:#006e99;font-size:12px"> <br>
              <p>Codec Solutions, <br>
              No. 10 - 2 /1, 10th Lane,<br>
              Colombo – 03, Sri Lanka <br> </p>
              <p>+94 7777 21122</p>
              <p>codecsolutions@yahoo.com</p>
            </div>
          </td>
        </tr>
      </table>

      <hr style="border-color: #2966A3"> <br>

      <?php
        $sql_loan = "SELECT * FROM employee_loans WHERE loanID='$id'";
        $result_loan = $con->query($sql_loan);
        $row_loanlist = $result_loan->fetch_array();

        $sql_emp = "SELECT * FROM employee WHERE empID='$empID'";
        $result_emp = $con->query($sql_emp);
        $row = $result_emp->fetch_array();


      ?>

      <div class="row" style="width:90%;margin:auto">
        <h5>
          <?php if ($row['empGender'] == 'Male') {
            echo 'Mr.';
          } else{
            if ($row['empMarital'] == 'Married' ) {
              echo 'Mrs.';
            } else{
              echo 'Miss.';
            }
          } ?>
          <?php echo $row['empName']; ?>
        </h5> <br>
        <h5 style="font-weight:bold">LETTER FOR REJECTION OF PERSONAL LOAN REQUEST</h5>
        <p><?php echo $row_loanlist['reason']; ?>
        </p>
        <br>
        <div style="float:right">
          <h5>Account Department</h5>
          <h5>Codec Solutions</h5>
        </div>

      <br><br>
    </div>
    <hr style="border-color: #2966A3;">
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
