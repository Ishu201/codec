<?php

include '../common/dbconnection.php';
include '../model/departmentmodel.php';

$ob = new dbconnection();
$con = $ob->connection();
$obj = new department();
//$result = $obj->viewAemployee($name);

$status = $_REQUEST['status'];


switch ($status) {
    case "add":
        $msg = $obj->addDept();
        $code = 'success';
          if ($msg == '1') {
            $msg = 'This Employee is Assigned to another Department';
            $code = 'error';
          } elseif($msg == '2'){
            $msg = 'This Department Already Exist';
            $code = 'error';
          } else{
            $msg = 'New Department is Created';

          }
        $newmsg = base64_encode($msg);
        header("Location:../department.php?msg=$newmsg&code=$code");
        break;

    case "update":
        $msg = $obj->updateDept();
        $code = 'success';
          if ($msg == '1') {
            $msg = 'This Employee is Assigned to another Department';
            $code = 'error';
          }
        $newmsg = base64_encode($msg);
        header("Location:../department.php?msg=$newmsg&code=$code");
        break;


}
