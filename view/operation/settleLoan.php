<?php
include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();

$id = $_REQUEST['loan_ID'];

$sql = "SELECT * FROM employee_loans  WHERE loanID ='$id'";
$result_val = $con->query($sql);
$row_val = $result_val->fetch_array();

$paid = $row_val['payback_amt'];
$empID = $row_val['empID'];

$newcount = $row_val['count'] + 1;

	$sqlu = "UPDATE employee_loans SET  process='Settled', paid='$paid', remain='$empID', count='$newcount' WHERE loanID = '$id'";
	$con->query($sqlu);

	Set the DELETE SQL data
	$sql = "UPDATE employee SET loanStat = 'No' WHERE empID='$empID'";
	$con->query($sql);

	$sql = "UPDATE employee_salary SET personalLoans='0' WHERE empID='$empID'";
	$con->query($sql);


?>
