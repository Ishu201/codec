<?php
$id = $_REQUEST['emp_ID'];

include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();

$date = date('Y-m-d');

	// Set the DELETE SQL data
	$sql = "UPDATE employee SET empJobStatus = 'Alumnus' , dateOfResign='$date' WHERE empID = '$id'";

	$sql2 = "UPDATE department SET empID = '0' WHERE empID = '$id'";
	$con->query($sql2);

	$sql3 = "UPDATE users SET stat = 'Inactive' WHERE empID = '$id'";
	$con->query($sql3);


	// Process the query so that we will save the date of birth
	if ($con->query($sql)) {
	  echo "Employee is no Longer working with us ";
	} else {
	  echo "Error: " . $sql . "<br>" . $mysqli->error;
	}

	// Close the connection after using it
	$con->close();

?>
