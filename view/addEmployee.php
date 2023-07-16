<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string
include 'model/departmentmodel.php';

$ob = new dbconnection();
$con = $ob->connection();
//to display task list

$dept = new department;
$result_dept = $dept->viewDept();

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('common/files.php') ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>

    <style media="screen">
      .error{
        color:red
      }

      .suc{
        color:#28A745
      }
      .error_class{
        border-color:red !important
      }
      .error_class:hover{
        border-color:red !important
      }

      .success_class{
        border-color:#28A745 !important;
      }
      .success_class:hover{
        border-color:#28A745 !important
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
      document.getElementById('emplist').className = 'active';
    </script>

    <?php include('common/header.php') ?>
    <!-- head bar -->


    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-7 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>New Employee</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-5 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="employees.php">Employee List</a></li>
                                    <li class="breadcrumb-item myactive">Add new Employee</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->
                <section id="main-content">

                  <?php include('src/employeeAlert.php') ?>

                    <div class="col-lg-12 col-sm-12">
                      <div class="card">
                        <div class="card-title">
                            <h4>Add Employee</h4>
                        </div>
                        <div class="basic-form"> <br>
                            <form method="post" action="controller/employeecontroller.php?status=add" enctype="multipart/form-data">
                              <div class="form-group">
                                <label for="myfile" style="margin-bottom:0px !important;"><span style="color:red">*</span> Employee Image: &nbsp </label>
                                <p style="font-size:13px;margin-top:0px !important;">Please use only .jpg .jpeg .png and .webp files</p>
                                <input  type="file" id="myfile" name="image" accept="image/*" required onchange="imageup();">
                                <p style="color:red;display:none;font-weight:bold" id="w2"><br>Select an Image less than 2Mb</p>
                              </div>

                              <?php
                              $sql = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA ='codec' AND TABLE_NAME ='employee'";
                              $result = $con->query($sql);
                              $row = $result->fetch_array();
                              $num = $row[0];
                               ?>

                              <div class="row">
                                <div class="col-lg-2 col-sm-6">
                                  <div class="form-group">
                                      <label>Employee Code <span style="color:red">*</span></label>
                                      <input type="text"  class="form-control" name="empCode" readonly value="EID<?php echo sprintf("%05d", $num) ?>">
                                  </div>
                                </div>
                                <div class="col-lg-5 col-sm-6">
                                  <div class="form-group">
                                      <label>Full Name <span style="color:red">*</span></label>
                                      <input  type="text"  class="form-control"  id="empName" name="empName" placeholder="Employee Full Name" minlength="10" required>
                                  </div>
                                </div>
                                <div class="col-lg-2 col-sm-6">
                                  <div class="form-group">
                                      <label>EPF State <span style="color:red">*</span></label>
                                      <select class="form-control" name="epfState" id="epfState" required>
                                        <option value="yes">Have EPF</option>
                                        <option value="no">No EPF</option>
                                      </select>
                                  </div>
                                </div>
                                <script type="text/javascript">
                                  $( "#epfState" ).change(function() {
                                    var epfstate = $('#epfState').val();
                                    if (epfstate == 'yes') {
                                      $("#epfcard").css('display','block');
                                      $("#empEpf").prop('required',true);
                                    }
                                    else {
                                      $("#epfcard").css('display','none');
                                      $("#empEpf").removeAttr('required');
                                    }
                                  });
                                </script>
                                <div id="epfcard" class="col-lg-3 col-sm-6">
                                  <div class="form-group">
                                      <label>EPF Number <span style="color:red">*</span></label>
                                      <input type="text"  class="form-control" pattern="[0-9]{5}" id="empEpf" name="empEpf" placeholder="Employee Provident Fund" required min="5" maxlength="5">
                                      <p id="errorEpf" style="color:red;font-weight:bold;"></p>
                                  </div>
                                </div>
                              </div>

                              <?php
                              $sql_mid = "SELECT MAX(machineID) FROM employee";
                              $result_mid = $con->query($sql_mid);
                              $row_mid = $result_mid->fetch_array();
                              $num_mid = $row_mid[0]+1;
                               ?>

                              <div class="row">
                                <div class="col-lg-2 col-sm-6">
                                  <div class="form-group">
                                      <label>Machine ID <span style="color:red">*</span></label>
                                      <input type="number"  class="form-control" name="machineID" value="<?php echo sprintf("%04d",$num_mid); ?>" readonly required>
                                  </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                  <div class="form-group">
                                      <label>Employee Type <span style="color:red">*</span></label>
                                      <select class="form-control" id="empType" name="empType" required>
                                        <option value="">Select Type</option>
                                        <option value="worker">Worker</option>
                                        <option value="staff">Staff</option>
                                      </select>
                                  </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                  <div class="form-group">
                                      <label>Date Of Joining <span style="color:red">*</span></label>
                                      <input type="date"  class="form-control" id="empJoin" value="<?php echo date('Y-m-d') ?>" max="<?php echo date('Y-m-d') ?>" name="empJoin" placeholder="yyyy-mm-dd" required>
                                  </div>
                                </div>


                                <div class="col-lg-3">
                                  <label>Work Shift <span style="color:red">*</span></label>
                                  <div class="input-group">
                                    <select class="form-control" name="shiftStart" onchange="" id="shiftStart">
                                      <option value="">Select Time</option>
                                      <option value="07:30">07:30 AM</option>
                                      <option value="08:00">08:00 AM</option>
                                      <option value="08:30">08:30 AM</option>
                                    </select>
                                    <span class="input-group-btn">
                                      <button type="button" class="btn btn-flat btn-default" style="height:42px" disabled >To</button>
                                    </span>
                                    <select class="form-control" name="shiftEnd" id="shiftEnd">
                                      <option value="">Select Time</option>
                                      <option value="17:00">05:00 PM</option>
                                      <option value="17:30">05:30 PM</option>
                                    </select>
                                  </div>
                                </div>

                              </div>

                              <div class="row">
                                <div class="col-lg-3 col-sm-6">
                                  <div class="form-group">
                                      <label>Department <span style="color:red">*</span></label>
                                      <select class="form-control" name="deptID" id="dept" required style="text-transform:capitalize">
                                        <option value="">Select a Department...</option>
                                        <?php
                                          while ($row_dept = $result_dept->fetch_array()) { ?>
                                        <option value="<?php echo $row_dept['deptID'] ?>"><?php echo $row_dept['deptName'] ?></option>
                                        <?php
                                          }
                                        ?>
                                      </select>
                                  </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                  <div class="form-group">
                                      <label>Designation <span style="color:red">*</span></label>
                                      <select class="form-control" name="desigID" id="desig_select" required style="text-transform:capitalize">
                                      </select>
                                  </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                  <div class="form-group">
                                      <label>NIC <span style="color:red">*</span></label>
                                      <input type="text"  class="form-control" id="empNIC" name="empNIC"  placeholder="Use the NIC without V" pattern="[0-9]{9,10}"  required min="9" maxlength="10">
                                      <p id="errorNic" style="color:red;font-weight:bold;"></p>
                                  </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                  <div class="form-group">
                                      <label>Contact No <span style="color:red">*</span></label>
                                      <input type="text"  class="form-control" id="empContact" name="empContact" placeholder="Employee Contacts" pattern="[0-9]{10}"  required min="10" maxlength="10">
                                      <p id="errorCon" style="color:red;font-weight:bold;"></p>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-lg-3 col-sm-6">
                                  <div class="form-group">
                                      <label>Email Address <span style="color:red">*</span></label>
                                      <input type="email"  class="form-control" id="empEmail" name="empEmail" placeholder="example@mail.com" required>
                                      <p id="errorEmail" style="color:red;font-weight:bold;"></p>
                                  </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                  <div class="form-group">
                                      <label>Gender <span style="color:red">*</span></label>
                                      <select class="form-control" id="empGender" name="empGender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                      </select>
                                  </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                  <div class="form-group">
                                      <label>Address <span style="color:red">*</span></label>
                                      <input type="text"  class="form-control" id="empAddress" name="empAddress" placeholder="Residancial Address" required>
                                </div></div>
                              </div>
                              <div class="float-right">
                                <button type="reset" class="btn btn-default">Clear</button>
                                <button type="submit" class="btn btn-success">Add</button>
                              </div>
                            </form>
                        </div>
                      </div>
                    </div>
                  <!-- </div> -->


      <?php include('common/footer.php') ?>
     <!-- footer -->


          <script src="assets/js/lib/toastr/toastr.min.js"></script>
          <script src="assets/js/lib/toastr/toastr.init.js"></script>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    // dept dependent ajax
    $(document).on('change', '#dept', function(){
      // var deptId = $(this).val();
      var deptID = $(this).val();
      $.ajax({
        type: "GET", //we are using GET method to get data from server side
        url: '/codec/view/operation/load_sub.php', // get the route value
        data: {deptID:deptID}, //set data
        }).done(function (data) {
        console.log(data);
        $("#desig_select").html(data);
    });
  });

  // duplicate check ajax
  $(document).on('change', '#empEpf', function(){
    // var deptId = $(this).val();
    var empEpf = $(this).val();
    var col = 'epf';
    $.ajax({
      type: "GET", //we are using GET method to get data from server side
      url: '/codec/view/operation/epf_duplicatecheck.php', // get the route value
      data: {val:empEpf,col:col}, //set data
    }).done(function (data) {
      console.log(data);
      $("#errorEpf").html(data);
    });
  });

  $(document).on('change', '#empNIC', function(){
    // var deptId = $(this).val();
    var empNIC = $(this).val();
    var col = 'nic';
    $.ajax({
      type: "GET", //we are using GET method to get data from server side
      url: '/codec/view/operation/epf_duplicatecheck.php', // get the route value
      data: {val:empNIC,col:col}, //set data
    }).done(function (data) {
      console.log(data);
      $("#errorNic").html(data);
    });
  });

  $(document).on('change', '#empContact', function(){
    // var deptId = $(this).val();
    var empContact = $(this).val();
    var col = 'con';
    $.ajax({
      type: "GET", //we are using GET method to get data from server side
      url: '/codec/view/operation/epf_duplicatecheck.php', // get the route value
      data: {val:empContact,col:col}, //set data
    }).done(function (data) {
      console.log(data);
      $("#errorCon").html(data);
    });
  });

  $(document).on('change', '#empEmail', function(){
    // var deptId = $(this).val();
    var empEmail = $(this).val();
    var col = 'email';
    $.ajax({
      type: "GET", //we are using GET method to get data from server side
      url: '/codec/view/operation/epf_duplicatecheck.php', // get the route value
      data: {val:empEmail,col:col}, //set data
    }).done(function (data) {
      console.log(data);
      $("#errorEmail").html(data);
    });
  });

  });
</script>

<script type="text/javascript">
function imageup(){
  var input = document.getElementById('myfile');
  const fileSize = input.files[0].size / 1024 / 1024; // in MiB
if (fileSize > 2) {
document.getElementById('myfile').value = '';
document.getElementById('w2').style.display = 'block';
} else {
document.getElementById('w2').style.display = 'none';
}
}
</script>

</html>
