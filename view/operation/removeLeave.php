<?php
$id = $_REQUEST['leave_ID'];

include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();


	// Set the DELETE SQL data
	$sql = "DELETE FROM leave_requests  WHERE reqID = '$id'";

	// Process the query so that we will save the date of birth
	if ($con->query($sql)) {
	  echo "request has been deleted.";
	} else {
	  echo "Error: " . $sql . "<br>" . $mysqli->error;
	}

	// Close the connection after using it
	$con->close();

?>
