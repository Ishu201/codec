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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <style media="screen">
      .autocompleter-item:hover{
        cursor:pointer;
        font-size:17px !important;
      }
      .autocompleter-item{
        font-size:16px !important;
        margin: 5px;
        color: #0066cc;
      }
    </style>
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
      document.getElementById('projects').className = 'active open';
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
                                <h1>Add New Project</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-5 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="projectList.php">Project List</a></li>
                                    <li class="breadcrumb-item myactive">Add new Project</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->
                <section id="main-content">
                    <div class="col-lg-12 col-sm-12">
                      <div class="card">
                        <div class="card-title">
                            <h4>Project Details</h4>
                        </div>

                        <?php
                        $sql = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA ='codec' AND TABLE_NAME ='projects'";
                        $result = $con->query($sql);
                        $row = $result->fetch_array();
                        $num = $row[0];
                         ?>

                        <div class="basic-form"> <br>
                            <form method="post" action="controller/projectcontroller.php?stat=add">
                              <div class="row">
                                <div class="col-lg-2 col-sm-6">
                                  <div class="form-group">
                                      <label>Project ID <span style="color:red">*</span></label>
                                      <input type="text"  class="form-control" name="" value="CDC<?php echo sprintf("%05d", $num) ?>" readonly>
                                  </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                  <div class="form-group">
                                      <label>Project Title <span style="color:red">*</span></label>
                                      <input type="text"  class="form-control" name="project_name" placeholder="Project Name">
                                  </div>
                                </div>

                                <?php
                                  $sql_id = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA ='codec' AND TABLE_NAME ='projects'";
                                  $result_id = $con->query($sql_id);
                                  $row_id = $result_id->fetch_array();
                                  $num_id = $row_id[0];
                                ?>

                                <input type="hidden" name="getID" value="<?php echo $num_id; ?>">

                                <div class="col-lg-4 col-sm-6">
                                  <div class="form-group">
                                      <label>Industry <span style="color:red">*</span></label>
                                      <input type="text" id="industry" name="industry" class="form-control" required placeholder="Select Industry">
                                  </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                  <div class="form-group">
                                      <label>Project Type <span style="color:red">*</span></label>
                                      <input type="text" id="project_type" name="project_type" class="form-control" required placeholder="Type of the System">
                                  </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                  <div class="form-group">
                                      <label>Payment Mode <span style="color:red">*</span></label>
                                      <select class="form-control" name="project_status" required>
                                        <option value="">Select</option>
                                        <option value="One Time Payment">One Time Payment</option>
                                        <option value="Initial with Monthly Payment">Initial with Monthly Payment</option>
                                        <option value="Initial with Annual Payment">Initial with Annual Payment</option>
                                      </select>
                                  </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                  <div class="form-group">
                                      <label>Project Leader <span style="color:red">*</span></label>
                                      <select class="form-control" name="empID" required style="text-transform:capitalize">
                                        <option value="">Select</option>
                                        <?php
                                        $sql = "SELECT * FROM employee WHERE empJobStatus='Working' AND (desigID='12' OR desigID='13' OR desigID='14')";
                                        $result = $con->query($sql);
                                        while ($row = $result->fetch_array()) {
                                          $pemp = $row['empID'];
                                          $sql3 = "SELECT employee.* FROM projects INNER JOIN employee ON employee.empID=projects.empID WHERE projects.empID='$pemp' AND projects.status='ongoing'";
                                          $result3 = $con->query($sql3);
                                           $countm = $result3->num_rows;
                                           $col='';
                                           if ($countm > 0) {
                                             $col = 'color:red !important;';
                                           }
                                        ?>
                                          <option style="text-transform:capitalize;<?php echo $col; ?>" value="<?php echo $row['empID']; ?>"><?php echo $row['empName']; ?></option>
                                        <?php } ?>
                                      </select>
                                  </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                  <div class="form-group">
                                      <label>Project Start Date <span style="color:red">*</span></label>
                                      <input type="date"  class="form-control" name="startDate"  required>
                                  </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                  <div class="form-group">
                                      <label>Estimated End Date <span style="color:red">*</span></label>
                                      <input type="date"  class="form-control" name="endDate"  required>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="form-group">
                                    <label>Project Summary <span style="color:red">*</span></label>
                                    <textarea class="form-control" rows="3" placeholder="Project Description" name="description" style="height:150px" required></textarea>
                                  </div>
                                </div>
                              </div>

                              <hr>

                              <div class="card-title">
                                  <h4>Customer Details</h4>
                              </div> <br>
                              <div class="row">
                                <div class="col-lg-5 col-sm-6">
                                  <div class="form-group">
                                      <label>Customer Name <span style="color:red">*</span></label>
                                      <input type="text"  class="form-control" name="customer_name" placeholder="Customer Name" required>
                                  </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                  <div class="form-group">
                                      <label>Company <span style="color:red">*</span></label>
                                      <input type="text"  class="form-control" name="customer_company" placeholder="Organization Name" required>
                                  </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                  <div class="form-group">
                                      <label>Contact No <span style="color:red">*</span></label>
                                      <input type="number"  class="form-control" name="customer_contact"  placeholder="Customer Contacts"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10"  required >
                                  </div>
                                </div>
                                <div class="col-lg-7 col-sm-6">
                                  <div class="form-group">
                                      <label>Customer Address <span style="color:red">*</span></label>
                                      <input type="text"  class="form-control" name="customer_address"  placeholder="Customer Address" required>
                                  </div>
                                </div>
                                <div class="col-lg-5 col-sm-6">
                                  <div class="form-group">
                                      <label>Customer Email <span style="color:red">*</span></label>
                                      <input type="email"  class="form-control" name="customer_email" placeholder="exsample@mail.com" required>
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
                  <!-- </div> -->


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

            <!-- <script src="assets/js/sweetAlert.js"></script> -->
            <!-- jquery vendor -->
            <!-- <script src="assets/js/lib/jquery.min.js"></script> -->
            <script src="assets/js/lib/jquery.nanoscroller.min.js"></script>
            <!-- nano scroller -->
            <script src="assets/js/lib/menubar/sidebar.js"></script>
            <script src="assets/js/lib/preloader/pace.min.js"></script>
            <!-- sidebar -->

            <script src="assets/js/lib/bootstrap.min.js"></script>
            <script src="assets/js/scripts.js"></script>
            <!-- bootstrap -->

            <script src="assets/js/lib/calendar-2/moment.latest.min.js"></script>
            <script src="assets/js/lib/calendar-2/pignose.calendar.min.js"></script>
            <script src="assets/js/lib/calendar-2/pignose.init.js"></script>

            <script src="assets/js/lib/toastr/toastr.min.js"></script>
            <script src="assets/js/lib/toastr/toastr.init.js"></script>


            <script src="assets/js/lib/weather/jquery.simpleWeather.min.js"></script>
            <script src="assets/js/lib/weather/weather-init.js"></script>
            <script src="assets/js/lib/circle-progress/circle-progress.min.js"></script>
            <script src="assets/js/lib/circle-progress/circle-progress-init.js"></script>
            <script src="assets/js/lib/chartist/chartist.min.js"></script>
            <script src="assets/js/lib/sparklinechart/jquery.sparkline.min.js"></script>
            <script src="assets/js/lib/sparklinechart/sparkline.init.js"></script>
            <script src="assets/js/lib/owl-carousel/owl.carousel.min.js"></script>
            <script src="assets/js/lib/owl-carousel/owl.carousel-init.js"></script>
            <!-- scripit init-->
            <script src="assets/js/dashboard2.js"></script>
            <!-- footer -->

            <script src="assets/js/lib/toastr/toastr.min.js"></script>
            <script src="assets/js/lib/toastr/toastr.init.js"></script>
     <!-- footer -->

     <script src="../vendor/autocomplete/src/jquery.autocompleter.min.js"></script>
     <script src="../vendor/autocomplete/main.js"></script>

     <script type="text/javascript">
     /**
      * Crayola colors in JSON format
      * from: https://gist.github.com/jjdelc/1868136
      */
     var colors =
     [
         {
             "label": "Healthcare Industry",
         },
         {
             "label": "Educational Industry",
         },
         {
             "label": "Manufacturing Industry",
         },
         {
             "label": "Finance Industry",
         },
         {
             "label": "Tourism Industry",
         },
         {
             "label": "Automotive Industry",
         },
         {
             "label": "Agriculture Industry",
         },
         {
             "label": "Retail Industry",
         },
         {
             "label": "NGO and Charity Industry",
         },
         {
             "label": "Restaurant Industry",
         },
         {
             "label": "Apparel Industry",
         },
         {
             "label": "Photography and Printing Industry",
         },
     ];

     $(function () {
       $('#industry').autocompleter({
             // marker for autocomplete matches
             highlightMatches: true,

             // object to local or url to remote search
             source: colors,

             // abort source if empty field
             empty: false,

             // max results
             limit: 5,

             callback: function (value, index, selected) {
                 if (selected) {
                     $('.icon').css('background-color', selected.hex);
                 }
             }
         });
     });



     </script>

     <script type="text/javascript">
         var types =
         [
             {
                 "label": "ERP Systems",
             },
             {
                 "label": "Brochure and Catalogue Systems",
             },
             {
                 "label": "Non-profit Systems",
              },
             {
                 "label": "Portal Systems",
             },
             {
                 "label": "ECommerce Systems",
             },
             {
                 "label": "Portfolio Systems",
             },
             {
                 "label": "HR Management Systems",
             },
             {
                 "label": "Inventory Management Systems",
             },
             {
                 "label": "Information Systems",
             },
         ];

         $(function () {
           $('#project_type').autocompleter({
                 // marker for autocomplete matches
                 highlightMatches: true,

                 // object to local or url to remote search
                 source: types,

                 // abort source if empty field
                 empty: false,

                 // max results
                 limit: 5,

                 callback: function (value, index, selected) {
                     if (selected) {
                         $('.icon').css('background-color', selected.hex);
                     }
                 }
             });
         });
     </script>

</body>

</html>
