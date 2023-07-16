<?php
include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();

$id = $_REQUEST['id'];
$projectID = $_REQUEST['projectID'];
$type = $_REQUEST['type'];

if ($type == 'New developments in ERP systems') {
	$points = 10;
} else if ($type == 'Report changes / developments') {
	$points = 4.5;
} else if ($type == 'Website creation / changes / tech issues') {
	$points = 5;
} else if ($type == 'Changes in existing ERP systems') {
	$points = 2.5;
} else if ($type == 'UI developments') {
	$points = 5;
} else if ($type == 'Payment gateway / SMS gateway integration') {
	$points = 2.5;
} else {
	$points = 4.5;
}

	// Set the DELETE SQL data
	$sql = "UPDATE `project_maintenance` SET `stat` = 'reviewed', `points`='$points' WHERE id ='$id'";
	$con->query($sql);

	$nmsg = 'Project Task is Reviewed';
	$msg = base64_encode($nmsg);
	header("Location:../editCProject.php?projectID=$projectID&msg=$msg");

?>
