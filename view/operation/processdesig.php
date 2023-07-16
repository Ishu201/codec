<?php
$id = $_REQUEST['desig_ID'];

include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();


	// Set the DELETE SQL data
	$sql = "UPDATE designation SET stat='no' WHERE desigID = '$id'";

	// Process the query so that we will save the date of birth
	if ($con->query($sql)) {
	  echo "Designation has been deleted.";
	} else {
	  echo "Error: " . $sql . "<br>" . $mysqli->error;
	}

	// Close the connection after using it
	$con->close();

?>
