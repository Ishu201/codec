<?php
$id = $_REQUEST['pdocID'];

include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();

$sql2 = "DELETE FROM member_permissions WHERE documentID = '$id'";
$con->query($sql2);

	// Set the DELETE SQL data
	$sql = "DELETE FROM project_documents WHERE p_docID = '$id'";


	// Process the query so that we will save the date of birth
	if ($con->query($sql)) {
	  echo "Notice has been deleted.";
	} else {
	  echo "Error: " . $sql . "<br>" . $mysqli->error;
	}

	// Close the connection after using it
	$con->close();

?>
