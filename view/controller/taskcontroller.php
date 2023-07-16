<?php

include '../common/dbconnection.php';
include '../model/taskmodel.php';

$ob = new dbconnection();
$con = $ob->connection();
$obj = new task();
//$result = $obj->viewAemployee($name);

$status = $_REQUEST['status'];


switch ($status) {
    case "add":
        $obj->addTask();
        $newmsg = base64_encode('New Task is Created');
        $url =  $_SERVER["HTTP_REFERER"].'?stat=suc&msh='.$newmsg;
        header("Location: $url");
        break;

    case "update":
        $taskID = $_POST['taskID'];
        $result = $obj->updateTask($taskID);
        if ($result == 'todo') {
          $newmsg = base64_encode('Task is not Completed');
          $url =  $_SERVER["HTTP_REFERER"].'?stat=error&msh='.$newmsg;
        } else{
          $newmsg = base64_encode('Task is Completed');
          $url =  $_SERVER["HTTP_REFERER"].'?stat=suc&msh='.$newmsg;
        }

        header("Location: $url");
        // header("Location:../adminDashboard.php#taskTable");
        break;

      case "remove":
          $taskID = $_REQUEST['id'];
          $result = $obj->removeTask($taskID);
          $newmsg = base64_encode('Task is Removed');
          $url =  $_SERVER["HTTP_REFERER"].'?stat=suc&msh='.$newmsg;
          header("Location: $url");
          // header("Location:../adminDashboard.php#taskTable");
          break;

}
