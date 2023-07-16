<?php
$id = $_REQUEST['deptID'];
$getid = $_REQUEST['check'];

include '../common/dbconnection.php';
include '../model/designationmodel.php';

$ob = new dbconnection();
$con = $ob->connection();

$desig = new designation;
$result_desig = $desig->viewDesig_dept($id);

	echo '<option value="">Select a Designation...</option>';
  while ($row_desig = $result_desig->fetch_array()) {
		$stat ='';
		if($row_desig['desigID'] == $getid){
			$stat = 'selected';
		}
		echo "<option ".$stat." value=".$row_desig['desigID'].">".$row_desig['designation']."</option>";
  }

	// Close the connection after using it
	$con->close();

?>
