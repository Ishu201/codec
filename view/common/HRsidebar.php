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
                <li id="adminDash"> <a href="hrDashboard.php"> <i class="ti-home"></i>Dashboard</a> </li>
                <li id="calander"><a href="calender.php"><i class="ti-calendar"></i> Calender</a></li>

                <li class="label">Company</li>
                <li id="employees"><a class="sidebar-sub-toggle "><i class="ti-user"></i> Employees<span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li id="emplist"><a href="employees.php"><i class="ti-layout-cta-left"></i>Employee List</a></li>
                        <li id="descipline"><a href="desciplinary.php"><i class="ti-alert"></i>Disciplinary</a></li>
                        <li id="loanApp"><a href="loanApp.php"><i class="ti-money"></i>Loan Applications</a></li>
                    </ul>
                </li>

                <li id="attendance"><a class="sidebar-sub-toggle"><i class="ti-bar-chart-alt"></i> Attendance<span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li id="attList"><a href="attendance.php"><i class="ti-layout-cta-left"></i>Attendance Upload</a></li>
                        <li id="attReport"><a href="attendanceReport.php"><i class="ti-clipboard"></i>Individual Attendance</a></li>
                        <li id="attlist"><a href="attendanceList.php"><i class="ti-clipboard"></i>Total Attendance</a></li>
                    </ul>
                </li>


                <li id="leave"><a class="sidebar-sub-toggle"><i class="ti-briefcase"></i> Leave Management<span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li id="companyLeave"><a href="companyLeaves.php"><i class="ti-layout-cta-left"></i>Company Leaves</a></li>
                        <li id="leaveReq"><a href="leaveReq.php"><i class="ti-comment"></i>Leave Requests</a></li>
                    </ul>
                </li>

                <li class="label">Notice</li>
                <li id="notice"><a href="notice.php"><i class="ti-bell"></i> Notice Board </a></li>
                <li id="mail"><a href="mail.php"><i class="ti-email"></i> Direct Mails </a></li>
                <br><br><br>
            </ul>
        </div>
    </div>
</div>
<!-- /# sidebar -->
