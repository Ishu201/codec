<?php
$id = $_REQUEST['receiver'];

include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();

	$sql = "UPDATE mail SET stat='off' WHERE mail_receiver='$id'";


	// Process the query so that we will save the date of birth
	if ($con->query($sql)) {
	  header("Location:../mail.php?stat=done");
	}
	// Close the connection after using it
	$con->close();

?>
