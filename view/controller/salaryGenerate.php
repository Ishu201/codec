
<?php
include '../common/dbconnection.php';

$ob = new dbconnection();
$con = $ob->connection();
//

  $empID = $_REQUEST['empID'];
  $month = $_REQUEST['month'];
  $basic = $_REQUEST['basic'];
  $ot_hrs = $_REQUEST['ot_hrs'];
  $ot_pay = $_REQUEST['ot_pay'];
  $allowance = $_REQUEST['allowance'];
  $special_allowance = $_REQUEST['special_allowance'];
  $total_addition = $_REQUEST['total_addition'];
  $other = $_REQUEST['other'];
  $loans = $_REQUEST['loans'];
  $epf_amount = $_REQUEST['epf_amount'];
  $latehrs = $_REQUEST['latehrs'];
  $special_deduction = $_REQUEST['special_deduction'];
  $total_deduction = $_REQUEST['total_deduction'];
  $net_salary = $_REQUEST['net_salary'];
  $deptID = $_REQUEST['deptID'];
  $empName = $_REQUEST['empName'];

    $sql2 = "INSERT INTO `salary_master`(`empID`, `month`, `basic`, `ot_hrs`, `ot_pay`, `allowance`, `special_allowance`, `total_addition`, `other`, `loans`, `epf_amount`, `latehrs`, `late_deduction`, `total_deduction`, `net_salary`)
    VALUES('$empID','$month','$basic','$ot_hrs','$ot_pay','$allowance','$special_allowance','$total_addition','$other', '$loans','$epf_amount','$latehrs','$special_deduction','$total_deduction','$net_salary')";
    $result2 = $con->query($sql2);

    if ($loans > 0) {
      $sql = "SELECT * FROM employee_loans  WHERE empID ='$empID' AND remain!='0'";
    	$result_val = $con->query($sql);
      $row_val = $result_val->fetch_array();

      $id = $row_val['loanID'];

      $paid = $row_val['paid'];
      $remain = $row_val['remain'];

      $newpaid = $paid + $loans;
      $newremain = $remain - $loans;

      $newcount = $row_val['count'] + 1;

      if ($newremain == 0) {
        $sqlu = "UPDATE employee_loans SET  process='Settled', paid='$newpaid', remain='$newremain', count='$newcount' WHERE loanID = '$id'";
      	$con->query($sqlu);

        // Set the DELETE SQL data
      	$sql = "UPDATE employee SET loanStat = 'No' WHERE empID='$empID'";
      	$con->query($sql);

      	$sql = "UPDATE employee_salary SET personalLoans='0' WHERE empID='$empID'";
      	$con->query($sql);

      } else{
        $sqlu = "UPDATE employee_loans SET  process='Paying', paid='$newpaid', remain='$newremain', count='$newcount' WHERE loanID = '$id'";
      	$con->query($sqlu);
      }

    }



?>
