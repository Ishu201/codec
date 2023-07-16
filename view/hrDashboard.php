<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string
include 'model/taskmodel.php';
//include '../model/commonmodel.php';
$ob = new dbconnection();
$con = $ob->connection();
//to display task list
$obj = new task;
$empID = $_SESSION['empID'];
$result = $obj->viewTask($empID);
?>

<?php
 if ($_SESSION['username'] != 'HR') {
   $msg = base64_encode('Please Log in to the system..!');
   header("Location:../index.php?msg=$msg");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('common/files.php') ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <link href="assets/css/app.css" rel="stylesheet">

    <style media="screen">
      .my{
        margin:15px;box-shadow:none;margin-right:5px;
      }
      .mb-3{
        padding-left: 8px !important;
      }
    </style>
</head>

<body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>


    <?php
     if ($_SESSION['username'] == 'HR') {
      include('common/HRsidebar.php');
    }
    ?>
    <!-- /# sidebar -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script type="text/javascript">
      document.getElementById('adminDash').className = 'active';
    </script>

    <?php include('common/header.php') ?>
    <!-- head bar -->
    <?php include('src\dashboardAlert.php') ?>


    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Welcome <span>to HR Dashboard</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item myactive">Home</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->
                <section id="main-content">

                  <div class="row">
        						<div class="col-xl-12 col-xxl-12 d-flex" >
        							<div class="w-100">
        								<div class="row">
        									<!-- first column -->
                          <?php
                            $sql_emp = "SELECT * FROM employee WHERE empJobStatus='Working'";
                            $result_emp = $con->query($sql_emp);
                            $count_emp = $result_emp->num_rows;
                            if ($count_emp <= 0) {
                              $count_emp = 0;
                            }
                          ?>

                          <div class="col-sm-4" style="padding:0px;">
        										<div class="card my">
        											<div class="card-body">
                                <div class="row">
        													<div class="col mt-0">
        														<h4 class="card-title">Total Employees</h4>
        													</div>
        													<div class="col-auto">
        														<div class="stat text" style="background-color:#2ACB91">
                                      <i class="ti-user new-widget align-middle" style="color:white;"></i>
        														</div>
        													</div>
        												</div>
                                <h2 class="mt-1 mb-3"><?php echo $count_emp; ?></h2>
        													<span class="text-muted">Working Employees</span>
        											</div>
        											</div>
        										</div>

                          <?php
                            // $sql_resource = "SELECT SUM(value) FROM item";
                            // $result_resource = $con->query($sql_resource);
                            // $rowcc = $result_resource->fetch_array();
                            // $count_res = $rowcc[0];
                            // if ($count_res <= 0) {
                            //   $count_res = 0;
                            // }
                          ?>

        									<!-- second column -->
        									<!-- <div class="col-sm-3" style="padding:0px">
        										<div class="card my">
        											<div class="card-body">
                                <div class="row">
        													<div class="col mt-0">
        														<h5 class="card-title">Company Resources</h5>
        													</div>

        													<div class="col-auto">
        														<div class="stat" style="background-color:#E74A3B">
        															<i class="ti-money new-widget align-middle" style="color:white;"></i>
        														</div>
        													</div>
        												</div>
        												<h4 class="mt-1 mb-3">Rs.<?php //echo number_format($count_res,2); ?></h4>
                                <div class="mb-0" style="padding-top:8px;">
        													<span class="text-muted">Net worth</span>
        												</div>
        											</div>
        										</div>
                          </div> -->

                          <?php
                            $sql_emp = "SELECT * FROM employee_loans WHERE hrRemark=''";
                            $result_emp = $con->query($sql_emp);
                            $count_emp = $result_emp->num_rows;
                            if ($count_emp <= 0) {
                              $count_emp = 0;
                            }
                          ?>

                          <div class="col-sm-4" style="padding:0px;">
        										<div class="card my" >
        											<div class="card-body">
        												<div class="row">
        													<div class="col mt-0">
        														<h5 class="card-title">Loan Applications</h5>
        													</div>

        													<div class="col-auto">
        														<div class="stat text" style="background-color:#F7C64A">
        															<i class="ti-link new-widget align-middle" style="color:white;"></i>
        														</div>
        													</div>
        												</div>
        												<h2 class="mt-1 mb-3"><?php echo $count_emp; ?></h2>
                                <!-- <div class="mb-0" style=""> -->
        													<span class="text-muted">Applications to Review</span>
        												<!-- </div> -->
        											</div>
        										</div>
        									</div>

                          <?php
                            $sql_emp = "SELECT * FROM leave_requests WHERE status='Pending'";
                            $result_emp = $con->query($sql_emp);
                            $count_emp = $result_emp->num_rows;
                            if ($count_emp <= 0) {
                              $count_emp = 0;
                            }
                          ?>

        									<div class="col-sm-4" style="padding:0px;">
        										<div class="card my">
        											<div class="card-body">
          												<div class="row">
          													<div class="col mt-0">
          														<h5 class="card-title">Leave Applications</h5>
          													</div>

          													<div class="col-auto">
          														<div class="stat text" style="background-color:#4E73DF;">
          															<i class="ti-files new-widget align-middle" style="color:white;"></i>
          														</div>
          													</div>
          												</div>
          												<h2 class="mt-1 mb-3"><?php echo $count_emp; ?></h2>
                                  <span class="text-muted">Pending Leave Applications</span>
        											</div>
        										</div>
                          </div>


        								</div>
        							</div>
        						</div>

        						<div class="col-xl-7 col-xxl-7"> <br>
                      <div class="card" >
                          <div class="card-title">
                              <h4>Notice Board </h4>
                              <?php
                              function get_time_ago( $time ) {
                                  $time_difference = time() - $time;

                                  if( $time_difference < 1 ) { return 'less than 1 second ago'; }
                                  $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                                              30 * 24 * 60 * 60       =>  'month',
                                              24 * 60 * 60            =>  'day',
                                              60 * 60                 =>  'hour',
                                              60                      =>  'minute',
                                              1                       =>  'second'
                                  );

                                  foreach( $condition as $secs => $str )
                                  {
                                      $d = $time_difference / $secs;

                                      if( $d >= 1 )
                                      {
                                          $t = round( $d );
                                          return 'About ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' Ago';
                                      }
                                  }
                              }

                               ?>
                          </div>

                          <div class="recent-comment m-t-15">
                            <?php
                            $sql_notice = "SELECT * FROM notice ORDER BY date DESC";
                            $result_notice = $con->query($sql_notice);
                            while ($rowc_notice = $result_notice->fetch_array()) {
                              $sender = $rowc_notice['sender'];
                              $type = $rowc_notice['type'];
                              if (($type == 'all') or ($type == 'allcompany') or ($type == $empID)) {
                             ?>
                              <div class="media">
                                  <div class="media-left">
                                    <?php
                                      if ($sender == '1') {
                                        echo '<img class="media-object" src="../res/images/adminlog.jpg">';
                                        $name = 'Admin';
                                      } else if ($sender == '2') {
                                        echo '<img class="media-object" src="../res/images/acclog.png">';
                                        $name = 'Account Department';
                                      } else if ($sender == '3') {
                                        echo '<img class="media-object" src="../res/images/hrlog.png">';
                                        $name = 'HR Department';
                                      } else if ($sender == '4') {
                                        echo '<img class="media-object" src="../res/images/devlog.png">';
                                        $name = 'Development Department';
                                      }
                                    ?>
                                  </div>
                                  <div class="media-body">
                                      <h4 class="media-heading "><?php echo $name; ?></h4>
                                      <p><?php echo $rowc_notice['notice_text'] ?></p>
                                      <p class="comment-date"><?php $date = $rowc_notice['date']; echo get_time_ago( strtotime($date) ); ?></p>
                                  </div>
                              </div>
                            <?php } } ?>

                          </div>
                      </div>
        						</div>
                    <div class="col-lg-5"> <br>
                      <div class="card"  >
                          <div class="card-title">
                              <h4>Tasks</h4>

                          </div>
                          <div class="todo-list">
                              <div class="tdl-holder">
                                  <div class="">
                                      <ul>
                                        <?php
                                          while ($row = $result->fetch_array()) {
                                        ?>
                                          <li>
                                              <label>
                                                <form class="" action="controller/taskcontroller.php?status=update" method="post">
                                                  <input type="hidden" name="taskID" value="<?php echo $row['taskID']; ?>">
                                                  <?php if ($row['stat'] == 'todo') { ?>
                                                    <input type="checkbox" onChange="this.form.submit()"><i></i>
                                                    <span><?php echo $row['task']; ?></span>
                                                  <?php } else if ($row['stat'] == 'Completed'){ ?>
                                                      <input type="checkbox" onChange="this.form.submit()" checked><i></i>
                                                      <span style="text-decoration:linethrough"><?php echo $row['task']; ?></span>
                                                  <?php } ?>
                                                  <a href="controller/taskcontroller.php?status=remove&id=<?php echo $row['taskID']; ?>" >x</a>
                                                </form>
                                              </label>
                                          </li>
                                        <?php
                                          }
                                        ?>
                                      </ul>
                                  </div>
                                  <form action="controller/taskcontroller.php?status=add" method="post">
                                    <input type="hidden" name="empID" value="<?php echo $empID; ?>">
                                    <input type="text" class="form-control" name="task"
                                        placeholder="Write new item and hit 'Enter'...">
                                        <input type="submit"  value="Add" style="visibility:hidden">
                                  </form>
                              </div>
                          </div>
                      </div>
                    </div>
        					</div>


                  <?php
                  $date_get = date('Y-m');
                  // $date_get = '2022-08';
                  $array_working = [];
                  $array_authorized_leaves = [];
                  $array_unauthorized_leaves = [];
                  $month_days=[];

                    $date = $date_get.'-01';
                    $end = $date_get.'-' . date('t', strtotime($date)); //get end date of month

                     while(strtotime($date) <= strtotime($end)) {
                        $day_num = date('d', strtotime($date));
                        $day_name = date('l', strtotime($date));
                        $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                        $check_date = $date_get.'-'.$day_num;
                        $month_days[] = $day_num ;

                        $sql_attendace = "SELECT * FROM attendance_exported_table WHERE date='$check_date'";
                          $result_attendace = $con->query($sql_attendace);
                          $rowcount1 = mysqli_num_rows($result_attendace);

                          if ($rowcount1 < 0) {
                            $array_working[] = 0;
                            $array_authorized_leaves[] = 0;
                            $array_unauthorized_leaves[] = 0;
                          }

                          else{
                            $sql_attendace2 = "SELECT * FROM attendance_exported_table WHERE date ='$check_date' AND status='On'";
                              $result_attendace2 = $con->query($sql_attendace2);
                              $rowcount2 = mysqli_num_rows($result_attendace2);

                              if ($rowcount2 > 0) {
                                $array_working[] = $rowcount2;
                              }
                              else{
                                $array_working[] = 0;
                              }

                               $sql_attendace3 = "SELECT * FROM attendance_exported_table WHERE date ='$check_date' AND status='Off'";
                                $result_attendace3 = $con->query($sql_attendace3);
                                $count_au = 0;
                                $count_unau = 0;
                              //
                                while ($row_atts = $result_attendace3->fetch_array()) {
                                  $mid = $row_atts['machineID'];
                                  $sql_empd = "SELECT * FROM employee  WHERE machineID='$mid'";
                                  $result_empd = $con->query($sql_empd);
                                  $row_empd = $result_empd->fetch_array();

                                  $empID = $row_empd['empID'];

                                  $sql_leaves = "SELECT * FROM leave_requests WHERE `empID`='$empID' AND `status`='Approved' AND `leave`='Yes'";
                                  $result_leaves = $con->query($sql_leaves);
                                  $row_leaves = $result_leaves->fetch_array();
                                  $rowcount3 = mysqli_num_rows($result_leaves);

                                  $c_date = $check_date;

                                    if ($rowcount3 > 0) {
                                      $start = $row_leaves['startDate'];
                                      $end_lev = $row_leaves['endDate'];

                                        if ($start == $end_lev) {
                                          if ($c_date == $start){
                                            $count_au = $count_au+ 1;
                                          }else{
                                            $count_unau = $count_unau + 1;
                                          }
                                        }

                                        else{
                                          $final = 0;
                                          $period = new DatePeriod(
                                               new DateTime($start),
                                               new DateInterval('P1D'),
                                               new DateTime($end_lev)
                                          );

                                          foreach ($period as $key => $value) {
                                            $cdate = $value->format('Y-m-d');
                                            if ($cdate == $c_date) {
                                              $final = 1;
                                            }
                                          }

                                          if ($final == 0) {
                                            $count_unau = $count_unau + 1;
                                          } else {
                                             $count_au = $count_au+ 1;
                                          }

                                        }

                                      //
                                    } else{
                                      $count_unau = $count_unau + 1;
                                    }
                                } //end of while stat=off rows
                              //
                                $array_authorized_leaves[] = $count_au;
                                $array_unauthorized_leaves[] = $count_unau;
                          }

                     }

              ?>


                    <div class="row">
                        <div class="col-lg-8"> <br>
                          <div class="card">
                            <div class="card-title">
                              <h4>Employee Attendance - <?php echo date('F'); ?></h4>
                            </div>
                            <canvas id="myChart" ></canvas>
                          </div>

                          <script type="text/javascript">
                          var ctx = document.getElementById("myChart").getContext('2d');
                          var myChart = new Chart(ctx, {
                              type: 'line',
                              data: {
                                labels: [<?php echo implode( ", ", $month_days ); ?>],
                                datasets: [{
                                    label: 'Authorized Leaves',
                                    backgroundColor: "#008d93",
                                    borderColor: "#008d93",
                                    data: [<?php echo implode( ", ", $array_authorized_leaves ); ?>],
                                    fill:true
                                  },{
                                    label: 'No Pay Leaves',
                                    backgroundColor: "#E2D784",
                                    borderColor: "#E2D784",
                                    data: [<?php echo implode( ", ", $array_unauthorized_leaves ); ?>],
                                    fill:true
                                  },{
                                      label: 'Onduty Employees',
                                      backgroundColor: "rgb(46,84,104,.5)",
                                      borderColor: "#2e5468",
                                      data: [<?php echo implode( ", ", $array_working ); ?>],
                                      fill:true
                                    }],
                              },
                            options: {
                              title: {
                                  display: false,
                                  text: 'World population per region (in millions)'
                                },
                                scales:{
                                  xAxes: [{
                                    gridLines: {
                                      drawOnChartArea: false,
                                      max:40
                                    }
                                  }],
                                  yAxes: [{
                                    display: true,
                                    ticks: {
                                        beginAtZero: true,
                                        steps: 5,
                                        stepValue: 5,
                                        max: 40
                                    }
                                }]
                                }
                              }
                            });
                          </script>
                        </div>

                        <div class="col-lg-4"> <br><br>
                          <div class="card">
                              <div class="card-body">
                                  <div class="year-calendar"></div>
                              </div>
                          </div>
                        </div>

                    </div>



              <?php include('common/footer.php') ?>
              <!-- footer -->
</body>

</html>
