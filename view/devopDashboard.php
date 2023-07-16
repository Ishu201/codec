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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
</head>

<body>


    <?php

    include('common/leadSidebar.php')
    ?>
    <!-- /# sidebar -->
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
                                <h1>Welcome <span>to Development Dashboard</span></h1>
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
                            $sql_emp = "SELECT * FROM projects WHERE status='ongoing'";
                            $result_emp = $con->query($sql_emp);
                            $count_emp = $result_emp->num_rows;
                            if ($count_emp <= 0) {
                              $count_emp = 0;
                            }
                          ?>

                          <div class="col-sm-3" style="padding:0px;">
        										<div class="card my">
        											<div class="card-body">
                                <div class="row">
        													<div class="col mt-0">
        														<h4 class="card-title">Total Projects</h4>
        													</div>
        													<div class="col-auto">
        														<div class="stat text" style="background-color:#2ACB91">
                                      <i class="ti-package new-widget align-middle" style="color:white;"></i>
        														</div>
        													</div>
        												</div>
                                <h2 class="mt-1 mb-3"><?php echo $count_emp; ?></h2>
        													<span class="text-muted">Systems in Development</span>
        											</div>
        											</div>
        										</div>

                          <?php
                            $sql_resource = "SELECT * FROM projects WHERE status='Completed'";
                            $result_resource = $con->query($sql_resource);
                            $count_res = $result_resource->num_rows;
                            if ($count_res <= 0) {
                              $count_res = 0;
                            }
                          ?>

        									<!-- second column -->
        									<div class="col-sm-3" style="padding:0px">
        										<div class="card my">
        											<div class="card-body">
                                <div class="row">
        													<div class="col mt-0">
        														<h5 class="card-title">Completed Projects</h5>
        													</div>

        													<div class="col-auto">
        														<div class="stat" style="background-color:#E74A3B">
        															<i class="ti-archive new-widget align-middle" style="color:white;"></i>
        														</div>
        													</div>
        												</div>
        												<h2 class="mt-1 mb-3"><?php echo $count_res; ?></h2>
        													<span class="text-muted">Fully Developed Systems</span>
        											</div>
        										</div>
                          </div>

                          <?php
                            $sql_emp = "SELECT * FROM employee WHERE deptID='3' AND empJobStatus='Working'";
                            $result_emp = $con->query($sql_emp);
                            $count_emp = $result_emp->num_rows;
                            if ($count_emp <= 0) {
                              $count_emp = 0;
                            }
                          ?>

                          <div class="col-sm-3" style="padding:0px;">
        										<div class="card my" >
        											<div class="card-body">
        												<div class="row">
        													<div class="col mt-0">
        														<h5 class="card-title">Available Developers</h5>
        													</div>

        													<div class="col-auto">
        														<div class="stat text" style="background-color:#F7C64A">
        															<i class="ti-user new-widget align-middle" style="color:white;"></i>
        														</div>
        													</div>
        												</div>
        												<h2 class="mt-1 mb-3"><?php echo $count_emp; ?></h2>
                                <!-- <div class="mb-0" style=""> -->
        													<span class="text-user">Employees in Development</span>
        												<!-- </div> -->
        											</div>
        										</div>
        									</div>

                          <?php
                            $sql_emp = "SELECT * FROM project_maintenance WHERE priority='1' AND stat='TODO'";
                            $result_emp = $con->query($sql_emp);
                            $count_emp = $result_emp->num_rows;
                            if ($count_emp <= 0) {
                              $count_emp = 0;
                            }
                          ?>

        									<div class="col-sm-3" style="padding:0px;">
        										<div class="card my">
        											<div class="card-body">
          												<div class="row">
          													<div class="col mt-0">
          														<h5 class="card-title">Immediate Tasks</h5>
          													</div>

          													<div class="col-auto">
          														<div class="stat text" style="background-color:#4E73DF;">
          															<i class="ti-files new-widget align-middle" style="color:white;"></i>
          														</div>
          													</div>
          												</div>
          												<h2 class="mt-1 mb-3"><?php echo $count_emp; ?></h2>
                                  <span class="text-muted">Incomplete Immediate Tasks</span>
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
                  $year = date('Y');
                  $sal = [];

                    for ($i=1; $i < 13; $i++) {
                      $month = $year.'-'.sprintf("%02d", $i);
                      $expo_amt = 0;
                        $sql_expo = "SELECT COUNT(projectID) FROM projects WHERE startDate LIKE '$month%'";
                        $result_expo = $con->query($sql_expo);
                          $row_expo = $result_expo->fetch_array();
                          $expo_amt = $row_expo[0];
                          $sal[] = $expo_amt;
                    }


                  ?>

                    <div class="row">
                        <div class="col-lg-8">
                          <div class="card">
                            <div class="card-title">
                              <h4>Projects Developed by CODEC</h4>
                            </div> <br>
                            <canvas id="bar-chart" ></canvas>
                          </div>

                          <script type="text/javascript">


                              var chartColors = {
                                color1:"#D1CDC9",
                                color2:"#9DAEB9",
                                color3:"#718795",
                                color4:"#2A3B57"
                              };

                              var myChart = new Chart(document.getElementById("bar-chart"), {
                                type: 'bar',
                                data: {
                                  labels: ["January",	"February",	"March",	"April",	"May",	"June",	"July","August",	"September","October","November","December"],
                                  datasets: [
                                    {
                                      label: "Projects ",
                                      backgroundColor: [chartColors.color1,chartColors.color1,chartColors.color1,chartColors.color1,chartColors.color1,chartColors.color1,chartColors.color1,chartColors.color1,chartColors.color1,chartColors.color1,],
                                      data: [<?php echo implode( ", ", $sal ); ?>]
                                    }
                                  ]
                                },
                                options: {
                                  legend: { display: false },
                                  title: {
                                    display: false,
                                    text: ''
                                  },
                                  scales:{
                                    xAxes: [{
                                      gridLines: {
                                        drawOnChartArea: false
                                      }
                                    }] ,
                                    yAxes: [{
                                      display: true,
                                      ticks: {
                                          beginAtZero: true,
                                          max: 10
                                      }
                                  }]
                                  }
                                }
                            });

                            var colorChangeValue = 50; //set this to whatever is the deciding color change value
                              var dataset = myChart.data.datasets[0];
                              for (var i = 0; i < dataset.data.length; i++) {
                                if (dataset.data[i] < 2) {
                                  dataset.backgroundColor[i] = chartColors.color1;
                                }
                                else if ((dataset.data[i] > 2) && (dataset.data[i] <= 5)){
                                  dataset.backgroundColor[i] = chartColors.color2;
                                }
                                else if ((dataset.data[i] > 5) && (dataset.data[i] <= 10)){
                                  dataset.backgroundColor[i] = chartColors.color3;
                                }
                                else{
                                 dataset.backgroundColor[i] = chartColors.color4;
                                }
                              }
                              myChart.update()

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
