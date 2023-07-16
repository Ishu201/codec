<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string

$ob = new dbconnection();
$con = $ob->connection();

// $id = $_REQUEST['id'];
$empID = $_REQUEST['user'];
// $stat = $_REQUEST['stat'];


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

    input:focus{
      border:1px solid #2966A3 !important;
      box-shadow:none !important
    }

    textarea:focus{
      border:1px solid #2966A3 !important;
      box-shadow:none !important
    }
  </style>

</head>


<body  style="background-color:#f2f2f2">
 <br><br>
<div class="container-fluid text-center">
  <div class="row content">
    <div class="col-lg-2"></div>
    <div class="col-sm-8 text-left" style="background-color:white;">
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
        $sql_emp = "SELECT * FROM employee WHERE empID='$empID'";
        $result_emp = $con->query($sql_emp);
        $row = $result_emp->fetch_array();

      ?>


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
          <form  action="operation/addLoanReq.php" method="post">
          <div class="row">
            <div class="col-lg-4">
              <h5><span style="color:red">*</span> Apply Date :</h5>
            </div>
            <div class="col-lg-4">
              <input type="date" required  name="applyDate" min="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="Application Date..">
            </div>
          </div> <br>
          <div class="row">
            <div class="col-lg-4">
              <h5><span style="color:red">*</span> Requesting Loan Amount :</h5>
            </div>
            <div class="col-lg-4">
              <input type="number" required  name="loanAmount" min="0" max="1000000" class="form-control" placeholder="Loan Amount">
              <input type="hidden" required value="<?php echo $empID; ?>"  name="userhidden" >
            </div>
          </div> <br>
          <div class="row">
            <div class="col-lg-12">
              <h5><span style="color:red">*</span> Loan Requesting Letter</h5>
              <textarea name="letter" required  placeholder="Loan Requesting Letter..." class="form-control" style="height:250px;"></textarea>
            </div>
          </div> <br>
          <input type="submit" name="" class="btn btn-success" value="Send Loan Request" style="float:right">
        </div>
      </form>

      <br><br>
    </div>

      <br> <br>
      <hr style="border-color: #2966A3">
      <br><br>
    </div>

  </div>
</div> <br><br>


</body>

</html>
