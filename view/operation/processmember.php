<?php
$id = $_REQUEST['member_ID'];

include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();

$date=date('Y-m-d');

	// Set the DELETE SQL data
	$sql = "UPDATE project_members SET stat='off', toDate='$date' WHERE memberID = '$id'";

	// Process the query so that we will save the date of birth
	if ($con->query($sql)) {
	  echo "Notice has been deleted.";
	} else {
	  echo "Error: " . $sql . "<br>" . $mysqli->error;
	}

	// Close the connection after using it
	$con->close();

?>
