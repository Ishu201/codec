<?php

include '../common/dbconnection.php';
include '../model/noticemodel.php';

$ob = new dbconnection();
$con = $ob->connection();
$obj = new notice();
//$result = $obj->viewAemployee($name);

$status = $_REQUEST['status'];

switch ($status) {
    case "add":
        $msg = $obj->addNotice();
        $newmsg = base64_encode($msg);
        header("Location:../notice.php?msg=$newmsg&code=success");
        break;

    case "remove":
        $noticeID = $_REQUEST['id'];
        $result = $obj->removeNotice($noticeID);
        header("Location:../notice.php?msg=$result");
        break;
}
