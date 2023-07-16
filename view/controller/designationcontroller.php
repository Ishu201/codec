<?php

include '../common/dbconnection.php';
include '../model/designationmodel.php';

$ob = new dbconnection();
$con = $ob->connection();
$obj = new designation();

$status = $_REQUEST['status'];


switch ($status) {
    case "add":
        $msg = $obj->addDesig();
        $code = 'success';
          if ($msg == '1') {
            $msg = 'This Designation is Already Registered';
            $code = 'error';
          }  else{
            $msg = 'New Designation is Created';
          }
        $newmsg = base64_encode($msg);
        header("Location:../designation.php?msg=$newmsg&code=$code");
        break;

    case "update":
        $msg = $obj->updateDesig();
        $code = 'success';
        $newmsg = base64_encode($msg);
        header("Location:../designation.php?msg=$newmsg&code=$code");
        break;


}
