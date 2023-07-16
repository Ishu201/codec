<?php
$id = $_REQUEST['type'];

include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();


	if ($id == '1') {
		$sql = "UPDATE notice SET Admin='off'";
	}
	else if ($id == '2') {
		$sql = "UPDATE notice SET ACC='off'";
	} else if ($id == '3') {
		$sql = "UPDATE notice SET HR='off'";
	}
	else if ($id == '4') {
		$sql = "UPDATE notice SET IT='off'";
	}

	// Process the query so that we will save the date of birth
	if ($con->query($sql)) {
	  header("Location:../notice.php?stat=done");
	}
	// Close the connection after using it
	$con->close();

?>
