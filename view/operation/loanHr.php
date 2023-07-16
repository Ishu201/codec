<?php
include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();

$id = $_POST['loanID'];
$empid = $_POST['userhidden'];
$hrRemark = $_POST['hrRemark'];
$hrCheck = $_POST['hrCheck'];

	// Set the DELETE SQL data
	$sql = "UPDATE employee_loans SET hrRemark = '$hrRemark' , hrCheck = '$hrCheck', process='Under the Reveiw of Account Department' WHERE loanID = '$id'";
	$con->query($sql);

	$nmsg = 'Employee Loan Request is Reveiwed by HR Department ..!';
	$msg = base64_encode($nmsg);
	header("Location:../loanForm.php?id=".$id."&user=".$empid."&msg=".$msg."&code=success");

?>
