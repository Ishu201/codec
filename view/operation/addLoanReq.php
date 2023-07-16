<?php
include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();

$applyDate = $_POST['applyDate'];
$empid = $_POST['userhidden'];
$loanAmount = $_POST['loanAmount'];
$letter = $_POST['letter'];

	// Set the DELETE SQL data
	$sql = "INSERT INTO employee_loans(empID,applyDate,letter,loanAmount,process,status,notificationStatus) VALUES('$empid','$applyDate','$letter','$loanAmount','Send to the review of HR Department','Pending','HR On')";
	$con->query($sql);

	$nmsg = 'Loan Request is Sent ..!';
	$msg = base64_encode($nmsg);
	header("Location:../emploanApp.php?msg=".$msg."&code=success");

?>
