<?php
$id = $_REQUEST['leave_ID'];
$stat = $_REQUEST['stat'];

include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();

	if ($stat == 'app') {
		$update_emp = "UPDATE leave_requests SET status='Approved' WHERE reqID='$id'";
		$result_emp = $con->query($update_emp) or die($con->error);

	} else{
		$update_emp = "UPDATE leave_requests SET status='Rejected' WHERE reqID='$id'";
		$result_emp = $con->query($update_emp) or die($con->error);
	}


	// Set the DELETE SQL data






	// Close the connection after using it
	$con->close();

?>
