
<?php
include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();
//

  $leaveID = $_POST['leaveID'];
  $empID = $_POST['empID'];
  $startDate = $_POST['startDate'];
  $endDate = $_POST['endDate'];
  $duration = $_POST['duration'];
  $reason = $_POST['reason'];
  $date = date('Y-m-d');

    $sql2 = "INSERT INTO `leave_requests`(`date`, `empID`, `leaveID`, `reason`, `startDate`, `endDate`, `duration`, `status`) VALUES ('$date','$empID','$leaveID','$reason','$startDate','$endDate','$duration','Pending')";
    $result2 = $con->query($sql2);

    // $sql3 = "UPDATE `employee_leaves` SET used=(used-1) WHERE empID='$empID' AND leaveID='$leaveT'";
    // $result3 = $con->query($sql3);

    $nmsg = 'Leave Request is Sent ..!';
    $msg = base64_encode($nmsg);
    header("Location:../empleaveReq.php?msg=$msg&code=success");

?>
