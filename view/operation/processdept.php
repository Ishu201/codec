<?php
$id = $_REQUEST['dept_ID'];

include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();


	// Set the DELETE SQL data
	$sql = "UPDATE department SET stat='no'  WHERE deptID = '$id'";

	// Process the query so that we will save the date of birth
	if ($con->query($sql)) {
	  echo "Department has been deleted.";
	} else {
	  echo "Error: " . $sql . "<br>" . $mysqli->error;
	}

	// Close the connection after using it
	$con->close();

?>
