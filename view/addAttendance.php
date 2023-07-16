<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string

$ob = new dbconnection();
$con = $ob->connection();
//to display task list

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('common/files.php') ?>
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
      document.getElementById('attendance').className = 'active open';
      document.getElementById('attList').className = 'active';
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
                                <h1>New Resources</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-5 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                              <ol class="breadcrumb">
                                  <li class="breadcrumb-item"><a href="attendance.php">Attendance List</a></li>
                                  <li class="breadcrumb-item myactive">Upload Attendance</li>
                              </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->
                <section id="main-content">

                  <?php include('src/itemAlert.php') ?>

                    <div class="col-lg-12 col-sm-12">
                      <div class="card">
                        <div class="card-title">
                            <h4>Add Resource</h4>
                        </div><br>
                        <p style="font-size:16px;color:#b30000"><b>* Note : </b>
                          From this screen you can upload all of your attendance details from Microsoft CSV file.
                          Please note that if you upload wrong file or if you did not upload the processed CSV file, it will damage the database.
                          System has no warranty for those incidents. Please first select the attendance date and upload the processed CSV file from the Fingerprint Machine..</p>
                        <div class="basic-form">
                            <div class="row">
                              <div class="col-lg-12 col-sm-6">
                                <h6 style="color:#333333">Following Dates are Updated</h6>
                                <div class="row">
                                  <?php
                                    $thismonth = date('Y-m');

                                    $sql_attendace = "SELECT * FROM attendance_exported_table WHERE date LIKE '$thismonth%' GROUP BY date";
                                    $result_attendace = $con->query($sql_attendace);
                                    while ($row_attendace = $result_attendace->fetch_array()){
                                  ?>
                                  <div class="col-lg-1"  style="color:#333333">
                                    <?php echo $row_attendace['date']; ?>
                                  </div>
                                <?php } ?>
                                </div>
                              </div>
                            </div>
                            <br>

                            <form  method="post" action="controller/uploadAttendance.php" enctype="multipart/form-data">
                              <div class="row">
                                <div class="col-lg-4 col-sm-6">
                                  <div class="form-group">
                                      <label>Date <span style="color:red">*</span></label>
                                      <input type="date" style="width:80%" class="form-control" name="upload_date" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>" required>
                                  </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                  <div class="form-group">
                                      <label>Attendance Record <span style="color:red">*</span></label> <br>
                                      <input type="file" id="myfile" name="attFile" required>
                                  </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                  <br>
                                  <button type="submit" class="btn btn-success" name="submit">Upload</button>
                                </div>
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

</html>
