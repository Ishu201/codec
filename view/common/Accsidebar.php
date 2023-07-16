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
                <li id="adminDash"> <a href="accDashboard.php"> <i class="ti-home"></i>Dashboard</a> </li>
                <li id="calander"><a href="calender.php"><i class="ti-calendar"></i> Calender</a></li>

                <li class="label">Company</li>
                <li id="resourse"><a href="resources.php"><i class="ti-truck"></i>Resources</a></li>
                <li id="expenses"> <a href="expenses.php"><i class="ti-money"></i>Company Expenses</a></li>

                <li class="label">Loans</li>
                <li id="loanApp"><a href="loanApp.php"><i class="ti-money"></i>Loan Applications</a></li>

                <li class="label">Salary</li>
                <li id="genPay"><a href="generatePayroll.php"><i class="ti-map"></i>Generate Payroll</a></li>
                <li id="payList"><a href="payrollList.php"><i class="ti-layout-cta-left"></i>Payroll List</a></li>
                <li id="salaryAdvance"> <!--<a href="salaryAdvance.php"><i class="ti-panel"></i>Salary Advance</a>--></li>
                <!-- <li id="payChart"><a href="payments.php"><i class="ti-bar-chart-alt"></i>Payments</a></li>  <!--chart -->

                <li class="label">Notice</li>
                <li id="notice"><a href="notice.php"><i class="ti-bell"></i> Notice Board </a></li>
                <li id="mail"><a href="mail.php"><i class="ti-email"></i> Direct Mails </a></li>
                <br><br><br>
            </ul>
        </div>
    </div>
</div>
<!-- /# sidebar -->
