<?php
include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();

$id = $_REQUEST['id'];
$stat = $_REQUEST['gets'];

	// Set the DELETE SQL data
	$sql = "UPDATE users SET permission ='$stat'  WHERE userID ='$id'";
	$con->query($sql);

	header("Location:../users.php");

?>
