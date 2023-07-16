

<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
    <div class="nano">
        <div class="nano-content">
            <ul>
                <div class="logo"><a href="empDashboard.php">
                    <img src="../res/images/image.png" alt="" style="width:50px;height:50px" /> <span>CODEC</span></a></div>
                <li class="label">Main</li>
                <li id="adminDash"> <a href="empDashboard.php"> <i class="ti-home"></i>Dashboard</a> </li>
                <li id="calander"><a href="calender.php"><i class="ti-calendar"></i> Calender and Tasks </a></li>


                <li class="label">Personal</li>
                <li id="descipline"><a href="empdesciplinary.php"><i class="ti-alert"></i>Disciplinary Notes</a></li>
                <li id="attReport"><a href="empattendance.php"><i class="ti-clipboard"></i>Attendance Record</a></li>

                <li id="leave"><a class="sidebar-sub-toggle"><i class="ti-briefcase"></i> Leave Application<span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li id="companyLeave"><a href="empcompanyLeaves.php"><i class="ti-layout-cta-left"></i>Company Leaves</a></li>
                        <li id="leaveReq"><a href="empleaveReq.php"><i class="ti-comment"></i>Leave Requests</a></li>
                    </ul>
                </li>

                <li id="loanApp"><a href="emploanApp.php"><i class="ti-money"></i>Loan Applications</a></li>

                <li id="payList"><a href="emppayrollList.php"><i class="ti-layout-cta-left"></i>Salary Records</a></li>

                <?php
                  $sql_empData = "SELECT * FROM employee WHERE empID='{$_SESSION['empID']}'";
                  $result_empData = $con->query($sql_empData);
                  $row_empData = $result_empData->fetch_array();

                  if ($row_empData['userType'] == 'Team') {
                  ?>
                <li class="label">Projects</li>
                <!-- <li id="projectList"><a href="empProjectList.php"><i class="ti-layout-cta-left"></i>Project List</a></li> -->
                <li id="comProjects"><a href="empCompletedProjects.php"><i class="ti-archive"></i>Working Projects</a></li>

                <?php } ?>

                <li class="label">Company</li>
                <li id="mail"><a href="mail.php"><i class="ti-email"></i> Direct Mails </a></li>
                <br><br><br>
            </ul>
        </div>
    </div>
</div>
<!-- /# sidebar -->
