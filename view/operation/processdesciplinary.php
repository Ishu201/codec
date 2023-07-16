<?php
$disid = $_REQUEST['desc_ID'];
$id = $_REQUEST['emp_ID'];

include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();
	$date = date('Y-m-d');


	// Set the DELETE SQL data
	$update_emp = "UPDATE employee SET desciplinary='No' WHERE empID='$id'";
	$result_emp = $con->query($update_emp) or die($con->error);

	$sql_suspend = "UPDATE disciplinary SET status='off', date_end='$date' WHERE disID='$disid'";
	$suspend_emp = $con->query($sql_suspend) or die($con->error);


	// Close the connection after using it
	$con->close();

?>
