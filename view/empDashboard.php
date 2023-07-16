<!DOCTYPE html>
<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string
//include '../model/commonmodel.php';
$ob = new dbconnection();
$con = $ob->connection();
?>

<?php include('common/logcheck.php'); ?>

<html lang="en">

<head>
    <?php
    include('common/files.php') ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <style media="screen">
      .toast-error {
        background-color: rgb(255,166,0,.5) !important;
        text-align:center !important;
        color:#994d00 !important
      }
      #toast-container > div.toast {
        background-image: none !important;
    }
    </style>
</head>

<body>

    <?php
      include('common/empSidebar.php') ;

    ?>
    <!-- /# sidebar -->
    <script type="text/javascript">
      document.getElementById('adminDash').className = 'active';
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
                                <h1>Welcome <span>to Employee Dashboard</span></h1>
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

                  <?php
                  $date_empData = date('Y-m-d');
                    $sql_empData = "SELECT * FROM employee WHERE empID='$session_empID'";
                    $result_empData = $con->query($sql_empData);
                    $row_empData = $result_empData->fetch_array();
                    $time = '00:00:00';

                    $time1 = $row_empData['shiftStart'];
                    $time2 = $row_empData['shiftEnd'];

                    function timeDiff($firstTime,$lastTime) {
                      $a_split = explode(":", $firstTime);
                      $b_split = explode(":", $lastTime);
                      $a_stamp = mktime($a_split[0], $a_split[1]);
                      $b_stamp = mktime($b_split[0], $b_split[1]);
                      if($a_stamp > $b_stamp)
                      {
                          $diff = $a_stamp - $b_stamp; //69600
                      }else{
                          $diff = $b_stamp - $a_stamp; //69600
                      }
                      $min = gmdate("i", $diff);
                      $d_hours = gmdate("d", $diff)==1 ? 0 :  gmdate("d", $diff)*12 ;
                      $hours = $d_hours + gmdate("H", $diff) ;
                      $hours = sprintf("%02d", $hours);
                      echo $hours . ':' . $min; // 56:12:12
                    }


                  ?>

                  <script type="text/javascript">
                  $(document).ready(function() {
                    setInterval(timestamp, 1000);
                  });

                  function timestamp() {
                    $.ajax({
                        url: 'operation/timestamp.php?shift=<?php echo $time1; ?>',
                        success: function(data) {
                            $('#timestamp').html(data);
                        },
                    });
                  }
                  </script>

                  <?php
                    $today = date('Y-m-d');
                    $sql_time = "SELECT * FROM leave_requests WHERE empID='$session_empID' AND date='$today' AND status='Approved'";
                    $result_time = $con->query($sql_time);
                    $count_time = $result_time->num_rows;

                    if (($count_time > 0) or (date('l') == 'Sunday')) {
                      $workstat = '<button type="button" class="btn btn-sm btn-danger" name="button">On Leave</button>';
                      if (date('l') == 'Sunday') {
                        $workstat = '<button type="button" class="btn btn-sm btn-danger" name="button">Sunday</button>';
                      }
                      ?>
                        <script type="text/javascript">
                        $(document).ready(function() {
                          $('#timestamp2').show();
                          $('#timestamp').hide();
                        });

                        </script>
                      <?php
                    } elseif($count_time <= 0){
                      $workstat = '<button type="button" class="btn btn-sm btn-info" name="button">On Duty</button>';
                      ?>
                        <script type="text/javascript">
                        $(document).ready(function() {
                          $('#timestamp').show();
                          $('#timestamp2').hide();
                        });

                        </script>
                      <?php
                    }
                  ?>

                    <div class="row">
                      <div class="col-lg-4">
                        <div class="card" style="padding:0px;">
                            <div class="card-title" style="background-color:#e6e6e6;padding:5px;padding-left:10px">
                                <h4>Work Log</h4>
                            </div>
                            <div class="row" style="padding:10px">
                              <div class="col-lg-7" style="padding-left:25px;">
                                <div class="card-title" style="margin-bottom:20px">
                                    <p style="font-size:18px;text-transform:uppercase;margin-bottom:0px"><?php echo date('l'); ?></p>
                                    <p style="font-size:16px;margin-top:0px"><?php echo date('F d, Y'); ?></p>
                                </div>
                                <h1 style="font-size:55px;color:#00b386;margin-bottom:0px;" id="timestamp"></h1>
                                <h1 style="font-size:55px;color:#00b386;margin-bottom:0px;" id="timestamp2">00:00:00</h1>
                                <p style="font-size:15px;margin-top:0px">Total Work Time</p>
                                <br>
                                <?php echo $workstat; ?>
                              </div>

                              <div class="col-lg-5">
                              <div style="margin-left:20%;font-weight:bold">
                                <p style="font-size:15px;margin:2px;">Shift Start Time :</p>
                                <p style="font-size:15px;margin:2px;color:#F01C7A;"><?php if(date('l') == 'Sunday') { echo '00:00'; } else{ echo $row_empData['shiftStart']; }  ?>:00</p>
                                <p style="font-size:15px;margin:2px;margin-top:15px">Total Work Time :</p>
                                <p style="font-size:15px;margin:2px;color:#429AD0;"><?php  if(date('l') == 'Sunday') { echo '00:00'; } else if(date('l') == 'Saturday') { echo '06:00'; } else{ timeDiff($time1 ,$time2); } ?> Hrs</p>
                                <p style="font-size:15px;margin:2px;margin-top:15px">Shift End Time :</p>
                                <p style="font-size:15px;margin:2px;color:#F69420;"><?php  if(date('l') == 'Sunday') { echo '00:00'; } else if(date('l') == 'Saturday') { echo '02:00'; } else{ echo $row_empData['shiftEnd']; } ?>:00</p>
                              </div>

                              </div>
                            </div>
                          </div>
                          <?php if ($row_empData['userType'] == 'Team') {  ?>
                          <div class="card" style="background-color:#6D9197">
                            <center>
                            <h4 style="color:white">Developer Account</h4>
                          </center>
                          </div>
                        <?php } else{ ?>
                          <div class="card" style="background-color:#9D98AE">
                            <center>
                            <h4 style="color:white">Employee Account</h4>
                          </center>
                          </div>
                        <?php } ?>
                      </div>

                      <?php
                      $mID = $row_empData['machineID'];
                      $year = date('Y');
                      $sal = [];
                        for ($i=1; $i < 13; $i++) {
                          $month = $year.'-'.sprintf("%02d", $i);
                          $expo_amt = 0;
                            $sql_expo = "SELECT COUNT(ID) FROM attendance_exported_table WHERE machineID='$mID' AND date LIKE '$month%' AND status='On'";
                            $result_expo = $con->query($sql_expo);
                              $row_expo = $result_expo->fetch_array();
                              $expo_amt = $row_expo[0];
                              $sal[] = $expo_amt;
                        }
                      ?>

                      <div class="col-lg-8">
                        <div class="card" style="height:395px">
                          <div class="card-title" style="margin-bottom:7px">
                            <h4>Attendance - <?php echo date('Y'); ?></h4>
                          </div>
                          <canvas id="bar-chart" style="height:280px;" ></canvas>
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
                                datasets: [ {
                                    type: 'bar',
                                    label: "Days -",
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
                                  yAxes: [{
                                    display: true,
                                    ticks: {
                                        beginAtZero: true,
                                        max: 30
                                    }
                                }]
                                }
                              }
                          });

                          var colorChangeValue = 50; //set this to whatever is the deciding color change value
                            var dataset = myChart.data.datasets[0];
                            for (var i = 0; i < dataset.data.length; i++) {
                              if (dataset.data[i] < 15) {
                                dataset.backgroundColor[i] = chartColors.color1;
                              }
                              else if ((dataset.data[i] > 15) && (dataset.data[i] <= 20)){
                                dataset.backgroundColor[i] = chartColors.color2;
                              }
                              else if ((dataset.data[i] > 20) && (dataset.data[i] <= 25)){
                                dataset.backgroundColor[i] = chartColors.color3;
                              }
                              else{
                               dataset.backgroundColor[i] = chartColors.color4;
                              }
                            }
                            myChart.update()

                        </script>
                      </div>

                      </div>
                    </div>


                    <div class="row"  style="padding-right:10px;padding-left:10px">
                      <?php
                        $sql0 = "SELECT SUM(days),SUM(used) FROM employee_leaves WHERE empID ='$session_empID' AND stat='On'";
                         $result0 = $con->query($sql0);
                         $row0 = $result0->fetch_array();
                         $count_rem = $row0[0]-$row0[1];
                      ?>
                      <div class="col-lg-4">
                        <div class="card p-0">
                          <div class="stat-widget-three">
                            <div class="stat-icon bg-primary" style="padding:25px;background-color:#EBAF48 !important">
                              <i class="material-icons" style="font-size:45px;">local_mall</i>
                            </div>
                            <div class="stat-content">
                              <div class="stat-digit"><?php echo $count_rem; ?></div>
                              <div class="stat-text">Remaining Leaves</div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <?php
                        $sql1 = "SELECT * FROM `employee_loans` WHERE empID='$session_empID' AND status='Approved'";
                        $result1 = $con->query($sql1);
                        $row1 = $result1->fetch_array();
                        $count1 = $result1->num_rows;
                      ?>
                      <div class="col-lg-4">
                        <div class="card p-0">
                          <div class="stat-widget-three">
                            <div class="stat-icon bg-success" style="padding:25px;background-color:#20376B !important">
                              <i class="material-icons" style="font-size:45px;">monetization_on</i>
                            </div>
                            <div class="stat-content">
                              <div class="stat-digit"><?php echo $count1; ?></div>
                              <div class="stat-text">Personal Loans</div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <?php
                        $sql2 = "SELECT * FROM `disciplinary` WHERE empID='$session_empID' AND status='On'";
                        $result2 = $con->query($sql2);
                        $row2 = $result2->fetch_array();
                        $count2 = $result2->num_rows;
                      ?>
                      <div class="col-lg-4">
                        <div class="card p-0">
                          <div class="stat-widget-three">
                            <div class="stat-icon bg-danger" style="padding:25px;background-color:#AF3559 !important">
                              <i class="material-icons" style="font-size:45px;">warning</i>
                            </div>
                            <div class="stat-content">
                              <div class="stat-digit"><?php echo $count2; ?></div>
                              <div class="stat-text">Desciplinary Notes</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>


                    <?php if ($row_empData['userType'] == 'Team') {  ?>
                    <div class="row" style="padding-right:10px;padding-left:10px">

                      <?php
                        $proj = [];
                        $grand_total = 0;
                          for ($i=1; $i < 13; $i++) {
                            $month = $year.'-'.sprintf("%02d", $i);
                            $assign_proj = 0;
                              $sql_proj = "SELECT * FROM project_members WHERE empID='$session_empID' AND fromdate LIKE '$month%' GROUP BY projectID";
                              $result_proj = $con->query($sql_proj);
                                $count4 = $result_proj->num_rows;

                              $sql_mtc = "SELECT * FROM `project_maintenance` WHERE empID='$session_empID' AND date LIKE '$month%' GROUP BY projectID";
                              $result_mtc = $con->query($sql_mtc);
                                $count5 = $result_mtc->num_rows;

                                $assign_proj = $count4+$count5;
                                $proj[] = $assign_proj;

                                $thisMon = date('m');
                                if ($i == $thisMon) {
                                  $totAssigned_proj = $assign_proj;
                                }
                          }


                          $points = [];
                            for ($i=1; $i < 13; $i++) {
                              $month = $year.'-'.sprintf("%02d", $i);
                              $assign_point = 0;
                                $sql_point = "SELECT * FROM project_members WHERE empID='$session_empID' AND fromdate LIKE '$month%' GROUP BY projectID";
                                $result_point = $con->query($sql_point);
                                  $count_projPoint = $result_point->num_rows;
                                  $proj_val = $count_projPoint * 40;

                                $sql_mtcpoint = "SELECT SUM(points) FROM `project_maintenance` WHERE empID='$session_empID' AND date LIKE '$month%'";
                                $result_mtcpoint = $con->query($sql_mtcpoint);
                                $row_mtcpoint = $result_mtcpoint->fetch_array();
                                  $assign_point = $row_mtcpoint[0]+ $proj_val;
                                  $points[] = number_format($assign_point,2);

                                  if ($i == $thisMon) {
                                    $totAssigned_points = $assign_point;
                                  }
                            }

                      ?>
                      <div class="col-lg-3">
                        <div class="card nestable-cart">
                          <div class="row">
                            <div class="col-lg-7" >
                              <div class="card-title">
                                <h4 style="color:#6C757E !important">Assigned Projects </h4>
                              </div>
                              <h3 style="color:#6C757E !important"><?php echo $totAssigned_proj; ?></h3>
                              <span style="margin-top:15px"><?php echo date('F Y'); ?></span>
                            </div>
                            <div class="col-lg-5" style="padding-left:0px !important;"> <br>
                              <div class="sparkline-unix">
                                <span id="sparklinedash4" style="width:250px !important;height:250px !important"> </span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <script type="text/javascript">
                      $(document).ready(function() {
                      	"use strict";

                        $('#sparklinedash4').sparkline([ <?php echo implode( ", ", $proj ); ?>], {
                            type: 'bar',
                            height: '50',
                            barWidth: '6',
                            resize: true,
                            barSpacing: '5',
                            barColor: '#fb9678',
                        });
                          $('#sparklinedash41').sparkline([ <?php echo implode( ", ", $points ); ?>], {
                              type: 'bar',
                              height: '50',
                              barWidth: '6',
                              resize: true,
                              barSpacing: '5',
                              barColor: '#00cc99',
                          });
                          var sparkResize;

                          $(window).resize(function(e) {
                              clearTimeout(sparkResize);
                              sparkResize = setTimeout(sparklineLogin, 500);
                          });
                          sparklineLogin();

                      });
                      </script>

                      <?php
                      $month1 = date('Y-m');
                      $sql_todo = "SELECT * FROM `project_maintenance` WHERE empID='$session_empID' AND dueDate LIKE '$month1%' AND stat='TODO'";
                      $result_todo = $con->query($sql_todo);
                      $count_todo = $result_todo->num_rows;
                      if ($count_todo <= 0) {
                        $count_todo = 0;
                      }

                      $sql_completed = "SELECT * FROM `project_maintenance` WHERE empID='$session_empID' AND dueDate LIKE '$month1%' AND stat='completed'";
                      $result_completed = $con->query($sql_completed);
                      $count_completed = $result_completed->num_rows;
                      if ($count_completed <= 0) {
                        $count_completed = 0;
                      }

                       $total = $count_todo + $count_completed;
                       if ($total != 0) {
                         $todo_val = ($count_completed/$total)*100;
                       }


                      ?>

                      <div class="col-lg-3">
                        <div class="card nestable-cart">
                          <div class="row">
                            <div class="col-lg-6" >
                              <div class="card-title">
                                <h4 style="color:#6C757E !important">Project Tasks </h4>
                              </div>
                              <h3 style="color:#6C757E !important"><?php echo $total; ?></h3>
                              <span style="margin-top:15px">Completed - <?php echo $count_completed ?></span>
                            </div>
                            <div class="col-lg-6">
                              <i class="material-icons" style="font-size:40px;float:right;color:#20376B">event_note</i> <br><br><br> <br>
                              <div class="progress" style="height:4px;">
                                <div class="progress-bar" style="height:4px;background-color:#20376B;width:<?php echo $todo_val; ?>%"  role="progressbar"  aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-3">
                        <div class="card nestable-cart">
                          <div class="row">
                            <div class="col-lg-7" >
                              <div class="card-title">
                                <h4 style="color:#6C757E !important">Earned Points </h4>
                              </div>
                              <h3 style="color:#6C757E !important"><?php echo number_format($totAssigned_points,2); ?></h3>
                              <span style="margin-top:15px"><?php echo date('F Y'); ?></span>
                            </div>
                            <div class="col-lg-5" style="padding-left:0px !important;"> <br>
                              <div class="sparkline-unix">
                                <span id="sparklinedash41" style="width:240px !important;height:250px !important;"> </span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <?php
                        $grand_total = 0;
                        $sql_proj1 = "SELECT * FROM project_members WHERE empID='$session_empID' GROUP BY projectID";
                        $result_proj1 = $con->query($sql_proj1);
                          $countproj = $result_proj1->num_rows;

                        $sql_mtc1 = "SELECT * FROM `project_maintenance` WHERE empID='$session_empID' GROUP BY projectID";
                        $result_mtc1 = $con->query($sql_mtc1);
                          $countMtc = $result_mtc1->num_rows;

                        $grand_total = $countproj + $countMtc;

                      ?>

                      <div class="col-lg-3">
                        <div class="card nestable-cart">
                          <div class="row">
                            <div class="col-lg-8" >
                              <div class="card-title">
                                <h4 style="color:#6C757E !important">Completed Projects </h4>
                              </div>
                              <h3 style="color:#6C757E !important"><?php echo $grand_total; ?></h3>
                              <span style="margin-top:15px">Total Worked Projects</span>
                            </div>
                            <div class="col-lg-4">
                              <i class="material-icons" style="font-size:40px;float:right;color:#bf4080">public</i> <br><br><br> <br>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>


                    <div class="row" style="padding:10px">
                        <div class="col-lg-7">
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
                                   if ($type == 'all') {
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

                        <div class="col-lg-5">
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
