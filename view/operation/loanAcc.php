<?php
include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();

$id = $_POST['loanID'];
$empid = $_POST['userhidden'];
$status = $_POST['status'];
$interest = $_POST['interest'];
$duration = $_POST['duration'];
$monthly = $_POST['monthly'];
$startMonth = $_POST['firstMonth'];
$endMonth = $_POST['endMonth'];
$reason = $_POST['reason'];
$subject = $_POST['subject'];

$payback = $_POST['payback'];


if ($status == 'Approved' ) {
	// Set the DELETE SQL data
	$sql = "UPDATE employee_loans SET payback_amt='$payback' , status = '$status' , interest = '$interest', duration = '$duration', monthly = '$monthly', startMonth = '$startMonth', endMonth = '$endMonth' ,
	process='completed', paid='0', remain='$payback', notificationStatus='Off' WHERE loanID = '$id'";
	$con->query($sql);

	// Set the DELETE SQL data
	$sql = "UPDATE employee SET loanStat = 'yes' WHERE empID='$empid'";
	$con->query($sql);

	$sql = "UPDATE employee_salary SET personalLoans='$monthly' WHERE empID='$empid'";
	$con->query($sql);

	$nmsg = 'Employee Loan Request is Approved by Account Department ..!';
	$msg = base64_encode($nmsg);

	header("Location:../loanFormAcc.php?id=".$id."&user=".$empid."&msg=".$msg."&code=success");
} else{
	// Set the DELETE SQL data
	$sql = "UPDATE employee_loans SET status = '$status' , rejectSub='$subject', reason = '$reason', process='completed', notificationStatus='Off' WHERE loanID = '$id'";
	$con->query($sql);

	$nmsg = 'Employee Loan Request is Rejected by Account Department ..!';
	$msg = base64_encode($nmsg);
	header("Location:../loanFormAcc.php?id=".$id."&user=".$empid."&msg=".$msg."&code=error");
}





?>
