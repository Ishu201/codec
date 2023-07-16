<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string
$ob = new dbconnection();
$con = $ob->connection();

$empID = $_SESSION['empID'];
$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('common/files.php') ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>

    <style media="screen">
    .nav-item{
      font-size: 15px;
    }
    tr:hover{
     background-color: #e6e6e6;
     cursor: pointer;
   }

   .comment-date{
     font-size:12px
   }

    </style>
</head>

<body  onload="read();">

  <?php if ($_SESSION['username'] == 'Admin') {
    include('common/sidebar.php');
  } elseif ($_SESSION['username'] == 'Accounts') {
    include('common/Accsidebar.php');
  } elseif ($_SESSION['username'] == 'HR') {
    include('common/HRsidebar.php');
  } elseif ($_SESSION['username'] == 'Development') {
    include('common/leadsidebar.php');
  } else{
    include('common/empSidebar.php');
  }
  ?>

    <!-- /# sidebar -->
    <script type="text/javascript">
      document.getElementById('mail').className = 'active';
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
                                <h1>Personal Mails in CODEC</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Codec Mails</a></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->
                <?php
                  $sql = "SELECT * FROM employee WHERE empID='$empID'";
                  $result = $con->query($sql);
                  $row = $result->fetch_array();
                ?>
                <section id="main-content">
                  <div class="card" style="height:700px;">
										<div class="card-body">
                      <div class="user-head">
                        <a class="inbox-avatar">
                          <?php
                            if ($empID == '1') {
                              echo '<img src="../res/images/adminlog.jpg">';
                            } else if ($empID == '2') {
                              echo '<img src="../res/images/acclog.png">';
                            } else if ($empID == '3') {
                              echo '<img src="../res/images/hrlog.png">';
                            } else if ($empID == '4') {
                              echo '<img src="../res/images/devlog.png">';
                            } else{
                              echo '<img src="../res/images/emplogo.jpg" style="border:1px solid #d6d6d6" alt="">';
                            }
                          ?>

                        </a>
                        <div class="user-name">
                          <h5><a href="#">
                            <?php
                            if ($empID == '1') {
                              echo 'Admin';
                            } else if ($empID == '2') {
                              echo 'Accounts Department';
                            } else if ($empID == '3') {
                              echo 'HR Department';
                            } else if ($empID == '4') {
                              echo 'Development Department';
                            } else{
                              echo $row['empName'];
                            }
                          ?>
                        </a></h5>
                          <span><a href="#"><?php
                            if ($empID == '1') {
                              echo 'Admin@CDC';
                            } else if ($empID == '2') {
                              echo 'Accounts@CDC';
                            } else if ($empID == '3') {
                              echo 'HumanR@CDC';
                            } else if ($empID == '4') {
                              echo 'DevOp@CDC';
                            } else{
                              echo $_SESSION['username'];
                            }
                          ?></a></span>
                        </div>
                      </div>

                      <br> <br>
                        <a href="#composeMail" data-toggle="modal" title="Compose" class="btn btn-primary" style="width:200px;"> Compose</a>
                        <!-- Modal -->
                        <?php include('build/composeMail.php'); ?>
                        <!-- /.modal -->

											<!-- Nav tabs --> <br> <br>
											<div class="vtabs customvtab" >
												<ul class="nav nav-tabs tabs-vertical" role="tablist" style="width:250px" id="myTab">
													<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home3" role="tab"><span class="hidden-sm-up"><i class="fa fa-inbox"></i></span> <span class="hidden-xs-down">&nbsp Inbox</span> </a> </li>
													<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile3" role="tab"><span class="hidden-sm-up"><i class="fa fa-envelope-o"></i></span> <span class="hidden-xs-down">&nbsp Sent</span></a> </li>
													<!-- <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages3" role="tab"><span class="hidden-sm-up"><i class="ti-pencil"></i></span> <span class="hidden-xs-down">&nbsp Draft</span></a> </li> -->
												</ul>
												<!-- Tab panes -->
												<div class="tab-content" style="position:absolute;top:20px;right:20px;width:74%">
													<div class="tab-pane active" id="home3" role="tabpanel" style="border:1px solid #A3C2C2;height:600px">
                            <aside class="lg-side" >
                              <div class="inbox-head" style="background-color:#a3c2c2">
                                <h4 class="input-text" style="font-weight:bold">Inbox</h4>
                              </div>
                              <div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true">

                                  <?php
                                  $sql = "SELECT * FROM mail WHERE mail_receiver='$username' AND process='send' ORDER BY date DESC";
                                  $result = $con->query($sql);
                                  $no = 1;
                                  while($row_user = $result->fetch_array()){
                                    $sender = $row_user['mail_sender'];

                                    $sql2 = "SELECT * FROM employee WHERE empEmail='$sender'";
                                    $result2 = $con->query($sql2);
                                    $row_sender = $result2->fetch_array();

                                    if ($sender == 'Admin') {
                                      $img = '<img class="media-object" style="border:1px solid #d9d9d9;border-radius:60%;height:40px;width:40px;" src="../res/images/adminlog.jpg">';
                                      $name = 'Admin';
                                    } else if ($sender == 'Accounts') {
                                      $img = '<img class="media-object" style="border:1px solid #d9d9d9;border-radius:60%;height:40px;width:40px;" src="../res/images/acclog.png">';
                                      $name = 'Account Department';
                                    } else if ($sender == 'HR') {
                                      $img = '<img class="media-object" style="border:1px solid #d9d9d9;border-radius:60%;height:40px;width:40px;" src="../res/images/hrlog.png">';
                                      $name = 'HR Department';
                                    }else if ($sender == 'Development') {
                                      $img = '<img class="media-object" style="border:1px solid #d9d9d9;border-radius:60%;height:40px;width:40px;" src="../res/images/devlog.png">';
                                      $name = 'Development Department';
                                    } else{
                                      $img = '<img class="media-object" style="border:1px solid #d9d9d9;border-radius:60%;height:40px;width:40px;" src="../res/images/emplogo.jpg">';
                                      $name = $row_sender['empName'];
                                    }
                                  ?>

                                  <!-- start first -->
                                  <div class="card-header" role="tab" id="headingTwo<?php echo $no; ?>">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx<?php echo $no; ?>" href="#collapseTwo<?php echo $no; ?>" aria-expanded="false" aria-controls="collapseTwo<?php echo $no; ?>">
                                      <div class="media" >
                                          <div class="media-left">
                                              <?php echo $img; ?>
                                          </div>
                                          <div class="media-body" style="padding-left:20px;">
                                            <div class="row">
                                              <div class="col-lg-6">
                                                <h4 style="font-size:13px"><?php echo $name; ?></h4>
                                                <p><?php  echo $row_user['subject'] ; ?> </p>
                                              </div>
                                              <div class="col-lg-6" >
                                                <div class="float-right">
                                                  <p class="comment-date" style=""><?php $date = $row_user['date']; echo get_time_ago( strtotime($date) ) ?></p>
                                                </div>
                                              </div>
                                              </div>
                                          </div>
                                      </div>
                                    </a>
                                  </div>
                                  <div id="collapseTwo<?php echo $no; ?>" class="collapse" role="tabpane<?php echo $no; ?>" aria-labelledby="headingTwo<?php echo $no; ?>" data-parent="#accordionEx<?php echo $no; ?>">
                                    <div class="card-body" style="padding:10px;">
                                      <div class="row">
                                        <div class="col-lg-9">
                                          <p class="reqHeading"><span style="font-weight:normal"> &nbsp <?php echo $row_user['message']; ?></span> </p>
                                        </div>
                                        <div class="col-lg-3" >
                                          <div class="float-right">
                                            <p class="comment-date" style=""><?php echo $row_user['date']; ?></p>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <!-- end first -->
                                <?php $no++; } ?>

                              </div>

                            </aside>
													</div>



													<div class="tab-pane  p-20" id="profile3" role="tabpanel" style="border:1px solid #A3C2C2;height:600px;padding:0px !important;">
                            <aside class="lg-side" >
                              <div class="inbox-head" style="background-color:#a3c2c2">
                                <h4 class="input-text" style="font-weight:bold">Sent Mail</h4>
                              </div>
                              <div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true">

                                  <?php
                                  $sql = "SELECT * FROM mail WHERE mail_sender='$username' AND process='send' ORDER BY date DESC";
                                  $result = $con->query($sql);
                                  $k = 1;
                                  while($row_user = $result->fetch_array()){
                                    $sender = $row_user['mail_receiver'];

                                    $sql2 = "SELECT * FROM employee WHERE empEmail='$sender'";
                                    $result2 = $con->query($sql2);
                                    $row_sender = $result2->fetch_array();

                                    if ($sender == 'Admin') {
                                      $img = '<img class="media-object" style="border:1px solid #d9d9d9;border-radius:60%;height:40px;width:40px;" src="../res/images/adminlog.jpg">';
                                      $name = 'Admin';
                                    } else if ($sender == 'Accounts') {
                                      $img = '<img class="media-object" style="border:1px solid #d9d9d9;border-radius:60%;height:40px;width:40px;" src="../res/images/acclog.png">';
                                      $name = 'Account Department';
                                    } else if ($sender == 'HR') {
                                      $img = '<img class="media-object" style="border:1px solid #d9d9d9;border-radius:60%;height:40px;width:40px;" src="../res/images/hrlog.png">';
                                      $name = 'HR Department';
                                    }else if ($sender == 'Development') {
                                      $img = '<img class="media-object" style="border:1px solid #d9d9d9;border-radius:60%;height:40px;width:40px;" src="../res/images/devlog.png">';
                                      $name = 'Development Department';
                                    } else{
                                      $img = '<img class="media-object" style="border:1px solid #d9d9d9;border-radius:60%;height:40px;width:40px;" src="../res/images/emplogo.jpg">';
                                      $name = $row_sender['empName'];
                                    }
                                  ?>

                                  <!-- start first -->
                                  <div class="card-header" role="tab" id="headingTwo<?php echo $no; ?>">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx<?php echo $no; ?>" href="#collapseTwo<?php echo $no; ?>" aria-expanded="false" aria-controls="collapseTwo<?php echo $no; ?>">
                                      <div class="media" >
                                          <div class="media-left">
                                              <?php echo $img; ?>
                                          </div>
                                          <div class="media-body" style="padding-left:20px;">
                                            <div class="row">
                                              <div class="col-lg-6">
                                                <h4 style="font-size:13px"><?php echo $name; ?></h4>
                                                <p><?php  echo $row_user['subject'] ; ?> </p>
                                              </div>
                                              <div class="col-lg-6" >
                                                <div class="float-right">
                                                  <p class="comment-date" style=""><?php $date = $row_user['date']; echo get_time_ago( strtotime($date) ) ?></p>
                                                </div>
                                              </div>
                                              </div>
                                          </div>
                                      </div>
                                    </a>
                                  </div>
                                  <div id="collapseTwo<?php echo $no; ?>" class="collapse" role="tabpane<?php echo $no; ?>" aria-labelledby="headingTwo<?php echo $no; ?>" data-parent="#accordionEx<?php echo $no; ?>">
                                    <div class="card-body" style="padding:10px;">
                                      <div class="row">
                                        <div class="col-lg-9">
                                          <p class="reqHeading"><span style="font-weight:normal"> &nbsp <?php echo $row_user['message']; ?></span> </p>
                                        </div>
                                        <div class="col-lg-3" >
                                          <div class="float-right">
                                            <p class="comment-date" style=""><?php echo $row_user['date']; ?></p>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <!-- end first -->
                                <?php $no++; } ?>

                              </div>

                            </aside>
                          </div>




													<div class="tab-pane p-20" id="messages3" role="tabpanel" style="border:1px solid #A3C2C2;height:600px;padding:0px !important;">
                            <aside class="lg-side" >
                              <div class="inbox-head" style="background-color:#a3c2c2">
                                <h4 class="input-text" style="font-weight:bold">Draft Mail</h4>
                              </div>
                              <div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true">

                                  <?php
                                  $sql = "SELECT * FROM mail WHERE mail_sender='$username' AND process='draft' ORDER BY date DESC";
                                  $result = $con->query($sql);
                                  $k = 1;
                                  while($row_user = $result->fetch_array()){
                                    $sender = $row_user['mail_receiver'];

                                    $sql2 = "SELECT * FROM employee WHERE empEmail='$sender'";
                                    $result2 = $con->query($sql2);
                                    $row_sender = $result2->fetch_array();

                                    if ($sender == 'Admin') {
                                      $img = '<img class="media-object" style="border:1px solid #d9d9d9;border-radius:60%;height:40px;width:40px;" src="../res/images/adminlog.jpg">';
                                      $name = 'Admin';
                                    } else if ($sender == 'Accounts') {
                                      $img = '<img class="media-object" style="border:1px solid #d9d9d9;border-radius:60%;height:40px;width:40px;" src="../res/images/acclog.png">';
                                      $name = 'Account Department';
                                    } else if ($sender == 'HR') {
                                      $img = '<img class="media-object" style="border:1px solid #d9d9d9;border-radius:60%;height:40px;width:40px;" src="../res/images/hrlog.png">';
                                      $name = 'HR Department';
                                    }else if ($sender == 'Development') {
                                      $img = '<img class="media-object" style="border:1px solid #d9d9d9;border-radius:60%;height:40px;width:40px;" src="../res/images/devlog.png">';
                                      $name = 'Development Department';
                                    } else{
                                      $img = '<img class="media-object" style="border:1px solid #d9d9d9;border-radius:60%;height:40px;width:40px;" src="../res/images/emplogo.jpg">';
                                      $name = $row_sender['empName'];
                                    }
                                  ?>

                                  <!-- start first -->
                                  <div class="card-header" role="tab" id="headingTwo<?php echo $no; ?>">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx<?php echo $no; ?>" href="#collapseTwo<?php echo $no; ?>" aria-expanded="false" aria-controls="collapseTwo<?php echo $no; ?>">
                                      <div class="media" >
                                          <div class="media-left">
                                              <?php echo $img; ?>
                                          </div>
                                          <div class="media-body" style="padding-left:20px;">
                                            <div class="row">
                                              <div class="col-lg-6">
                                                <h4 style="font-size:13px"><?php echo $name; ?></h4>
                                                <p><?php  echo $row_user['subject'] ; ?> </p>
                                              </div>
                                              <div class="col-lg-6" >
                                                <div class="float-right">
                                                  <p class="comment-date" style=""><?php $date = $row_user['date']; echo get_time_ago( strtotime($date) ) ?></p>
                                                </div>
                                              </div>
                                              </div>
                                          </div>
                                      </div>
                                    </a>
                                  </div>
                                  <div id="collapseTwo<?php echo $no; ?>" class="collapse" role="tabpane<?php echo $no; ?>" aria-labelledby="headingTwo<?php echo $no; ?>" data-parent="#accordionEx<?php echo $no; ?>">
                                    <div class="card-body" style="padding:10px;">
                                      <div class="row">
                                        <div class="col-lg-9">
                                          <p class="reqHeading"><span style="font-weight:normal"> &nbsp <?php echo $row_user['message']; ?></span> </p>
                                        </div>
                                        <div class="col-lg-3" >
                                          <div class="float-right">
                                            <p class="comment-date" style=""><?php echo $row_user['date']; ?></p>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <!-- end first -->
                                <?php $no++; } ?>

                              </div>

                            </aside>
                          </div>


												</div>
											</div>
										</div>
									</div>

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


      <?php include('common/footer.php') ?>
     <!-- footer -->

    <script type="text/javascript">
      function read(){
        var stat = <?php if(isset($_REQUEST['stat'])){ echo 'read'; } else { echo "''";} ?>;
        if (stat == '') {
          window.location.href = "operation/mailread.php?receiver=<?php echo $username; ?>";
        }
      }
    </script>

</body>

</html>
