<?php
$id = $_REQUEST['leave_ID'];

include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();


	// Set the DELETE SQL data
	$sql = "UPDATE company_leaves SET stat='Deactive' WHERE leaveID='$id'";

	$getn = "SELECT * FROM company_leaves WHERE leaveID='$id'";
	$result = $con->query($getn);
	$row = $result->fetch_array();
		$name = $row['leave_type'];

		$sql2 = "UPDATE employee_leaves SET stat='Off' , used='0' WHERE leaveID='$name'";
		$con->query($sql2);

	// Process the query so that we will save the date of birth
	if ($con->query($sql)) {
	  echo "Leave Type has been deleted.";
	} else {
	  echo "Error: " . $sql . "<br>" . $mysqli->error;
	}

	// Close the connection after using it
	$con->close();

?>
