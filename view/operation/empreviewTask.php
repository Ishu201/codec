<?php
include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();

$id = $_REQUEST['id'];
$projectID = $_REQUEST['projectID'];
$stat = $_REQUEST['stat'];
$today = date('Y-m-d');

if ($stat == 'todo') {
	$upto = 'in progress';
	$nmsg = 'Project Task is in Progress';
	$condition = '';
} else{
	$upto = 'completed';
	$nmsg = 'Project Task is Completed';
	$condition = ",finished='$today'";
}

	// Set the DELETE SQL data
	$sql = "UPDATE `project_maintenance` SET `stat` = '$upto' $condition WHERE id ='$id'";
	$con->query($sql);

  $msg = base64_encode($nmsg);
	header("Location:../empeditCProject.php?projectID=$projectID&msg=$msg");

?>
