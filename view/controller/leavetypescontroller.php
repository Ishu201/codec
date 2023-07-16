
<?php
include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();
//

if(isset($_POST["addL"]))
{
  $leaveName = $_POST['leaveName'];
  $leaveDate = $_POST['leaveDates'];

  $sql = "SELECT * FROM company_leaves WHERE leave_type='$leaveName'";
  $result = $con->query($sql);
  $rowcount= mysqli_num_rows($result);

  if ($rowcount > 0) {
    $nmsg = $leaveName.' Already Registered..!';
    $msg = base64_encode($nmsg);
    header("Location:../leaveTypes.php?msg=$msg&code=error");
  }

  else{
    $sql2 = "INSERT INTO company_leaves(leave_type,total_days) VALUES('$leaveName','$leaveDate')";
    $result2 = $con->query($sql2);

    $nmsg = $leaveName.' Is Registered..!';
    $msg = base64_encode($nmsg);
    header("Location:../leaveTypes.php?msg=$msg&code=success");
  }
}

else if(isset($_POST["editL"])){
  $leaveName = $_POST['leaveName'];
  $leaveDate = $_POST['leaveDays'];
  $leaveID = $_POST['leaveID'];

  $sql2 = "UPDATE company_leaves SET leave_type='$leaveName', total_days='$leaveDate' WHERE leaveID='$leaveID'";
  $result2 = $con->query($sql2);

  $sql3 = "UPDATE employee_leaves SET leaveID='$leaveName', days='$leaveDate' WHERE leaveID='$leaveName'";
  $result3 = $con->query($sql3);

  $nmsg = $leaveName.' Is Updated..!';
  $msg = base64_encode($nmsg);
  header("Location:../leaveTypes.php?msg=$msg&code=success");

}

?>
