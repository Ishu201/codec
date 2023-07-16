<?php
$id = $_REQUEST['deptID'];

include '../common/dbconnection.php';
include '../model/designationmodel.php';

$ob = new dbconnection();
$con = $ob->connection();

$desig = new designation;
$result_desig = $desig->viewDesig_dept($id);

	echo '<option value="">Select a Designation...</option>';
  while ($row_desig = $result_desig->fetch_array()) {
		echo "<option value=".$row_desig['desigID'].">".$row_desig['designation']."</option>";
  }

	// Close the connection after using it
	$con->close();

?>
