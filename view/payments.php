<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string
// include 'model/departmentmodel.php';

$ob = new dbconnection();
$con = $ob->connection();
//to display task list

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('common/files.php') ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
</head>
<body>

    <?php include('common/sidebar.php') ?>
    <!-- /# sidebar -->
    <script type="text/javascript">
      document.getElementById('payments').className = 'active open';
      document.getElementById('payChart').className = 'active';
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
                                <h1>Analyzing Employee Salary Payments</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Employee Payments</a></li>
                                    <li class="breadcrumb-item myactive">Payments</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>

                <?php
                $year = date('Y');
                $sal = [];
                $loan = [];

                  for ($i=1; $i < 13; $i++) {
                    $month = $year.'-'.sprintf("%02d", $i);
                    $salary_amt = 0;
                    $loan_amt = 0;
                      $sql_salary = "SELECT * FROM salary_master WHERE month LIKE '$month%'";
                      $result_salary = $con->query($sql_salary);
                        while ($row_salary = $result_salary->fetch_array()) {
                          $salary_amt = $salary_amt + $row_salary['net_salary'];
                          $loan_amt = $loan_amt + $row_salary['loans'];
                        }
                    $sal[] = $salary_amt;
                    $loan[] = $loan_amt;
                  }



                ?>

                <!-- /# row -->
                <section id="main-content">
                  <div class="row">
                    <div class="col-lg-12 col-sm-12">
                      <div class="card">
                        <div class="card-title" >
                            <h4>Employee Payments in 2022</h4>
                        </div> <br>
                        <div>
                          <canvas id="myChart" style="width:100%;height:480px;"></canvas>
													<script type="text/javascript">
                          var ctx = document.getElementById("myChart").getContext('2d');
                          var myChart = new Chart(ctx, {
                            	type: 'bar',
                            	data: {
                            		labels: ["January",	"February",	"March",	"April",	"May",	"June",	"July","August",	"September","October","November","December"],
                            		datasets: [{
                              			 label: 'Employee Salary Payments Rs.',
                                     data: [<?php echo implode( ", ", $sal ); ?>,1000000],
                                     fill: true,
                                     backgroundColor: '#5591A9'
                              		}],
                            	},
                            options: {
                                tooltips: {
                                  displayColors: true,
                                  callbacks:{
                                    mode: 'x',
                                  },
                                },
                                scales: {
                                  xAxes: [{
                                    stacked: false,
                                    gridLines: {
                                      display: false,
                                    }
                                  }],
                                  yAxes: [{
                                    stacked: false,
                                    ticks: {
                                      beginAtZero: true,
                                    },
                                    type: 'linear',
                                  }]
                                },
                            		responsive: true,
                            		maintainAspectRatio: false,
                            		legend: { position: 'top' },
                            	}
                            });
                          </script>
    										</div>
                      </div>
                    </div>
                  </div>


      <?php include('common/footer.php') ?>
     <!-- footer -->

</body>

</html>
