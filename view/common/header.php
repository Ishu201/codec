<?php $session_empID = $_SESSION['empID']; ?>
<div class="header" >
    <div class="container-fluid" >
        <div class="row">
            <div class="col-lg-12">
                <div class="float-left">
                    <div class="hamburger sidebar-toggle">
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                    </div>
                </div>

                <div class="float-right">
                  <?php if($_SESSION['roleID'] != 1){ ?>
                  <?php
                  $session_username = $_SESSION['username'];

                    $sql_get_mail2 = "SELECT * FROM task WHERE empID='$session_empID' AND stat='todo' ";
                    $result_get_mail2 = $con->query($sql_get_mail2);
                    $count_get_mail2 = $result_get_mail2->num_rows;
                  ?>
                    <div class="dropdown dib">
                        <div class="header-icon" data-toggle="dropdown">
                          <div>
                            <i class="ti-notepad"></i>
                            <?php if ($count_get_mail2 > 0) { ?>
                            <p style="background-color:#00ace6;font-size:10px;color:white;font-weight:bold;padding-left:4px;padding-right:4px;border-radius:60%;position:absolute;top:5px;right:0px;"><?php echo $count_get_mail2; ?></p>
                          <?php } ?>
                          </div>
                        </div>
                    </div>
                  <?php } ?>

                <?php
                  if ($session_empID == 1) {
                    $sql_notice_get = "SELECT * FROM notice WHERE Admin='on' ORDER BY date DESC";
                    $result_notice_get = $con->query($sql_notice_get);
                    $count = $result_notice_get->num_rows;
                  }
                  else if ($session_empID == 2) {
                    $sql_notice_get = "SELECT * FROM notice  WHERE ACC='on' AND (type='allcompany' OR type='all' OR type='2') ORDER BY date DESC";
                    $result_notice_get = $con->query($sql_notice_get);
                    $count = $result_notice_get->num_rows;
                  }
                  else if ($session_empID == 3) {
                    $sql_notice_get = "SELECT * FROM notice WHERE HR='on' AND (type='allcompany' OR type='all' OR type='3') ORDER BY date DESC";
                    $result_notice_get = $con->query($sql_notice_get);
                    $count = $result_notice_get->num_rows;
                  }
                  else if ($session_empID == 4) {
                    $sql_notice_get = "SELECT * FROM notice WHERE IT='on' AND (type='allcompany' OR type='all' OR type='4') ORDER BY date DESC";
                    $result_notice_get = $con->query($sql_notice_get);
                    $count = $result_notice_get->num_rows;
                  }
                  else{
                    $sql_notice_get = "SELECT * FROM notice WHERE type='all' ORDER BY date DESC";
                    $result_notice_get = $con->query($sql_notice_get);
                    $count = $result_notice_get->num_rows;
                  }
                ?>
                    <div class="dropdown dib">
                        <div class="header-icon" data-toggle="dropdown">
                            <div>
                              <i class="ti-bell"></i>
                              <?php if($count > 0){ ?>
                              <p style="background-color:red;font-size:10px;color:white;font-weight:bold;padding-left:4px;padding-right:4px;border-radius:60%;position:absolute;top:5px;right:0px;"><?php  echo $count; ?></p>
                            <?php } ?>
                            </div>
                            <div class="drop-down dropdown-menu dropdown-menu-right">
                                <div class="dropdown-content-heading">
                                    <span class="text-left">Recent Notifications</span>
                                </div>
                                <div class="dropdown-content-body">
                                    <ul>
                                      <?php while ($row_notice_get = $result_notice_get->fetch_array()) { ?>
                                        <li>
                                            <a href="#" id="noticelink1">
                                              <?php
                                              $sender = $row_notice_get['sender'];
                                              if ($sender == '1') {
                                                echo '<img class="pull-left m-r-10 avatar-img" src="../res/images/adminlog.jpg">';
                                                $name = 'Admin';
                                              } else if ($sender == '2') {
                                                echo '<img class="pull-left m-r-10 avatar-img" src="../res/images/acclog.png">';
                                                $name = 'Account Department';
                                              } else if ($sender == '3') {
                                                echo '<img class="pull-left m-r-10 avatar-img" src="../res/images/hrlog.png">';
                                                $name = 'HR Department';
                                              } else if ($sender == '4') {
                                                echo '<img class="pull-left m-r-10 avatar-img" src="../res/images/devlog.png">';
                                                $name = 'Development Department';
                                              }
                                              ?>
                                                <div class="notification-content">
                                                    <div class="notification-heading"><?php echo $name; ?></div>
                                                    <div class="notification-text"><?php echo $row_notice_get['notice_text']; ?></div>
                                                </div>
                                            </a>
                                        </li>
                                      <?php } ?>
                                        <li class="text-center">
                                            <a href="#" id="noticelink2" class="more-link">See All</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php
                    $session_username = $_SESSION['username'];

                      $sql_get_mail = "SELECT * FROM mail WHERE mail_receiver='$session_username' AND stat='On' ORDER BY date DESC";
                      $result_get_mail = $con->query($sql_get_mail);
                      $count_get_mail = $result_get_mail->num_rows;
                    ?>
                      <div class="dropdown dib">
                          <div class="header-icon" data-toggle="dropdown">
                            <div>
                              <i class="ti-email"></i>
                              <?php if ($count_get_mail > 0) { ?>
                              <p style="background-color:red;font-size:10px;color:white;font-weight:bold;padding-left:4px;padding-right:4px;border-radius:60%;position:absolute;top:5px;right:0px;"><?php echo $count_get_mail; ?></p>
                            <?php } ?>
                            </div>

                              <div class="drop-down dropdown-menu dropdown-menu-right">
                                  <div class="dropdown-content-heading">
                                      <span class="text-left">New Messages</span>
                                  </div>
                                  <div class="dropdown-content-body">
                                      <ul>
                                        <?php while($row_get_mail = $result_get_mail->fetch_array()){
                                          $sender_get_mail = $row_get_mail['mail_sender'];

                                          $sqlget_mail2 = "SELECT * FROM employee WHERE empEmail='$sender_get_mail'";
                                          $resultget_mail2 = $con->query($sqlget_mail2);
                                          $row_get_mail22 = $resultget_mail2->fetch_array();

                                          if ($sender_get_mail == 'Admin') {
                                            $img_get_mail = '<img class="pull-left m-r-10 avatar-img" src="../res/images/adminlog.jpg">';
                                            $name_get_mail = 'Admin';
                                          } else if ($sender_get_mail == 'Accounts') {
                                            $img_get_mail = '<img class="pull-left m-r-10 avatar-img" src="../res/images/acclog.png">';
                                            $name_get_mail = 'Account Department';
                                          } else if ($sender_get_mail == 'HR') {
                                            $img_get_mail = '<img class="pull-left m-r-10 avatar-img" src="../res/images/hrlog.png">';
                                            $name_get_mail = 'HR Department';
                                          }else if ($sender_get_mail == 'Development') {
                                            $img_get_mail = '<img class="pull-left m-r-10 avatar-img" src="../res/images/devlog.png">';
                                            $name_get_mail = 'Development Department';
                                          } else{
                                            $img_get_mail = '<img class="pull-left m-r-10 avatar-img" src="../res/images/emplogo.jpg">';
                                            $name_get_mail = $row_get_mail22['empName'];
                                          }
                                        ?>
                                          <li class="notification-unread">
                                              <a href="#">
                                                  <?php echo $img_get_mail; ?>
                                                  <div class="notification-content">
                                                      <div class="notification-heading"><?php echo $name_get_mail; ?></div>
                                                      <div class="notification-text"> <?php echo $row_get_mail['subject'] ; ?></div>
                                                  </div>
                                              </a>
                                          </li>
                                        <?php } ?>
                                          <li class="text-center" id="maillink">
                                              <a href="mail.html" class="more-link">See All</a>
                                          </li>
                                      </ul>
                                  </div>
                              </div>
                          </div>
                      </div>


                    <div class="dropdown dib">
                        <div class="header-icon" data-toggle="dropdown">
                            <span class="user-avatar"><?php echo $_SESSION['username']; ?> &nbsp
                                <i class="ti-angle-down f-s-10"></i>
                            </span>
                            <div class="drop-down dropdown-profile dropdown-menu dropdown-menu-right" style="width:250px;">
                                <div class="dropdown-content-heading" style="padding:1px">
                                  <div class="row" style="width:240px;margin:1px">
                                    <div class="col-lg-3">
                                      <div class="media-left">
                                        <?php
                                          if ($session_empID == '1') {
                                            echo '<img class="media-object" src="../res/images/adminlog.jpg" alt="..." style="width:40px;height:40px;border-radius:50%">';
                                          } else if ($session_empID == '2') {
                                            echo '<img class="media-object" src="../res/images/acclog.png" alt="..." style="width:40px;height:40px;border-radius:50%">';
                                          } else if ($session_empID == '3') {
                                            echo '<img class="media-object" src="../res/images/hrlog.png" alt="..." style="width:40px;height:40px;border-radius:50%">';
                                          } else if ($session_empID == '4') {
                                            echo '<img class="media-object" src="../res/images/devlog.png" alt="..." style="width:40px;height:40px;border-radius:50%">';
                                          } else{
                                            echo '<img class="media-object" src="../res/images/emplogo.jpg" alt="" alt="..." style="width:40px;height:40px;border-radius:50%;border:1px solid #d6d6d6">';
                                          }
                                        ?>
                                      </div>
                                    </div>
                                    <div class="col-lg-9">
                                      <div class="media-body">
                                        <h4 class="media-heading" style="font-size:15px;">

                                           <?php
                                           if ($session_empID == '1') {
                                             echo 'Admin';
                                           } else if ($session_empID == '2') {
                                             echo 'Accounts Dept';
                                           } else if ($session_empID == '3') {
                                             echo 'HR Dept';
                                           } else if ($session_empID == '4') {
                                             echo 'Development Dept';
                                           } else{
                                             echo $_SESSION['username'];
                                           }
                                         ?>
                                        </h4>
                                        <p>Codec User </p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="controller/logout.php" id="logout"><i class="ti-power-off"></i> <span>Logout</span> </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
document.getElementById('logout').onclick = function(){
  window.location.href = "controller/logout.php";
}
<?php if($_SESSION['roleID'] != 1){ ?>
document.getElementById('noticelink1').onclick = function(){
  window.location.href = "notice.php";
}

document.getElementById('noticelink2').onclick = function(){
  window.location.href = "notice.php";
}

<?php } ?>

document.getElementById('maillink').onclick = function(){
  window.location.href = "mail.php";
}
</script>

<?php date_default_timezone_set("Asia/Colombo"); ?>
