
<?php
include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();
//

if(isset($_POST["submit"]))
{
  $type = $_POST['type'];
  $account = $_POST['account'];
  $method = $_POST['method'];
  $amount = $_POST['amount'];
  $paidDate = $_POST['paidDate'];
  $date = date('Y-m', strtotime(date('Y-m')." -1 month"));

    $sql2 = "INSERT INTO expenses(type,amount,account,paidDate,method) VALUES('$type','$amount','$account','$paidDate','$method')";
    $result2 = $con->query($sql2);

    $sql = "UPDATE `salary_master` SET payDate='$paidDate' WHERE month='$date'";
    $result = $con->query($sql);

    $nmsg = 'New Expenses is Created ..!';
    $msg = base64_encode($nmsg);
    header("Location:../addBill.php?msg=$msg&code=success");
}


?>
