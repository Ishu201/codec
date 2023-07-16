<?php

class task {

    public function viewTask($empID) {
        $con = $GLOBALS['con'];
        $sql = "SELECT * FROM task WHERE empID='$empID' AND stat!='Removed'";
        $result = $con->query($sql);
        return $result;
    }

    public function updateTask($taskID) {
        $date = date("Y-m-d");
        $con = $GLOBALS['con'];
        $stat = '';
          $sql_check = "SELECT * FROM task WHERE taskID='$taskID'";
          $result_check = $con->query($sql_check);
          $stat_check = $result_check->fetch_array();
            if ($stat_check['stat'] == 'Completed') {
              $stat = 'todo';
            }else{
              $stat = 'Completed';
            }
        $sql = "UPDATE task SET date = '$date', stat = '$stat' WHERE taskID = '$taskID'";
        $result = $con->query($sql) or die($con->error);
        return $stat;
    }


    function addTask() {
        $task = $_POST['task'];
        $empID = $_POST['empID'];
        $date = date("Y-m-d");
        $con = $GLOBALS['con'];
        $sql = "INSERT INTO task (empID,task,date) VALUES('$empID','$task','$date')";
        $result = $con->query($sql) or die($con->error);
        $msg = 'New Task is Created';
        return $msg;
    }

    public function removeTask($taskID) {
        $con = $GLOBALS['con'];
        $sql = "UPDATE task SET stat = 'Removed' WHERE taskID = '$taskID'";
        $result = $con->query($sql) or die($con->error);
        $msg = 'Task is Completed';
        return $msg;
    }

}
