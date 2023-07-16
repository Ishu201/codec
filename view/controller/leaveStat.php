
<?php
include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();
//

if($_REQUEST["stat"] == 'end'){
  $id = $_REQUEST['id'];

    echo $sql = "UPDATE `leave_requests` SET `leave` = 'No' WHERE reqID='$id'";
    $result = $con->query($sql);

    $nmsg = 'Your Leave has Ended ..!';
    $msg = base64_encode($nmsg);
    header("Location:../empleaveReq.php?msg=$msg&code=success");
} else{
  $id = $_REQUEST['id'];

    echo $sql = "UPDATE `leave_requests` SET `leave` = 'Yes' WHERE reqID='$id'";
    $result = $con->query($sql);

    $nmsg = 'Your Leave is Started ..!';
    $msg = base64_encode($nmsg);
    header("Location:../empleaveReq.php?msg=$msg&code=success");
}


?>
