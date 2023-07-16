<!DOCTYPE html>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <style media="screen">
      html,body{
        width: 100%;
        height: 100%;
        margin: 0px;
        padding: 0px;
        overflow-x: hidden;
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
</head>

<body>

  <?php
  include('common/empSidebar.php') ;

  ?>
    <!-- /# sidebar -->
    <script type="text/javascript">
      document.getElementById('descipline').className = 'active';
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
                                <h1>Desciplinary Records</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item ">Desciplinary Notes</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>


                <!-- /# row -->
                <section id="main-content">

                  <div class="row">
                    <div class="col-lg-12">
                      <div class="card">
                      <div class="card-title">
                          <h4>Desciplinary Notes </h4>
                      </div>


                      <?php
                      $sql = "SELECT * FROM `disciplinary` WHERE empID='$session_empID' ORDER BY disID DESC";
                      $result = $con->query($sql);
                       $count = $result->num_rows;
                       if ($count > 0) {
                         while($row = $result->fetch_array()){
                      ?>
                      <div class="recent-comment">
                      <div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true"> <br>
                        <div class="media-body">
                            <h4 class="media-heading"><span style="color:gray;font-size:18px">Title</span> - <?php echo $row['title']; ?></h4>
                            <div class="comment-action">
                              <p><?php echo $row['description']; ?></p>
                            </div>
                            <div class="comment-date">
                              <div class="float-right">
                                <p class="reqHeading" style="text-align:right">&nbsp Status</p>
                                <?php if ($row['status'] == 'off') { ?>
                                  <button class="btn-sm btn-dark btn">Ended</button>
                                <?php } else{ ?>
                                <button class="btn-sm btn-success btn">Effective</button>
                              <?php } ?>
                              </div>
                            </div>
                        </div> <br><br>
                        <ul class="list-group">
                        <?php if ($row['w1'] == 1) { ?>
                          <li class="list-group-item">
                            <div class="media" >
                            <div class="media-left">
                                <img class="media-object" src="assets/images/info.png" alt="...">
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">Written Warning 1</h4>
                                <p><?php echo $row['warning1']; ?></p>
                                <p class="comment-date">
                                  <?php
                                    $date = $row['date4'];
                                    echo $your_date = date("F d, Y", strtotime($date));
                                  ?>
                                </p>
                            </div>
                          </div>
                          </li>
                        <?php } ?>

                        <?php if ($row['w2'] == 1) { ?>
                          <li class="list-group-item">
                            <div class="media" >
                            <div class="media-left">
                                <img class="media-object" src="assets/images/info.png" alt="...">
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">Written Warning 2</h4>
                                <p><?php echo $row['warning2']; ?></p>
                                <p class="comment-date">
                                  <?php
                                    $date = $row['date5'];
                                    echo $your_date = date("F d, Y", strtotime($date));
                                  ?>
                                </p>
                            </div>
                          </div>
                          </li>
                        <?php } ?>

                        <?php if ($row['dem'] == 1) { ?>
                          <li class="list-group-item">
                            <div class="media" >
                            <div class="media-left">
                                <img class="media-object" src="assets/images/warning.png" alt="...">
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">Demotion</h4>
                                <p><?php echo $row['demMsg']; ?></p>
                                <p class="comment-date">
                                  <?php
                                    $date = $row['date6'];
                                    echo $your_date = date("F d, Y", strtotime($date));
                                  ?>
                                </p>
                            </div>
                          </div>
                          </li>
                        <?php } ?>

                        <?php if ($row['sus'] == 1) { ?>
                          <li class="list-group-item">
                            <div class="media" >
                            <div class="media-left">
                                <img class="media-object" src="assets/images/danger.png" alt="...">
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">Suspended</h4>
                                <p><?php echo $row['suspension']; ?></p>
                                <p class="comment-date">
                                  <?php
                                    $date = $row['date7'];
                                    echo $your_date = date("F d, Y", strtotime($date));
                                  ?>
                                </p>
                            </div>
                          </div>
                        </li>
                        <?php } ?>
                        </ul>
                      </div> </div>
                      <br>
                    <?php  } } else{ ?>
                      <p>No Desciplinary process is on Action..</p>
                    <?php } ?>
                    </div>
                    </div>
                  </div>



      <?php include('common/footer.php') ?>
     <!-- footer -->

</body>

</html>
