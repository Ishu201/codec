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
                <li id="adminDash"> <a href="adminDashboard.php"> <i class="ti-home"></i>Dashboard</a> </li>
                <li id="calander"><a href="calender.php"><i class="ti-calendar"></i> Calender</a></li>

                <li class="label">Company</li>
                <li id="organization" ><a class="sidebar-sub-toggle" ><i class="ti-harddrives"></i> Organization<span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li id="dept" ><a href="department.php" ><i class="ti-direction"></i> Department</a></li>
                        <li id="desig"><a href="designation.php"><i class="ti-id-badge"></i>Designation</a></li>
                        <li id="resourse"><a href="resources.php"><i class="ti-truck"></i>Resources</a></li>
                        <li id="expenses"> <a href="expenses.php"><i class="ti-money"></i>Company Expenses</a></li>
                    </ul>
                </li>
                <li id="employees"><a class="sidebar-sub-toggle "><i class="ti-user"></i> Employees<span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li id="emplist"><a href="employees.php"><i class="ti-layout-cta-left"></i>Employee List</a></li>
                        <li id="descipline"><a href="desciplinary.php"><i class="ti-alert"></i>Disciplinary</a></li>
                        <li id="userAcc"><a href="users.php"><i class="ti-user"></i>User Accounts</a></li>
                    </ul>
                </li>

                <li id="attendance"><a class="sidebar-sub-toggle"><i class="ti-bar-chart-alt"></i> Attendance<span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li id="attList"><a href="attendance.php"><i class="ti-layout-cta-left"></i>Attendance Upload</a></li>
                        <li id="attReport"><a href="attendanceReport.php"><i class="ti-clipboard"></i>Individual Attendance</a></li>
                        <li id="attlist"><a href="attendanceList.php"><i class="ti-clipboard"></i>Total Attendance</a></li>
                        <li id="attChart"><a href="attendanceChart.php?month=<?php echo date('Y-m'); ?>"><i class="ti-bar-chart-alt"></i>Attendance Chart</a></li>
                    </ul>
                </li>


                <li id="leave"><a class="sidebar-sub-toggle"><i class="ti-briefcase"></i> Leave Management<span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li id="companyLeave"><a href="companyLeaves.php"><i class="ti-layout-cta-left"></i>Company Leaves</a></li>
                        <li id="leaveReq"><a href="leaveReq.php"><i class="ti-comment"></i>Leave Requests</a></li>
                    </ul>
                </li>

                <li id="loan"><a class="sidebar-sub-toggle"><i class="ti-credit-card"></i> Employee Loans<span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li id="loanApp"><a href="loanApp.php"><i class="ti-layout-cta-btn-right"></i>Loan Applications</a></li>
                        <li id="loanData"><a href="loanData.php"><i class="ti-money"></i>Loan Details</a></li>
                    </ul>
                </li>

                <li id="payments"><a class="sidebar-sub-toggle"><i class="ti-bar-chart-alt"></i> Employee Payments<span class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li id="genPay"><a href="generatePayroll.php"><i class="ti-map"></i>Generate Payroll</a></li>
                        <li id="payList"><a href="payrollList.php"><i class="ti-layout-cta-left"></i>Payroll List</a></li>
                        <li id="salaryAdvance"> <!--<a href="salaryAdvance.php"><i class="ti-panel"></i>Salary Advance</a>--></li>
                        <li id="payChart"><a href="payments.php"><i class="ti-bar-chart-alt"></i>Payments</a></li>  <!--chart -->
                    </ul>
                </li>

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
