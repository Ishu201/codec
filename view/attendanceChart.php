<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string
//include '../model/commonmodel.php';
$ob = new dbconnection();
$con = $ob->connection();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('common/files.php') ?>
    <link rel="stylesheet" href="assets/css/pagination.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

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
        margin-top:40px;
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


    </style>
</head>

<body>

    <?php include('common/sidebar.php') ?>
    <!-- /# sidebar -->
    <script type="text/javascript">
      document.getElementById('attendance').className = 'active open';
      document.getElementById('attChart').className = 'active';
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
                                <h1>Analyzing Monthly Employee Attendance</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Attendance</a></li>
                                    <li class="breadcrumb-item myactive">Attendance Chart</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>

                <!-- /# row -->
                <section id="main-content">
                  <div class="row">
                    <div class="col-lg-5 col-sm-12">
                      <div class="card">
                        <div class="card-title">
                            <h4>Select Required Month</h4>
                        </div>
                        <form class="" >
                          <div class="row">
                            <div class="col-lg-8">
                              <div class="form-group">
                                  <label>Month <span style="color:red">*</span></label>
                                  <input type="month"  class="form-control" value="<?php  echo $_REQUEST['month']; ?>" max="<?php echo date('Y-m'); ?>" name="month" onchange="this.form.submit();" placeholder="Select the Month" required>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div> <br><br>

                    <?php if (isset($_REQUEST['month'])) {
                        $date_get = $_REQUEST['month'];
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
                    <div class="col-lg-12 col-sm-12">
                      <div class="card">
                        <div class="card-title" >
                            <h4>Employee Attendance and Leaves - <?php
                            $month = $_REQUEST['month'];
                            $mon = DateTime::createFromFormat("Y-m" , $month);
                            echo $mon->format('Y-F'); ?></h4>
                        </div>
                        <br>
                        <div>
                          <canvas id="myChart" style="width:100%;height:20px;"></canvas>
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
                                			data: [<?php echo implode( ", ", $array_working ); ?>,40],
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
                                      drawOnChartArea: false
                                    }
                                  }]
                                }
                            	}
                            });
                          </script>
    										</div>
                      </div>
                    </div>
                  <?php } ?>
                  </div>


      <?php include('common/footer.php') ?>
     <!-- footer -->
     <?php include('common/tableExport.php') ?>

</body>

</html>
