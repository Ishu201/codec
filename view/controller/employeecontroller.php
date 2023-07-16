<?php

include '../common/dbconnection.php';
include '../model/employeemodel.php';

$ob = new dbconnection();
$con = $ob->connection();
$obj = new employee();
//$result = $obj->viewAemployee($name);

$status = $_REQUEST['status'];
if($status != 'add') {
    $id = $_REQUEST['emp_id'];
    if (isset($_REQUEST['contactrecord'])) {
      $contactrecord_id = $_REQUEST['contactrecord'];
    }
}


switch ($status) {
    case "add":
        $msg = $obj->addEmp();
        $code = 'success';
          if ($msg == '1') {
            $msg = 'This Contact Number is Already Registered';
            $code = 'error';
          } elseif($msg == '2'){
            $msg = 'This Email Address is Already Registered';
            $code = 'error';
          } elseif($msg == '3'){
            $msg = 'This NIC Number is Already Registered';
            $code = 'error';
          } elseif($msg == '4'){
            $msg = 'This EPF Number is Already Registered';
            $code = 'error';
          } else{
            $msg = $msg.' is Successfully Registered';
          }
        $newmsg = base64_encode($msg);
        header("Location:../addEmployee.php?msg=$newmsg&code=$code&stat=edit");
    break;

    case "suspend":
        $msg = $obj->suspend_emp();
        $code = 'success';
        $newmsg = base64_encode($msg);
        header("Location:../employees.php?msg=$newmsg&code=$code");
    break;

    // case "rem_suspend":
    //   $date = date('Y-m-d');
    //   $disid = $_REQUEST['disID'];
    //
    //   $update_emp = "UPDATE employee SET desciplinary='No' WHERE empID='$id'";
    //   $result_emp = $con->query($update_emp) or die($con->error);
    //
    //   $sql_suspend = "UPDATE disciplinary SET status='off', date_end='$date' WHERE disID='$disid'";
    //   $suspend_emp = $con->query($sql_suspend) or die($con->error);
    //
    //   $msg = 'Desciplinary Actions are Cleared';
    //   $code = 'success';
    //   $newmsg = base64_encode($msg);
    //   header("Location:../employees.php?msg=$newmsg&code=$code");
    // break;

    case "rem_suspend2":
      $date = date('Y-m-d');
      $disid = $_REQUEST['disID'];

      $update_emp = "UPDATE employee SET desciplinary='No' WHERE empID='$id'";
      $result_emp = $con->query($update_emp) or die($con->error);

      $sql_suspend = "UPDATE disciplinary SET status='off', date_end='$date' WHERE disID='$disid'";
      $suspend_emp = $con->query($sql_suspend) or die($con->error);

      $msg = 'Desciplinary Actions are Cleared';
      $code = 'success';
      $newmsg = base64_encode($msg);
      header("Location:../desciplinary.php?msg=$newmsg&code=$code");
    break;

    case "personalUpdate":
      $msg = $obj->personalUpdate();
      $code = 'success';
        if ($msg == '1') {
          $text = 'This Contact Number is Already Registered';
          $code = 'error';
        } elseif($msg == '2'){
          $text = 'This Email Address is Already Registered';
          $code = 'error';
        } else {
          $text = 'Employee Data is Successfully Updated';
        }
      $newmsg = base64_encode($text);
      header("Location:../editEmployee.php?id=$id&msg=$newmsg&code=$code&stat=edit");
    break;

    case "contactUpdate":
      $msg = $obj->updateContact($contactrecord_id);
      $code = 'success';
      $msg = $msg.' contact Details are Updated';
      $newmsg = base64_encode($msg);
      header("Location:../editEmployee.php?id=$id&msg=$newmsg&code=$code&stat=edit");
    break;

    case "contactAdd":
      $msg = $obj->addContact();
      $code = 'success';
      $newmsg = base64_encode($msg);
      header("Location:../editEmployee.php?id=$id&msg=$newmsg&code=$code&stat=edit");
    break;

    case "educationAdd":
      $msg = $obj->addEducation();
      $code = 'success';
      $newmsg = base64_encode($msg);
      header("Location:../editEmployee.php?id=$id&msg=$newmsg&code=$code&stat=edit");
    break;

    case "expAdd":
      $msg = $obj->addExp();
      $code = 'success';
      $newmsg = base64_encode($msg);
      header("Location:../editEmployee.php?id=$id&msg=$newmsg&code=$code&stat=edit");
    break;

    case "updateBank":
      $msg = $obj->UpdateBank();
      $code = 'success';
      $newmsg = base64_encode($msg);
      header("Location:../editEmployee.php?id=$id&msg=$newmsg&code=$code&stat=edit");
    break;

    case "addDoc":
      $msg = $obj->addDoc();
      $code = 'success';
      if ($msg == 'Something Went Wrong..') {
        $code = 'error';
      }
      $newmsg = base64_encode($msg);
      header("Location:../editEmployee.php?id=$id&msg=$newmsg&code=$code&stat=edit");
    break;

    case "updateSalary":
      $msg = $obj->updateSalary();
      $code = 'success';
      $newmsg = base64_encode($msg);
      header("Location:../editEmployee.php?id=$id&msg=$newmsg&code=$code&stat=edit");
    break;

    case "updateLeave":
      $msg = $obj->updateLeave();
      $code = 'success';
      $newmsg = base64_encode($msg);
      header("Location:../editEmployee.php?id=$id&msg=$newmsg&code=$code&stat=edit");
    break;


}
