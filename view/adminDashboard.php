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
 if ($_SESSION['username'] != 'Admin') {
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


    <?php
    include('common/sidebar.php')
    ?>
    <!-- /# sidebar -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
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
                                <h1>Welcome <span>to Admin Dashboard</span></h1>
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
                    $sql_emp = "SELECT * FROM employee WHERE empJobStatus='Working'";
                    $result_emp = $con->query($sql_emp);
                    $count_emp = $result_emp->num_rows;
                    if ($count_emp <= 0) {
                      $count_emp = 0;
                    }
                  ?>

                  <div class="row">
        						<div class="col-xl-5 col-xxl-5 d-flex" >
        							<div class="w-100">
        								<div class="row">
        									<!-- first column -->
        									<div class="col-sm-6" style="padding:0px;">
        										<div class="card my">
        											<div class="card-body">
          												<div class="row">
          													<div class="col mt-0">
          														<h5 class="card-title">Total Employees</h5>
          													</div>

          													<div class="col-auto">
          														<div class="stat text" style="background-color:#4E73DF;">
          															<i class="ti-user new-widget align-middle" style="color:white;"></i>
          														</div>
          													</div>
          												</div>
          												<h1 class="mt-1 mb-3"><?php echo $count_emp; ?></h1>
        											</div>
        										</div>

                            <?php
                              $sql_projects = "SELECT * FROM projects WHERE status!='cancelled'";
                              $result_projects = $con->query($sql_projects);
                              $count_projects = $result_projects->num_rows;
                              if ($count_projects <= 0) {
                                $count_projects = 0;
                              }
                            ?>

        										<div class="card my">
        											<div class="card-body">
                                <div class="row">
        													<div class="col mt-0">
        														<h4 class="card-title">Total Projects</h4>
        													</div>
        													<div class="col-auto">
        														<div class="stat text" style="background-color:#2ACB91">
                                      <i class="ti-harddrives new-widget align-middle" style="color:white;"></i>
        														</div>
        													</div>
        												</div>
        												<h1 class="mt-1 mb-3"><?php echo $count_projects ?></h1>
        												<div class="mb-0">
        													<span class="text-muted">All Projects</span>
        												</div>
        											</div>
        										</div>
        									</div>

                          <?php
                            $sql_resource = "SELECT SUM(value) FROM item";
                            $result_resource = $con->query($sql_resource);
                            $rowcc = $result_resource->fetch_array();
                          ?>

        									<!-- second column -->
        									<div class="col-sm-6" style="padding:0px">
        										<div class="card my">
        											<div class="card-body">
                                <div class="row">
        													<div class="col mt-0">
        														<h5 class="card-title">Company Resources</h5>
        													</div>

        													<div class="col-auto">
        														<div class="stat" style="background-color:#E74A3B">
        															<i class="ti-package new-widget align-middle" style="color:white;"></i>
        														</div>
        													</div>
        												</div>
        												<h3 class="mt-1 mb-3">Rs.<?php echo number_format($rowcc[0],2) ?></h3>
                                <div class="mb-0" style="padding-top:12px">
        													<span class="text-muted">Item Worth</span>
        												</div>
        											</div>
        										</div>

                            <?php
                              $sql_loans = "SELECT * FROM employee_loans WHERE process='Paying'";
                              $result_loans = $con->query($sql_loans);
                              $count_loans = $result_loans->num_rows;
                              if ($count_loans <= 0) {
                                $count_loans = 0;
                              }
                            ?>

        										<div class="card my" >
        											<div class="card-body">
        												<div class="row">
        													<div class="col mt-0">
        														<h5 class="card-title">Total Employee Loans</h5>
        													</div>

        													<div class="col-auto">
        														<div class="stat text" style="background-color:#F7C64A">
        															<i class="ti-link new-widget align-middle" style="color:white;"></i>
        														</div>
        													</div>
        												</div>
        												<h1 class="mt-1 mb-3"><?php echo $count_loans; ?></h1>
        											</div>
        										</div>
        									</div>
        								</div>
        							</div>
        						</div>

        						<div class="col-xl-7 col-xxl-7">
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
                            $sql_notice = "SELECT * FROM notice ORDER BY date DESC LIMIT 4";
                            $result_notice = $con->query($sql_notice);
                            while ($rowc_notice = $result_notice->fetch_array()) {
                              $sender = $rowc_notice['sender'];
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
                            <?php } ?>

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
                        $sql_expo = "SELECT SUM(amount) FROM expenses WHERE paidDate LIKE '$month%'";
                        $result_expo = $con->query($sql_expo);
                          $row_expo = $result_expo->fetch_array();
                          $expo_amt = $row_expo[0];
                          $sal[] = $expo_amt;
                    }

                    $val = [];

                      for ($i=1; $i < 13; $i++) {
                        $month = $year.'-'.sprintf("%02d", $i);
                        $expo_amt2 = 0;
                          $sql_expo2 = "SELECT SUM(amount) FROM expenses WHERE paidDate LIKE '$month%' AND type LIKE 'Salary Payments%'";
                          $result_expo2 = $con->query($sql_expo2);
                            $row_expo2 = $result_expo2->fetch_array();
                            $expo_amt2 = $row_expo2[0];
                            $val[] = $expo_amt2;
                      }

                  ?>

                    <div class="row">
                        <div class="col-lg-8"> <br>
                          <div class="card">
                            <div class="card-title">
                              <h4>Monthly Expenses in CODEC</h4>
                            </div> <br>
                            <canvas id="bar-chart" ></canvas>
                          </div>

                          <script type="text/javascript">


                              var chartColors = {
                                color1:"#9CCDDC",
                                color2:"#5591A9",
                                color3:"#054569",
                                color4:"#062C43"
                              };

                              var myChart = new Chart(document.getElementById("bar-chart"), {
                                type: 'bar',
                                data: {
                                  labels: ["January",	"February",	"March",	"April",	"May",	"June",	"July","August",	"September","October","November","December"],
                                  datasets: [ {
                                      type: 'line',
                                      label: 'Salary Payments Rs:',
                                      data: [<?php echo implode( ", ", $val ); ?>],
                                      borderColor: "#D6AD3B",
                                      backgroundColor: "#D6AD3B",
                                      fill: false
                                  }, {
                                      type: 'bar',
                                      label: "Total Expenses Rs.",
                                      backgroundColor: [chartColors.color1,chartColors.color1,chartColors.color1,chartColors.color1,chartColors.color1,chartColors.color1,chartColors.color1,chartColors.color1,chartColors.color1,chartColors.color1,],
                                      data: [<?php echo implode( ", ", $sal ); ?>,950000]
                                    }
                                  ]
                                },
                                options: {
                                  legend: { display: true },
                                  title: {
                                    display: false,
                                    text: ''
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

                            var colorChangeValue = 50; //set this to whatever is the deciding color change value
                              var dataset = myChart.data.datasets[1];
                              for (var i = 0; i < dataset.data.length; i++) {
                                if (dataset.data[i] < 800000) {
                                  dataset.backgroundColor[i] = chartColors.color1;
                                }
                                else if ((dataset.data[i] > 800000) && (dataset.data[i] <= 850000)){
                                  dataset.backgroundColor[i] = chartColors.color2;
                                }
                                else if ((dataset.data[i] > 850000) && (dataset.data[i] <= 900000)){
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


                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card"  >
                                <div class="card-title">
                                    <h4>Tasks</h4>

                                </div>
                                <div class="todo-list" id="taskTable">
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
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-title pr">
                                    <h4>Recent Recruiters</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table student-data-table m-t-20">
                                          <?php
                                          $month = date('Y-m');
                                            $sql5 = "SELECT * FROM `employee` WHERE empJobStatus='Working' ORDER BY dateOfJoin DESC LIMIT 5";
                                            $result5 = $con->query($sql5);
                                          ?>
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Employee Name</th>
                                                    <th>Designation</th>
                                                    <th>Employement</th>
                                                    <th>Contact</th>
                                                    <th>Joined Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              <?php $no=1; while ($row5 = $result5->fetch_array()) { ?>
                                                <tr>
                                                    <td>EID<?php echo sprintf("%05d", $row5['empID']) ?></td>
                                                    <td>
                                                        <?php echo $row5['empName']; ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $desig = $row5['desigID'];
                                                        $sql5s = "SELECT * FROM `designation` WHERE desigID='$desig'";
                                                        $result5s = $con->query($sql5s);
                                                        $row5s = $result5s->fetch_array();
                                                         echo $row5s['designation'];
                                                          ?>
                                                    </td>
                                                    <td style="text-transform:capitalize">
                                                        <?php echo $row5['empType']; ?>
                                                    </td>
                                                    <td>
                                                      0<?php echo $row5['empContact']; ?>
                                                    </td>
                                                    <td style="text-align:right;">
                                                        <?php echo $row5['dateOfJoin']; ?>
                                                    </td>
                                                </tr>
                                              <?php $no++; } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /# column -->
                    </div>


              <?php include('common/footer.php') ?>
              <!-- footer -->
</body>

</html>
