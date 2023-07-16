<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string

$ob = new dbconnection();
$con = $ob->connection();
//to display task list

$session_empID = $_SESSION['empID'];

$projectID = $_GET['projectID'];
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Styles -->
    <link href="assets/css/lib/rangSlider/ion.rangeSlider.css" rel="stylesheet">
    <link href="assets/css/lib/rangSlider/ion.rangeSlider.skinFlat.css" rel="stylesheet">

    <style media="screen">
      td{
        font-weight: normal;
      }

      html,body{
        width: 100%;
        height: 100%;
        margin: 0px;
        padding: 0px;
        overflow-x: hidden;

      }

      #maininput::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
        color: #434a70 !important;
      }

      #subinput::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
        color: #2eb8b8 !important;
      }

      .irs-from{
        background-color: #434a70 !important;
      }

      .irs-to{
        background-color: #434a70 !important;
      }

      .irs-bar{
        background:#009999;
      }

      .irs-slider{
        color:#009999;
      }

    </style>

    <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script>
      $(document).ready(function(){
        // $(".dial").knob({
        //   'format' : function (value) {
        //      return value + '%';
        //   }
        // });
        jQuery.noConflict();
          $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            var pactiveTab = localStorage.getItem('activeTab');
              localStorage.setItem('activeTab', $(e.target).attr('href'));
              var colo = $(e.target).attr('href');
              $('#myTab a[href="' + pactiveTab + '"]').removeClass('active');
              $('#myTab a[href="' + colo + '"]').addClass('active show');
              if (colo == '#personal') {
                // location.reload();
              }
          });
          var activeTab = localStorage.getItem('activeTab');
          if(activeTab){
              $('#myTab a[href="' + activeTab + '"]').tab('show');
              $('#myTab a[href="' + activeTab + '"]').addClass('active show');
          }
      });
    </script>


    <!-- <script type="text/javascript">
    $(document).ready(function(){
      $(".dial").knob({
        'format' : function (value) {
           return value + '%';
        }
      });
    });
    </script> -->

</head>

<body>

  <?php if ($_SESSION['username'] == 'Admin') {
    include('common/sidebar.php');
  } elseif ($_SESSION['username'] == 'Development') {
    include('common/leadsidebar.php');
  }
  ?>
    <!-- /# sidebar -->
    <script type="text/javascript">
      document.getElementById('projectList').className = 'active';
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
                                <h1>Edit Project Details</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-5 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="projectList.php">Project List</a></li>
                                    <li class="breadcrumb-item myactive">View and Edit Project</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->
                <section id="main-content">

                  <?php include('src/projectEditAlert.php'); ?>

                    <div class="col-lg-12 col-sm-12">
                      <div class="card">
                        <div class="card-body p-b-0">
    											<!-- Nav tabs -->
    											<ul class="nav nav-tabs customtab2" role="tablist" id="myTab">
    												<li class="nav-item active" > <a class="nav-link" data-toggle="tab" href="#personal" role="tab"><span class="hidden-sm-up"><i class="ti-package"></i></span> <span class="hidden-xs-down"> Project Data</span></a> </li>
    												<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#member" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down"> Project Members</span></a> </li>
    												<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tasklist" role="tab"><span class="hidden-sm-up"><i class="ti-list-ol"></i></span> <span class="hidden-xs-down"> Project Tasks</span></a> </li>
    												<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#doc" role="tab"><span class="hidden-sm-up"><i class="ti-files"></i></span> <span class="hidden-xs-down"> Documents</span></a> </li>
                            <?php if ($session_empID == 1) {  ?>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Ldoc" role="tab"><span class="hidden-sm-up"><i class="ti-files"></i></span> <span class="hidden-xs-down"> Legal Documents</span></a> </li>
                            <?php } ?>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#notes" role="tab"><span class="hidden-sm-up"><i class="ti-notepad"></i></span> <span class="hidden-xs-down"> Notes</span></a> </li>
                            <!-- <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#income" role="tab"><span class="hidden-sm-up"><i class="ti-money"></i></span> <span class="hidden-xs-down"> Expences</span></a> </li> -->
    											</ul>
    											<!-- Tab panes -->
    											<div class="tab-content">
                            <!-- project panel -->
                            <div class="tab-pane active p-20" id="personal" role="tabpanel">
                              <form  action="controller/projectcontroller.php?stat=updateInfo&projectID=<?php echo $projectID; ?>" method="post">
                                <?php
                                $sql = "SELECT * FROM projects  WHERE projectID='$projectID'";
                                $result = $con->query($sql);
                                $row = $result->fetch_array();
                                ?>
                              <div class="row">
                                <div class="col-lg-4">
                                  <div class="row">
                                    <div class="card-body m-t-15 " style="margin-top:0px !important;padding:10px !important;margin-left:10px;">
                                      <!-- <input class="knob dial" data-fgColor="#336699" data-bgcolor="#c6d9ec" data-thickness=".35" readonly value="45" data-width="35%" > -->
                                      <input class="knob" id="jqxKnob" name="progress" data-width="200" data-displayPrevious=true data-bgColor="#2FB594" data-fgColor="#2FB594" data-skin="tron" data-thickness=".2" value="<?php echo $row['progress']; ?>">
                                    </div>
                                    <div class="col-lg-12">
                                      <h5 style="text-transform:capitalize"><?php echo $row['project_name']; ?></h5>
                                      <p>Project ID : CDC<?php echo sprintf("%05d", $row['projectID']); ?></p>
                                    </div>
                                    <div class="col-lg-4">
                                      Customer
                                    </div>
                                    <div class="col-lg-8" style="text-transform:capitalize">
                                      : <?php echo $row['customer_name']; ?>
                                    </div>
                                    <div class="col-lg-4" >
                                      Company
                                    </div>
                                    <div class="col-lg-8" style="text-transform:capitalize">
                                      : <?php echo $row['customer_company']; ?>
                                    </div>
                                    <?php if ($row['progress'] > 85) { ?>
                                    <div class="col-lg-12" > <br>
                                      <a href="controller/projectcontroller.php?stat=completeproj&projectID=<?php echo $projectID; ?>" class="btn btn-dark">Complete Project</a>
                                    </div>
                                  <?php } ?>
                                  </div>
                                </div>
                                <div class="col-lg-8">
                                  <div class="basic-form">
                                      <div class="row">
                                        <div class="col-lg-12 col-sm-12">
                                          <div class="form-group">
                                              <label>Project <span style="color:red">*</span></label>
                                              <input type="text" id="project_name" name="project_name" class="form-control" required value="<?php echo $row['project_name']; ?>">
                                          </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                          <div class="form-group">
                                              <label>Project Type <span style="color:red">*</span></label>
                                              <input type="text" id="project_type" name="project_type" class="form-control" required value="<?php echo $row['project_type']; ?>">
                                          </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                          <div class="form-group">
                                            <label>Industry <span style="color:red">*</span></label>
                                            <input type="text" id="industry" name="industry" class="form-control" required placeholder="Select Industry" value="<?php echo $row['industry']; ?>">
                                          </div>
                                        </div>
                                      </div>


                                      <div class="row">
                                        <div class="col-lg-6">
                                          <label>Payment Mode <span style="color:red">*</span></label>
                                          <select class="form-control" name="project_status" required id="payType">
                                            <option value="">Select</option>
                                            <option <?php if($row['project_status'] == 'One Time Payment'){ echo 'selected'; } ?>  value="One Time Payment">One Time Payment</option>
                                            <option <?php if($row['project_status'] == 'Initial with Monthly Payment'){ echo 'selected'; } ?> value="Initial with Monthly Payment">Initial with Monthly Payment</option>
                                            <option <?php if($row['project_status'] == 'Initial with Annual Payment'){ echo 'selected'; } ?> value="Initial with Annual Payment">Initial with Annual Payment</option>
                                          </select>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                          <div class="form-group">
                                              <label>Project Leader <span style="color:red">*</span></label>
                                              <select class="form-control" name="empID" required style="text-transform:capitalize">
                                                <option value="">Select</option>
                                                <?php
                                                $sql2 = "SELECT * FROM employee WHERE empJobStatus='Working' AND (desigID='12' OR desigID='13' OR desigID='14')";
                                                $result2 = $con->query($sql2);
                                                while ($row2 = $result2->fetch_array()) {
                                                  $pemp = $row2['empID'];
                                                  $sql3 = "SELECT employee.* FROM projects INNER JOIN employee ON employee.empID=projects.empID WHERE employee.empID='$pemp' AND projects.status='ongoing'";
                                                  $result3 = $con->query($sql3);
                                                   $countm = $result3->num_rows;
                                                   $col='';
                                                   if ($countm > 0) {
                                                     $col = 'color:red !important;';
                                                   }
                                                ?>
                                                  <option <?php if($row['empID'] == $row2['empID']){ echo 'selected'; } ?> style="text-transform:capitalize;<?php echo $col; ?>" value="<?php echo $row2['empID']; ?>"><?php echo $row2['empName']; ?></option>
                                                <?php } ?>
                                              </select>
                                          </div>
                                          <input type="hidden" name="prevleader" value="<?php echo $row['empID']; ?>">
                                        </div>
                                      </div>

                                      <div class="row">
                                        <div class="col-lg-6 col-sm-6">
                                          <div class="form-group">
                                              <label>Project Start Date <span style="color:red">*</span></label>
                                              <input type="date"  class="form-control" name="startDate" value="<?php echo $row['startDate']; ?>"  required>
                                          </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                          <div class="form-group">
                                              <label>Estimated End Date <span style="color:red">*</span></label>
                                              <input type="date"  class="form-control" name="endDate" value="<?php echo $row['endDate']; ?>"  required>
                                          </div>
                                        </div>
                                      </div>


                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-lg-12">
                                  <center><label>Project Summary <span style="color:red">*</span></label></center>
                                  <textarea class="form-control" rows="3" placeholder="Project Description" name="description" style="height:150px !important" required><?php echo $row['description']; ?></textarea>
                                </div>
                              </div>  <br> <br>

                              <p style="border-bottom:1px solid #d6d6d6;padding-bottom:5px;">Login and Server Credentials</p>
                              <div class="row">
                                <div class="col-lg-6 col-sm-12" style="border-right:1px solid gray;">
                                  <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                      <div class="form-group">
                                          <label>Website Link <span style="color:red">*</span></label>
                                          <input type="url"  class="form-control" name="webLink" value="<?php echo $row['webLink']; ?>" style="width:90%;display:inline-block"  placeholder="Enter Web system Link"  required>
                                          <a style="display:inline-block;color:white;height:40px;padding-top:10px;" href="<?php echo $row['webLink']; ?>" target="_blank" type="button" class="btn btn-sm btn-info" name="button"><span class="ti-angle-double-right"></span></a>
                                      </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                      <div class="form-group">
                                          <label>Username <span style="color:red">*</span> <span class="copybtn" onclick="getcopy('webun');" style="position:absolute;right:5%;font-size:12px;color:#343957">Copy</span></label>
                                          <input id="webun" type="text"  class="form-control" name="webun" value="<?php echo $row['webun']; ?>"  required  >
                                      </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                      <div class="form-group">
                                          <label>Password <span style="color:red">*</span> <span class="copybtn" onclick="getcopy('webpwd');" style="position:absolute;right:5%;font-size:12px;color:#343957">Copy</span></label>
                                          <input id="webpwd" type="text"  class="form-control" name="webpwd" value="<?php echo $row['webpwd']; ?>"   required>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="col-lg-6 col-sm-12">
                                  <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                      <div class="form-group">
                                          <label>Server Link <span style="color:red">*</span></label>
                                          <input type="url"  class="form-control" name="serverLink" value="<?php echo $row['serverLink']; ?>" style="width:90%;display:inline-block"  placeholder="Enter Server Link"  required>
                                          <a style="display:inline-block;color:white;height:40px;padding-top:10px;" href="<?php echo $row['serverLink']; ?>" target="_blank" type="button" class="btn btn-sm btn-info" name="button"><span class="ti-angle-double-right"></span></a>
                                      </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                      <div class="form-group">
                                          <label>Username <span style="color:red">*</span> <span class="copybtn" onclick="getcopy('serverun');" style="position:absolute;right:5%;font-size:12px;color:#343957">Copy</span></label>
                                          <input type="text" id="serverun"  class="form-control" name="serverun" value="<?php echo $row['serverun']; ?>"  required  >
                                      </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                      <div class="form-group">
                                          <label style="width:100%">Password <span style="color:red">*</span> <span class="copybtn" onclick="getcopy('serverpwd');" style="position:absolute;right:5%;font-size:12px;color:#343957">Copy</span> </label>
                                          <input type="text" id="serverpwd"   class="form-control" name="serverpwd" value="<?php echo $row['serverpwd']; ?>"  required  >
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <script type="text/javascript">
                                function getcopy(id) {
                                  var copyText = document.getElementById(id);
                                  copyText.select();
                                  copyText.setSelectionRange(0, 99999);
                                  navigator.clipboard.writeText(copyText.value);
                                }
                              </script>

                              <br><br>

                              <p style="border-bottom:1px solid #d6d6d6;padding-bottom:5px;">Customer Details</p>
                              <div class="row">
                                <div class="col-lg-4 col-sm-6">
                                  <div class="form-group">
                                      <label>Customer Name <span style="color:red">*</span></label>
                                      <input type="text"  class="form-control" name="customer_name" value="<?php echo $row['customer_name']; ?>"   required>
                                  </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                  <div class="form-group">
                                      <label>Customer Company <span style="color:red">*</span></label>
                                      <input type="text"  class="form-control" name="customer_company" value="<?php echo $row['customer_company']; ?>"   required >
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-lg-4 col-sm-6">
                                  <div class="form-group">
                                      <label>Customer Address <span style="color:red">*</span></label>
                                      <input type="text"  class="form-control" name="customer_address" value="<?php echo $row['customer_address']; ?>"   required>
                                  </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                  <div class="form-group">
                                      <label>Contact Number <span style="color:red">*</span></label>
                                      <input type="text"  class="form-control" name="customer_contact" value="<?php echo $row['customer_contact']; ?>"   required pattern="[0-9]{10}"  required min="10" maxlength="10">
                                  </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                  <div class="form-group">
                                      <label>Customer Email<span style="color:red">*</span></label>
                                      <input type="text"  class="form-control" name="customer_email" value="<?php echo $row['customer_email']; ?>"  required>
                                  </div>
                                </div>
                              </div>

                              <div class="float-right">
                                <?php if ($session_empID == 1) { ?>
                                <button type="submit" class="btn btn-success">Update</button>
                              <?php } ?>
                                <!-- <button  name="button" class="btn btn-warning" id="print">Print</button> -->
                                <br><br><br>
                              </div>
                              </form>

                            </div>



                            <!-- project member -->
    												<div class="tab-pane  p-20" id="member" role="tabpanel">
                              <div class="card-title">
                              <h4>Working Developers</h4>
                            </div>

                              <div class="row">
                                <?php
                                $sql_projectmember = "SELECT employee.*,project_members.* FROM project_members INNER JOIN employee ON employee.empID=project_members.empID WHERE project_members.projectID='$projectID' AND project_members.stat='on'";
                                $result_projectmember = $con->query($sql_projectmember);
                                while ($row_projectmember = $result_projectmember->fetch_array()) {
                                  $desigID = $row_projectmember['desigID'];
                                  $sql_getdesig = "SELECT designation FROM designation WHERE desigID='$desigID'";
                                  $result_getdesig = $con->query($sql_getdesig);
                                  $row_getdesig = $result_getdesig->fetch_array();
                                  ?>
                                  <div class="col-lg-4">
                                    <div class="card" style="background-color:#cccccc">
                                      <table>
                                        <tr>
                                          <td style="color:#666666 !important;font-size:16px;"><?php echo $row_getdesig['designation'];  ?> <br> <br>
                                            <h5><?php echo $row_projectmember['empName'];  ?></h5>
                                          </td>
                                          <td > <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row_projectmember['image']); ?>" alt="" style="width:100px;height:100px;border:1px solid #666666"> </td>
                                        </tr>
                                        <tr>
                                          <td colspan="2" style="color:#737373 !important;text-align:left;font-size:15px;padding:5px"><i class="material-icons">business</i> Location - <?php  echo $row_projectmember['empAddress']; ?></td>
                                        </tr>
                                        <tr>
                                          <td colspan="2" style="color:#737373 !important;text-align:left;font-size:15px;padding:5px"><i class="material-icons">phone</i> Contact - +94<?php echo $row_projectmember['empContact']; ?></td>
                                        </tr>
                                        <tr>
                                          <td colspan="2" style="color:#737373 !important;text-align:left;font-size:15px;padding:5px"><i class="material-icons" >email</i> Email - <?php echo $row_projectmember['empEmail']; ?></td>
                                        </tr>
                                        <tr>
                                          <td></td>
                                          <td  style="padding-top:5px;"> <button type="button" style="margin-right:5px" class="btn-sm btn-danger btn sweet-message " data-id="<?php echo $row_projectmember['memberID']; ?>" data-project="<?php echo $projectID; ?>">Change</button></td>
                                        </tr>
                                      </table>
                                    </div>
                                  </div>
                                <?php } ?>
                              </div>
                              <br>
                              <hr>
                              <br>

                              <?php //if (($session_empID == 1) or ($session_empID == 4)) {  ?>
                              <h5>Assign a New Developer</h5>
                              <div class="row">
                                <div class="col-lg-12">
                                  <form class="" action="controller/projectcontroller.php?stat=addDeveloper&projectID=<?php echo $projectID; ?>" method="post">
                                    <div class="row"><div class="col-lg-4">
                                      <label>Development Team Member<span style="color:red">*</span></label>
                                      <select class="form-control" name="empID" required style="text-transform:capitalize">
                                        <option value="">Select a Member</option>
                                        <?php
                                        $sql_team = "SELECT * FROM employee WHERE empJobStatus='Working' AND deptID='3'";
                                        $result_team = $con->query($sql_team);
                                        while ($row_team = $result_team->fetch_array()) {
                                          $_team = $row_team['empID'];
                                          $sql_checkteam = "SELECT * FROM project_members WHERE empID='$_team' AND projectID='$projectID' AND stat='on'";
                                          $result_checkteam = $con->query($sql_checkteam);
                                          $countt = $result_checkteam->num_rows;
                                          if ($countt > 0) {

                                          } else{
                                            $sql_checkteam2 = "SELECT * FROM project_members WHERE empID='$_team' AND projectID!='$projectID' AND project_members.stat='on'";
                                            $result_checkteam2 = $con->query($sql_checkteam2);
                                            $countt2 = $result_checkteam2->num_rows;
                                            $col = '';
                                            $val = '';
                                            if ($countt2 > 0) {
                                              $col = 'color:red !important;';
                                              $val = '('.$countt2.')';
                                            }
                                            ?>
                                            <option style="text-transform:capitalize;<?php echo $col; ?>" value="<?php echo $row_team['empID']; ?>"><?php echo $row_team['empName']; ?> &nbsp <?php echo $val; ?></option>
                                          <?php } } ?>
                                        </select>
                                      </div>
                                      <input type="hidden" name="projectName" value="<?php echo $row['project_name'] ?>">

                                      <div class="col-lg-4" style="text-align:right"> <br>
                                        <button type="submit" class="btn btn-success" >Add Member</button>
                                      </div></div>

                                    </form>
                                  </div>
                                </div>
                              <?php //} ?>

                              <br><hr>

                              <?php
                              $sql_projectmember22 = "SELECT employee.*,project_members.* FROM project_members INNER JOIN employee ON employee.empID=project_members.empID WHERE project_members.projectID='$projectID' AND project_members.stat='off'";
                              $result_projectmember22 = $con->query($sql_projectmember22);
                              $count22 = $result_projectmember22->num_rows;
                              if($count22 > 0){
                                ?>
                                <br>
                                <br>

                                <div class="card-title">
                                <h4>Previous Developers</h4>
                              </div>
                                <div class="row">
                                  <table class="table table-striped table-bordered">
                                    <thead>
                                      <tr style="background-color:#476B6B;color:white !important">
                                        <th style="color:white !important">#</th>
                                        <th style="color:white !important">Developer Name</th>
                                        <th style="color:white !important">Designation</th>
                                        <th style="color:white !important">Contact No</th>
                                        <th style="color:white !important">Email</th>
                                        <th style="color:white !important">Addres</th>
                                        <th style="color:white !important">Work Period</th>
                                        <!-- <th>Actions</th> -->
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $no = 1;
                                      while ($row_projectmember22 = $result_projectmember22->fetch_array()) {
                                        $desigID22 = $row_projectmember22['desigID'];
                                        $sql_getdesig22 = "SELECT designation FROM designation WHERE desigID='$desigID22'";
                                        $result_getdesig22 = $con->query($sql_getdesig22);
                                        $row_getdesig22 = $result_getdesig22->fetch_array();
                                        ?>
                                        <tr>
                                          <td><?php echo $no; ?></td>
                                          <td style="text-transform:capitalize !important"><?php echo $row_projectmember22['empName'];  ?></td>
                                          <td style="text-transform:capitalize !important"><?php echo $row_getdesig22['designation'];  ?></td>
                                          <td>+94<?php echo $row_projectmember22['empContact']; ?></td>
                                          <td><?php echo $row_projectmember22['empEmail']; ?></td>
                                          <td style="text-transform:capitalize !important"><?php  echo $row_projectmember22['empAddress']; ?></td>
                                          <td><?php echo $row_projectmember22['fromdate']; ?> - <?php echo $row_projectmember22['todate'];  ?></td>
                                        </tr>
                                        <?php $no++; } ?>
                                      </tbody>
                                    </table>
                                  </div>
                                <?php } ?>

                            </div>



                            <!-- task info panel -->
                    <div class="tab-pane  p-20" id="tasklist" role="tabpanel">

                              <button type="button" name="button" id='enableEdit' class="btn btn-sm btn-info" style="float:right">Add Task</button>
                              <button type="button" name="button" id='disaableEdit' class="btn btn-sm btn-dark" style="float:right;display:none">Close</button><br> <br>

                              <form action="controller/projectcontroller.php?stat=mainTaskt&projectID=<?php echo $projectID; ?>" method="post" style="display:none" class="editTask">
                                <input type="text" id="maininput" class="form-control" name="main_task" placeholder="Write a Main Task and hit 'Enter'..." style="background-color:#cfd2e2;border:1px solid #afb4cf !important;">
                                <input type="submit"  value="Add" style="visibility:hidden">
                              </form>

                              <script type="text/javascript">
                               document.getElementById("enableEdit").onclick = function() {
                                 $(".editTask").css("display", "");
                                 $("#disaableEdit").css("display", "");
                                 $("#enableEdit").css("display", "none");
                               };

                               document.getElementById("disaableEdit").onclick = function() {
                                 $("#enableEdit").css("display", "");
                                 $("#disaableEdit").css("display", "none");
                                 $(".editTask").css("display", "none");
                               };
                              </script>

                              <div class="col-lg-12" >
                                <?php
                                $k = 1;
                                $sql_taskList = "SELECT * FROM project_timeline WHERE task_cat='main' AND projectID='$projectID'";
                                $result_taskList = $con->query($sql_taskList);
                                 $count_taskList = $result_taskList->num_rows;
                                 if ($count_taskList > 0) {
                                   while ($row_taskList = $result_taskList->fetch_array()) {
                                ?>
                                <br> <?php if($k != 1){ echo '<br>'; } ?>
                                <form class="" action="controller/projectcontroller.php?stat=save_mainTask&projectID=<?php echo $projectID; ?>&numb=<?php echo $k; ?>" method="post">
                                <div class="row" style="border:1px solid #d6d6d6;padding:5px;margin-bottom:15px !important;">
                                  <p style="padding:5px;color:white;background-color: #343957; position:relative;left:-2%;height:30px;">Main</p>
                                  <div class="col-lg-6" style="padding-top:5px;padding-left:25px;">
                                    <input type="checkbox"  disabled class="form-control" <?php if($row_taskList['status'] == 'complete' ){ echo 'checked'; } ?> style="height:18px;weight:18px;position:relative;left:-55%;">
                                    <span style="display:inline-block"><?php echo $row_taskList['task']; ?></span>
                                  </div>
                                  <div class="col-lg-5">
                                    <div class="rangeslider">
                                        <div>
                                            <input type="text" id="range_<?php echo $k; ?>" value="" name="range_<?php echo $k; ?>" />
                                            <input type="hidden" name="p_taskID<?php echo $k; ?>" value="<?php echo $row_taskList['p_taskID']; ?>">
                                            <input type="hidden" name="M_sdate<?php echo $k; ?>" value="" id="sdate<?php echo $k; ?>">
                                            <input type="hidden" name="M_edate<?php echo $k; ?>" value="" id="edate<?php echo $k; ?>">
                                        </div>
                                    </div>
                                  </div>
                                  <?php //if (($session_empID == 1) or ($session_empID == 4)) {  ?>
                                  <button class="btn" type="submit" style="padding:0px;height:30px;background-color:white;position:relative;right:-1.9%;top:1%;font-size:18px;font-weight:bold;color:green" href="" >&check;</button>
                                  <a style="position:relative;right:-2.5%;top:3%;font-size:20px ;font-weight:bold;color:red" href="controller/projectcontroller.php?stat=remove_mainTask&id=<?php  echo $row_taskList['p_taskID']; ?>&projectID=<?php echo $projectID; ?>" >&times;</a>
                                  <?php //} ?>
                                </div>
                              </form>

                              <?php
                              $projectStart_date = $row['startDate'];
                                  $projectStart_orderdate = explode('-', $projectStart_date);
                                  $projectStart_year = $projectStart_orderdate[0];
                                  $projectStart_month   = number_format($projectStart_orderdate[1]);
                                  $projectStart_day  = number_format($projectStart_orderdate[2]);

                                $projectend_date = $row['endDate'];
                                  $projectend_orderdate = explode('-', $projectend_date);
                                  $projectend_year = $projectend_orderdate[0]; ;
                                  $projectend_month   = number_format($projectend_orderdate[1]);
                                  $projectend_day  = number_format($projectend_orderdate[2]);
                              ?>

                                <script type="text/javascript">
                                var lang = "en-US";
                                 var year = <?php echo $projectStart_year; ?>;

                                 function tsToDate<?php echo $k; ?> (ts) {
                                     var d = new Date(ts);

                                     return d.toLocaleDateString(lang, {
                                         year: 'numeric',
                                         month: 'long',
                                         day: 'numeric'
                                     });
                                 }
                                 </script>

                                 <script type="text/javascript">
                                    $(function () {
                                        "use strict";
                                        $("#range_<?php echo $k; ?>").ionRangeSlider({
                                            // skin: "big",
                                            type: "double",
                                            grid: true,
                                            min: dateToTS(new Date(<?php echo $projectStart_year; ?>, <?php echo $projectStart_month-1; ?>, <?php echo $projectStart_day; ?>)),
                                            max: dateToTS(new Date(<?php echo $projectend_year; ?>, <?php echo $projectend_month-1; ?>, <?php echo $projectend_day; ?>)),
                                            <?php
                                              if ($row_taskList['startDate'] != '') {
                                            ?>
                                            from: <?php echo $row_taskList['startDate']; ?>,
                                            to: <?php echo $row_taskList['endDate']; ?>,
                                            <?php } ?>
                                            prettify: tsToDate<?php echo $k; ?>,

                                            onFinish: function (data) {
                                              var total_range = document.getElementById("range_<?php echo $k; ?>").value;
                                              let text = total_range;
                                              const myArray = text.split(";");
                                              let start = myArray[0];
                                              let end = myArray[1];

                                              document.getElementById("sdate<?php echo $k; ?>").value = start;
                                              document.getElementById("edate<?php echo $k; ?>").value = end;
                                          }
                                        });
                                    });
                                </script>
                                <?php if ($row_taskList['startDate'] != '') { ?>
                                <form action="controller/projectcontroller.php?stat=subTaskt&mainID=<?php echo $row_taskList['p_taskID']; ?>&projectID=<?php echo $projectID; ?>" method="post" style="margin-left:25px !important;display:none" class="editTask">
                                  <input type="text" id="subinput" class="form-control" name="sub_task" placeholder="Write a Sub Task and hit 'Enter'..." style="background-color:#c2f0f0;border:1px solid #85e0e0 !important;">
                                  <input type="submit"  value="Add" style="visibility:hidden">
                                </form>
                              <?php } ?>

                                <?php
                                $kk = 1;
                                $maincat_id = $row_taskList['p_taskID'];
                                $sql_taskList_sub = "SELECT * FROM project_timeline WHERE task_cat='sub' AND maincat_id='$maincat_id' AND projectID='$projectID'";
                                $result_taskList_sub = $con->query($sql_taskList_sub);
                                   while ($row_taskList_sub = $result_taskList_sub->fetch_array()) {
                                ?>
                                <form class="" action="controller/projectcontroller.php?stat=save_subTask&projectID=<?php echo $projectID; ?>&numb=<?php echo $kk; ?>&mainID=<?php echo $k; ?>" method="post">
                                <div class="row" style="border:1px solid #d6d6d6;padding:5px;margin-bottom:15px !important;margin-left:25px !important;">
                                  <p style="padding:5px;color:white;background-color: #2eb8b8; position:relative;left:-2%;height:30px;">Sub</p>
                                  <div class="col-lg-6" style="padding-top:5px;padding-left:25px;">
                                    <input type="checkbox" disabled checked class="form-control" style="height:18px;weight:18px;position:relative;left:-55%;">
                                    <span style="display:inline-block"><?php echo $row_taskList_sub['task']; ?></span>
                                  </div>
                                  <div class="col-lg-5">
                                    <div class="rangeslider">
                                        <div>
                                            <input type="text" id="<?php echo $k; ?>subrange_<?php echo $kk; ?>" value="" name="subrange_<?php echo $kk; ?>" />
                                            <input type="hidden" name="<?php echo $k; ?>ps_taskID<?php echo $kk; ?>" value="<?php echo $row_taskList_sub['p_taskID']; ?>">
                                            <input type="hidden" name="<?php echo $k; ?>S_sdate<?php echo $kk; ?>" value="" id="<?php echo $k; ?>S_sdate<?php echo $kk; ?>">
                                            <input type="hidden" name="<?php echo $k; ?>S_edate<?php echo $kk; ?>" value="" id="<?php echo $k; ?>S_edate<?php echo $kk; ?>">
                                        </div>
                                    </div>
                                  </div>
                                  <?php //if (($session_empID == 1) or ($session_empID == 4)) {  ?>
                                  <button class="btn" type="submit" style="padding:0px;height:30px;background-color:white;position:relative;right:-1.9%;top:1%;font-size:18px;font-weight:bold;color:green" href="" >&check;</button>
                                  <a style="position:relative;right:-2.5%;top:3%;font-size:20px ;font-weight:bold;color:red" href="controller/projectcontroller.php?stat=remove_subTask&id=<?php  echo $row_taskList_sub['p_taskID']; ?>&projectID=<?php echo $projectID; ?>" >&times;</a>
                                  <?php //} ?>
                                </div>
                                </form>


                                <script type="text/javascript">
                                var lang = "en-US";
                                 var year = 2022;


                                 function subtsToDate<?php echo $kk; ?> (ts) {
                                     var d = new Date(ts);

                                     return d.toLocaleDateString(lang, {
                                         year: 'numeric',
                                         month: 'long',
                                         day: 'numeric'
                                     });
                                 }
                                 </script>

                                 <script type="text/javascript">
                                    $(function () {
                                        "use strict";
                                        $("#<?php echo $k; ?>subrange_<?php echo $kk; ?>").ionRangeSlider({
                                            // skin: "big",
                                            type: "double",
                                            grid: true,
                                            min: <?php echo $row_taskList['startDate']; ?>,
                                            max: <?php echo $row_taskList['endDate']; ?>,
                                            <?php
                                              if ($row_taskList_sub['startDate'] != '') {
                                            ?>
                                            from: <?php echo $row_taskList_sub['startDate']; ?>,
                                            to: <?php echo $row_taskList_sub['endDate']; ?>,
                                            <?php } ?>
                                            prettify: subtsToDate<?php echo $kk; ?>,

                                            onFinish: function (data) {
                                              var total_range = document.getElementById("<?php echo $k; ?>subrange_<?php echo $kk; ?>").value;
                                              let text = total_range;
                                              const myArray = text.split(";");
                                              let start = myArray[0];
                                              let end = myArray[1];

                                              document.getElementById("<?php echo $k; ?>S_sdate<?php echo $kk; ?>").value = start;
                                              document.getElementById("<?php echo $k; ?>S_edate<?php echo $kk; ?>").value = end;
                                          }
                                        });
                                    });
                                </script>


                              <?php $kk++; } ?>

                              <?php $k++; } ?>

                              <?php } else { ?>
                                <p>No Project Tasks are Defined..</p>
                              <?php } ?>

                                <!-- /# card -->
                              </div>
                    </div>

                              <script type="text/javascript">
                               function dateToTS (date) {
                                   return date.valueOf();
                               }

                               </script>


                             <script> // table filter function
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


                            <!-- document panel -->
                            <div class="tab-pane p-20" id="doc" role="tabpanel">
                              <?php
                                $leader = $row['empID'];
                              if (($session_empID == 1) or ($session_empID == 4) or ($session_empID == $leader)) {
                                 ?>
                              <div class="card-title">
                                  <h4>Project Documents</h4>
                                  <?php
                                    $sql_pdocs = "SELECT * FROM `project_documents` WHERE projectID='$projectID'";
                                    $result_pdocs = $con->query($sql_pdocs);
                                   $count_pdocs = $result_pdocs->num_rows;
                                    if ($count_pdocs != 0) {
                                   ?>
                                  <div class="col-lg-12">
                                    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search Document" style="float:right;width:300px" class="form-control"> <br>
                                  </div>
                              </div> <br>
                              <?php
                              $sql_projectmemberp = "SELECT employee.*,project_members.* FROM project_members INNER JOIN employee ON employee.empID=project_members.empID WHERE project_members.projectID='$projectID' GROUP BY project_members.empID ";
                              $result_projectmemberp = $con->query($sql_projectmemberp);
                              $count_projectmemberp = $result_projectmemberp->num_rows;
                              ?>
                              <div class="table">
                                  <table class="table-bordered" id="myTable">
                                      <thead>
                                          <tr style="background-color:#527a7a;">
                                              <th style="color:white !important;vertical-align:middle" width="5%" rowspan="2">#</th>
                                              <th style="color:white !important;vertical-align:middle" width="30%" rowspan="2">File Title</th>
                                              <th style="color:white !important;text-align:center;vertical-align:middle" width="10%" rowspan="2"  style="">File</th>
                                              <th style="color:white !important;text-align:center;" width="50%" colspan="<?php echo $count_projectmemberp; ?>">Access Priviliges</th>
                                              <th style="color:white !important;vertical-align:middle" width="5%" rowspan="2">Remove</th>
                                          </tr>
                                          <tr style="background-color:#527a7a;">
                                            <?php
                                              while ($row_projectmemberp = $result_projectmemberp->fetch_array()) {
                                                $str = $row_projectmemberp['empName'];
                                                $strName = explode(" ",$str);
                                            ?>
                                              <td style="text-align:center;color:white !important;font-size:13px"><?php echo $strName[1]; ?> <?php echo $strName[2]; ?></td>
                                          <?php } ?>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <?php
                                        $no=1;
                                          while ($row_pdocs = $result_pdocs->fetch_array()) {
                                            $type = $row_pdocs['type'];
                                            $badge = 'dark';
                                            if ($type == 'pdf') {
                                              $badge = 'danger';
                                            } else if($type == 'docx'){
                                              $badge = 'info';
                                            } else if($type == 'xlsx'){
                                              $badge = 'success';
                                            }

                                            $getPid = $row_pdocs['p_docID'];
                                        ?>
                                          <tr>
                                              <th style="color:gray !important"><?php echo $no; ?></th>
                                              <td  style="text-transform:capitalize !important"><?php echo $row_pdocs['title'] ?></td>
                                              <td style="text-align:center;"> <a href="../res/projectsDoc/<?php echo $row_pdocs['doc'] ?>" target="blank"><span class="badge badge-<?php echo $badge; ?>"><?php echo $type; ?></span></a> </td>
                                              <?php
                                              $sql_projectmemberp2 = "SELECT employee.*,project_members.* FROM project_members INNER JOIN employee ON employee.empID=project_members.empID WHERE project_members.projectID='$projectID' GROUP BY project_members.empID ";
                                              $result_projectmemberp2 = $con->query($sql_projectmemberp2);
                                                while ($row_projectmemberp2 = $result_projectmemberp2->fetch_array()) {
                                                  $eeID = $row_projectmemberp2['empID'];
                                                  $sql_getpv = "SELECT * FROM member_permissions WHERE projectID='$projectID' AND empID='$eeID' AND documentID='$getPid'";
                                                  $result_getpv = $con->query($sql_getpv);
                                                   $count_getpv = $result_getpv->num_rows;
                                                   $text = ''; $vals = 'no';
                                                   if ($count_getpv > 0) {
                                                     $text = 'checked';
                                                     $vals = 'yes';
                                                   }

                                                  ?>

                                                  <form class="" action="controller/projectcontroller.php?stat=priviliges&empID=<?php echo $eeID; ?>&docID=<?php echo $row_pdocs['p_docID']; ?>&projectID=<?php echo $projectID; ?>" method="post">
                                                  <td style="text-align:center"><input style="width:15px;height:15px" name="permission" onChange="this.form.submit()" <?php echo $text; ?> type="checkbox" ></td>
                                                  <input type="hidden" name="priviligeStat" value="<?php echo $vals; ?>">
                                                  </form>

                                              <?php } ?>
                                              <td style="text-align:center"><button style="background-color:transparent;font-size:15px;font-weight:bold" type="button" class="btn-sm  btn sweet-message2 delete" data-id="<?php echo  $row_pdocs['p_docID']; ?>" data-proj="<?php echo  $projectID; ?>">X</button></td>

                                          </tr>
                                        <?php $no++; } ?>
                                      </tbody>
                                  </table>
                                </div> <?php } else {  ?>
                                  </div>
                                  <p>There is No Records...</p> <?php } ?>


                              <div class="row">
                                <div class="col-lg-12">
                                <br> <hr> <br>
                                <div class="basic-form">
                                  <div class="card-title">
                                      <h4 style="color:#009999;">Add New Document</h4>
                                  </div> <br>
                                  <form class="" action="controller/projectcontroller.php?stat=addDoc&projectID=<?php echo $projectID; ?>" method="post" enctype="multipart/form-data" >
                                      <div class="row">
                                        <div class="col-lg-6 col-sm-6">
                                          <div class="form-group">
                                              <label>Document Title <span style="color:red">*</span> </label>
                                              <input type="text"  class="form-control" required name="Doctitle" placeholder="Document Title">
                                          </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                          <div class="form-group">
                                          <label for="myfile">File :</label> <br>
                                            <input type="file" id="myfile" class="form-control" required name="myfile" accept="image/*, .doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document, .pdf" >
                                            <p style="font-size:13px;margin-top:5px;color:#ac5377">Please use only .jpg , .png , .jpeg , .docx , .xlsx and .pdf files</p>
                                          </div>
                                        </div>
                                      </div>

                                        <div class="float-right">
                                          <button type="reset" class="btn btn-default">Clear</button>
                                          <button type="submit" class="btn btn-success">Add</button>
                                        </div>
                                    </form>
                                </div>
                              </div>
                            </div>
                          <?php } else{ ?>
                            <div class="card-title">
                                <h4>Project Documents</h4>
                                <?php
                                  $sql_pdocs2 = "SELECT project_documents.* FROM project_documents INNER JOIN member_permissions ON project_documents.projectID = member_permissions.projectID WHERE member_permissions.projectID='$projectID' AND member_permissions.empID='$session_empID'";
                                  $result_pdocs2 = $con->query($sql_pdocs2);
                                 $count_pdocs2 = $result_pdocs2->num_rows;
                                  if ($count_pdocs2 != 0) {
                                 ?>
                                <div class="col-lg-12">
                                  <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search Document" style="float:right;width:300px" class="form-control"> <br>
                                </div>
                            </div> <br> <br>
                            <div class="table">
                                <table class="table-bordered" id="myTable" style="width:90%;margin:auto">
                                    <thead>
                                        <tr style="background-color:#527a7a;">
                                          <th style="color:white !important;text-align:center;" >#</th>
                                          <th style="color:white !important;">File Title</th>
                                          <th style="color:white !important;text-align:center;">File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $no=1;
                                        while ($row_pdocs2 = $result_pdocs2->fetch_array()) {
                                          $type = $row_pdocs2['type'];
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
                                            <td  style="text-transform:capitalize !important"><?php echo $row_pdocs2['title'] ?></td>
                                            <td style="text-align:center;"> <a href="../res/projectsDoc/<?php echo $row_pdocs2['doc'] ?>" target="blank"><span class="badge badge-<?php echo $badge; ?>"><?php echo $type; ?></span></a> </td>
                                        </tr>
                                      <?php $no++; } ?>
                                    </tbody>
                                </table>
                              </div>
                            <?php } else {  ?>
                                </div>
                                <p>There is No Records...</p> <?php } ?>

                          <?php } ?>
                            </div>


                            <?php if ($session_empID == 1) {  ?>

                            <!-- project legal documents -->
    												<div class="tab-pane   p-20" id="Ldoc" role="tabpanel">
                              <div class="col-lg-12" >
                                <div class="card-title">
                                    <h4>Legal Documents List</h4>
                                </div> <br>
                                <?php
                                $nos = 1;
                                $sql6 = "SELECT * FROM project_legal_documents WHERE projectID ='$projectID'";
                                $result6 = $con->query($sql6);
                                $count_pdocs6 = $result6->num_rows;
                                 if ($count_pdocs6 != 0) {
                                ?>
                                <div class="table">
                                    <table style="width:100%" class="table table-bordered">
                                        <thead style="background-color:#476B6B">
                                            <tr>
                                                <th style="color:white !important">#</th>
                                                <th style="color:white !important">Title</th>
                                                <th style="color:white !important">Type</th>
                                                <th style="color:white !important;text-align:center;">Date</th
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                          while ($row6 = $result6->fetch_array()) {
                                            $type = $row6['type'];
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
                                                <th style="padding-left:20px;color:gray !important"><?php echo $nos; ?></th>
                                                <td style="text-align:center;color:gray"><?php echo $row6['title']; ?></td>
                                                <td style="text-align:center;color:gray"> <a href="../res/projectLDoc/<?php echo $row6['doc'] ?>" target="blank"><span class="badge badge-<?php echo $badge; ?>"><?php echo $type; ?></span></a></td>
                                                <td style="text-align:center;color:gray"><?php echo $row6['date']; ?></td>
                                            </tr>
                                          <?php $nos++; } ?>
                                        </tbody>
                                    </table>
                                </div>
                              <?php } else {  ?>
                                  <p>There is No Records...</p> <?php } ?>
                              </div> <br>

                              <div class="row">
                                <div class="col-lg-12">
                                <br> <hr> <br>
                                <div class="basic-form">
                                  <div class="card-title">
                                      <h4 style="color:#009999;">Add New Legal Document</h4>
                                  </div> <br>
                                  <form class="" action="controller/projectcontroller.php?stat=addLDoc&projectID=<?php echo $projectID; ?>" method="post" enctype="multipart/form-data" >
                                      <div class="row">
                                        <div class="col-lg-6 col-sm-6">
                                          <div class="form-group">
                                              <label>Document Title <span style="color:red">*</span> </label>
                                              <input type="text"  class="form-control" required name="Ltitle" placeholder="Document Title">
                                          </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                          <div class="form-group">
                                          <label for="myfile">File :</label> <br>
                                            <input type="file" id="myfile2" class="form-control" required name="myfile2" accept="image/*, .doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document, .pdf" >
                                            <p style="font-size:13px;margin-top:5px;color:#ac5377">Please use only .jpg , .png , .jpeg , .docx , .xlsx and .pdf files</p>
                                          </div>
                                        </div>
                                      </div>

                                        <div class="float-right">
                                          <button type="reset" class="btn btn-default">Clear</button>
                                          <button type="submit" class="btn btn-success">Add</button>
                                        </div>
                                    </form>
                                </div>
                              </div>
                            </div>
                            </div>
                          <?php } ?>


                            <!-- notes panel -->
                            <div class="tab-pane p-20" id="notes" role="tabpanel">
                              <div class="todo-list" id="taskTable">
                                  <div class="tdl-holder">
                                      <div class="">
                                          <ul>
                                            <?php
                                              $sql_notes = "SELECT * FROM project_notes WHERE projectID='$projectID'";
                                              $result_notes = $con->query($sql_notes);
                                              while ($row_notes = $result_notes->fetch_array()) {
                                            ?>
                                              <li style="margin-top:12px">
                                                <label>
                                                  <table style="width:100%">
                                                    <tr>
                                                      <td style="border-right:1px solid #252525;color:#252525 !important;font-weight:bold;width:10%"><?php echo $row_notes['employee']; ?></td>
                                                      <td style="padding-left:10px;width:70%"><?php echo $row_notes['note']; ?></td>
                                                      <td style="text-align:right;width:10%"><?php echo $row_notes['date']; ?></td>
                                                    </tr>
                                                  </table>
                                                </label>
                                              </li>
                                            <?php
                                              }
                                            ?>
                                          </ul>
                                      </div>

                                      <?php
                                        if ($session_empID == 1) {
                                          $set_emp = 'Admin';
                                        } else if ($session_empID == 4) {
                                          $set_emp = 'Development Dept';
                                        } else{
                                          $sql_setEmpName = "SELECT * FROM employee WHERE empID='$session_empID'";
                                          $result_setEmpName = $con->query($sql_setEmpName);
                                          $row_setEmpName = $result_setEmpName->fetch_array();
                                          $str = $row_setEmpName['empName'];
                                          $strName = explode(" ",$str);
                                          $set_emp = $strName[1].' '.$strName[2];
                                        }
                                      ?>
                                      <form action="controller/projectcontroller.php?stat=addnote&projectID=<?php echo $projectID; ?>" method="post">
                                        <input type="text" class="form-control" name="note"
                                            placeholder="Write a new note and hit 'Enter'...">
                                            <input type="hidden" name="empname" value="<?php echo $set_emp; ?>">
                                            <input type="submit"  value="Add" style="visibility:hidden">
                                      </form>
                                  </div>
                              </div>
                            </div>




                             <!-- expenses panel -->
                            <div class="tab-pane p-20" id="income" role="tabpanel">
                              income
                            </div>



    											</div>
    										</div>
                      </div>
                    </div>
                  <!-- </div> -->

                  <?php //include('build/editEdu.php') ?>

<br><br><br>



<div class="row">
  <div class="col-lg-12">
    <div class="footer">
      <p>2022 © Developed By Ishu Nawodya</p>
    </div>
  </div>
</div>
</section>
</div>
</div>
</div>

<?php include('build/remove_editproject.php'); ?>


    <!-- jquery vendor -->
    <script src="assets/js/lib/jquery.min.js"></script>
    <script src="assets/js/lib/jquery.nanoscroller.min.js"></script>
    <!-- nano scroller -->
    <script src="assets/js/lib/menubar/sidebar.js"></script>
    <script src="assets/js/lib/preloader/pace.min.js"></script>
     <!-- footer -->
     <script src="assets/js/lib/data-table/datatables.min.js"></script>

     <script src="assets/js/lib/rangeSlider/ion.rangeSlider.min.js"></script>
     <script src="assets/js/lib/rangeSlider/moment.js"></script>
     <script src="assets/js/lib/rangeSlider/moment-with-locales.js"></script>
     <!-- <script src="assets/js/lib/rangeSlider/rangeslider.init.js"></script> -->

     <script src="assets/js/lib/toastr/toastr.min.js"></script>
     <script src="assets/js/lib/toastr/toastr.init.js"></script>

     <!--ION Range Slider JS-->
     <script src="assets/js/lib/knob/jquery.knob.min.js "></script>
     <script src="assets/js/lib/knob/knob.init.js "></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</body>

</html>
