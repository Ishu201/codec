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
    <link rel="stylesheet" href="assets/css/pagination.css">

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
        margin-bottom: 10px
      }

      .dt-buttons{

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

      .leave-rem{
        color:#343957;
        font-weight: bold;
      }

      .media{
        border: none !important;
      }

      .card-header:hover{
        background-color: #e0e0d1;
      }

      .reqHeading{
        font-weight: bold;
      }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
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
      document.getElementById('leave').className = 'active open';
      document.getElementById('leaveReq').className = 'active';
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
                                <h1>Employee Leave Requests</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Leave Management</a></li>
                                    <li class="breadcrumb-item myactive">Leave Requests</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>

                <!-- /# row -->
                <section id="main-content">

                  <?php include('src/leaveAlert.php'); ?>

                  <div class="card">
                    <div class="card-title">
                        <h4>Leave Requests </h4>
                    </div>
                    <div class="recent-comment">
                    <div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true">

                      <?php
                      $cmonth = date('Y-m');
                        $sql_leaves = "SELECT * FROM leave_requests WHERE startDate LIKE '$cmonth%' ORDER BY date DESC";
                        $result_leaves = $con->query($sql_leaves);
                        $no = 1;
                        while ($row_leaves = $result_leaves->fetch_array()) {
                          $employee = $row_leaves['empID'];
                            $sql_emp = "SELECT * FROM employee WHERE empID='$employee'";
                            $result_emp = $con->query($sql_emp);
                            $row_emp = $result_emp->fetch_array();

                          $leaveT = $row_leaves['leaveID'];
                            $sql_lt = "SELECT * FROM company_leaves WHERE leaveID='$leaveT'";
                            $result_lt = $con->query($sql_lt);
                            $row_lt = $result_lt->fetch_array();

                          $desig = $row_emp['desigID'];
                            $sql_dept = "SELECT designation.designation, department.deptName FROM designation INNER JOIN department ON designation.deptID = department.deptID WHERE desigID='$desig'";
                            $result_dept = $con->query($sql_dept);
                            $row_dept = $result_dept->fetch_array();
                      ?>

                      <!-- start first -->
                      <div class="card-header" role="tab" id="headingTwo<?php echo $no; ?>" style="background-color:#EEEFF3">
                        <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx<?php echo $no; ?>" href="#collapseTwo<?php echo $no; ?>" aria-expanded="false" aria-controls="collapseTwo<?php echo $no; ?>">
                          <div class="media" >
                              <div class="media-left">
                                  <img class="media-object" style="border:1px solid #d9d9d9;border-radius:60%;height:80px;width:80px;" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row_emp['image']); ?>">
                              </div>
                              <div class="media-body">
                                  <h4 class="media-heading"><?php echo $row_emp['empName']; ?></h4>
                                  <p style="text-transform:capitalize"><?php echo $row_lt['leave_type']; ?> &nbsp - &nbsp <?php echo $row_leaves['reason']; ?> </p>
                                  <div class="comment-action">
                                    <?php if ($row_leaves['status'] == 'Approved'){ ?>
                                      <div class="badge badge-success">Approved</div>
                                    <?php } else if ($row_leaves['status'] == 'Pending'){ ?>
                                      <div class="badge badge-info">Pending</div>
                                    <?php } else { ?>
                                      <div class="badge badge-danger">Rejected</div>
                                    <?php } ?>
                                  </div>
                                  <?php
                                    $month = $row_leaves['date'];
                                    $mon = DateTime::createFromFormat("Y-m-d" , $month);
                                  ?>
                                  <p class="comment-date"><?php echo $mon->format('l d, Y'); ?></p>
                              </div>
                          </div>
                        </a>
                      </div>
                      <div id="collapseTwo<?php echo $no; ?>" class="collapse" role="tabpane<?php echo $no; ?>" aria-labelledby="headingTwo<?php echo $no; ?>" data-parent="#accordionEx<?php echo $no; ?>">
                        <div class="card-body" style="padding:10px;">
                          <div class="row">
                            <div class="col-lg-6">
                              <p class="reqHeading">Designation &nbsp &nbsp - <span style="font-weight:normal"> &nbsp <?php echo $row_dept['designation']; ?> (<?php echo $row_dept['deptName']; ?>)</span> </p>
                              <p class="reqHeading">Start Date &nbsp &nbsp &nbsp &nbsp - <span style="font-weight:normal;padding-right:80px !important;"> &nbsp <?php echo $row_leaves['startDate']; ?></span>End Date &nbsp &nbsp - <span style="font-weight:normal"> &nbsp <?php echo $row_leaves['endDate']; ?></span>  </p>
                              <p class="reqHeading">Duration &nbsp &nbsp  &nbsp &nbsp &nbsp - <span style="font-weight:normal;padding-right:100px !important;"> &nbsp <?php echo $row_leaves['duration']; ?></span> Status &nbsp &nbsp - <span style="font-weight:normal"> &nbsp <?php echo $row_leaves['status']; ?></span>  </p>
                            </div>
                            <div class="col-lg-4">

                                  <div class="card-body" id="leaveRem" style="display:none">
                                    <div class="table">
                                        <table style="width:100%;" class="table table-bordered">
                                            <thead style="background-color:#d6d6d6;">
                                                <tr>
                                                    <th>Type</th>
                                                    <th style="text-align:center">Remaining</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              <?php
                                              $id= $row_emp['empID'];
                                              $sql6 = "SELECT * FROM employee_leaves WHERE empID ='$id' AND stat='On'";
                                              $result6 = $con->query($sql6);
                                               $count = $result6->num_rows;
                                               if ($count > 0) {
                                                 while ($row6 = $result6->fetch_array()) { ?>
                                                <tr>
                                                  <th style="padding-left:20px;color:gray !important"><?php echo $row6['leaveID']; ?></th>
                                                    <td style="text-align:center;color:gray"><?php echo $row6['days']-$row6['used']; ?></td>
                                                </tr>
                                              <?php } } else{ ?>
                                              <td colspan="3"> There is No Leave Records</td>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                  </div>

                            </div>
                            <div class="col-lg-2" >
                              <div class="float-right">
                                <?php if ($row_leaves['status'] == 'Pending') {  ?>
                                <button  class="btn-sm btn btn-warning" onclick="viewLeave();" id="lview">View</button>
                                <button class="btn-sm btn-success btn sweet-message delete" data-id="<?php echo  $row_leaves['reqID']; ?>" data-st="app">Approve</button>
                                <button class="btn-sm btn-danger btn sweet-message2 delete" data-id="<?php echo  $row_leaves['reqID']; ?>" data-st="rej">Reject</button>
                              <?php } ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- end first -->
                    <?php $no++; } ?>
                    </div> </div>
                  </div>

                  <script type="text/javascript">
                    function viewLeave(){
                      var val = document.getElementById('leaveRem').style.display;
                      if (val == 'block') {
                        document.getElementById('lview').innerHTML = 'view';
                        document.getElementById('leaveRem').style.display='none';
                      } else{
                        document.getElementById('lview').innerHTML = 'close';
                        document.getElementById('leaveRem').style.display='block';
                      }
                    }
                  </script>

                   <br><hr>

                   <div class="page-header">
                       <div class="page-title">
                           <h1>Leave Request Records</span></h1>
                       </div>
                   </div>
                  <div class="row">
                    <div class="col-lg-12 col-sm-12">
                      <div class="card">
                        <div class="card-title">
                            <h4>Leave Requests</h4>
                        </div>
                        <div class="bootstrap-data-table-panel">
                            <div class="table-responsive">
                                <table id="bootstrap-data-table-export" class="table  table-bordered">
                                    <thead>
                                        <tr style="background-color:#d6d6d6 !important">
                                            <th>Employee Name</th>
                                            <th>Department <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Leave Type <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Start Date <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>End Date <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th>Duration <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                            <th style="text-align:left">Leave Status <i class="ti-exchange-vertical float-right sortIcon"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                        $sql_leaves = "SELECT * FROM leave_requests ORDER BY startDate DESC";
                                        $result_leaves = $con->query($sql_leaves);
                                        $no = 1;
                                        while ($row_leaves = $result_leaves->fetch_array()) {
                                          $employee = $row_leaves['empID'];
                                            $sql_emp = "SELECT * FROM employee WHERE empID='$employee'";
                                            $result_emp = $con->query($sql_emp);
                                            $row_emp = $result_emp->fetch_array();

                                          $leaveT = $row_leaves['leaveID'];
                                            $sql_lt = "SELECT * FROM company_leaves WHERE leaveID='$leaveT'";
                                            $result_lt = $con->query($sql_lt);
                                            $row_lt = $result_lt->fetch_array();

                                          $desig = $row_emp['deptID'];
                                            $sql_dept = "SELECT deptName FROM  department WHERE deptID='$desig'";
                                            $result_dept = $con->query($sql_dept);
                                            $row_dept = $result_dept->fetch_array();

                                       ?>
                                        <tr>
                                            <td><?php echo $row_emp['empName']; ?></td>
                                            <td><?php echo $row_dept['deptName']; ?></td>
                                            <td><?php echo $row_lt['leave_type']; ?></td>
                                            <td><?php echo $row_leaves['startDate']; ?></td>
                                            <td><?php echo $row_leaves['endDate']; ?></td>
                                            <td><?php echo $row_leaves['duration']; ?></td>
                                            <td><?php echo $row_leaves['status']; ?></td>
                                        </tr>
                                      <?php } ?>
                                    </tbody>
                                </table>
                            </div> <br>
                        </div>
                      </div>
                    </div>
                  </div>




                  <?php include('build/leaveApp.php'); ?>

                  <?php include('build/removeleaveReq.php'); ?>


      <?php include('common/footer.php') ?>
     <!-- footer -->
     <?php include('common/tableExport.php') ?>

</body>

</html>
