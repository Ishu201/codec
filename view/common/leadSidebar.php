<?php
// if(($_SESSION['roleID'] != 4)){
//   $msg = base64_encode('Please Log in to the system..!');
//   header("Location:../index.php?msg=$msg");
// }
 ?>


<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures" >
    <div class="nano" >
        <div class="nano-content" >
            <ul>
                <div class="logo"><a href="adminDashboard.php">
                    <img src="../res/images/image.png" alt="" style="width:50px;height:50px" /> <span>CODEC</span></a></div>
                <li class="label">Main</li>
                <li id="adminDash"> <a href="devOpDashboard.php"> <i class="ti-home"></i>Dashboard</a> </li>
                <li id="calander"><a href="calender.php"><i class="ti-calendar"></i> Calender</a></li>

                <li class="label">Projects</li>
                <li id="projectList"><a href="ProjectList.php"><i class="ti-layout-cta-left"></i>Project List</a></li>
                <li id="comProjects"><a href="CompletedProjects.php"><i class="ti-archive"></i>Completed Projects
                  <?php
                    $sql_protask = "SELECT * FROM project_maintenance WHERE stat='completed' AND view='yes'";
                    $result_protask  = $con->query($sql_protask);
                    $count_protask  = $result_protask ->num_rows;
                    if ($count_protask > 0) {
                    ?>
                      <span class="badge badge-danger" style="float:right;padding:5px;width:20px;border-radius:50%"><?php echo $count_protask; ?></span>
                    <?php
                    }
                  ?>
                </a></li>


                <li class="label">Personal</li>
                <li id="notice"><a href="notice.php"><i class="ti-bell"></i> Notice Board </a></li>
                <li id="mail"><a href="mail.php"><i class="ti-email"></i> Direct Mails </a></li>
                <br><br><br>
            </ul>
        </div>
    </div>
</div>
<!-- /# sidebar -->
