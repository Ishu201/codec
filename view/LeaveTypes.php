<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string
// include 'model/departmentmodel.php';

$ob = new dbconnection();
$con = $ob->connection();
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
    html,body{
      width: 100%;
      height: 100%;
      margin: 0px;
      padding: 0px;
      overflow-x: hidden;
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
      document.getElementById('leave').className = 'active open';
      document.getElementById('companyLeave').className = 'active';
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
                                <h1>Company Leaves and Holiday Management</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="companyLeaves.php">Company Leaves</a></li>
                                    <li class="breadcrumb-item myactive">Manage Leave Types</li>
                                </ol>
                            </div>
                        </div>
                      </div>
                    <!-- /# column -->
                </div>

                <!-- /# row -->
                <section id="main-content">

                  <?php include('src/leavetypeAlert.php') ?>

                  <div class="row">
                    <div class="col-lg-5 col-sm-12">
                      <div class="card">
                          <div class="card-title">
                              <h4>Add New Leave Type</h4>
                          </div>
                          <div class="card-body">
                              <div class="basic-form"> <br>
                                  <form action="controller/leavetypescontroller.php" method="post">
                                      <div class="form-group">
                                          <label>Leave Type <span style="color:red">*</span></label>
                                          <input type="text"  class="form-control" name="leaveName" required>
                                      </div>
                                      <div class="form-group">
                                          <label>Days <span style="color:red">*</span></label>
                                          <input type="number"  class="form-control" name="leaveDates" required>
                                      </div>
                                      <div class="float-right">
                                        <button type="reset" class="btn btn-default">Clear</button>
                                        <button type="submit" class="btn btn-success" name="addL">Add</button>
                                      </div>
                                  </form>
                              </div>
                          </div>
                      </div>
                    </div>

                    <div class="col-lg-7 col-sm-12">
                      <div class="card">
                          <div class="card-title">
                              <h4>Leave List </h4>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table table-bordered">
                                      <thead>
                                          <tr style="background-color:#d6d6d6">
                                              <th>Leave Type</th>
                                              <th style="text-align:right">No of Days</th>
                                              <th>Actions</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <?php
                                        $sql = "SELECT * FROM company_leaves";
                                        $result = $con->query($sql);
                                        while ($row = $result->fetch_array()) {
                                        ?>
                                          <tr>
                                              <td><?php echo $row['leave_type']; ?></td>
                                              <td style="text-align:right"><?php echo $row['total_days']; ?></td>
                                              <td>
                                                <a href="leaveTypes.php?msg=edit&id=<?php echo  $row['leaveID']; ?>"><button type="submit" class="btn-sm btn btn-success" data-toggle="modal" data-target="#editLeaveType">Edit</button></a>
                                                <?php
                                                  if ($row['stat'] == 'Active') { ?>
                                                    <button class="btn-sm btn-danger btn sweet-message delete" data-id="<?php echo  $row['leaveID']; ?>">Deactive</button>
                                                  <?php } else{ ?>
                                                    <button class="btn-sm btn-info btn sweet-message2 delete" data-id="<?php echo  $row['leaveID']; ?>">Active</button>
                                                <?php } ?>
                                              </td>
                                          </tr>
                                        <?php } ?>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div>
                    </div>
                  </div>

                  <?php include('build/editLeaveType.php') ?>
                  <?php include('build/removeLeaveType.php') ?>


      <?php include('common/footer.php') ?>
     <!-- footer -->

</body>

</html>
