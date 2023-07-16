<?php
$id = $_REQUEST['record_ID'];

include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();


	// Set the DELETE SQL data
	$sql = "DELETE FROM employee_contact WHERE contactID='$id'";

	// Process the query so that we will save the date of birth
	if ($con->query($sql)) {
	  echo "Contact Record is Removed";
	} else {
	  echo "Error: " . $sql . "<br>" . $mysqli->error;
	}

	// Close the connection after using it
	$con->close();

?>
