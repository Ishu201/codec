<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string
include 'model/employeemodel.php';
include 'model/departmentmodel.php';

$ob = new dbconnection();
$con = $ob->connection();

$id = $_REQUEST['id'];
$stat_url = $_REQUEST['stat'];

$emp = new employee;
$result_emp = $emp-> viewEmp_selected($id);
$row = $result_emp->fetch_array();
$empID = $row['empID'];

$dept = new department;
$result_dept = $dept->viewDept();

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
    <link rel="stylesheet" href="assets/css/pagination.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>

    <style media="screen">
      td{
        font-weight: normal;
      }

      thead{
        background-color:#476b6b;
        color:white !important;
        border:none !important;
      }

      th{
        color:white !important
      }

      .table{

      }

      .dt-buttons{
        position: absolute;
        left: 0%
      }

      .btn-sm{
        font-size: 13px;
      }

      .table-responsive{
        margin-top:10px;
      }

      .pagination{
        display: none;
      }

      html,body{
        width: 100%;
        height: 100%;
        margin: 0px;
        padding: 0px;
        overflow-x: hidden;
      }

      .myinput1{
        padding: 5px;
        border:none !important;
        width:350px;
        border-bottom:solid 1.5px #cccccc !important;
      }

      .myinput1:disabled{
        background-color: white !important;
        border:none !important;
      }

      .myinput1:focus{
        outline: none;
        font-weight: bold;
      }

      input:read-only:hover {
      cursor: not-allowed;
      }

    </style>

    <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script>
      $(document).ready(function(){
        jQuery.noConflict();
          $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
              localStorage.setItem('activeTab', $(e.target).attr('href'));
          });
          var activeTab = localStorage.getItem('activeTab');
          if(activeTab){
              $('#myTab a[href="' + activeTab + '"]').addClass('active show');
              $('#myTab a[href="' + activeTab + '"]').tab('show');
          }
      });
    </script>

    <?php if (isset($_REQUEST['loan'])) { ?>
        <script>
          $(document).ready(function(){
            jQuery.noConflict();
              $('a[href="#dropdown1"]').click();
          });
        </script>
    <?php } ?>

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
                                <h1>Edit Employee - <i style="color:gray;text-transform:capitalize"><?php echo $row['empName']; ?></i></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-5 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="employees.php">Employee List</a></li>
                                    <li class="breadcrumb-item myactive">Edit Employee</li>
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
                        <div class="card-body p-b-0">
    											<!-- Nav tabs -->
    											<ul class="nav nav-tabs customtab2" role="tablist" id="myTab">
    												<li class="nav-item active"> <a class="nav-link" data-toggle="tab" href="#personal" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down"> Personal Info</span></a> </li>
    												<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#contact" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down"> Contact Details</span></a> </li>
    												<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#education" role="tab"><span class="hidden-sm-up"><i class="ti-bookmark-alt"></i></span> <span class="hidden-xs-down"> Education</span></a> </li>
    												<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#experiance" role="tab"><span class="hidden-sm-up"><i class="ti-medall"></i></span> <span class="hidden-xs-down"> Experience</span></a> </li>
    												<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#bank" role="tab"><span class="hidden-sm-up"><i class="ti-credit-card"></i></span> <span class="hidden-xs-down"> Bank Details</span></a> </li>
    												<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#doc" role="tab"><span class="hidden-sm-up"><i class="ti-files"></i></span> <span class="hidden-xs-down"> Documents</span></a> </li>
                            <li class="nav-item dropdown">
    													<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
    														<span class="hidden-sm-up"><i class="ti-money"></i></span> <span class="hidden-xs-down"> Payments</span>
    													</a>
    													<div class="dropdown-menu">
                                <a class="dropdown-item" id="dropdown3-tab" href="#dropdown3" role="tab" data-toggle="tab" aria-controls="dropdown3">Salary Data</a>
                                <?php
                                $sql_loan = "SELECT * FROM employee_loans WHERE empID='$empID'";
                                $result_loan = $con->query($sql_loan);
                                 $count_loan = $result_loan->num_rows;
                                if ($count_loan > 0) {
                                  $disab = '';
                                  } else{
                                    $disab = 'pointer-events: none;color:#d6d6d6';
                                  }
                                ?>
                                <a class="dropdown-item" id="dropdown1-tab"  style="<?php echo $disab; ?>" href="#dropdown1" role="tab" data-toggle="tab" aria-controls="dropdown1">Loan Details</a>
                              </div>
    												</li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#jobLeave" role="tab"><span class="hidden-sm-up"><i class="ti-bag"></i></span> <span class="hidden-xs-down"> Leave</span></a> </li>
    											</ul>
    											<!-- Tab panes -->
    											<div class="tab-content">
                            <!-- personal panel -->
    												<div class="tab-pane active p-20" id="personal" role="tabpanel">
                              <div class="user-profile" >
                                <div class="row" >
                                  <div class="col-lg-3" >
                                    <div class="user-photo m-b-30" > <br>
                                      <center>
                                      <img style="border-radius:70%;width:200px;height:180px;border:1px solid #ADC2D6" class="img-fluid" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>" alt="" />
                                      <br> <br>
                                      <h4 style="text-transform:capitalize"><?php echo $row['empName'] ?></h4>
                                      <h6>Employee CODE - EID<?php echo sprintf("%05d", $empID) ?></h6>
                                    </center>
                                    </div>

                                  </div>

                                  <div class="col-lg-9" style="padding-left:5%">
                                    <div class="basic-form"> <br>
                                        <form id="printable" action="controller/employeecontroller.php?status=personalUpdate&emp_id=<?php echo $empID; ?>" method="post"  >
                                          <div class="row">
                                            <div class="col-lg-9 col-sm-6">
                                              <div class="form-group">
                                                  <label>Full Name <span style="color:red">*</span></label>
                                                  <input type="hidden"  class="form-control" name="empID" value="<?php echo $empID; ?>">
                                                  <input  type="text"  class="form-control" required readonly name="empName" value="<?php echo $row['empName']; ?>">
                                              </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                              <div class="form-group">
                                                  <label>Machine ID <span style="color:red">*</span></label>
                                                  <input type="text" readonly required  class="form-control" name="machineID"  value="<?php echo $row['machineID'] ?>">
                                              </div>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-lg-5 col-sm-6">
                                              <div class="form-group">
                                                  <label>Department <span style="color:red">*</span></label>
                                                  <select class="form-control" name="deptID" id="dept" required>
                                                    <option value="">Select a Department...</option>
                                                    <?php
                                                      while ($row_dept = $result_dept->fetch_array()) { ?>
                                                    <option <?php if ($row['deptID'] == $row_dept['deptID']){ echo 'selected'; } ?> value="<?php echo $row_dept['deptID'] ?>"><?php echo $row_dept['deptName'] ?></option>
                                                    <?php
                                                      }
                                                    ?>
                                                  </select>
                                              </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                              <div class="form-group">
                                                  <label>Designation<span style="color:red">*</span></label>
                                                  <select class="form-control" name="desigID" id="desig_select" required>
                                                  </select>
                                              </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                              <div class="form-group">
                                                  <label>Date Of Joining <span style="color:red">*</span></label>
                                                  <input type="date" readonly  class="form-control" name="empJoined" required value="<?php echo $row['dateOfJoin'] ?>" >
                                              </div>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-lg-3 col-sm-6">
                                              <div class="form-group">
                                                  <label>Employee Type <span style="color:red">*</span></label>
                                                  <select class="form-control" id="empType" name="empType" required>
                                                    <option <?php if($row['empType'] == 'worker'){ echo 'selected'; } ?> value="worker">Worker</option>
                                                    <option <?php if($row['empType'] == 'staff'){ echo 'selected'; } ?> value="staff">Staff</option>
                                                  </select>
                                              </div>
                                            </div>
                                            <div class="col-lg-3">
                                              <div class="form-group">
                                                  <label>EPF State <span style="color:red">*</span></label>
                                                  <?php if ($row['epfState'] == 'yes') { ?>
                                                      <input type="text" style="text-transform:capitalize" readonly  class="form-control" name="epfState" value="<?php echo $row['epfState'] ?>" >
                                                  <?php
                                                } else{
                                                   ?>
                                                  <select class="form-control" name="epfState" id="epfState">
                                                    <option  value="yes">Have EPF</option>
                                                    <option selected readonly value="no">No EPF</option>
                                                  </select>
                                                <?php } ?>
                                              </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                              <div class="form-group">
                                                  <label>EPF Number </label>
                                                  <input type="text"  class="form-control" readonly name="epfNO" id="empEpf"  value="<?php echo $row['epfNo'] ?>">
                                              </div>
                                            </div>
                                            <div class="col-lg-5">
                                              <label>Work Shift <span style="color:red">*</span></label>
                                              <div class="input-group">
                                                <select class="form-control" name="shiftStart"  id="shiftStart">
                                                  <option <?php if($row['shiftStart'] == '07:30') { echo 'selected'; } ?> value="07:30">07:30 AM</option>
                                                  <option <?php if($row['shiftStart'] == '08:00') { echo 'selected'; } ?> value="08:00">08:00 AM</option>
                                                  <option <?php if($row['shiftStart'] == '08:30') { echo 'selected'; } ?> value="08:30">08:30 AM</option>
                                                </select>
                                                <span class="input-group-btn">
                                                  <button type="button" class="btn btn-flat btn-default" style="height:42px" disabled >To</button>
                                                </span>
                                                <select class="form-control" name="shiftEnd" id="shiftEnd">
                                                  <option value="">Select Time</option>
                                                  <option <?php if($row['shiftEnd'] == '17:00') { echo 'selected'; } ?>  value="17:00">05:00 PM</option>
                                                  <option <?php if($row['shiftEnd'] == '17:30') { echo 'selected'; } ?>  value="17:30">05:30 PM</option>
                                                </select>
                                              </div>
                                            </div>
                                          </div>

                                          <script type="text/javascript">

                                            $( "#epfState" ).change(function() {
                                              var epfstate = $('#epfState').val();
                                              if (epfstate == 'yes') {
                                                $("#empEpf").prop('required',true);
                                                $("#empEpf").prop("readonly", false);
                                                $('#empEpf').val('');
                                              }
                                              else {
                                                $("#empEpf").removeAttr('required');
                                                $("#empEpf").prop("readonly", true);
                                                $('#empEpf').val('No');
                                              }
                                            });
                                          </script>

                                          <div class="row">
                                            <div class="col-lg-4 col-sm-6">
                                              <div class="form-group">
                                                  <label>NIC <span style="color:red">*</span></label>
                                                  <input type="number"  class="form-control" name="empNic" readonly value="<?php echo $row['empNIC'] ?>" required>
                                              </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                              <div class="form-group">
                                                  <label>Contact No <span style="color:red">*</span></label>
                                                  <input type="number"  class="form-control" name="empContact" placeholder="Employee Contacts" value="0<?php echo $row['empContact'] ?>" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10">
                                              </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                              <div class="form-group">
                                                  <label>Email Address <span style="color:red">*</span></label>
                                                  <input type="email"  class="form-control" name="empEmail" placeholder="exsample@mail.com" value="<?php echo $row['empEmail'] ?>" required>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-lg-8 col-sm-12">
                                              <div class="form-group">
                                                  <label>Address <span style="color:red">*</span></label>
                                                  <input type="text"  class="form-control" required name="empAddress" value="<?php echo $row['empAddress'] ?>" placeholder="Residancial Address">
                                              </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                              <div class="form-group">
                                                  <label>Gender <span style="color:red">*</span></label>
                                                  <input type="text" readonly required  class="form-control" value="<?php echo $row['empGender'] ?>">
                                              </div>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-lg-4">
                                              <div class="form-group">
                                                  <label>Job Status <span style="color:red">*</span></label>
                                                  <input type="text" required  class="form-control"  value="<?php if($row['empJobStatus'] == 'Working'){ echo 'Currently Working'; } else { echo 'Previous Worker'; }  ?>" readonly>
                                              </div>
                                            </div>
                                            <div class="col-lg-4">
                                              <div class="form-group">
                                                  <label>Employement End Date</label>
                                                  <input type="date" id="endDate"  class="form-control" name="dateOfResign" placeholder="yyyy-mm-dd"
                                                  value="<?php echo $row['dateOfResign'] ?>"
                                                  <?php if(($row['empJobStatus'] == 'Working') or ($row['dateOfResign'] != '')){ echo 'readonly';} ?>
                                                  >
                                              </div>
                                            </div>

                                            <div class="col-lg-4">
                                              <div class="form-group">
                                                  <label>User Type <span style="color:red">*</span></label>
                                                  <select class="form-control" name="userType">
                                                    <option <?php if($row['userType'] == 'Employee'){ echo 'selected'; } ?> value="Employee">Employee</option>
                                                    <option <?php if($row['userType'] == 'Team'){ echo 'selected'; } ?> value="Team">Developer</option>
                                                  </select>
                                              </div>
                                            </div>
                                          </div>

                                          <hr>

                                          <div class="row">
                                            <div class="col-lg-4">
                                              <div class="form-group">
                                                  <label>Date Of Birth <span style="color:red">*</span></label>
                                                  <input type="date"  class="form-control" value="<?php echo $row['empDOB'] ?>" name="empDOB" required placeholder="yyyy-mm-dd">
                                              </div>
                                            </div>
                                            <div class="col-lg-4">
                                              <div class="form-group">
                                                  <label>Maritial Status <span style="color:red">*</span></label>
                                                  <select class="form-control" name="empMarital"required>
                                                    <option value="">Select Marital State..</option>
                                                    <option <?php if($row['empMarital'] == 'Married'){ echo 'selected'; } ?> value="Married">Married</option>
                                                    <option <?php if($row['empMarital'] == 'Unmarried'){ echo 'selected'; } ?> value="Unmarried">Unmarried</option>
                                                    <option <?php if($row['empMarital'] == 'Widowed'){ echo 'selected'; } ?> value="Widowed">Widowed</option>
                                                    <option <?php if($row['empMarital'] == 'Divorced'){ echo 'selected'; } ?> value="Divorced">Divorced</option>
                                                  </select>
                                              </div>
                                            </div>
                                            <div class="col-lg-4">
                                              <div class="form-group">
                                                  <label>Blood Group <span style="color:red">*</span></label>
                                                  <select class="form-control" name="empBlood" required>
                                                    <option value="">Select Blood Type</option>
                                                    <option <?php if($row['empBlood'] == 'A+'){ echo 'selected'; } ?> value="A+">A+</option>
                                                    <option <?php if($row['empBlood'] == 'A-'){ echo 'selected'; } ?> value="A-">A-</option>
                                                    <option <?php if($row['empBlood'] == 'B+'){ echo 'selected'; } ?> value="B+">B+</option>
                                                    <option <?php if($row['empBlood'] == 'B-'){ echo 'selected'; } ?> value="B-">B-</option>
                                                    <option <?php if($row['empBlood'] == 'AB+'){ echo 'selected'; } ?> value="AB+">AB+</option>
                                                    <option <?php if($row['empBlood'] == 'AB-'){ echo 'selected'; } ?> value="AB-">AB-</option>
                                                    <option <?php if($row['empBlood'] == 'O+'){ echo 'selected'; } ?> value="O+">O+</option>
                                                    <option <?php if($row['empBlood'] == 'O-'){ echo 'selected'; } ?> value="O-">O-</option>
                                                  </select>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-lg-12">
                                              <div class="form-group">
                                                  <label>Special Medical Condition</label>
                                                  <textarea class="form-control" name="empSpecial" rows="3" placeholder="Emergency Medical Records" style="height:120px"><?php echo $row['empSpecial'] ?></textarea>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="float-right">
                                            <?php if ($stat_url != 'viewOnly') { ?>
                                            <button type="reset" class="btn btn-default">Clear</button>
                                            <button type="submit" class="btn btn-success">Save</button>
                                          <?php } ?>
                                            <!-- <button  name="button" class="btn btn-warning" id="print">Print</button> -->
                                          </div>
                                        </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- contact info panel -->
    												<div class="tab-pane  p-20" id="contact" role="tabpanel">
                              <div class="row">
                                <?php
                                $result_empcontact = $emp->view_contact($empID);
                                  while ($row_contact = $result_empcontact->fetch_array()) {
                                    $no= $row_contact['contactID'];
                                ?>
                                  <div class="col-lg-12" style="border-bottom:1px solid #cccccc;">
                                    <form class="" action="controller/employeecontroller.php?status=contactUpdate&emp_id=<?php echo $empID; ?>&contactrecord=<?php echo $no; ?>" method="post">
                                      <input type="hidden"  class="form-control" name="recordID<?php echo $no; ?>" value="<?php echo $no; ?>">
                                      <input type="hidden"  class="form-control" name="contactname<?php echo $no; ?>" value="<?php echo $row_contact['fullname']; ?>">
                                      <div class="row emergency-contact">
                                        <div class="col-lg-3"> <br>
                                          <h4><?php echo $row_contact['fullname']; ?></h4>
                                          <h6 style="color:gray">Relationship : <?php echo $row_contact['relationship']; ?></h6>
                                        </div>
                                        <div class="col-lg-7">
                                          <div class="contact-information">
                                            <h4 style="font-size:14px">Contact information</h4>
                                            <div class="phone-content" style="font-weight:normal">
                                              <span class="contact-title">Phone:</span>
                                              <input type="number" name="ctcphone<?php echo $no; ?>" value="0<?php echo $row_contact['contact']; ?>" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" disabled class="myinput1 input_<?php echo $no; ?>" maxlength="10">
                                            </div>
                                            <div class="address-content" style="font-weight:normal">
                                              <span class="contact-title">Address:</span>
                                              <input type="text" name="ctcaddress<?php echo $no; ?>" value="<?php echo $row_contact['address']; ?>" disabled class="myinput1 input_<?php echo $no; ?>">
                                            </div>
                                            <div class="email-content" style="font-weight:normal">
                                              <span class="contact-title">Email:</span>
                                              <input type="email" name="ctcemail<?php echo $no; ?>" value="<?php echo $row_contact['email']; ?>" disabled class="myinput1 input_<?php echo $no; ?>">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-lg-2">
                                          <?php if ($stat_url != 'viewOnly') { ?>
                                          <div style="float:right">
                                            <button id="btnedit<?php echo $no; ?>" type="button" class="btn-sm btn btn-dark "><i class="ti-marker-alt"></i></button>
                                            <button id="btnsave<?php echo $no; ?>" style="display:none" class="btn-sm btn btn-success">Save</button>
                                            <button id="btncancel<?php echo $no; ?>" style="display:none" type="button" class="btn-sm btn btn-dark">Cancel</button>
                                            <button type="button" class="btn-sm btn btn-danger sweet-message1 delete" data-id="<?php echo  $no; ?>" data-emp="<?php echo  $empID; ?>">X</button>
                                          </div>
                                        <?php } ?>
                                        </div>
                                      </div>
                                    </form>
                                      <script type="text/javascript">
                                        // var editbtn = document.getElementById('<?php echo $no; ?>');
                                        $("#btnedit<?php echo $no; ?>").click(function(){
                                          $(".input_<?php echo $no; ?>").removeAttr('disabled');
                                          $("#btnsave<?php echo $no; ?>").css("display", "inline-block");
                                          $("#btncancel<?php echo $no; ?>").css("display", "inline-block");
                                          $("#btnedit<?php echo $no; ?>").css("display", "none");
                                        });

                                        $("#btncancel<?php echo $no; ?>").click(function(){
                                          $(".input_<?php echo $no; ?>").prop('disabled',true);
                                          $("#btnsave<?php echo $no; ?>").css("display", "none");
                                          $("#btncancel<?php echo $no; ?>").css("display", "none");
                                          $("#btnedit<?php echo $no; ?>").css("display", "inline-block");
                                        });

                                      </script>
                                  </div>
                                <?php } ?>

                                <?php include('build/removeempcontact.php') ?>
                                <?php if ($stat_url != 'viewOnly') { ?>
                                  <div class="col-lg-12"><br>
                                    <div class="basic-form" >
                                      <div class="card-title">
                                          <h4 style="color:#009999;">Add Emergency Contact</h4>
                                      </div> <br>
                                        <form action="controller/employeecontroller.php?status=contactAdd&emp_id=<?php echo $empID; ?>" method="post">
                                          <input type="hidden"  class="form-control" name="empID" value="<?php echo $empID; ?>">
                                          <div class="row">
                                            <div class="col-lg-6 col-sm-6">
                                              <div class="form-group">
                                                  <label>Full Name <span style="color:red">*</span></label>
                                                  <input type="text"  class="form-control" name="fullname" placeholder="Person's Full Name" required>
                                              </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                              <div class="form-group">
                                                  <label>Relationship <span style="color:red">*</span></label>
                                                  <select class="form-control" name="relation" required>
                                                    <option value="">Select</option>
                                                    <option value="Husband">Husband</option>
                                                    <option value="Wife">Wife</option>
                                                    <option value="Mother">Mother</option>
                                                    <option value="Father">Father</option>
                                                    <option value="Sibiling">Sibiling</option>
                                                    <option value="Kid">Kid</option>
                                                    <option value="Other">Other</option>
                                                  </select>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-lg-4 col-sm-6">
                                              <div class="form-group">
                                                  <label>Contact No <span style="color:red">*</span></label>
                                                  <input type="number"  class="form-control" name="empContact" placeholder="Employee Contacts" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10">
                                              </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                              <div class="form-group">
                                                  <label>Email Address </label>
                                                  <input type="email"  class="form-control" name="empEmail" placeholder="example@mail.com" required>
                                              </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                              <div class="form-group">
                                                  <label>Address <span style="color:red">*</span></label>
                                                  <input type="text"  class="form-control" name="address" placeholder="Employee Address" required>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="float-right">
                                            <button type="reset" class="btn btn-default">Clear</button>
                                            <button type="submit" class="btn btn-success">Save</button>
                                          </div>
                                        </form>
                                    </div>
                                  </div>
                                <?php } ?>
                                </div>
                            </div>

                            <!-- education panel -->
    												<div class="tab-pane p-20" id="education" role="tabpanel">
                              <div class="card-title">
                                  <h4>Educational Qualifications</h4>
                              </div> <br>
                                <?php
                                  $count = $emp->count_education($empID);
                                  if ($count != 0) {
                                 ?>
                                  <div class="table">
                                      <table class="table table-striped table-bordered">
                                          <thead>
                                              <tr>
                                                  <th>#</th>
                                                  <th>Certificate</th>
                                                  <th>Institute</th>
                                                  <th>Result</th>
                                                  <th style="text-align:center">Year</th>
                                                  <!-- <th>Actions</th> -->
                                              </tr>
                                          </thead>
                                          <tbody>
                                            <?php
                                            $result_empeducation = $emp->view_education($empID);

                                            $no=1;
                                              while ($row_education = $result_empeducation->fetch_array()) {
                                                $timestamp = strtotime($row_education['start']);
                                                  $formattedDate = date('F Y', $timestamp);

                                                $timestamp2 = strtotime($row_education['endDate']);
                                                  $formattedDate2 = date('F Y', $timestamp2);
                                            ?>
                                              <tr>
                                                  <td><?php echo $no; ?></td>
                                                  <td style="text-transform:capitalize !important"><?php echo $row_education['degree']; ?></td>
                                                  <td style="text-transform:capitalize !important"><?php echo $row_education['institute']; ?></td>
                                                  <td style="text-transform:capitalize !important"><?php echo $row_education['result']; ?></td>
                                                  <td><?php echo $formattedDate; ?> - <?php echo $formattedDate2; ?></td>
                                                  <!-- <td>
                                                    <a><button class="btn-sm btn btn-success" data-toggle="modal" data-target="#editEdu">Edit</button></a>
                                                    <button class="btn-sm btn-danger btn sweet-message2">Remove</button>
                                                  </td> -->
                                              </tr>
                                            <?php $no++; } ?>
                                          </tbody>
                                      </table>
                                  </div> <?php } else{  ?>
                                    <p>There is No Records...</p> <?php } ?>
                              <br>
                              <?php if ($stat_url != 'viewOnly') { ?>
                              <div class="row">
                                <div class="col-lg-12">
                                <hr style="border-color:#476b6b;"> <br>
                                <div class="basic-form">
                                  <div class="card-title">
                                      <h4 style="color:#009999;">Add New Record</h4>
                                  </div> <br>
                                  <form class="" action="controller/employeecontroller.php?status=educationAdd&emp_id=<?php echo $empID; ?>" method="post">
                                    <input type="hidden"  class="form-control" name="empID" value="<?php echo $empID; ?>">
                                      <div class="row">
                                        <div class="col-lg-6 col-sm-6">
                                          <div class="form-group">
                                              <label>Degree/ Certificate Title <span style="color:red">*</span> </label>
                                              <input type="text"  class="form-control" name="degree" placeholder="Degree title" required>
                                          </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                          <div class="form-group">
                                              <label>Institute <span style="color:red">*</span> </label>
                                              <input type="text"  class="form-control" name="intitute" placeholder="Institute Name" required>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row">
                                        <div class="col-lg-4 col-sm-6">
                                          <div class="form-group">
                                              <label>Result <span style="color:red">*</span> </label>
                                              <input type="text"  class="form-control" name="result" placeholder="Result" required>
                                          </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                          <div class="form-group">
                                              <label>From <span style="color:red">*</span></label>
                                              <input type="month"  class="form-control dateyear" name="start" placeholder="Enrolled In" required>
                                          </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                          <div class="form-group">
                                              <label>To <span style="color:red">*</span></label>
                                              <input type="month"  class="form-control dateyear" name="end" placeholder="Graduated In" required>
                                          </div>
                                        </div>
                                      </div>

                                      <div class=" float-left">
                                        <button type="reset" class="btn btn-default">Clear</button>
                                        <button type="submit" class="btn btn-success">Add</button>
                                      </div>
                                    </form>
                                </div>
                              </div></div>
                              <?php } ?>
                            </div>

                            <!-- experiance panel -->
                            <div class="tab-pane p-20" id="experiance" role="tabpanel">
                              <div class="card-title">
                                  <h4>Previous Work Experience</h4>
                              </div> <br>
                              <?php
                                $count = $emp->count_exp($empID);
                                if ($count != 0) {
                               ?>
                                  <div class="table">
                                      <table class="table table-striped table-bordered">
                                          <thead>
                                              <tr>
                                                  <th>#</th>
                                                  <th>Company Name</th>
                                                  <th>Location</th>
                                                  <th>Designation</th>
                                                  <th>Work Duration</th>
                                                  <!-- <th>Actions</th> -->
                                              </tr>
                                          </thead>
                                          <tbody>
                                            <?php
                                            $result_empeducation = $emp->view_exp($empID);
                                            $no=1;
                                              while ($row_education = $result_empeducation->fetch_array()) {
                                                $timestamp = strtotime($row_education['start']);
                                                  $formattedDate = date('F Y', $timestamp);

                                                $timestamp2 = strtotime($row_education['endDate']);
                                                  $formattedDate2 = date('F Y', $timestamp2);

                                            ?>
                                              <tr>
                                                  <td><?php echo $no; ?></td>
                                                  <td style="text-transform:capitalize !important"><?php echo $row_education['company'] ?></td>
                                                  <td style="text-transform:capitalize !important"><?php echo $row_education['contact'] ?> <br> <?php echo $row_education['address'] ?></td>
                                                  <td style="text-transform:capitalize !important"><?php echo $row_education['position'] ?></td>
                                                  <td><?php echo $formattedDate; ?> - <?php echo $formattedDate2; ?></td>
                                                  <!-- <td>
                                                    <a><button class="btn-sm btn btn-success" data-toggle="modal" data-target="#editExperience"> Edit</button></a>
                                                    <button class="btn-sm btn-danger btn sweet-message4"> Remove</button>
                                                  </td> -->
                                              </tr>
                                            <?php $no++ ;} ?>
                                          </tbody>
                                      </table>
                                    </div> <?php } else{  ?>
                                      <p>There is No Records...</p> <?php } ?>
                                <br>

                                <?php if ($stat_url != 'viewOnly') { ?>
                              <div class="row">
                                <div class="col-lg-12">
                                <hr style="border-color:#476b6b;"> <br>
                                <div class="basic-form">
                                  <div class="card-title">
                                      <h4 style="color:#009999;">Add New Record</h4>
                                  </div> <br>
                                    <form class="" action="controller/employeecontroller.php?status=expAdd&emp_id=<?php echo $empID; ?>" method="post">
                                      <input type="hidden"  class="form-control" name="empID" value="<?php echo $empID; ?>">
                                      <div class="row">
                                        <div class="col-lg-4 col-sm-6">
                                          <div class="form-group">
                                              <label>Company Name <span style="color:red">*</span> </label>
                                              <input type="text"  class="form-control" name="company" placeholder="Company Name" required>
                                          </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6">
                                          <div class="form-group">
                                              <label>Contact <span style="color:red">*</span> </label>
                                              <input type="number"  class="form-control" name="contact" placeholder="Contact No" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10">
                                          </div>
                                        </div>
                                        <div class="col-lg-5 col-sm-6">
                                          <div class="form-group">
                                              <label>Designation <span style="color:red">*</span> </label>
                                              <input type="text"  class="form-control" name="position" placeholder="Position" required>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row">
                                        <div class="col-lg-6 col-sm-6">
                                          <div class="form-group">
                                              <label>Address <span style="color:red">*</span> </label>
                                              <input type="text"  class="form-control" name="address" placeholder="Company Location" required>
                                          </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6">
                                          <div class="form-group">
                                              <label>Start <span style="color:red">*</span></label>
                                              <input type="month"  class="form-control" name="start" required>
                                          </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6">
                                          <div class="form-group">
                                              <label>End <span style="color:red">*</span></label>
                                              <input type="month"  class="form-control" name="end" required>
                                          </div>
                                        </div>
                                      </div>

                                      <div class=" float-left">
                                        <button type="reset" class="btn btn-default">Clear</button>
                                        <button type="submit" class="btn btn-success">Add</button>
                                      </div>
                                    </form>
                                </div>
                              </div></div>
                              <?php } ?>
                            </div>

                            <!-- bank account panel -->
                            <div class="tab-pane p-20" id="bank" role="tabpanel">
                              <div class="row">
                                <div class="col-lg-12">
                                <div class="basic-form">
                                  <?php
                                    $result_empbank = $emp->view_bank($empID);
                                    $row_bank = $result_empbank->fetch_array();
                                   ?>
                                      <form class="" action="controller/employeecontroller.php?status=updateBank&emp_id=<?php echo $empID; ?>" method="post">
                                        <input type="hidden"  class="form-control" name="empID" value="<?php echo $empID; ?>">
                                      <div class="row">
                                        <div class="col-lg-6 col-sm-6">
                                          <div class="form-group">
                                              <label>Bank Name <span style="color:red">*</span> </label>
                                              <select class="form-control" name="bankName" id="inp1" disabled required>
                                                <option <?php if($row_bank['bankName'] == '') { echo 'selected' ; } ?> value=""></option>
                                                <option <?php if($row_bank['bankName'] == 'HNB-Hatton National Bank') { echo 'selected' ; } ?> value="HNB-Hatton National Bank">HNB-Hatton National Bank</option>
                                                <option <?php if($row_bank['bankName'] == 'NSB-Nations Trust Bank') { echo 'selected' ; } ?> value="NSB-Nations Trust Bank">NSB-Nations Trust Bank</option>
                                                <option <?php if($row_bank['bankName'] == 'BOC-Bank of Ceylone') { echo 'selected' ; } ?> value="BOC-Bank of Ceylone">BOC-Bank of Ceylone</option>
                                                <option <?php if($row_bank['bankName'] == 'Peoples Bank') { echo 'selected' ; } ?> value="Peoples Bank">Peoples Bank</option>
                                                <option <?php if($row_bank['bankName'] == 'Commercial Bank') { echo 'selected' ; } ?> value="Commercial Bank">Commercial Bank</option>
                                              </select>
                                          </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                          <div class="form-group">
                                              <label>Account Holder Name <span style="color:red">*</span> </label>
                                              <input id="inp2" type="text"  class="form-control" required disabled name="AccHolder_name" value="<?php echo $row_bank['AccHolder_name']; ?>">
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row">
                                        <div class="col-lg-6 col-sm-6">
                                          <div class="form-group">
                                              <label>Branch Name <span style="color:red">*</span> </label>
                                              <input id="inp3" type="text"  class="form-control" required disabled name="branchName" value="<?php echo $row_bank['branchName']; ?>">
                                          </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                          <div class="form-group">
                                              <label>Account Number <span style="color:red">*</span></label>
                                              <input id="inp4" type="number"  class="form-control" required disabled name="accountNo" value="<?php echo $row_bank['accountNo']; ?>">
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row">
                                        <div class="col-lg-6">
                                          <div class="form-group">
                                              <label>Account Type <span style="color:red">*</span> </label>
                                              <select id="inp5" class="form-control" name="accountType" disabled required>
                                                <option <?php if($row_bank['accountType'] == '') { echo 'selected' ; } ?> value=""></option>
                                                <option <?php if($row_bank['accountType'] == 'Regular Savings') { echo 'selected' ; } ?> value="Regular Savings">Regular Savings</option>
                                                <option <?php if($row_bank['accountType'] == 'Checking Account') { echo 'selected' ; } ?> value="Checking Account">Checking Account</option>
                                                <option <?php if($row_bank['accountType'] == 'Join Account') { echo 'selected' ; } ?> value="Join Account">Join Account</option>
                                              </select>
                                          </div>
                                        </div>
                                      </div>

                                      <?php if ($stat_url != 'viewOnly') { ?>
                                        <div class="float-right">
                                          <button id="editbtn" type="button" class="btn btn-info" onclick="get_edit();">Edit Bank Details</button>
                                          <button id="updatebtn" style="display:none" type="submit" class="btn btn-success">Update Data</button>
                                          <button id="cancelbtn" type="button" style="display:none" class="btn btn-default" onclick="remove_edit();">Cancel</button>
                                        </div>
                                      <?php } ?>
                                    </form>
                                </div>
                              </div></div>
                            </div>

                            <script type="text/javascript">
                              function get_edit(){
                                $('#editbtn').css("display", "none");
                                $('#updatebtn').css("display", "inline-block");
                                $('#cancelbtn').css("display", "inline-block");

                                $('#inp1').removeAttr('disabled');
                                $('#inp2').removeAttr('disabled');
                                $('#inp3').removeAttr('disabled');
                                $('#inp4').removeAttr('disabled');
                                $('#inp5').removeAttr('disabled');
                              }

                              function remove_edit(){
                                $('#editbtn').css("display", "block");
                                $('#updatebtn').css("display", "none");
                                $('#cancelbtn').css("display", "none");

                                $("#inp1").prop('disabled',true);
                                $("#inp2").prop('disabled',true);
                                $("#inp3").prop('disabled',true);
                                $("#inp4").prop('disabled',true);
                                $("#inp5").prop('disabled',true);
                              }
                            </script>

                            <!-- document panel -->
                            <div class="tab-pane p-20" id="doc" role="tabpanel">
                              <div class="card-title">
                                  <h4>Valued Documents</h4>
                                  <div class="col-lg-12">
                                    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search Document" style="float:right;width:300px" class="form-control"> <br>
                                  </div>
                              </div> <br>
                              <?php
                                $count = $emp->count_doc($empID);
                                if ($count != 0) {
                               ?>
                              <div class="table">
                                  <table class="table table-striped table-bordered" id="myTable">
                                      <thead>
                                          <tr>
                                              <th>#</th>
                                              <th>File Title</th>
                                              <th  style="text-align:center;">File</th>
                                              <th>Remove</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <?php
                                        $result_doc = $emp->view_doc($empID);
                                        $no=1;
                                          while ($row_doc = $result_doc->fetch_array()) {
                                            $type = $row_doc['type'];
                                            $badge = 'dark';
                                            if ($type == 'pdf') {
                                              $badge = 'danger';
                                            } else if($type == 'docx'){
                                              $badge = 'info';
                                            } else if($type == 'xlsx'){
                                              $badge = 'success';
                                            }
                                        ?>
                                          <tr>
                                              <th style="color:gray !important"><?php echo $no; ?></th>
                                              <td  style="text-transform:capitalize !important"><?php echo $row_doc['title'] ?></td>
                                              <td style="text-align:center;"> <a href="../res/employeeDoc/<?php echo $row_doc['doc'] ?>" target="blank"><span class="badge badge-<?php echo $badge; ?>"><?php echo $type; ?></span></a> </td>
                                              <td><button style="background-color:transparent;font-size:15px;color:black" type="button" class="btn-sm  btn sweet-message2 delete" data-id="<?php echo  $row_doc['docID']; ?>" data-emp="<?php echo  $empID; ?>">X</button></td>
                                          </tr>
                                        <?php $no++; } ?>
                                      </tbody>
                                  </table>
                                </div> <?php } else{  ?>
                                  <p>There is No Records...</p> <?php } ?>

                              <?php include('build/removeDoc.php') ?>

                              <?php if ($stat_url != 'viewOnly') { ?>
                              <div class="row">
                                <div class="col-lg-12">
                                <br> <hr style="border-color:#476b6b;"> <br>
                                <div class="basic-form">
                                  <div class="card-title">
                                      <h4 style="color:#009999;">Add New Document</h4>
                                  </div> <br>
                                  <form class="" action="controller/employeecontroller.php?status=addDoc&emp_id=<?php echo $empID; ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden"  class="form-control" name="empID" value="<?php echo $empID; ?>">
                                      <div class="row">
                                        <div class="col-lg-6 col-sm-6">
                                          <div class="form-group">
                                              <label>Document Title <span style="color:red">*</span> </label>
                                              <input type="text"  class="form-control" required name="title" placeholder="Document Title">
                                          </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                          <div class="form-group">
                                          <label for="myfile">File :</label> <br>
                                            <input type="file" id="myfile" class="form-control" required name="myfile">
                                          </div>
                                        </div>
                                      </div>

                                        <div class="float-right">
                                          <button type="reset" class="btn btn-default">Clear</button>
                                          <button type="submit" class="btn btn-success">Add</button>
                                        </div>
                                    </form>
                                </div>
                              </div></div>
                              <?php } ?>
                            </div>


                            <!-- salary data dropdown panel -->
                            <div class="tab-pane fade" id="dropdown3" role="tabpanel" aria-labelledby="dropdown3-tab">
                              <?php
                                  $desigID = $row['desigID'];
                                  $sql2 = "SELECT * FROM designation WHERE desigID ='$desigID'";
                                  $result2 = $con->query($sql2);
                                  $row_amt = $result2->fetch_array();
                                  $value = $row_amt['basic_salary'];

                                  $salary_details = $emp->view_salary($empID);
                                  $row_salarydetails = $salary_details->fetch_array();
                               ?>
                              <div style="padding:15px;"> <br>
                              <h3 class="card-title">Payment Informations</h3>
                              <form action="controller/employeecontroller.php?status=updateSalary&emp_id=<?php echo $empID; ?>" method="post">
                                <div class="row">
                                  <div class="form-group col-md-5 m-t-5">
                                    <label>Basic Salary <span style="color:red">*</span> </label>
                                    <input type="hidden"  class="form-control" name="salaryID" value="<?php echo $row_salarydetails['salaryID']; ?>">
                                    <input type="hidden"  class="form-control" name="empID" value="<?php echo $empID; ?>">
                                    <input type="number" name="basic_salary"  class="form-control"  readonly required value="<?php echo $value; ?>">
                                  </div>
                                  <!-- <div class="form-group col-md-3 m-t-5">
                                    <label>BRA 02 <span style="color:red">*</span> </label>
                                    <input type="number" name="BRA01"  class="form-control" placeholder="BRA 02 Amount" value="2500"  required>
                                  </div> -->
                                </div> <br>

                                <h3 class="card-title">Addition</h3>
                                <div class="row">
                                  <div class="form-group col-md-3 m-t-5">
                                    <label>Allowances <span style="color:red">*</span> </label>
                                    <input type="number" name="allowance"  class="form-control" placeholder="Total Amount of Allowances" value="<?php echo $row_salarydetails['allowance']; ?>"  required>
                                  </div>
                                  <?php
                                    if ($row['empType'] == 'worker') {
                                      $text = $row_salarydetails['OTrate'];
                                      $req = '';
                                    } else{
                                      $text = 'No OT rate for Staff';
                                      $req = 'readonly';
                                    }
                                  ?>

                                  <div class="form-group col-md-3 m-t-5">
                                    <label>OT Rate</label>
                                    <input type="text" name="OTrate"  class="form-control" <?php echo $req; ?>  value="<?php echo $text ; ?>">
                                  </div>

                                  <!-- <div class="form-group col-md-4 m-t-5">
                                    <label>Day Ince</label>
                                    <input type="text" name="ince"  class="form-control" placeholder="Day Ince..."  >
                                  </div> -->
                                </div> <br>

                                <h3 class="card-title">Deduction</h3>
                                <?php
                                  if ($row['epfState'] == 'yes') {
                                    $text2 = $row_salarydetails['epf'];
                                    $req2 = '';
                                  } else{
                                    $text2 = 'No EPF for this Employee';
                                    $req2 = 'readonly';
                                  }
                                ?>
                                 <div class="row">
                                  <div class="form-group col-md-4 m-t-5">
                                      <label>EPF Percentage in %</label>
                                      <input type="text" name="epf" <?php echo $req2; ?> class="form-control" value="<?php echo $text2 ; ?>" placeholder="EPF Percentage">
                                  </div>

                                  <?php
                                  if ($row['loanStat'] == 'yes') {
                                    $sql3 = "SELECT * FROM employee_loans WHERE status ='Active' AND empID='$empID'";
                                    $result3 = $con->query($sql3);
                                    $row_loan = $result3->fetch_array();
                                  }

                                  ?>

                                  <div class="form-group col-md-4 m-t-5">
                                      <label>Loans</label>
                                      <input type="number" name="personalLoans" readonly  class="form-control" value="<?php echo $row_loan['monthly']; ?>" placeholder="Loan Charges">
                                  </div>
                                  <div class="form-group col-md-4 m-t-5">
                                      <label>Others</label>
                                      <input type="number" name="other"  class="form-control" value="<?php echo $row_salarydetails['other']; ?>" placeholder="Other Charges">
                                  </div>
                                 </div>

                                 <?php if ($stat_url != 'viewOnly') { ?>
                                   <div class="form-group">
                                     <div class="col-sm-12">
                                       <button  type="submit" style="float: right" class="btn btn-success">Update Salary Information</button>
                                     </div>
                                   </div>
                                 <?php } ?>

                              </form>
                            </div>
    												</div>


                              <!-- company loans dropdown panel -->
                              <div class="tab-pane fade" id="dropdown1" role="tabpanel" aria-labelledby="dropdown1-tab">
                                <div style="padding:15px;"> <br>
                                  <h3 class="card-title">Company Loans</h3> <br>

                                  <div class="col-lg-12">
                                    <?php
                                      $sql_loan = "SELECT * FROM employee_loans WHERE empID='$empID'";
                                      $result_loan = $con->query($sql_loan);

                                    ?>
                                    <div class="table">
                                      <table class="table table-striped table-bordered">
                                        <thead>
                                          <tr>
                                            <th>#</th>
                                            <th>Applied Date</th>
                                            <th>Loan Ammount</th>
                                            <th>Interest Rate</th>
                                            <th>Duration</th>
                                            <th>Started Month</th>
                                            <th>Monthly Charge</th>
                                            <th>End Month</th>
                                            <th  style="text-align:center;">Application</th>
                                            <th>Status</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                          while ($row_loanlist = $result_loan->fetch_array()) {

                                            if ($row_loanlist['status'] == 'pending') {
                                           ?>
                                          <tr>
                                            <th style="color:gray !important"><?php echo $row_loanlist['loanID']; ?></th>
                                            <td><?php echo $row_loanlist['applyDate']; ?></td>
                                            <td align="right">Rs. <?php echo number_format($row_loanlist['loanAmount'],2); ?></td>
                                            <td align="center" colspan="5"> The Loan Application is Still Pending...</td>
                                            <td style="text-align:center;"> <a href="loanForm.php?id=<?php echo $row_loanlist['loanID']; ?>&user=<?php echo $empID; ?>" target="blank"><i class="ti-write"></i></a> </td>
                                            <td><span class="badge badge-warning">Pending</span></td>
                                          </tr>
                                        <?php
                                          } else if ($row_loanlist['status'] == 'Approved') {
                                        ?>
                                         <tr>
                                           <th style="color:gray !important"><?php echo $row_loanlist['loanID']; ?></th>
                                           <td><?php echo $row_loanlist['applyDate']; ?></td>
                                           <td align="right">Rs. <?php echo number_format($row_loanlist['loanAmount'],2); ?></td>
                                           <td align="center"><?php echo $row_loanlist['interest']; ?>%</td>
                                           <td><?php echo $row_loanlist['duration']; ?> Year</td>
                                           <td><?php echo $row_loanlist['startMonth']; ?></td>
                                           <td align="right">Rs. <?php echo number_format($row_loanlist['monthly'],2); ?></td>
                                           <td align="center"><?php echo $row_loanlist['endMonth']; ?></td>
                                           <td style="text-align:center;"> <a href="loanForm.php?id=<?php echo $row_loanlist['loanID']; ?>&user=<?php echo $empID; ?>" target="blank"><i class="ti-write"></i></a> </td>
                                           <td><span class="badge badge-success">Approved</span></td>
                                         </tr>
                                       <?php } else if ($row_loanlist['status'] == 'Rejected') { ?>
                                          <tr>
                                            <th style="color:gray !important"><?php echo $row_loanlist['loanID']; ?></th>
                                            <td><?php echo $row_loanlist['applyDate']; ?></td>
                                            <td align="right">Rs. <?php echo number_format($row_loanlist['loanAmount'],2); ?></td>
                                            <td colspan="5"><?php echo $row_loanlist['reason']; ?></td>
                                            <td style="text-align:center;"> <a href="loanForm.php?id=<?php echo $row_loanlist['loanID']; ?>&user=<?php echo $empID; ?>" target="blank"><i class="ti-write"></i></a> </td>
                                            <td><span class="badge badge-danger">Declined</span></td>
                                          </tr>
                                        <?php } } ?>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                </div>
                              </div>


                            <!-- leave panel -->
                            <div class="tab-pane p-20" id="jobLeave" role="tabpanel">
                              <div class="row">
                                <div class="col-lg-6" >
                                  <div class="card-title">
                                      <h4>Company Leaves</h4>
                                  </div>

                                    <div class="form-group" style="margin-left:10px">
                                      <div class="row">
                                        <?php
                                        $sql4 = "SELECT * FROM company_leaves WHERE stat ='Active'";
                                        $result4 = $con->query($sql4);
                                        $no = 1;
                                        while ($row_cleave = $result4->fetch_array()) { ?>
                                          <?php
                                          $getsimilar='';
                                          $matleave = '';
                                          $type = $row_cleave['leave_type'];
                                          $sql5 = "SELECT * FROM employee_leaves WHERE leaveID ='$type' AND empID='$empID' AND stat='On'";
                                          $result5 = $con->query($sql5);
                                          $count5 = $result5->num_rows;
                                            if ($count5 == 1) {
                                              $getsimilar='checked';
                                            }
                                            if (($row['empGender'] == 'Male') and ($type == 'Maternity Leaves')) {
                                              $matleave = 'disabled';
                                            }
                                          ?>
                                        <div class="col-lg-5">
                                          <form style="width:70%" action="controller/employeecontroller.php?status=updateLeave&emp_id=<?php echo $empID; ?>" method="post">
                                          <input <?php echo $getsimilar; ?> <?php echo $matleave; ?> type="checkbox" id="<?php echo $no; ?>" name="leave" value="<?php echo $row_cleave['leave_type'] ?>" <?php if ($stat_url != 'viewOnly') { echo 'onChange="this.form.submit()"'; } else{ echo 'disabled'; } ?>  >
                                          <label for="<?php echo $no; ?>"><?php echo $row_cleave['leave_type'] ?></label>
                                          <input type="hidden" name="empID" value="<?php echo $empID ?>">
                                          <input type="hidden" name="leave_type" value="<?php echo $row_cleave['leave_type'] ?>">
                                          <input type="hidden" name="total_days" value="<?php echo $row_cleave['total_days'] ?>">
                                          </form>
                                        </div>
                                      <?php $no++;  } ?>
                                      </div>
                                    </div>
                                </div>

                                <div class="col-lg-6" >
                                  <div class="card-title">
                                      <h4>Total Leaves - <?php echo $year = date('Y'); ?></h4>
                                  </div> <br>
                                  <div class="table">
                                      <table style="width:100%" class="table table-bordered">
                                          <thead style="background-color:#476B6B">
                                              <tr>
                                                  <th style="padding-left:20px">Type</th>
                                                  <th style="text-align:center">Days</th>
                                                  <th style="text-align:center">Used</th>
                                                  <th style="text-align:center">Remaining</th
                                              </tr>
                                          </thead>
                                          <tbody>
                                            <?php
                                            $sql6 = "SELECT * FROM employee_leaves WHERE empID ='$empID' AND stat='On'";
                                            $result6 = $con->query($sql6);
                                            while ($row6 = $result6->fetch_array()) { ?>
                                              <tr>
                                                  <th style="padding-left:20px;color:gray !important"><?php echo $row6['leaveID']; ?></th>
                                                  <td style="text-align:center;color:gray"><?php echo $row6['days']; ?></td>
                                                  <td style="text-align:center;color:gray"><?php echo $row6['used']; ?></td>
                                                  <td style="text-align:center;color:gray"><?php echo $row6['days']-$row6['used']; ?></td>
                                              </tr>
                                            <?php } ?>
                                          </tbody>
                                      </table>
                                  </div>
                                </div>

                              </div>
                            </div>

    											</div>
    										</div>
                      </div>
                    </div>
                  <!-- </div> -->

                  <?php //include('build/editEdu.php') ?>
                  <?php //include('build/editExperience.php') ?>


      <?php include('common/footer.php') ?>
     <!-- footer -->
     <?php include('common/tableExport.php') ?>

          <script src="assets/js/lib/toastr/toastr.min.js"></script>
          <script src="assets/js/lib/toastr/toastr.init.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    // dept dependent ajax
    $(document).on('change', '#dept', function(){
      // var deptId = $(this).val();
      var deptID = $(this).val();
      $.ajax({
        type: "GET", //we are using GET method to get data from server side
        url: '/codec/view/operation/load_sub2.php', // get the route value
        data: {deptID:deptID,check:<?php echo $row['desigID']; ?>}, //set data
        }).done(function (data) {
        console.log(data);
        $("#desig_select").html(data);
    });
  });

  var deptID = <?php echo $row['deptID']; ?>;
  $.ajax({
    type: "GET", //we are using GET method to get data from server side
    url: '/codec/view/operation/load_sub2.php', // get the route value
    data: {deptID:deptID,check:<?php echo $row['desigID']; ?>}, //set data
    }).done(function (data) {
    console.log(data);
    $("#desig_select").html(data);
  });

  });
</script>

<script>
function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>

</body>

</html>
