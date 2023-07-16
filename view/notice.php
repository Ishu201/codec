<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //To hide errors
include 'common/session.php';
include 'common/dbconnection.php'; //To get connection string
include 'model/noticemodel.php';
//include '../model/commonmodel.php';
$ob = new dbconnection();
$con = $ob->connection();

$obj = new notice;
$empID = $_SESSION['empID'];

$result = $obj->viewNotice($empID);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('common/files.php') ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>

    <style media="screen">
      .noticeAdmin{
        padding:15px;
        margin-bottom: 15px;
        /* background-color:#31475B; */
        color:#31475B !important;
        border: none;
      }

      .noticeLed{
        padding:15px;
        margin-bottom: 15px;
        color:#31475B !important;
        /* background-color: #31475B; */
        border: none;
      }

      .noticedev{
        padding:15px;
        margin-bottom: 15px;
        color:#31475B !important;
        /* background-color: #31475B; */
        border: none;
      }

      .noticehr{
        padding:15px;
        margin-bottom: 15px;
        color:#31475B !important;
        /* background-color: #31475B; */
        border: none;
      }


      .notice-content{
        margin-left:60px;
        font-size: 17px;
      }

      .notice-text{
        color:#343957
      }
      .header-notice{
        color:#343957 !important;
        margin-bottom: 0px;
        font-size: 17px;
      }

      .notice-time{
        margin-top: 25px;
        font-size: 13px;
        color:#343957 !important
      }

    </style>
</head>

<body onload="read();">

  <?php if ($_SESSION['username'] == 'Admin') {
    include('common/sidebar.php');
  } elseif ($_SESSION['username'] == 'Accounts') {
    include('common/Accsidebar.php');
  } elseif ($_SESSION['username'] == 'HR') {
    include('common/HRsidebar.php');
  } elseif ($_SESSION['username'] == 'Development') {
    include('common/leadsidebar.php');
  }
  ?>

    <!-- /# sidebar -->
    <script type="text/javascript">
      document.getElementById('notice').className = 'active';
    </script>

    <?php include('common/header.php') ?>
    <!-- head bar -->

    <?php include('src/itemAlert.php') ?>

    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Manage Notice Board</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Notice</a></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->
                <section id="main-content">
                  <div class="row">
                    <div class="col-lg-5">
                      <div class="card" style="padding:20px;">
                        <div class="card-title">
                          <h4>Add a New Notice</h4>
                        </div>
                        <div class="card-body"> <br>
                          <form action="controller/noticecontroller.php?status=add" method="post">
                          <div class="form-group">
                              <label>Notice Type <span style="color:red">*</span> </label>
                              <select class="form-control" name="type" required>
                                <option value="">Select</option>
                                <?php if ($empID == 1) { ?>
                                  <option value="all">For All Users</option>
                                  <option value="allcompany">Company Users</option>
                                  <option value="3">HR Department</option>
                                  <option value="2">Account Department</option>
                                  <option value="4">Development Department</option>
                                <?php } else{ ?>
                                  <option value="all">For All Users</option>
                                  <option value="allcompany">Company Users</option>
                                <?php } ?>
                              </select>
                              <input type="hidden" name="empID" value="<?php echo $empID; ?>">
                          </div>
                          <div class="form-group">
                              <label>Notice <span style="color:red">*</span></label>
                              <textarea class="form-control" name="notice_text" rows="3" placeholder="Notice Text" style="height:100px" required></textarea>
                           </div> <br>
                           <div class="form-group">
                               <center><button type="submit" class="btn btn-success" style="width:50%;" name="submit">Publish</button></center>
                            </div>
                           </form>
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

                    <div class="col-lg-7">
                      <div class="card" >
                        <div class="card-title">
                          <h4>Notice Board</h4>
                        </div>
                        <div class="card-body"> <br>
                          <?php while ($row = $result->fetch_array()) { ?>
                          <!-- admin notice -->
                          <?php if (($row['sender'] == $session_empID) or ($session_empID == 1)) { ?>
                          <?php if ($row['sender'] == 1) { ?>
                          <div class="card noticeAdmin" style="width:90%;margin:auto;margin-top:15px;margin-bottom:15px">
                            <div class="stat-widget-four">
                              <div class="stat-icon">
                                <img class="media-object" src="../res/images/adminlog.jpg" style="width:50px">
                              </div>
                              <div class="notice-content">
                                <?php if (($empID == 1) or ($row['sender'] == $empID)) { ?>
                                  <button type="button" class="close sweet-message" data-id="<?php echo  $row['noticeID']; ?>" style="color:#31475B"><span>&times;</span></button>
                                <?php } ?>
                                <div class="float-left">
                                  <h4 class="header-notice" style="color:#31475B !important;font-size:17px">Admin</h4>
                                  <p class="notice-text" style="color:#31475B;font-size:15px"><?php echo  $row['notice_text']; ?></p>
                                </div>
                                <div class="float-right notice-time">
                                  <p class="notice-text" style="color:#31475B"><?php $date = $row['date']; echo get_time_ago( strtotime($date) ); ?></p>
                                </div>
                              </div>
                            </div>
                          </div>
                        <?php } ?>

                        <?php if ($row['sender'] == 2) { ?>
                        <div class="card noticeLed" style="width:90%;margin:auto;margin-top:15px;margin-bottom:15px">
                          <div class="stat-widget-four">
                            <div class="stat-icon">
                              <img class="media-object" src="../res/images/acclog.png" style="width:50px">
                            </div>
                            <div class="notice-content">
                              <?php if (($empID == 1) or ($row['sender'] == $empID)) { ?>
                                <button type="button" class="close sweet-message" data-id="<?php echo  $row['noticeID']; ?>" style="color:#31475B"><span>&times;</span></button>
                              <?php } ?>
                              <div class="float-left">
                                <h4 class="header-notice" style="color:#31475B !important;font-size:17px">Account</h4>
                                <p class="notice-text" style="color:#31475B;font-size:15px"><?php echo  $row['notice_text']; ?></p>
                              </div>
                              <div class="float-right notice-time">
                                <p class="notice-text" style="color:#31475B"><?php $date = $row['date']; echo get_time_ago( strtotime($date) ); ?></p>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php } ?>

                      <?php if ($row['sender'] == 3) { ?>
                      <div class="card noticehr" style="width:90%;margin:auto;margin-top:15px;margin-bottom:15px">
                        <div class="stat-widget-four">
                          <div class="stat-icon">
                            <img class="media-object" src="../res/images/hrlog.png" style="width:50px">
                          </div>
                          <div class="notice-content">
                            <?php if (($empID == 1) or ($row['sender'] == $empID)) { ?>
                              <button type="button" class="close sweet-message" data-id="<?php echo  $row['noticeID']; ?>" style="color:#31475B"><span>&times;</span></button>
                            <?php } ?>
                            <div class="float-left">
                              <h4 class="header-notice" style="color:#31475B !important;font-size:17px">HR</h4>
                              <p class="notice-text" style="color:#31475B;font-size:15px"><?php echo  $row['notice_text']; ?></p>
                            </div>
                            <div class="float-right notice-time">
                              <p class="notice-text" style="color:#31475B"><?php $date = $row['date']; echo get_time_ago( strtotime($date) ); ?></p>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php } ?>

                    <?php if ($row['sender'] == 4) { ?>
                    <div class="card noticedev" style="width:90%;margin:auto;margin-top:15px;margin-bottom:15px">
                      <div class="stat-widget-four">
                        <div class="stat-icon">
                          '<img class="media-object" src="../res/images/devlog.png" style="width:50px">
                        </div>
                        <div class="notice-content">
                          <?php if (($empID == 1) or ($row['sender'] == $empID)) { ?>
                            <button type="button" class="close sweet-message" data-id="<?php echo  $row['noticeID']; ?>" style="color:#31475B"><span>&times;</span></button>
                          <?php } ?>
                          <div class="float-left">
                            <h4 class="header-notice" style="color:#31475B !important;font-size:17px">Development</h4>
                            <p class="notice-text" style="color:#31475B;font-size:15px"><?php echo  $row['notice_text']; ?></p>
                          </div>
                          <div class="float-right notice-time">
                            <p class="notice-text" style="color:#31475B"><?php $date = $row['date']; echo get_time_ago( strtotime($date) ); ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

                <?php } ?>
                        <?php } ?>

                          <br>
                        </div>
                      </div>
                    </div>
                    <!-- /# column -->
                  </div>

                  <?php include('build/removeNotice.php') ?>

      <?php include('common/footer.php') ?>
     <!-- footer -->

     <script type="text/javascript">
       function read(){
         var stat = <?php if(isset($_REQUEST['stat'])){ echo 'read'; } else { echo "''";} ?>;
         if (stat == '') {
           window.location.href = "operation/noticeread.php?type=<?php echo $empID; ?>";
         }
       }
     </script>
</body>

</html>
